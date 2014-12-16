<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Entity\SchoolClass;
use Application\Form\SchoolClassForm;


/**
 * SchoolClassController
 *
 * @author
 *
 * @version
 *
 */
class SchoolClassController extends BaseController
{
    
    /**
     * The default action - show the home page
     */    
    public function indexAction()
    {
        $classes = $this->getEntityManager()->createQuery('SELECT c FROM Application\Entity\SchoolClass c')->getResult();
        
    	return new ViewModel(array(
            'classes' => $classes
        ));
    }

    public function addAction()
    {
        $em = $this->getEntityManager();
        $schoolclass = new SchoolClass();
        $form = new SchoolClassForm($em);

        $teachers = $this->getTeachers($em);
        $form->get('teacher')->setAttribute('options' , $teachers);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->bind($schoolclass);
            $request_post = $request->getPost();
            $form->setData($request->getPost());
            
            //$schoolclass->setCreationTime(new \DateTime('now'));
            //$schoolclass->setPasswordHash($request_post['password']);
            //die(var_dump($form->get('academic_year')->getValue()));
            $schoolclass->setAcademicYear($form->get('academic_year')->getValue());
            
            $em->persist($schoolclass);
            $em->flush();
            return $this->redirect()->toRoute('school-class');
        }
        return array('form' => $form);
    }
    
    public function editAction()
    {
        $id = (int) $this->params('id', null);
        if (null === $id) {
            return $this->redirect()->toRoute('school-class');
        }
        
        $em = $this->getEntityManager();
        
        $schoolclass = $em->find('Application\Entity\SchoolClass', $id);
        $form = new SchoolClassForm($em);
        
        // Carregar professores
        $teachers = $this->getTeachers($em);
        $form->get('teacher')->setAttribute('options' , $teachers);
        
        $form->bind($schoolclass);

        // Selecionar ano correto
        //foreach ($form->get('academic_year')->getOptions(2013) as $op)
        //    if (op.getValue() == $schoolclass->)
        //$form->get('academic_year')->setAttribute('value' , $teachers);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$request_post = $request->getPost();
            $form->setData($request_post);
            
            if ($form->isValid()) {
                $schoolclass->setAcademicYear($form->get('academic_year')->getValue());
                
                $em->persist($schoolclass);
                $em->flush();
                
                $this->redirect()->toRoute('school-class');
            }
        }
        
        return array(
            'form' => $form,
            'id' => $id
        );
    }
    
    private function getTeachers($em)
    {
        $teachers = $em->createQuery('SELECT u.id, u.name FROM Application\Entity\User u WHERE u.role=2')->getResult();
        //die(var_dump($teachers));
        $teachers_aux = array();
        foreach ($teachers as $t) {
        	$teachers_aux[$t['id']] = $t['name'];
        }
        return $teachers_aux;
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params('id', null);
    	if ($id === null) {
    		return $this->redirect()->toRoute('school-class');
    	}
    
    	$em = $this->getEntityManager();
    
    	$schoolclass = $em->find('\Application\Entity\SchoolClass', $id);
    
    	$em->remove($schoolclass);
    	$em->flush();
    
    	$this->redirect()->toRoute('school-class');
    }
}