<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Image;

class OpinionEditForm extends Form
{

    public function __construct()
    {
        parent::__construct('opinion_edit');
        
        /*$submit_bomb = new Image('submit', array(
            'name' => 'submit_bomb',
            'ignore' => true,
            'label' => 'Submit',
            'src' => '/img/bomb1.png'
        ));
        $this->add($submit_bomb);*/
        /*$this->add(array(
            'name' => 'submit_bomb',
            'id' => 'btnBomb',
            'attributes' => array(
                'type'  => 'image',
                'src'   => '/img/bomb1.png',
                'height'=> '50',
                'width' => '50',
                'border'=> '0',
                'alt'   => 'Bomba'
            ),
        ));*/


        $this->add(array(
    		'name' => 'submit_bomb',
    		'type' => 'Submit',
    		'attributes' => array(
    		    'value' => 'bomb',
				'id' => 'btnBomb',
    		),
        ));

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