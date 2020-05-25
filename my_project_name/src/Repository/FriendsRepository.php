<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;


class FriendsRepository extends EntityRepository
{
    public function getFriends($user_id)
    {
        $qb = $this->createQueryBuilder("user")
            ->select("f.user_id1 as user_id")
            ->from(" App\Entity\Friends", "f")
            ->where("f.user_id2 = :user and f.status = 'acepted'")
            ->setParameter('user', $user_id)
            ->distinct();

        $query = $qb->getQuery();
        $res1 = $query->execute();

        $qb = $this->createQueryBuilder("user")
            ->select("f.user_id2 as user_id")
            ->from(" App\Entity\Friends", "f")
            ->where("f.user_id1 = :user and f.status = 'acepted'")
            ->setParameter('user', $user_id)
            ->distinct();

        $query = $qb->getQuery();
        $res2 = $query->execute();

        if (!$res1 && !$res2) {
            return false;
        }
        Return array_merge($res1, $res2);
    }

    public function getFriendsPending($user_id)
    {
        $qb = $this->createQueryBuilder("user")
            ->select("f.user_id1 as user_id")
            ->from(" App\Entity\Friends", "f")
            ->where("f.user_id2 = :user and f.status = 'pending'")
            ->setParameter('user', $user_id)
            ->distinct();

        $query = $qb->getQuery();
        $res1 = $query->execute();

        $qb = $this->createQueryBuilder("user")
            ->select("f.user_id2 as user_id")
            ->from(" App\Entity\Friends", "f")
            ->where("f.user_id1 = :user and f.status = 'pending'")
            ->setParameter('user', $user_id)
            ->distinct();

        $query = $qb->getQuery();
        $res2 = $query->execute();

        if (!$res1 && !$res2) {
            return false;
        }
        Return array_merge($res1, $res2);
    }

    public function getFriendsSugested($user_id)
    {

        $qb = $this->createQueryBuilder("user")
            ->select("u.user_id")
            ->from(" App\Entity\User", "u")->orderBy()
            ->distinct();

//        return $intersect;
    }


}
