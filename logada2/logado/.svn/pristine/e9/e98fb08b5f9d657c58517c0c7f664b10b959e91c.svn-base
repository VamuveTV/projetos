<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use ZendAuthenticationAuthenticationService;
use Application\Form\LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManager;
use Application\Form\LoginFormValidator;
use Application\Constants\Constants;

class AuthController extends BaseController
{
    
    public function getForm()
    {
        /*if (! $this->form) {
            $this->$form = new LoginForm(); 
        }
        $request = $this->getRequest(); 
        if ($request->isPost()) { 
            $form->setData($request); 
            $user = new User(); 
            $this->view->user = $user; 
            $formValidator = new LoginFormValidator(); { 
                $form->setInputFilter($formValidator->getInputFilter()); 
                $form->setData($request->getPost()); 
            } 
            if ($form->isValid()) { 
                $user->exchangeArray($form->getData()); 
            } 
        } //return ['form' => $form]; return array('form' => $form);*/
        
        if (! $this->form) {
            $user = new User();
            $builder = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }
        
        return $this->form;
    }

    public function loginAction()
    {
        // if already login, redirect to success page
        if ($this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('user');
        }
        
        $form = $this->getForm();
        
        return array(
            'form' => $form,
            'messages' => $this->flashmessenger()->getMessages()
        );
        // return array('form' => $form);
    }

    /*public function loginAction()
    {
    	$data = $this->getRequest()->getPost();
    
    	// If you used another name for the authentication service, change it here
    	$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
    
    	$adapter = $authService->getAdapter();
    	$adapter->setIdentityValue($data['email']);
    	$adapter->setCredentialValue($data['password']);
    	$authResult = $authService->authenticate();
    
    	if ($authResult->isValid()) {
    		return $this->redirect()->toRoute('home');
    	}
    
    	return new ViewModel(array(
    			'error' => 'Your authentication credentials are not valid',
    	));
    }*/
    
    public function authenticateAction()
    {
        //$form = $this->getForm();
        $form = new LoginForm();
        
    	$redirect = 'login';
    	//die(var_dump('entrou1'));
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    	    //$form->setData($request->getPost());
    	    
    	    $validator = new LoginFormValidator();
    	    $form->setInputFilter($validator->getInputFilter());
    	    $form->setData($request->getPost());
    	    
    	    //$filter = new LoginFormValidator();
            //echo $filter->filter($form);
    	    /*$formValidator = new LoginFormValidator(); {
    	    	$form->setInputFilter($formValidator->getInputFilter());
    	    	$form->setData($request->getPost());
    	    }*/
    	    
    	    //die(var_dump($form));
    	    if ($form->isValid()) {
    	    	$data = $form->getData();
    	    	//$email = $data->getPost('email');
    	    	$email = $data['email'];
    	    	$password_hash = hash("sha256", $data['password'], FALSE);
    	    	//echo $email;
    	    	// FIXME : hard-coded:
    	    	//$id = 3;
    	    	//$email = 'matherthal@gmail.com';
    	    	//$password = 'ed2b1f468c5f915f3f1cf75d7068baae';
    	    	$em = $this->getEntityManager();
    	    	$user = $this->getEntityManager()
                    ->createQuery(
                        'SELECT u FROM Application\Entity\User u '.
                        'WHERE u.email=\''.$email.'\' AND u.password_hash=\''.$password_hash.'\'')
    	    	    ->getResult();
	    	
    	    	//$user = $em->find('Application\Entity\User', $id);
    	    	
    	    	$authService = $this->getAuthService();
    	    	$adapter = $authService->getAdapter();
    	    	//$adapter->setIdentityValue($user);
    	    	$adapter->setIdentityValue($email);
    	    	$adapter->setCredentialValue($email);
    	    	
    	    	// Attempt authentication, saving the result
    	    	$result = $this->getAuthService()->authenticate();
    	    	
    	    	if ($result->isValid()) {
    	    		// Authentication succeeded; the identity ($username) is stored
    	    		// in the session
    	    		// $result->getIdentity() === $auth->getIdentity()
    	    		// $result->getIdentity() === $username
    	    	
    	    		//$layout = Zend_Layout::getMvcInstance();
    	    		//$layout->setLayout('layout_admin');
    	    		//Zend_Controller_Action_HelperBroker::addHelper($helper);
    	    		//$helper->layout->setLayout('layout_admin');
    	    		//Zend_Controller_Action_HelperBroker::addPrefix('User_Helpers');
    	    		//$helper = $this->_helper->getHelper('User_Helper');
    	    		//$helper->doSmth();
    	    		//$this->_helper->layout->setLayout('layout_admin');
                    
    	    	    if ($this->identity()->getRole() == Constants::ADMIN || $this->identity()->getRole() == Constants::STAFF)
    	    	        $redirect = 'home';
    	    	    else if ($this->identity()->getRole() == Constants::STUDENT)
                        $redirect = 'initial-post';
    	    		//$this->getAuthService()->setStorage($this->getSessionStorage());
    	    		//$this->getAuthService()->getStorage()->write($email);
    	    	}
    	    }
    	}
    	
    	return $this->redirect()->toRoute($redirect);
    }    
    
    /*public function authenticateAction()
    {
        $form = $this->getForm();
        $redirect = 'login';
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                return $this->redirect()->toRoute('user');
                $data = $form->getData();
                
                //try {
                //    $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                //} catch (\Exception $e) {
                //    var_dump($e->getTraceAsString());
                //}
                //
                //$adapter = $authService->getAdapter();
                //$adapter->setIdentityValue($request->getPost('email'));
                //$adapter->setCredentialValue($request->getPost('password'));
                //$authResult = $authService->authenticate();
                
                $authService = $this->getAuthService();
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['email']);
                $adapter->setCredentialValue(md5($data['password']));
                
                // Attempt authentication, saving the result
                $result = $this->getAuthService()->authenticate();
                foreach ($result->getMessages() as $message) {
                	// save message temporary into flashmessenger
                	$this->flashmessenger()->addMessage($message);
                }
                
                if ($result->isValid()) {
                	// Authentication succeeded; the identity ($username) is stored
                	// in the session
                	// $result->getIdentity() === $auth->getIdentity()
                	// $result->getIdentity() === $username
                
                	//$redirect = 'success';
                    $redirect = 'user';
                	// check if it has rememberMe :
                	if ($request->getPost('rememberme') == 1) {
                		$this->getSessionStorage()->setRememberMe(1);
                		// set storage again
                		$this->getAuthService()->setStorage($this->getSessionStorage());
                	}
                	$this->getAuthService()->setStorage($this->getSessionStorage());
                	$this->getAuthService()->getStorage()->write($request->getPost('email'));
                }
                
                //if ($result->isValid()) {
                //	return $this->redirect()->toRoute('user');
                //}
            }
        }
        
        /switch ($authResult->getCode()) {
        
        	case Result::FAILURE_IDENTITY_NOT_FOUND:
        		** do stuff for nonexistent identity **
        	    echo 'FAILURE_IDENTITY_NOT_FOUND';
        		break;
        
        	case Result::FAILURE_CREDENTIAL_INVALID:
        		** do stuff for invalid credential **
        		echo 'FAILURE_CREDENTIAL_INVALID';
        		break;
        
        	case Result::SUCCESS:
        		** do stuff for successful authentication **
        		echo 'SUCCESS';
        		break;
        
        	default:
        		** do stuff for other failure **
        		break;
        }/
        
        
        /return new ViewModel(array(
            'error' => 'Your authentication credentials are not valid'
        ));/
        return $this->redirect()->toRoute('login');
    }*/
    
    /*public function authenticateAction()
    {
        *
         * $authService = $this->getServiceLocator()->get('ZendAuthenticationAuthenticationService'); $adapter = $authService->getAdapter(); $adapter->setIdentityValue($data['login']); $adapter->setCredentialValue($data['password']);
         *
        $form = $this->getForm();
        $redirect = 'login';
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            // $form->getMessages(); //error messages
            // $form->getErrors(); //error codes
            // $form->getErrorMessages(); //any custom error messages
            
            if ($form->isValid()) {            
            // Set up the authentication adapter
            $this->getAuthService()
                ->getAdapter()
                ->setIdentity($request->getPost('email'))
                ->setCredential($request->getPost('password'));
            
            // Attempt authentication, saving the result
            $result = $this->getAuthService()->authenticate();
            foreach ($result->getMessages() as $message) {
                // save message temporary into flashmessenger
                $this->flashmessenger()->addMessage($message);
            }
            
            if ($result->isValid()) {
                // Authentication succeeded; the identity ($username) is stored
                // in the session
                // $result->getIdentity() === $auth->getIdentity()
                // $result->getIdentity() === $username
                
                $redirect = 'success';
                // check if it has rememberMe :
                if ($request->getPost('rememberme') == 1) {
                    $this->getSessionStorage()->setRememberMe(1);
                    // set storage again
                    $this->getAuthService()->setStorage($this->getSessionStorage());
                }
                $this->getAuthService()->setStorage($this->getSessionStorage());
                $this->getAuthService()
                    ->getStorage()
                    ->write($request->getPost('email'));
            }
             }
        }
        
        return $this->redirect()->toRoute($redirect);
    }*/

    public function logoutAction()
    {
        if ($this->getAuthService()->hasIdentity()) {
            $this->getSessionStorage()->forgetMe();
            $this->getAuthService()->clearIdentity();
            $this->flashmessenger()->addMessage("You've been logged out");
        }
        
        return $this->redirect()->toRoute('login');
    }
    
    public function testAction()
    {
    	if ($user = $this->identity()) {
    		echo $this->identity()->getName().' esta logado';
    	} else {
    		echo $this->identity()->getName().' nao esta logado';
    	}
    	
    	$form = $this->getForm();
    	
    	return array(
            'form' => $form
        );
    }
}