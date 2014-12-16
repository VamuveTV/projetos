<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Application\Constants\Constants;

class Module implements AutoloaderProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
    	$eventManager->attach('dispatch', array($this, 'checkLoginChangeLayout'));
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Application\Entity\AuthStorage' => function ($sm)
                {
                    return new \Application\Entity\AuthStorage('auth_storage');
                },
                
                'Zend\Authentication\AuthenticationService' => function ($serviceManager)
                {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },
                
                /*'LayoutService' => function ($sm)
                {
    	           $eventManager->attach('dispatch', array($this, 'checkLoginChangeLayout'));                    
                }*/
            )
            
            /*'factories' => array(
                'Application\Entity\AuthStorage' => function ($sm)
                {
                    return new \Application\Entity\AuthStorage('zf_tutorial');
                },
                
                'Zend\Authentication\AuthenticationService' => function ($serviceManager)
                {
                    //My assumption, you've alredy set dbAdapter
                    //and has users table with columns : user_name and pass_word
                    //that password hashed with md5
                    //echo '<pre>';
                    // print_r($sm);
                    // exit;
                    //$dbAdapter = $sm->get('doctrine.authenticationadapter.orm_default');
                    
                    //$authService = new AuthenticationService();
                    
                    //$authService->setAdapter($dbAdapter);
                    //$authService->setStorage($sm->get('Teste\Storage\MyStorage'));
                    
                    //return $authService;
                    //return false;
                    
                    
                    
                    // If you are using DoctrineORMModule:
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                    // If you are using DoctrineODMModule:
                    // return $serviceManager->get('doctrine.authenticationservice.odm_default');
                }
            )*/
        );
    }
    
    /*
     * public function getServiceConfig() { return array( 'factories' => array( 'Application\Entity\AuthStorage' => function ($sm) { return new \Application\Entity\AuthStorage('zf_tutorial'); }, 'AuthService' => function ($sm) { // My assumption, you've alredy set dbAdapter // and has users table with columns : user_name and pass_word // that password hashed with md5 //$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter'); //$dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'users', 'email', 'password', 'MD5(?)'); $adapter = $serviceLocator->get('doctrine.authenticationadapter.orm_default'); $adapter->setIdentityValue($username); $adapter->setCredentialValue($password); $authService = new Zend\Authentication\AuthenticationService(); $result = $authService->authenticate($adapter); //$authService = new AuthenticationService(); //$authService->setAdapter($dbTableAuthAdapter); //$authService->setStorage($sm->get('Application\Entity\AuthStorage')); return $result;//$authService; } ) ); }
     */
    
    // Carrega um layout diferente após o sucesso no login
    public function checkLoginChangeLayout(MvcEvent $e) 
    {
        $as = $e->getApplication()->getServiceManager()
            ->get('Zend\Authentication\AuthenticationService');
        if ($as->hasIdentity())
        {
            $layout = '';
            //change layout ...
            if ($as->getIdentity()->getRole() == Constants::ADMIN) {
            	$layout = 'layout/layout_admin';
            } else if ($as->getIdentity()->getRole() == Constants::STUDENT) {
            	$layout = 'layout/layout_student';
            } else if ($as->getIdentity()->getRole() == Constants::STAFF) {
            	$layout = 'layout/layout_staff';
            } else {
            	throw new Exception('User without role.');
            }

            $controller = $e->getTarget();
            //die(var_dump($controller));
            $controller->layout($layout);
        } 
    }
}
