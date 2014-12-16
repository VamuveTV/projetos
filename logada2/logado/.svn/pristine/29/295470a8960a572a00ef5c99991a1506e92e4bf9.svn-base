<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Feed',
                        'action' => 'index'
                    )
                )
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Auth',
                        'action' => 'login'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Auth',
                        'action' => 'login'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            
            'success' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/success',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Success',
                        'action' => 'index'
                    )
                )
            ),
            
            'user' => array(
                // 'type' => 'literal',
                'type' => 'segment',
                'options' => array(
                    'route' => '/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    // 'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'User',
                        'action' => 'index'
                    )
                )
            ),
            
            'initial-post' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/initial-post[/:action][/:mood]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'mood' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'InitialPost',
                        'action' => 'index'
                    )
                )
            ),
            
            'feed' => array(
                // 'type' => 'literal',
                'type' => 'segment',
                'options' => array(
                    'route' => '/feed[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    // 'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Feed',
                        'action' => 'index'
                    )
                )
            ),
            
            'profile' => array(
                // 'type' => 'literal',
                'type' => 'segment',
                'options' => array(
                    'route' => '/profile[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    // 'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Profile',
                        'action' => 'index'
                    )
                )
            ),
            
            'school-class' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/school-class[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'SchoolClass',
                        'action' => 'index'
                    )
                )
            ),
            
            'opinion' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/opinion[/:action][/:id][/:rating][/:prof][/:acad_year][/:class]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'rating' => '[0-9]+',
                        'prof' => '[0-2]+',
                        'acad_year' => '[0-9]+',
                        'class' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Opinion',
                        'action' => 'index'
                    )
                )
            ),
            
            'activity' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/activity[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Activity',
                        'action' => 'index'
                    )
                )
            ),
            
            'notifications' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/notifications[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Notifications',
                        'action' => 'index'
                    )
                )
            ),
            
            'contact' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/contact[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Contact',
                        'action' => 'index'
                    )
                )
            ),
            
            'map' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/map[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Map',
                        'action' => 'index'
                    )
                )
            ),
			
			'report' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/report[/:action][/:id][/:tpView][/:llaveDest][/:llaveRemet][/:llavePost]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
						'tpView' => '[0-9]+',
						'llaveDest' => '[0-9]+',
						'llaveRemet' => '[0-9]+',
						'llavePost' => '[0-9]+'
						),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Report',
                        'action' => 'index'
                    )
                )
            ),
			
			
			
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory'
        )
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo'
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\User' => 'Application\Controller\UserController',
            'Application\Controller\InitialPost' => 'Application\Controller\InitialPostController',
            'Application\Controller\Feed' => 'Application\Controller\FeedController',
            'Application\Controller\Auth' => 'Application\Controller\AuthController',
            'Application\Controller\Success' => 'Application\Controller\SuccessController',
            'Application\Controller\Profile' => 'Application\Controller\ProfileController',
            'Application\Controller\Test' => 'Application\Controller\TestController',
            'Application\Controller\SchoolClass' => 'Application\Controller\SchoolClassController',
            'Application\Controller\Opinion' => 'Application\Controller\OpinionController',
            'Application\Controller\Activity' => 'Application\Controller\ActivityController',
            'Application\Controller\Notifications' => 'Application\Controller\NotificationsController',
            'Application\Controller\Contact' => 'Application\Controller\ContactController',
            'Application\Controller\Map' => 'Application\Controller\MapController',
            'Application\Controller\Report' => 'Application\Controller\ReportController'
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/layout_admin' => __DIR__ . '/../view/layout/layout_admin.phtml',
            'layout/layout_student' => __DIR__ . '/../view/layout/layout_student.phtml',
            'layout/layout_staff' => __DIR__ . '/../view/layout/layout_staff.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Application/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities'
                )
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Application\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'email',
                //'credentialCallable' => 'Application\Utils::hashPassword'
                //'credential_callable' => function(User $user, $password) {
               // 	return $user->getPassword() == $password;
                //},
            )
        )
    ),
);
