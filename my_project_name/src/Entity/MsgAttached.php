<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity @ORM\Table(name="msg_attached")
 **/
class MsgAttached
{
    /** @ORM\Id @ORM\Column(type="integer")*/
    private $msg_id;

    /** @ORM\Id @ORM\Column(type="string")*/
    private $file_name;

    /** @ORM\Column(type="string")*/
    private $original_name;

    /**
     * MsgAttached constructor.
     * @param $msg_id
     * @param $file_name
     * @param $original_name
     */
    public function __construct($msg_id, $file_name, $original_name)
    {
        $this->msg_id = $msg_id;
        $this->file_name = $file_name;
        $this->original_name = $original_name;
    }

    /**
     * @return mixed
     */
    public function getOriginalName()
    {
        return $this->original_name;
    }

    /**
     * @param mixed $original_name
     */
    public function setOriginalName($original_name): void
    {
        $this->original_name = $original_name;
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
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     */
    public function setFileName($file_name): void
    {
        $this->file_name = $file_name;
    }



}