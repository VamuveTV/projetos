<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Constants\Constants;
use Application\Form\OpinionForm;
use Application\Form\PostForm;
use Application\Entity\StarRating;
use Application\Entity\Evaluation;
use Application\Form\OpinionEditForm;
use Application\Entity\Gift;
use Application\Entity\Profile;


/**
 * UserController
 *
 * @author
 *
 * @version
 *
 */
class OpinionController extends BaseController
{
    private $editForm;
    
    /**
     * The default action - show the home page
     */    
    public function indexAction()
    {
        //TODO: OTIMIZAR ESSA AÇÃO, QUE PEGA DE INÍCIO TODOS OS ALUNOS, PROFESSORES E ESCOLA
        $em = $this->getEntityManager();
        $form = new OpinionForm($em);
        //$form = $this->getForm();
        
        $id = $this->identity()->getId();
        
        $acad_year = null;
        $class = null;
        $pos = null;
        $disc = null;
        
        $request = $this->getRequest();
        //if ($request->isPost() == '') {
        if ($request->isPost()) {
            if ($request->getPost('submit_student')) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                	$acad_year = $form->get('acad_year')->getValue();
                	if ($acad_year == 0)
                	    $acad_year = null;
                	$class = $form->get('classes')->getValue();
                	if ($class == -1)
                	    $class = null;
                }
                
            } else if ($request->getPost('submit_staff')) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                	$pos = $form->get('position')->getValue();
                	if ($pos == -1)
                		$pos = null;
                	$disc = $form->get('disciplines')->getValue();
                	if ($disc == 0)
                		$disc = null;
                }
                
            }
        } 
        
        //$classes = $this->getClasses();
        //Imprimir classes
        //$this->printClasses($classes, $form);
        //if ($acad_year)
        //    $form->get('classes')->setValue($acad_year);
        //else 
        //    $form->get('classes')->setValue('-1'); // default value
        
        $bombs = array();
        
        // Pegar alunos excluindo o proprio
        $students = $this->getStudents($id, $acad_year, $class);
        
        // Verificar se tem bomba associada
        foreach ($students as $p) {
        	if ($this->getBomb($p->getId()))
        		$bombs[] = $p->getId();
        }
        
        // Pegar funcionarios
        $staff = $this->getStaff($pos, $disc);
        
        foreach ($staff as $p) {
        	if ($this->getBomb($p->getId()))
        		$bombs[] = $p->getId();
        }
        
        //Pegar escola
        $school = $this->getSchool($id);

        foreach ($school as $p) {
        	if ($this->getBomb($p->getId()))
        		$bombs[] = $p->getId();
        }
        
    	return new ViewModel(array('form' => $form, 'students' => $students, 'staff' => $staff, 
    	    'school' => $school, 'bombs' => $bombs));
    }
    
    public function filterAction()
    {
        //como pegar o tipo de submit:
        //$request->getPost('submit') == 'unique Label'
        
        // Ano academico
        $acad_year = strval($this->params('acad_year', null));
        if (! $acad_year) {
        	return $this->redirect()->toRoute('opinion');
        }
        
        $em = $this->getEntityManager();
        $form = new OpinionForm($em);
        
        $id = $this->identity()->getId();

        // Pegar alunos excluindo o proprio
        $students = $this->getStudents($id, $acad_year);
        
        // Pegar funcionarios
        $staff = $this->getStaff();
        
        //Pegar escola
        $school = $this->getSchool($id);
        
        $classes = $this->getClasses();
        //Imprimir classes
        $this->printClasses($classes, $form);
        
        return new ViewModel(array('form' => $form, 'students' => $students, 'staff' => $staff,
            'school' => $school, 'classes' => $classes));
    }
    
    public function editAction()
    {
        // Id do perfil de usuário visualizado
        $id = (int) $this->params('id', null);
        if (! $id) {
        	return $this->redirect()->toRoute('home');
        }
        // Se o perfil selecionado for do proprio usuario
        if ($id == $this->identity()->getProfile()->getId()) {
        	return $this->redirect()->toRoute('home');
        }
        
        // Tipo do perfil (se de aluno, funcionario ou escola)
        $proftype = (int) $this->params('prof', null);
        
        //if ($proftype == Constants::PROFILE_STUDENT || $proftype == Constants::PROFILE_STAFF)
        //    $userid =  $this->getEntityManager()
        //        ->createQuery('SELECT u.id FROM Application\Entity\User u '.
        //    		'WHERE u.profile='.$id)->getSingleScalarResult();
        
        // Perfil do visualizador
        $viewer_profile_id = $this->identity()->getProfile();
        
        // Obter usuário
        $em = $this->getEntityManager();
        $profile = $em->find('Application\Entity\Profile', $id);

        // Obter escola
        $school = $this->getSchool($id);
        if (empty($school))
            $school = 'Sem escola';
        else
            $school = $school->getName();
        
        // Obter turma
        $class = $this->getClass($id);

        // Obter amizade
        $friendshipRepo = $em->getRepository('Application\Entity\Friendship');
        
        // Confirmar se existe amizade
        $hasFriendship = $friendshipRepo->checkFriendship($id, $viewer_profile_id);
        
        // Obter avaliação
        $rating = $this->getEntityManager()
            ->createQuery('SELECT u FROM Application\Entity\StarRating u '.
                'WHERE u.receiver='.$id.' AND u.sender='.$viewer_profile_id->getId())
            ->getOneOrNullResult();
        // Verifica se há algum resultado
        if(! $rating) {
            $rating = 0;
        } else {
            $rating = $rating->getValue();
        }
        
        $form = new OpinionEditForm();
        
        // Setup das views
        $view = new ViewModel(array(
            'profile' => $profile, 
            'form' => $form,
            'hasFriendship' => $hasFriendship,
            'rating' => $rating,
            'school' => $school,
            'class' => $class,
            'proftype' => $proftype
        ));
        
        $postCreate = new ViewModel(array('form' => $form));
        $postCreate->setTemplate('application/post/postCreate');
        $view->addChild($postCreate, 'postCreate');
        
        return $view;
    }
    
    public function submitOpinionAction()
    {
        $em = $this->getEntityManager();
            	    
	    // Id do avaliado (receiver)
        $receiver_profile_id = (int) $this->params('id', null);
        // Opiniao/Avaliacao
        $rating = (int) $this->params('rating', null);
        if ($receiver_profile_id == null || $rating == null) {
        	return $this->redirect()->toRoute('opinion');
        }
        
        // Obter sender e receiver
        $sender = $this->identity()->getProfile();
        $receiver = $em->find('Application\Entity\Profile', $receiver_profile_id);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$form = new OpinionEditForm();
        	$form->setData($request->getPost());
        	
            if ($request->getPost('submit')) {	
                if ($form->isValid()) {
            	    // Se existe uma nova mensagem
            	    if (trim($form->get('comment')->getValue()) != "") {
                	    // Compor mensagem
                	    $evaluation = new Evaluation();
                	    $evaluation->setBody($form->get('comment')->getValue());
                	    $evaluation->setCreationTime(new \DateTime('now'));
                	    $evaluation->setReceiver($receiver);
                	    $evaluation->setSender($sender);
    
                	    // Armazenar nova mensagem
                	    $em->persist($evaluation);
                	    $em->flush();
            	    }
            	}
            	
            } else if ($request->getPost('submit_bomb')) {
                $gift = new Gift();
                $gift->setSender($sender);
                $gift->setReceiver($receiver);
                $gift->setType(Constants::GIFT_BOMB);
                
            	$em->persist($gift);
            	$em->flush();
            	
        	} else if ($request->getPost('submit_rating')) {
        	    if ($rating) {
            	    // Obter avaliação
            	    $starrating = $this->getEntityManager()
                        ->createQuery('SELECT u FROM Application\Entity\StarRating u '.
                            'WHERE u.receiver='.$receiver_profile_id.' AND u.sender='.$sender_profile_id)
                        ->getOneOrNullResult();
            	    // Verifica se há algum resultado
            	    if(! $starrating) {
            	    	$starrating = new StarRating();
                	    $starrating->setReceiver($receiver);
                	    $starrating->setSender($sender);
            	    } 
            	    
            	    if ($starrating->getValue() != $rating) {
                	    $starrating->setValue($rating);
                	    
                	    $em->merge($starrating);
                        $em->flush();
            	    }
        	    }
        	}
        }
        
        return $this->redirect()->toRoute('opinion');
    }
    
    protected function getStudents($id, $acad_year, $class)
    {
        // Pegar alunos excluindo o proprio
        if ($acad_year) {
            $sql_stdts =
                'SELECT p FROM Application\Entity\Profile p '.
                'WHERE p.id IN '.
                    '(SELECT IDENTITY(u.profile) FROM Application\Entity\SchoolClass sc '.
                    'JOIN sc.students u WHERE sc.academic_year='.$acad_year.')';
            
        } else if ($class) {
            $sql_stdts =
                'SELECT p FROM Application\Entity\Profile p WHERE p.id IN '.
                    '(SELECT IDENTITY(u.profile) FROM Application\Entity\SchoolClass sc '.
                    'JOIN sc.students u WHERE sc.id='.$class.')';
        } else {
            $sql_stdts = 
                'SELECT p FROM Application\Entity\Profile p '.
                'JOIN Application\Entity\User u '.
                'WITH p.id=u.profile '.
                'WHERE u.role='.strval(Constants::STUDENT).' AND u.id<>'.$id;
        }
        
        $students = $this->getEntityManager()->createQuery($sql_stdts)->getResult();
        return $students;
    }
    
    protected function getStaff($pos, $disc)
    {
        if ($pos) {
            $sql_staff =
                'SELECT p FROM Application\Entity\Profile p WHERE p.id IN '.
                    '(SELECT IDENTITY(u.profile) FROM Application\Entity\SchoolClass sc '.
                    'JOIN sc.teacher u WHERE sc.id='.$pos.')';
        } else if ($disc) {
            $sql_staff =
                'SELECT p FROM Application\Entity\Profile p WHERE p.id IN '.
                    '(SELECT IDENTITY(u.profile) FROM Application\Entity\SchoolClass sc '.
                    'JOIN sc.teacher u WHERE sc.id='.$disc.')';
            
        } else {
            $sql_staff =
                'SELECT p FROM Application\Entity\Profile p '.
                'JOIN Application\Entity\User u '.
                'WITH p.id=u.profile '.
                'WHERE u.role='.strval(Constants::STAFF);
        }
        
        $staff = $this->getEntityManager()->createQuery($sql_staff)->getResult();
        return $staff;
    }
    
    protected function getClasses()
    {
        //FIXME: PEGAR APENAS A ESCOLA QUE O USUARIO ESTUDA E AS TURMAS DAQUELA E AS DISCIPLINAS ESCOLA
        $sql_classes = 'SELECT s FROM Application\Entity\SchoolClass s';
        $classes = $this->getEntityManager()->createQuery($sql_classes)->getResult();
        return $classes;
    }

    protected function getGift($id)
    {
    	$sql_gift = 'SELECT g FROM Application\Entity\Gift g WHERE g.receiver='.$id;
    
    	$gift = $this->getEntityManager()->createQuery($sql_gift)->getResult();
    	return $gift;
    }

    protected function getBomb($id)
    {
        $q = 'SELECT g FROM Application\Entity\Gift g '.
        		'WHERE g.receiver=:profile_id AND g.type='.Constants::GIFT_BOMB;
        $q = $this->getEntityManager()->createQuery($q);
        $q->setParameter('profile_id', $id);
        
    	return $q->getResult();
    }
    
    protected function printClasses($classes, $form)
    {
        //$val = $form->get('classes')->getValue();
        $classes_array = array('-1' => 'Escolha a Turma');
        foreach ($classes as $class) {
        	$classes_array[$class->getId()] = $class->getName();
        }
        die(var_dump($classes_array));
        $form->get('classes')->setOptions(array(
        		'value_options' => $classes_array,
            )
        );
        
        return $classes;
    }
}