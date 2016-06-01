<?php
// src/BlogBundle/Entity/BlogPost.php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Posts")
 * @ORM\Entity
 */
#(repositoryClass="BlogBundle\Entity\BlogPostRepository")
class BlogPost
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $auth;

    private $login;

    public function setAuthor($author)
    {
        $this->login = $author;
    }

    public function getAuthor()
    {
        return $this->login;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getBody()
    {
        return $this->body; #mb_eregi_replace('\n', '<br>', $this->body);
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getTrimBody()
    {
        $p = mb_strpos($this->body, ' ', 150, 'UTF-8');
        return mb_strlen($this->body, 'UTF-8') > 150 ? rtrim(mb_substr($this->body, 0, !$p ? 150 : $p, 'UTF-8')).'...' : $this->body;  
    }

    public function getPostDate()
    {
        return $this->postDate->format('Y-m-d H:i');
    }

    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;
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
     * Set auth
     *
     * @param integer $auth
     *
     * @return BlogPost
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Get auth
     *
     * @return integer
     */
    public function getAuth()
    {
        return $this->auth;
    }

}
