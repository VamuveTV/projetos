<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Application\Constants\Constants;
use Zend\Form\Element\Button;
use Zend\Form\Element\Submit;
use Application\Entity\Post;
use Application\Form\MoodSelectionForm;
use Application\Form\PostForm;

/**
 * InitialPostController
 *
 * @author
 *
 * @version
 *
 */
class InitialPostController extends BaseController
{       
    
    public function indexAction()
    {        
    	$form = new MoodSelectionForm();
    	$request = $this->getRequest();
    	    	
    	if ($request->isPost()) 
    	{
    	    $request_post = $request->getPost();
    	    $form->setData($request_post);	           	    
	        
    	    if ($form->isValid())
    	    {   
                $this->redirect()->toRoute('initial-post', 
                    array('action' => 'comment', 'mood' => $request_post['moods']));                
    	    }
    	}
    	
    	return array('form' => $form);
    }
    
    public function commentAction()
    {   
        $form = new PostForm();
        
        $form->add(array(
        		'name' => 'skip',
        		'type' => 'Submit',
        		'attributes' => array(
    				'value' => 'Não quero comentar',
    				'id' => 'submitbutton',
        		    'class' => 'btn',
        		)
        ));
        
        $request = $this->getRequest();        
        $mood = (int) $this->params('mood', -1);
        
        if ($request->isPost()) 
        {
            $form->setData($request->getPost());
            
            // o usuário apertou skip
            $skip = $request->getPost('skip') !== null;            
                        
        	if ($form->isValid())
        	{   
        	    $id = $this->identity()->getProfile();
        	    $profile = $this->getEntityManager()->find('Application\Entity\Profile', $id);
        	            	    
        	    $logadoPost = new Post();
        	    $logadoPost->setMood($mood);
        	    
        	    $postBody = $skip ? null : $form->get('comment')->getValue();        	    
        	    $logadoPost->setBody($postBody);
        	    
        	    $logadoPost->setCreationTime(new \DateTime('now'));        	    
        	    $logadoPost->setReceiver($profile);
        	    $logadoPost->setSender($profile);
        	    
        	    $this->getEntityManager()->persist($logadoPost);
        	    $this->getEntityManager()->flush();
        	    
        	    return $this->redirect()->toRoute('feed');
        	}
        }
        else 
        {            
            if ($mood === -1) {
            	return $this->redirect()->toRoute('home');
            }
        }
        
        // Colocamos a view "post" como filha desta view
        $view = new ViewModel(array('form' => $form));
        $postCreate = new ViewModel(array('form' => $form));
        $postCreate->setTemplate('application/post/postCreate');
        $view->addChild($postCreate, 'postCreate');
        
        return $view;
    }
}