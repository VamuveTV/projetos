<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Entity\User;
use Application\Entity\UserRoles;
use Application\Entity\UserGenders;
use Application\Constants\Constants;
use Application\Form\AdminUserCreationForm;
use Application\Entity\Profile;

/**
 * UserController
 *
 * @author
 *
 * @version
 *
 */
class UserController extends BaseController
{
    private $editForm;
    
    /**
     * The default action - show the home page
     */    
    public function indexAction()
    {
        //$repository = $this->getEntityManager()->getRepository('\Application\Entity\User');
        //$users = $repository->findAll();
        
        //$this->em->getRepository('Federico\Entity\User')->getAllUsers();
        
        $users = $this->getEntityManager()->createQuery('SELECT u FROM Application\Entity\User u')->getResult();
        
        //return array(
        //    'users' => $users
        //);
        
        //$users = $this->getObjectManager()->getRepository('\Application\Entity\User')->findAll();
        
    	return new ViewModel(array('users' => $users));
    }
    
    public function addAction()
    {        
        $em = $this->getEntityManager();
        $form = new AdminUserCreationForm($em);
                
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();
            $form->bind($user);
            
            $request_post = $request->getPost();
            $form->setData($request_post);
            
            $prof = new Profile();
            //$prof->setDisplayName($request_post['displayName']);
            $prof->setDisplayName($request_post['name']);//FIXME: pegar displayname separado
            $prof->setBombCount(0);
            $prof->setHandshakeCount(0);
            $prof->setHeartCount(0);
            $prof->setStarRating(0.0);
            $prof->setPublicBombRating(FALSE);
            $prof->setPublicStarRating(FALSE);
            
            if ($form->isValid()) {
                $user->setCreationTime(new \DateTime('now'));
                $user->setPasswordHash(hash("sha256", $request_post['password'], FALSE));
                $user->setProfile($prof);
                
                $em->persist($user);
                $em->flush();
                return $this->redirect()->toRoute('user');
            }
            
            //die(var_dump($form->getMessages()));
        }
        return array('form' => $form);
    }
    
    public function editAction()
    {
        $id = (int) $this->params('id', null);
        if (null === $id) {
            return $this->redirect()->toRoute('user');
        }
        
        $em = $this->getEntityManager();
        //Registry::set('entityManager', $em);
        
        $user = $em->find('Application\Entity\User', $id);
        $prof = $user->getProfile();
        
        //$form = new PostForm();
        $form = new AdminUserCreationForm($em);
        
        $form->bind($user);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$request_post = $request->getPost();
            $form->setData($request_post);
            
            $name = $request_post['name'];
            $prof->setDisplayName($name);
            
            if ($form->isValid()) {
                $user->setPasswordHash(hash("sha256", $request_post['password'], FALSE));
        		
                $em->persist($user);
                $em->flush();
                
                $this->redirect()->toRoute('user');
            }
        }

        return array(
            'form' => $form,
            'id' => $id
        );
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params('id', null);
    	if ($id === null) {
    		return $this->redirect()->toRoute('user');
    	}
    
    	$em = $this->getEntityManager();
    
    	$user = $em->find('\Application\Entity\User', $id);
    
    	$em->remove($user);
    	$em->flush();
    
    	$this->redirect()->toRoute('user');
    }
    
    public function moodAction()
    {        
        $form = new Form();
        $form->add(array(
            'name' => 'moods',
            'type' => 'Radio',
            'options' => array(
        	   'value_options' => PostMoods::toArray(),
            )
        ));
        return array('form' => $form);
    }
}