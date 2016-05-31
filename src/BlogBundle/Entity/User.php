<?php
// src/BlogBundle/Entity/User.php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="Users")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\UserRepository")
 * @UniqueEntity(fields = "login",message = "This username already taken")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="BlogPost", mappedBy="id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     * @Assert\NotBlank()
     */
    private $login;

    /**
     * @Assert\NotBlank()
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $pass;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;


    public function getUserID()
    {
        return $this->id;
    }

    public function setUserID($UserID)
    {
        $this->id = $UserID;
    }

    public function getUserName()
    {
        return $this->login;
    }

    public function setUserName($login)
    {
        $this->login = $login;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->pass;
    }

    public function setPassword($pass)
    {
        $this->pass = $pass;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRoles()
    {
        return array('ROLE_USER'); #$this->role;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->login,
            $this->pass,
            #$this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->login,
            $this->pass,
            #$this->salt,
            ) = unserialize($serialized);
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

}
