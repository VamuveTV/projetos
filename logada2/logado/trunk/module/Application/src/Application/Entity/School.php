<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\SchoolRepository")
 * @ORM\Table(name="school")
 */
class School
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = null;

    /**
     * @ORM\OneToOne(targetEntity="Profile")
     **/
    protected $profile;
    
    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     **/
    protected $name;

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
     * Set name
     *
     * @param string $name
     * @return School
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set profile
     *
     * @param \Application\Entity\Profile $profile
     * @return School
     */
    public function setProfile(\Application\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \Application\Entity\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
