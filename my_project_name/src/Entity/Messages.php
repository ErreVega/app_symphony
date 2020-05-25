<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="App\Repository\MessagesRepository")

 **/
class Messages
{

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue * */
    private $msg_id;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="user_id")
     **/
    private $sender_id;
    /** @ORM\Column(type="datetime") * */
    private $date;
    /** @ORM\Column(type="string") * */
    private $subject;
    /** @ORM\Column(type="string") * */
    private $body;

    /**
     * Messages constructor.
     * @param $sender_id
     * @param $date
     * @param $subject
     * @param $body
     */
    public function __construct($sender_id, $date, $subject, $body)
    {
        $this->sender_id = $sender_id;
        $this->date = $date;
        $this->subject = $subject;
        $this->body = $body;
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
    public function getSenderId()
    {
        return $this->sender_id;
    }

    /**
     * @param mixed $sender_id
     */
    public function setSenderId($sender_id): void
    {
        $this->sender_id = $sender_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }


}