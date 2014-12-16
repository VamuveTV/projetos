<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\GradeRepository")
 * @ORM\Table(name="grade")
 */
class Grade
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="Subject")
     */
    protected $subject = null;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolClass")
     */
    protected $schoolClass = null;

    /**
     * @ORM\ManyToOne(targetEntity="School")
     */
    protected $school = null;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user = null;
    
    /**
     * @ORM\Column(type="decimal", precision=2, scale=1, nullable=false)
     */
    protected $value = null;
    
    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $term = null;

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
     * Set value
     *
     * @param string $value
     * @return Grade
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set term
     *
     * @param integer $term
     * @return Grade
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get term
     *
     * @return integer 
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set subject
     *
     * @param \Application\Entity\Subject $subject
     * @return Grade
     */
    public function setSubject(\Application\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \Application\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set schoolClass
     *
     * @param \Application\Entity\SchoolClass $schoolClass
     * @return Grade
     */
    public function setSchoolClass(\Application\Entity\SchoolClass $schoolClass = null)
    {
        $this->schoolClass = $schoolClass;

        return $this;
    }

    /**
     * Get schoolClass
     *
     * @return \Application\Entity\SchoolClass 
     */
    public function getSchoolClass()
    {
        return $this->schoolClass;
    }

    /**
     * Set school
     *
     * @param \Application\Entity\School $school
     * @return Grade
     */
    public function setSchool(\Application\Entity\School $school = null)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \Application\Entity\School 
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set user
     *
     * @param \Application\Entity\User $user
     * @return Grade
     */
    public function setUser(\Application\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
