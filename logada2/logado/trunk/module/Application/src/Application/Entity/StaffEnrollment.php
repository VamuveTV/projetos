<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\StaffEnrollmentRepository")
 * @ORM\Table(name="staffenrollment")
 */
class StaffEnrollment
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
     * @ORM\Column(type="string", length=1, nullable=false)
     */
    protected $membership_type;

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
     * @return StaffEnrollment
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
     * Set membership_type
     *
     * @param string $membershipType
     * @return StaffEnrollment
     */
    public function setMembershipType($membershipType)
    {
        $this->membership_type = $membershipType;

        return $this;
    }

    /**
     * Get membership_type
     *
     * @return string 
     */
    public function getMembershipType()
    {
        return $this->membership_type;
    }

    /**
     * Set school
     *
     * @param \Application\Entity\School $school
     * @return StaffEnrollment
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
     * @return StaffEnrollment
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
