<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Submit;

class PostForm extends Form
{

    public function __construct()
    {
        parent::__construct('post_form');
        $this->add(array(
            'name' => 'comment',
            'type' => 'textarea',
            'options' => array(
                'rows' => 4,
                'cols' => 20
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',            
            'attributes' => array(
                'value' => 'Postar',
                'id' => 'submitbutton',  
                'class' => 'btn btn-primary',
            ),
        ));
    }
}