<?php


namespace App\Controller;

use App\Entity\Friends;
use App\Entity\Messages;
use App\Entity\MsgAttached;
use App\Entity\MsgReceived;
use App\Entity\User;
use App\Form\NewMsgForm;
use App\Form\ProfileForm;
use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *
 * @IsGranted("ROLE_USER", statusCode=401, message="NO autorizado")
 */
class LogedControllers extends AbstractController
{
    /**
     * @Route("/msg/{num}", name="msg")
     */
    public function getMessage($num)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $res = $entityManager->find(Messages::class, $num);

        if (!$res ){
            return;
//            TODO
        }
        $attached_docs = $entityManager->getRepository(MsgAttached::class)->findBy(["msg_id" => $num]);
        $to = $entityManager->getRepository(MsgReceived::class)->findUsersBy($num);
        return $this->render("email.html.twig", array(
            "sender" => $res->getSenderId(),
            "to" => $to,
            "subject" => $res->getSubject(),
            "date" => date_format($res->getDate(), 'Y-m-d H:i:s'),
            "body" => $res->getBody(),
            "attach" => $attached_docs
        ));
    }

    /**
     * @Route("/profile/{num}", name="profile")
     */
    public function profile($num)
    {
        $res = $this->getDoctrine()->getManager()->getRepository(User::class)->find($num);
        if (!$res) {
            $res = False;
        }
        return $this->render("profile.html.twig", [
            "consulted_user_id" => $res->getUserId(),
            "photo_path" => $res->getPhotoPath(),
            "user_name" => $res->getUserName(),
            "description" => $res->getDescription(),
            "age" => $res->getAge(),
            "address" => $res->getAddress()]);
    }

    /**
     * @Route("/received", name="received")
     */
    public function received()
    {
        $userID = $this->getUser()->getUserId();
        $userMsgReceiv = $this->getDoctrine()->getManager()->getRepository(MsgReceived::class)->findMsgBy($userID);
        $msgs = $this->getDoctrine()->getManager()->getRepository(Messages::class)->getMessages($userMsgReceiv);
        return $this->render("msgRec.html.twig", ["mails" => $msgs]);
    }

    /**
     * @Route("/sent", name="sent")
     */
    public function sent()
    {
        $res = $this->getUser()->getMessagesSend();
        return $this->render("msgSend.html.twig", ["mails" => $res]);
    }

    /**
     * @Route("/sendMsg", name="sendMsg")
     * @Route("/sendMsg/{user}", name="sendMsgUser")
     * @param Request $request
     */
    public function sendMsg(Request $request, $user=null)
    {
        $success = False;
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(NewMsgForm::class);

        if (isset($user)){
            $user = $entityManager->getRepository(User::class)->findOneBy(["user_id"=> $user]);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $userSender = $this->getUser();
            $msg = new Messages($userSender, new \DateTime(), $data["subject"], $data["msgbody"]);

            $receivers = explode(",", $data["to"]);
            $err = [];

            foreach ($receivers as $rec) {
                $userRec = $entityManager->getRepository(User::class)->findOneBy(['user_name' => trim($rec)]);
                if (!$userRec) {
                    $err[] = "El usuario " . trim($rec) . " no existe.";
                } else {
                    $friends = $entityManager->getRepository(Friends::class)->getFriends($userSender);

                    if (!in_array(["user_id" => $userRec->getUserId()], $friends)) {
                        $err[] = "El usuario " . trim($rec) . " no esta entre tus amigos.";
                    } else {
                        $arrUserRec[] = $userRec;
                    }
                }
            }


            if (isset($err) && (count($err) >= count($receivers))) {
                $err[] = "No hay ningun destinatario valido para enviar su mensaje";
            } else {
                $success = TRUE;
                $entityManager->persist($msg);
                $entityManager->flush();
                foreach ($arrUserRec as $rec) {
                    $msgReceiv = new MsgReceived($rec->getUserId(), $msg->getMsgId());
                    $entityManager->persist($msgReceiv);
                    $entityManager->flush();
                }
                $files = $data["attach"];
                if (isset($files)) {

                    foreach ($files as $file) {
                        $fileName = uniqid() . '.' . $file->guessExtension();
                        $file->move(
                            $this->getParameter("attach_directory"),
                            $fileName
                        );
                        $msgAttach = new MsgAttached($msg->getMsgId(), $fileName, $file->getClientOriginalName());
                        $entityManager->persist($msgAttach);
                        $entityManager->flush();
                    }
                }
            }
            return $this->render("newMsg.html.twig", ["msg" => $msg,
                "err" => $err, "success" => $success,
                "form" => $form->createView()
            ]);
        }

        return $this->render("newMsg.html.twig", ["form" => $form->createView(), "user"=> $user]);
    }


    /**
     * @Route("/editprofile", name="editprofile")
     * @param Request $request
     * @return Response
     */
    public function editprofile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileForm::class);
        $placeholder = [$user->getDescription(), $user->getAddress(), $user->getAge()];

        $data = [];
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $file = $data["avatar"];

            $user->setAge($data["age"]);
            $user->setAddress($data["address"]);
            $user->setDescription($data["description"]);

            if (isset($file)) {
                $fileName = uniqid() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter("avatars_directory"),
                    $fileName
                );
                $user->setPhotoPath($fileName);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect("/profile/" . $user->getUserId(), 301);
        }
        return $this->render("editProfile.html.twig", ["form" => $form->createView(), "placeholder" => $placeholder, "data" => $data]);
    }

    /**
     * @Route("/friends", name="friends")
     * @return Response
     */
    public function friends()
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $friends = $entityManager->getRepository(Friends::class)->getFriends($user);
        $res = [];
        foreach ($friends as $friend) {
            $res[] = $entityManager->getRepository(User::class)->findOneBy($friend);
        }
        return $this->render("myFriends.html.twig", ["friends" => $res,  "title" => "Mis Amigos"]);
    }

    /**
     * @Route("/friends_pending", name="friends_pending")
     * @return Response
     */
    public function friendsPending()
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $friends = $entityManager->getRepository(Friends::class)->getFriendsPending($user);
        $res = [];
        foreach ($friends as $friend) {
            $res[] = $entityManager->getRepository(User::class)->findOneBy($friend);
        }
        return $this->render("myFriends.html.twig", ["friends" => $res, "title" => "Solicitudes Pendientes"]);
    }


    /**
     * @Route("/sugested", name="sugested")
     * @Route("/sendFriendPetition/{friendUser}", name="sendFriendPetition")
     * @return Response
     */
    public function sugested($friendUser = null)
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $friends = $entityManager->getRepository(Friends::class)->getFriendsSugested($user);
        $res = [];
        foreach ($friends as $friend) {
            $res[] = $entityManager->getRepository(User::class)->findOneBy($friend);
        }
        $send = false;
        if (isset($friendUser)){

            $entityManager = $this->getDoctrine()->getManager();
            $friendDoc = new Friends($user->getUserId(), $friendUser, "pending");
            $entityManager->persist($friendDoc);
            $entityManager->flush();
            $send = true;
        }


        return $this->render("myFriends.html.twig", [
            "friends" => $friends,
            "title" => "Amigos Sugeridos",
            "sugested" => true,
            "send" => $send]);
    }



}
