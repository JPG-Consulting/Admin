<?php
namespace Admin\Controller;

use Admin\Form\Login as LoginForm;
use Admin\Form\PasswordReset as PasswordResetForm;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthenticationController extends AbstractActionController
{
    protected $authservice;
    
    public function loginAction()
    {
        $form = new LoginForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()){
                //check authentication...
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('identity'))
                                       ->setCredential($request->getPost('credential'));
                $result = $this->getAuthService()->authenticate();
                
                if ($result->isValid()) {
                    $this->getAuthService()->getStorage()->write($request->getPost('identity'));
                    $this->redirect()->toRoute('admin');
                }
            }
        }
        
        return new ViewModel(array('form' => $form));
    }
    
    public function logoutAction()
    {
        
        $this->getAuthService()->clearIdentity();
        
        $this->redirect()->toRoute('admin/login');
    }
    
    public function resetAction()
    {
        $form = new PasswordResetForm();
        
        return new ViewModel(array('form' => $form));
    }
    
    protected function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('Admin\AuthenticationService');
        }
         
        return $this->authservice;
    }
}
