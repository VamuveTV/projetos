<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\EvaluationRepository")
 * @ORM\Table(name="evaluation")
 */
class Evaluation
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $body;
    
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
     * @return Evaluation
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
     * Set creation_time
     *
     * @param \DateTime $creationTime
     * @return Evaluation
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
     * @return Evaluation
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
     * @return Evaluation
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
