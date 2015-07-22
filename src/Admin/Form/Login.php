<?php
namespace Admin\Form;

use Zend\Form\Form;

class Login extends Form
{

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');

        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'identity',
            'options' => array(
                'label' => 'Username or Email',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'input-block',
            ),
        ));
        
        $this->add(array(
			'name' => 'credential',
            'type' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'type' => 'password',
                'class' => 'input-block',
            ),
        ));
        
        $this->add(array(
			'type' => 'Zend\Form\Element\Csrf',
			'name' => 'csrf',
			'options' => array(
				'csrf_options' => array(
    				'timeout' => 600
                )
            )
        ));
        
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Sign in',
                 'id' => 'submitbutton',
             ),
         ));
     }
     
}
