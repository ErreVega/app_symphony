<?php


namespace App\Controller;

use App\Entity\Friends;
use App\Entity\Messages;
use App\Entity\MsgReceived;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class APP_controller extends AbstractController
{
    /**
     * @Route("/test/{num}", name="test")
     */
    public function test($num)
    {
        $res = $this->getDoctrine()->getManager()->getRepository(MsgReceived::class)->getMessagesReceived($num);
        if (!$res) {
            $res = False;
        }
        return new Response (var_dump($res));
    }
    /**
     * @Route("/test2", name="test")
     */
    public function test2()
    {
        $res = $this->getUser()->getMessagesSend();

        return new Response (var_dump($res));
    }




    /**
     * @Route("/main", name="main")
     */
    public function main()
    {
        if ($this->getUser()->getActive()){
            $this->denyAccessUnlessGranted('ROLE_USER');
            return $this->render("main.html.twig");
        } else
            return $this->redirect("login");
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
    }

}
