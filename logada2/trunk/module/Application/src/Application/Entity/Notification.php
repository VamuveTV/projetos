<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\NotificationRepository")
 * @ORM\Table(name="notification")
 */
class Notification
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     **/
    protected $sender;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     **/
    protected $receiver;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $creation_time;
    
    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $type;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $seen;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $message;

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
     * Set creation_time
     *
     * @param \DateTime $creationTime
     * @return Notification
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
     * Set type
     *
     * @param integer $type
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set seen
     *
     * @param boolean $seen
     * @return Notification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return boolean 
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set sender
     *
     * @param \Application\Entity\User $sender
     * @return Notification
     */
    public function setSender(\Application\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \Application\Entity\User 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param \Application\Entity\User $receiver
     * @return Notification
     */
    public function setReceiver(\Application\Entity\User $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \Application\Entity\User 
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}
