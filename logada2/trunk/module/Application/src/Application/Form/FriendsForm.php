<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class FriendsForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('friends');
        
        $this->setAttribute('method', 'post');

        $this->add(array(
    		'name' => 'username',
    		'type' => 'Zend\Form\Element\Text',
    		'attributes' => array(
			    'placeholder' => 'Nome...',
    		    'required' => false
    		)
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'class',
            'options' => array(
                'value_options' => array(
                    -1 => 'Turma'
                )
            ),
    		'attributes' => array(
    		    'required' => false
    		)
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'school',
            'options' => array(
                'value_options' => array(
                    -1 => 'Escola',
                    1 => 'Escola Finxi' //FIXME: Escola estática!
                )
            ),
    		'attributes' => array(
    		    'required' => false
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'day_period',
            'options' => array(
                'value_options' => array(
                    - 1 => 'Período',
                    '0' => 'Manhã',
                    '1' => 'Tarde',
                    '2' => 'Noite'
                )
            ),
            'attributes' => array(
                'required' => false
    		)
        ));

        $this->add(array(
            'name' => 'submit_search',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Buscar',
                'id' => 'submitbutton',
    		),
        ));

        $this->add(array(
            'name' => 'submit_clean',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Limpar',
                'id' => 'submitbutton',
    		),
        ));
    }
}