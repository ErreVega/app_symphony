<?php

namespace App\Repository;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class  MsgReceivedRepository extends EntityRepository
{
    public function findMsgBy($user_id)
    {
        $qb = $this->createQueryBuilder("msg_alias")
            ->select("m.msg_id")
            ->from(" App\Entity\MsgReceived", "m")
            ->where('m.user_id = :user')
            ->setParameter('user', $user_id)
            ->distinct();

        $query = $qb->getQuery();
        $message = $query->execute();

        if (!$message){
            return false;
        }
        Return $message;
    }

    public function findUsersBy($msg){

        $qb = $this->createQueryBuilder("msg_alias")
            ->select("m.user_id")
            ->from(" App\Entity\MsgReceived", "m")
            ->where('m.msg_id = :msg')
            ->setParameter('msg', $msg)
            ->distinct();

        $query = $qb->getQuery();
        $users = $query->execute();

        if (!$users){
            return false;
        }
        foreach ($users as $user) {
            $receiver = $this->getEntityManager()->getRepository(User::class)->findOneBy($user);
            $res[] = $receiver->getUserName();
        }

        Return $res;



    }


}
