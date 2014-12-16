<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="Profile")
     **/
    protected $sender;
    
    /**
     * @ORM\ManyToOne(targetEntity="Profile")
     **/
    protected $receiver;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $body;
    
    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $mood;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $creation_time;

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
     * Set body
     *
     * @param string $body
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set mood
     *
     * @param integer $mood
     * @return Post
     */
    public function setMood($mood)
    {
        $this->mood = $mood;

        return $this;
    }

    /**
     * Get mood
     *
     * @return integer 
     */
    public function getMood()
    {
        return $this->mood;
    }

    /**
     * Set creation_time
     *
     * @param \DateTime $creationTime
     * @return Post
     */
    public function setCreationTime($creationTime)
    {
        $this->creation_time = $creationTime;

        return $this;
    }

    /**
     * Get creation_time
     *
     * @return \DateTime 
     */
    public function getCreationTime()
    {
        return $this->creation_time;
    }

    /**
     * Set sender
     *
     * @param \Application\Entity\Profile $sender
     * @return Post
     */
    public function setSender(\Application\Entity\Profile $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \Application\Entity\Profile 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param \Application\Entity\Profile $receiver
     * @return Post
     */
    public function setReceiver(\Application\Entity\Profile $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \Application\Entity\Profile 
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}
