<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class LoginForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('login');
        
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Digite seu email...',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Digite sua senha aqui...',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Senha'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Entrar',
                'id' => 'submitbutton',
    		),
        ));
        
        //$this->add(array(
        //    'name' => 'submit', 
        //    'type' => 'Zend\Form\Element\Submit',
        //    'label' => 'Entrar'
        //));
        
        //$this->add(array(
        //    'name' => 'csrf',
        //    'type' => 'Zend\Form\Element\Csrf'
        //));
    }
}