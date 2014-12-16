<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("user")
 */
class User
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Annotation\Attributes({"type":"hidden"})
     * @Annotation\AllowEmpty(true)
     */
    protected $id;
            
    /**
     * @ORM\OneToOne(targetEntity="Profile", cascade={"persist", "remove"}) 
     **/
    protected $profile;
    
    /**
     * @ORM\Column(type="string", length=127, nullable=false, unique=true)
     * @Annotation\Options({"label":"E-mail"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Type("Zend\Form\Element\Email")
     */
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false) 
     * @Annotation\AllowEmpty(true)        
     */
    protected $password_hash;
    
    /**
     * @ORM\Column(type="smallint", nullable=false) 
     * @Annotation\Attributes({"value": "0"})
     * @Annotation\Type("Zend\Form\Element\Radio") 
     */
    protected $role;
    
    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     * @Annotation\Options({"label":"Nome"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Validator({"name":"StringLength", "options":{"min":2, "max":127}, "locale": "pt_BR"})
     * @Annotation\ErrorMessage("Nomes devem conter de 2 a 127 caractéres.")
     * @Annotation\Attributes({"type":"text"})
     */
    protected $name;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Options({"label":"Data de aniversário"})
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\ErrorMessage("Insira uma data.") 
     */
    protected $birthday;
    
    /**
     * 
     * @ORM\Column(type="smallint", nullable=false)     
     * @Annotation\Attributes({"value": "0"})
     * @Annotation\Type("Zend\Form\Element\Radio") 
     */
    protected $sex;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Options({"label":"Data de criação"})
     * @Annotation\Required({"required":"false" })
     * @Annotation\AllowEmpty(true)
     */
    protected $creation_time;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label": "Senha"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":8, "max":127}, "locale": "pt_BR"})
     */
    protected $password;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Options({"label":"Remember Me ?:"})
     * @Annotation\AllowEmpty(true)
     * @Annotation\Required({"required":"false"})
     * @Annotation\Options({"default": 0})
     
    public $rememberme = 0;*/
    
    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Submit"})
     */
    public $submit;
    
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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password_hash
     *
     * @param string $passwordHash
     * @return User
     */
    public function setPasswordHash($passwordHash)
    {
        $this->password_hash = $passwordHash;

        return $this;
    }

    /**
     * Get password_hash
     *
     * @return string 
     */
    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param integer $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return integer 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set sex
     *
     * @param integer $sex
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return integer 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set creation_time
     *
     * @param \DateTime $creationTime
     * @return User
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
     * Set profile
     *
     * @param \Application\Entity\Profile $profile
     * @return User
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