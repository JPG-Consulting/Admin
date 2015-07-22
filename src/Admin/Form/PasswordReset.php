<?php
namespace Admin\Form;

use Zend\Form\Form;

class PasswordReset extends Form
{

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');

        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'type' => 'text',
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
                 'value' => 'Submit',
                 'id' => 'submitbutton',
             ),
         ));
     }
     
}
