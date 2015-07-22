<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SettingsController extends AbstractActionController
{
    public function indexAction()
    {
        $this->redirect()->toRoute('admin/settings/profile');
    }
    
    public function profileAction()
    {
        return new ViewModel();
    }
    
    public function adminAction()
    {
        return new ViewModel();
    }
    
}
