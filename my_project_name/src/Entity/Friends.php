<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="friends")
 * @ORM\Entity(repositoryClass="App\Repository\FriendsRepository")
 */
class Friends
{
    /** @ORM\Id @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user_id")
     */
    private $user_id1;

    /** @ORM\Id @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user_id")
     */
    private $user_id2;

    /** @ORM\Column(type="string", columnDefinition="ENUM('acepted', 'pending', 'rejected')") */
    private $status;

    /**
     * Friends constructor.
     * @param $user_id1
     * @param $user_id2
     * @param $status
     */
    public function __construct($user_id1, $user_id2, $status)
    {
        $this->user_id1 = $user_id1;
        $this->user_id2 = $user_id2;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getUserId1()
    {
        return $this->user_id1;
    }

    /**
     * @param mixed $user_id1
     */
    public function setUserId1($user_id1): void
    {
        $this->user_id1 = $user_id1;
    }

    /**
     * @return mixed
     */
    public function getUserId2()
    {
        return $this->user_id2;
    }

    /**
     * @param mixed $user_id2
     */
    public function setUserId2($user_id2): void
    {
        $this->user_id2 = $user_id2;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }



}