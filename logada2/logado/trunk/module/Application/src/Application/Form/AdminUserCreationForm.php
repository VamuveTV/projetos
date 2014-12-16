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

class AdminUserCreationForm extends Form
{
    public function __construct($em)
    {
        parent::__construct('admin_user_creation');
        
        $builder = new AnnotationBuilder($em);
        $this->setHydrator(new DoctrineHydrator($em, 'Application\Entity\User'));
        
        // copy element specs from builder
        foreach($builder->getFormSpecification('Application\Entity\User')['elements'] as $el)
        {
            $this->add($el['spec']);
        }
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Enviar',
                'id' => 'submitbutton',  
                'class' => 'btn btn-primary',
            ),
        ));
                
        $this->get('role')->setOptions(array(
        		'value_options' => Constants::rolesToArray(),
        		'label' => 'Papel do usuário',
            )
        );
        
        $this->get('sex')->setOptions(array(
        		'value_options' => Constants::genderToArray(),
        		'label' => 'Sexo',
            )
        );
    }
}