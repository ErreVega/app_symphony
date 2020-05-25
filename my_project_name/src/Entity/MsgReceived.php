<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity @ORM\Table(name="msg_received")
 * @ORM\Entity(repositoryClass="App\Repository\MsgReceivedRepository")
 **/
class MsgReceived
{
    /** @ORM\Id @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user_id")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $user_id;


    /** @ORM\Id @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Messages", inversedBy="msg_id")
     * @ORM\JoinColumn(name="msg_id", referencedColumnName="msg_id")
     */
    private $msg_id;

    /** @ORM\Column(type="boolean") */
    private $readed;

    /**
     * MsgReceived constructor.
     * @param $user_id
     * @param $msg_id
     * @param $readed
     */
    public function __construct($user_id, $msg_id)
    {
        $this->user_id = $user_id;
        $this->msg_id = $msg_id;
        $this->readed = 0;
    }

    /**
     * MsgReceived constructor.
     * @param $user_id
     * @param $msg_id
     */


    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getMsgId()
    {
        return $this->msg_id;
    }

    /**
     * @param mixed $msg_id
     */
    public function setMsgId($msg_id): void
    {
        $this->msg_id = $msg_id;
    }

    /**
     * @return mixed
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * @param mixed $readed
     */
    public function setReaded($readed): void
    {
        $this->readed = $readed;
    }


}
