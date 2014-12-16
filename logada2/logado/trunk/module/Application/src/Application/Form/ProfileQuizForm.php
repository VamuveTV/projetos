<?php
namespace Application\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;
use Application\Constants\Constants;

class ProfileQuizForm extends Form

{
	public function __construct($name = null)
	{
		parent::__construct('profile_quiz');

		$this->setAttribute('method', 'post');

		$this->add(array(
				'name' => 'displayname',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'placeholder' => 'Digite seu nome...',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Nome ou apelido para ser visualizado',
				),
		));

		$this->add(array(
				'name' => 'fullname',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'placeholder' => 'Digite seu nome...',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Nome Completo',
				),
		));
		
		$this->add(array(
				'name' => 'sex',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array(
						'required' => 'required',
						'value' => '0',
				),
				'options' => array(
						'label' => 'Sexo',
						'value_options' => Constants::genderToArray(),
				),
		));

		$this->add(array(
				'name' => 'email',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'placeholder' => 'Digite seu email...',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Email',
				),
		));
		
		
		
		/*$this->add(array(
				'name' => 'text_address',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'placeholder' => 'Digite seu endereço...',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Endereço',
				),
		));

		$this->add(array(
				'name' => 'text_city',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'placeholder' => 'Digite sua cidade...',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Cidade',
				),
		));

		$this->add(array(
				'name' => 'text_cep',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'placeholder' => 'Digite seu CEP...',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'CEP',
				),
		));*/

		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Salvar',
						'id' => 'submitbutton',
						'class' => 'btn btn-primary',
				),
		));
		
		$this->add(array(
				'name' => 'csrf',
				'type' => 'Zend\Form\Element\Csrf',
		));
	}
}