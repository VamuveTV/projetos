<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Constants\Constants;
use Application\Entity\User;
use Application\Entity\SchoolClass;
use Application\Entity\Subject;

class BaseController extends AbstractActionController
{
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    
    protected $form;

    protected $storage;

    protected $authservice;


    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function getAuthService()
    {
        if (! $this->authservice) {
            // $this->authservice = $this->getServiceLocator()->get('AuthService');
            $this->authservice = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        }
        
        return $this->authservice;
    }

    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()->get('Application\Entity\AuthStorage');
        }
        
        return $this->storage;
    }
    
    protected function getSchool($id)
    {
        $sql_school =
            'SELECT p FROM Application\Entity\Profile p '.
            'JOIN Application\Entity\School s '.
            'WITH s.profile=p.id WHERE s.id IN '.
                '(SELECT IDENTITY(se.school) FROM Application\Entity\StudentEnrollment se '.
                'JOIN se.user u WHERE se.user='.$id.')';
        
        $school = $this->getEntityManager()->createQuery($sql_school)->getResult();
        return $school;
    }
    
    protected function getClass($id)
    {
        //TODO: implementar recuperação de classe
        
        //$sql_class = 
            //'SELECT sc FROM Application\Entity\SchoolClass sc '.
            //'JOIN sc.students s '.
            //'WITH s.id<10';//.$id;
        //$sql_class = 
        //    'SELECT sc FROM Application\Entity\User u '.
        //    'JOIN Application\Entity\SchoolClass sc '.
        //    'WITH u.id=sc.students '.
        //    'WHERE u.id='.$id;
        //$class = $this->getEntityManager()->createQuery($sql_class)->getResult();
        
        $class = new SchoolClass();
        $class->setName( 'Minha Turma');
        $class->setAcademicYear(5);
        $class->setTerms(4);
        return $class;
    }
}