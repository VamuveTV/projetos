<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Application\Constants\Constants;

class MoodSelectionForm extends Form
{
    public function __construct()
    {
        parent::__construct('mood_selection');
        $this->add(array(
        		'name' => 'moods',
        		'type' => 'Radio',
        		'options' => array(
        				'value_options' => Constants::moodsToArray(),
        		),
        ));
        
        $this->get('moods')->setValue('0'); // default value
        
        $this->add(array(
        		'name' => 'submit',
        		'type' => 'Submit',
        		'attributes' => array(
        				'value' => 'Continuar',
        				'id' => 'submitbutton',
        		),
        ));
    }
}