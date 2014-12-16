<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\CalendarEventRepository")
 * @ORM\Table(name="calendarevent")
 */
class CalendarEvent
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
    protected $owner;
    
    /**
     * @ORM\ManyToOne(targetEntity="Profile")
     **/
    protected $receiver;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $creation_time;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $start_date;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $end_date;
    
    /**
     * @ORM\Column(type="string", length=63, nullable=false)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    protected $location;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $hidden;

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
     * @return CalendarEvent
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
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return CalendarEvent
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $endDate
     * @return CalendarEvent
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return CalendarEvent
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return CalendarEvent
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CalendarEvent
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     * @return CalendarEvent
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean 
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set owner
     *
     * @param \Application\Entity\Profile $owner
     * @return CalendarEvent
     */
    public function setOwner(\Application\Entity\Profile $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Application\Entity\Profile 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set receiver
     *
     * @param \Application\Entity\Profile $receiver
     * @return CalendarEvent
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
