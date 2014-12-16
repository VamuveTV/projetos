<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Application\Constants\Constants;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Password;
use Zend\Validator\StringLength;

class SchoolClassForm extends Form
{
    public function __construct($em)
    {
        parent::__construct('school-class');
        
        $builder = new AnnotationBuilder($em);
        $this->setHydrator(new DoctrineHydrator($em, 'Application\Entity\SchoolClass'));
        
        // copy element specs from builder
        foreach($builder->getFormSpecification('Application\Entity\SchoolClass')['elements'] as $el)
        {
            $this->add($el['spec']);
        }
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            )
        ));
        
        $this->get('terms')->setOptions(array(
        		'value_options' => array('4', '3', '2'),
            )
        );
        
        $years = array();
        $y = (int)date('Y');
        for ($i = 0; $i < $y - 2010; $i++) {
            $years[$i] = strval($y - $i);
            //array_push($years, $y - $i);
        }
        //die(var_dump($years));
        $this->get('academic_year')->setOptions(array(
        		'value_options' => $years,
            )
        );
    }
}