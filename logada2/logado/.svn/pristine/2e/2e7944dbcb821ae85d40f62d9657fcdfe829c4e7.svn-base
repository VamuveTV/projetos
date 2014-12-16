<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\GiftRepository")
 * @ORM\Table(name="gift")
 */
class Gift
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Profile")
     **/
    protected $sender;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Profile")
     **/
    protected $receiver;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $type;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $accepted;

    /**
     * Set type
     *
     * @param integer $type
     * @return Gift
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
     * Set accepted
     *
     * @param boolean $accepted
     * @return Gift
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean 
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set sender
     *
     * @param \Application\Entity\Profile $sender
     * @return Gift
     */
    public function setSender(\Application\Entity\Profile $sender)
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
     * @return Gift
     */
    public function setReceiver(\Application\Entity\Profile $receiver)
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
