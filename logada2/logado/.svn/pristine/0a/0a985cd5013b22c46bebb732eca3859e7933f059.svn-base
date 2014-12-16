<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\StarRatingRepository")
 * @ORM\Table(name="starrating")
 */
class StarRating
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
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $value;

    /**
     * Set value
     *
     * @param integer $value
     * @return StarRating
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set sender
     *
     * @param \Application\Entity\Profile $sender
     * @return StarRating
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
     * @return StarRating
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
