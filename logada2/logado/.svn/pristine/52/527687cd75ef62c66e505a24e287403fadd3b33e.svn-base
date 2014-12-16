<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\SchoolClassRepository")
 * @ORM\Table(name="schoolclass")
 */
class SchoolClass
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Annotation\Attributes({"type":"hidden"})
     * @Annotation\AllowEmpty(true)
     */
    protected $id = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @Annotation\Type("Zend\Form\Element\Select") 
     **/
    protected $teacher;
    
    /**
     * @ORM\ManyToMany(targetEntity="User")
     **/
    protected $students;
    
    /**
     * @ORM\Column(type="string", length=45, nullable=false)
     * @Annotation\Options({"label":"Nome"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Validator({"name":"StringLength", "options":{"min":2, "max":127}, "locale": "pt_BR"})
     * @Annotation\ErrorMessage("Nomes devem conter de 2 a 127 caractéres.")
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Attributes({"type":"text"})
     */
    protected $name;
           
    /**
     * @ORM\Column(type="smallint", nullable=false)
     * @Annotation\Options({"label":"Ano"})
     * @Annotation\ErrorMessage("Insira uma data.") 
     * @Annotation\Required({"required":"true" })
     * @Annotation\Type("Zend\Form\Element\Select")
     */
    protected $academic_year;
    
    /**
     * @ORM\Column(type="smallint", nullable=false)
     * @Annotation\Options({"label":"Período letivo"})
     * @Annotation\ErrorMessage("Insira o período letivo.") 
     * @Annotation\Required({"required":"true" })
     * @Annotation\Type("Zend\Form\Element\Select") 
     */
    protected $terms;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return SchoolClass
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
     * Set academic_year
     *
     * @param integer $academicYear
     * @return SchoolClass
     */
    public function setAcademicYear($academicYear)
    {
        $this->academic_year = $academicYear;

        return $this;
    }

    /**
     * Get academic_year
     *
     * @return integer 
     */
    public function getAcademicYear()
    {
        return $this->academic_year;
    }

    /**
     * Set terms
     *
     * @param integer $terms
     * @return SchoolClass
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return integer 
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Set teacher
     *
     * @param \Application\Entity\User $teacher
     * @return SchoolClass
     */
    public function setTeacher(\Application\Entity\User $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \Application\Entity\User 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Add students
     *
     * @param \Application\Entity\User $students
     * @return SchoolClass
     */
    public function addStudent(\Application\Entity\User $students)
    {
        $this->students[] = $students;

        return $this;
    }

    /**
     * Remove students
     *
     * @param \Application\Entity\User $students
     */
    public function removeStudent(\Application\Entity\User $students)
    {
        $this->students->removeElement($students);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudents()
    {
        return $this->students;
    }
}
