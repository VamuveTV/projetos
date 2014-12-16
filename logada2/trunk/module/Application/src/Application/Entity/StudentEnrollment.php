<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\StudentEnrollmentRepository")
 * @ORM\Table(name="studentenrollment")
 */
class StudentEnrollment
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = null;
   
    /**
     * @ORM\OneToOne(targetEntity="School")
     */
    protected $school;
    
    /**
     * @ORM\OneToOne(targetEntity="User")
     */
    protected $user;
        
    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    protected $enrollment_code;

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
     * Set enrollment_code
     *
     * @param string $enrollmentCode
     * @return StudentEnrollment
     */
    public function setEnrollmentCode($enrollmentCode)
    {
        $this->enrollment_code = $enrollmentCode;

        return $this;
    }

    /**
     * Get enrollment_code
     *
     * @return string 
     */
    public function getEnrollmentCode()
    {
        return $this->enrollment_code;
    }

    /**
     * Set school
     *
     * @param \Application\Entity\School $school
     * @return StudentEnrollment
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
     * @return StudentEnrollment
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
