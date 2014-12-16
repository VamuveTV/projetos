<?php
namespace SanAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SuccessController extends BaseController
{

    public function indexAction()
    {
        if (! $this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('login');
        }
        
        return new ViewModel();
    }
}