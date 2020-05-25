<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue * */
    private $user_id;
    /** @ORM\Column(type="string") * */
    private $user_name;
    /** @ORM\Column(type="string") * */
    private $email;
    /** @ORM\Column(type="string") * */
    private $role;
    /** @ORM\Column(type="boolean") * */
    private $active;
    /** @ORM\Column(type="string") * */
    private $password;
    /** @ORM\Column(type="string") * */
    private $activation_id;
    /** @ORM\Column(type="string") * */
    private $photo_path;
    /** @ORM\Column(type="string") * */
    private $description;
    /** @ORM\Column(type="integer") * */
    private $age;
    /** @ORM\Column(type="string") * */
    private $address;
    /**
     * @ORM\OneToMany(targetEntity="Messages", mappedBy="sender_id"))
     * @ORM\JoinColumn(name="user_id", referencedColumnName="sender_id")
     **/
    private $messagesSend;

    /**
     * @ORM\OneToMany(targetEntity="MsgReceived", mappedBy="user_id"))
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     **/
    private $messagesReceiv;

    /**
     * @return mixed
     */
    public function getMessagesReceiv()
    {
        return $this->messagesReceiv;
    }

    /**
     * @param mixed $messagesReceiv
     */
    public function setMessagesReceiv($messagesReceiv): void
    {
        $this->messagesReceiv = $messagesReceiv;
    }



    /**
     * @return mixed
     */
    public function getMessagesSend()
    {
        return $this->messagesSend;
    }

    /**
     * @param mixed $messagesSend
     */
    public function setMessagesSend($messagesSend): void
    {
        $this->messagesSend = $messagesSend;
    }



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
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name): void
    {
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getActivationId()
    {
        return $this->activation_id;
    }

    /**
     * @param mixed $activation_id
     */
    public function setActivationId($activation_id): void
    {
        $this->activation_id = $activation_id;
    }

    /**
     * @return mixed
     */
    public function getPhotoPath()
    {
        return $this->photo_path;
    }

    /**
     * @param mixed $photo_path
     */
    public function setPhotoPath($photo_path): void
    {
        $this->photo_path = $photo_path;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }


    public function getRoles()
    {
        return array($this->role);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
