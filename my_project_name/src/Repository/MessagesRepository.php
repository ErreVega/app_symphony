<?php

namespace App\Repository;
use App\Entity\MsgReceived;
use Doctrine\ORM\EntityRepository;

class  MessagesRepository extends EntityRepository
{

    public function getMessages($arrMsg)
    {
        $arrRES = [];
        foreach ($arrMsg as $msgId){
            $qb = $this->createQueryBuilder("msg_alias")
                ->select("m")
                ->from(" App\Entity\Messages", "m")
                ->where('m.msg_id = :msg')
                ->setParameter('msg', $msgId["msg_id"])
                ->distinct();

            $query = $qb->getQuery();
            $message = $query->execute();

            if ($message){
                $arrRES[] = $message;
            }
        }
        return $arrRES;
    }

}
