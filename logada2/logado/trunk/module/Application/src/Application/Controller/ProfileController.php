<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Entity\Post;
use Application\Form\ProfileQuizForm;
use Application\Form\ProfileQuizFormValidator;
use Application\Entity\Grade;
use Application\Form\FriendsForm;
use Application\Entity\School;
use Application\Entity\Profile;

/**
 * ProfileController
 *
 * @author
 *
 * @version
 *
 */
class ProfileController extends BaseController
{
    /**
     * Ação para visualizar o próprio perfil
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
    	// Id do visualizador e visualizado
    	//$id = $this->identity()->getId();
    
    	$em = $this->getEntityManager();
    	//$user = $em->find('Application\Entity\User', $id);
    	$user = $this->identity();
    	$profile = $user->getProfile();
    	$profileId = $profile->getId();
    
    	// Obter escola
    	//TODO: otimizar para pegar só o nome
    	$school = $this->getSchool($user->getId());
    	if (empty($school))
    		$school = 'Sem escola';
    	else
    		$school = $school[0]->getDisplayName();
    
    	// Obter turma
    	$class = $this->getClass($user->getId());
    
    	$postRepo = $em->getRepository('Application\Entity\Post');
    
    	$form = new PostForm();
    	$feed = $postRepo->getPublicPosts($profileId);
    
    	// Setup das views
    	$view = new ViewModel(array(
    			'profile' => $profile,
    			'form' => $form,
    			'school' => $school,
    			'class' => $class
    	));
    
    	$postCreate = new ViewModel(array('form' => $form));
    	$postCreate->setTemplate('application/post/postCreate');
    
    	$postDisplay = new ViewModel(array('feed' => $feed));
    	$postDisplay->setTemplate('application/post/postDisplay');
    
    	$view->addChild($postDisplay, 'postDisplay');
    	$view->addChild($postCreate, 'postCreate');
    
    	return $view;
    }
    
    /**
     * Ação para visualizar o perfil de outro usuário
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|\Zend\View\Model\ViewModel
     */
    public function viewAction()
    {
        // Id do usuário visualizado
        $id = (int) $this->params('id', null);
        if (null === $id) {
        	return $this->redirect()->toRoute('home');
        }
        
        //Se o perfil selecionado for do proprio usuario
        if ($id == $this->identity()->getProfile()->getId()) {
        	return $this->redirect()->toRoute('profile', array('action' => 'index'));
        }
        
        // Perfil do visualizador
        $viewer_profile_id = $this->identity()->getProfile();
        
        // Obter usuário
        $em = $this->getEntityManager();
        //$user = $em->find('Application\Entity\User', $user_id);
        //$profile = $user->getProfile();
        //$profileId = $profile->getId();
        $profile = $em->find('Application\Entity\Profile', $id);
        
        // Obter amizade e posts
        $friendshipRepo = $em->getRepository('Application\Entity\Friendship');        
        $postRepo = $em->getRepository('Application\Entity\Post');
        
        // Confirmar se existe amizade
        $hasFriendship = $friendshipRepo->checkFriendship($id, $viewer_profile_id);
        
        $form = new PostForm();
        $feed = $postRepo->getPublicPosts($id);
        
        // Setup das views
        $view = new ViewModel(array(
            'profile' => $profile, 
            'form' => $form,
            'hasFriendship' => $hasFriendship,
        ));
        
        $postCreate = new ViewModel(array('form' => $form));
        $postCreate->setTemplate('application/post/postCreate');
        
        $postDisplay = new ViewModel(array('feed' => $feed));
        $postDisplay->setTemplate('application/post/postDisplay');
        
        $view->addChild($postDisplay, 'postDisplay');
        $view->addChild($postCreate, 'postCreate');
        
        return $view;
    }
    
    /**
     * Ação para editar o perfil
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|multitype:number \Application\Form\ProfileQuizForm
     */
    public function editAction()
    {
        $id = (int) $this->params('id', null);
        if (! $id) {
        	return $this->redirect()->toRoute('profile');
        }
        
        $em = $this->getEntityManager();
        
        $user = $this->identity();
        $profile = $em->find('Application\Entity\Profile', $id);
        
        //$form = new PostForm();
        //$form = new AdminUserCreationForm($em);
        
        //$form->bind($profile);
        
        $form = new ProfileQuizForm();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	$request_post = $request->getPost();
        	//$form->setData($request_post);
        	//$qwer = $form->get('fullname');
        
        	$formValidator = new ProfileQuizFormValidator();
        	{
        		$form->setInputFilter($formValidator->getInputFilter());
        		$form->setData($request->getPost());
        	}
        	
        	if ($form->isValid()) {
            	$values = $form->getValues();
            	die(var_dump($values));
        		//$profile->setPasswordHash($request_post['password']);
        
        		//$em->persist($profile);
        		//$em->flush();
        
        		$this->redirect()->toRoute('profile');
        	}
        }
        
        return array(
    		'form' => $form,
    		'id' => $id
        );
    }
    
    /**
     * Ação para persistir a postagem
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function postToWallAction()
    {
        $id = (int) $this->params('id', null);
        if (null === $id) {
        	return $this->redirect()->toRoute('home');
        }
        
        $sender_profile_id = $this->identity()->getProfile();
        $receiver_profile_id = $id;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$form = new PostForm();
        	$form->setData($request->getPost());
        	if ($form->isValid())
        	{
        	    $em = $this->getEntityManager();
        	    
        	    $sender = $em->find('Application\Entity\Profile', $sender_profile_id);
        	    $receiver = $em->find('Application\Entity\Profile', $receiver_profile_id);
        	    
        	    $logadoPost = new Post();
        	    $logadoPost->setBody($form->get('comment')->getValue());
        	    $logadoPost->setCreationTime(new \DateTime('now'));
        	    $logadoPost->setReceiver($receiver);
        	    $logadoPost->setSender($sender);
        	            	    
        	    $em->persist($logadoPost);
        	    $em->flush();
        	}        	
        }
        
        /*if ($sender_profile_id == $receiver_profile_id)
            return $this->redirect()->toRoute('profile', 
                array('action' => 'view-personal', 'param' => $receiver_profile_id));
        else
            return $this->redirect()->toRoute('profile', 
                array('action' => 'view', 'param' => $receiver_profile_id));*/
        return $this->redirect()->toRoute('home');
    }
    
    /**
     * Ação para imprimir boletim do usuário
     * @return multitype:int Subjects
     */
    public function reportCardAction()
    {
        $id = $this->identity()->getProfile()->getId();
        
        //FIXME: recuperar disciplinas nas quais o aluno está inscrito, e não todas as disciplinas
        //$subjects = $this->getSubjects($id);
        $class = $this->getClass($id);
        $grades = $this->getGrades($id);
        
        //Organiza notas em uma matriz (array de arrays)
        //No primeiro array constam os nomes das disciplinas, e nos arrays internos
        //a chave são os períodos (terms - que correspondem aos bimestres, 
        //trimestres, etc, dependendo de como a escola organiza as provas) e nos 
        //valores são colocadas as notas
        $grades_array = array();
        foreach ($grades as $g) {
            $grades_array[$g->getSubject()->getName()][$g->getTerm()] = $g->getValue(); 
        }
        
        return array(
    		'id' => $id,
            'terms' => $class->getTerms(),
            'grades' => $grades_array
        );
    }
    
    /**
     * Ação para recuperar amigos e amigos favoritos
     * @return \Zend\View\Model\ViewModel
     */
    public function friendsAction()
    {
        $em = $this->getEntityManager();
        $form = new FriendsForm($em);
        
        $profile = $this->identity()->getProfile();
        
        $friendshipRepo = $em->getRepository('Application\Entity\Friendship');
        
        $friends = null;
        $favfriends = null;
        $found_friends = null;
        $main = true;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('submit_search')) {
            	$request_post = $request->getPost();
        		$form->setData($request_post);
        		if ($form->isValid()) {
        			$name = $form->get('username')->getValue();
        			if ($name != null)
        				$found_friends = $friendshipRepo->getFriendByName($profile, $name);
        			/*else 
        			$class = $form->get('classes')->getValue();
        			if ($class == -1)
        				$class = null;*/
        		}
        		$main = false;
            }
        } 
        
        if ($request->isGet() || !$main) {
            // Recuperar amigos favoritos
            $favfriends = $friendshipRepo->getFavoriteFriendsOf($profile);
            
            // Recuperar todos os amigos
            $friends = $friendshipRepo->getAllFriendsOf($profile);

            //FIXME: modelo não permite cadastrar mais de um user na escola. Corrigir.
            //FIXME: otimizar recuperação das escolas, que pode vir juntos dos profiles
            /*foreach ($friends as $f) {
             $f['school'] = $this->getSchool($f->getId())->getDisplayName();
            }*/
        }
        
        return new ViewModel(array('form' => $form, 'favfriends' => $favfriends, 'friends' => $friends, 'found_friends' => $found_friends));
    }
    
    private function quizForm()
    {
        $form = new ProfileQuizForm();
        $request = $this->getRequest();
        
        if($request->isPost())
        {
        	$user = new ProfileQuiz();
        
        	$formValidator = new ProfileQuizFormValidator();
        	{
        		$form->setInputFilter($formValidator->getInputFilter());
        		$form->setData($request->getPost());
        	}
        	 
        	if($form->isValid()) {
    			$user->exchangeArray($form->getData());
        	}
        }
    	return ['form' => $form];
    }
    
    /**
     * Obtém disciplinas do usuário
     * Como parâmetro recebe a id de um User
     * @param int $id
     * @return Subjects
     */
    protected function getSubjects($id)
    {
        //FIXME: recuperar disciplinas nas quais o aluno está inscrito, e não todas as disciplinas
        
        $sql_subjs = 'SELECT s FROM Application\Entity\Subject s';
        $subjects = $this->getEntityManager()->createQuery($sql_subjs)->getResult();
        
        return $subjects;
    }
    
    /**
     * Obtém Notas de todas as disciplinas do usuário indicado (User id)
     * @param int $id
     * @return Grades
     */
    protected function getGrades($id)
    {
        $sql_grades = 'SELECT g FROM Application\Entity\Grade g ';//.
            //'WHERE g.user='.$id;//.' ORDER BY g.subject ASC';
        
        $grades = $this->getEntityManager()->createQuery($sql_grades)->getResult();
        return $grades;
    }
}