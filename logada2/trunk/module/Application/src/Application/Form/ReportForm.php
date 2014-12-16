<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Application\Constants\Constants;

class ReportForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('report');
        
        $this->setAttribute('method', 'post');
        
       /* $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'classes',
            'options' => array(
                //'label' => 'Turmas',
                'value_options' => array(
                    '-1' => 'Escolha a Turma',
                    '1' => 'Matematica',
                    '2' => 'Portuguess',
                    '3' => 'Geografia',
                )
            )
        ));*/

       /* $ay = Constants::academicYearsToArray();
        $ay[-1] = 'Escolha a Série';
        $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'acad_year',
             'options' => array(
                 //'label' => 'Escolha a Série',
                 'value_options' => $ay
             )
        ));*/

        #$this->get('acad_year')->setValue('-1'); // default value
        
        /*$this->add(array(
            'name' => 'submit_student',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Buscar',
                'id' => 'submitbutton',
    		),
        ));*/
        
        
        /*$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'disciplines',
            'options' => array(
                //'label' => 'Turmas',
                'value_options' => array(
                    '-1' => 'Escolha a Turma',
                    '1' => 'Matematica',
                    '2' => 'Portuguess',
                    '3' => 'Geografia',
                )
            )
        ));*/
/*
        $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'position',
             'options' => array(
                 //'label' => 'Escolha a Série',
                 'value_options' => Constants::membershipTypeToArray(),
             )
        ));
*/
        $this->add(array(
            'name' => 'submit_staff',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Buscar',
                'id' => 'submitbutton',
    		),
        ));
    }
}