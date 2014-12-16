<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Entity\Post;
use Zend\Loader;
use Zend\View;

/**
 * NotificationsController
 *
 * @author
 *
 * @version
 *
 */
class NotificationsController extends BaseController
{
    
    public function indexAction()
    {
        //$uri = $this->getRequest()->getRequestUri();
        //$activeNav = $this->view->navigation()->findByUri($uri);
        //$activeNav->active = true;
        //$activeNav->setClass("active");
        
        //$activeElement = $view->navigation()->findOneBy('active', 1);
        //die(var_dump($activeElement));
        
        //die(var_dump($this->layout('layout/layout_student')));
        
        //die(var_dump(Zend\View\Helper\Navigation\Menu()));
        //Loader::loadClass('Zend_View');
        //$view = new Zend_View();
        
        return new ViewModel();
    }
}