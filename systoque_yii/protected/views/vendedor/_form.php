<?php
/* @var $this VendedorController */
/* @var $model Vendedor */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vendedor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nome'); ?>
		<?php echo $form->textField($model,'nome',array('class'=>'form-control','placeholder'=>'Digite seu nome')); ?>
		<?php echo $form->error($model,'nome'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Data de nascimento'); ?>
		<?php echo $form->dateField($model,'datanasc',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'datanasc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comissao'); ?>
		<?php echo $form->dropDownList($model, 'comissao', array('5'=>'5%','10'=>'10%','15'=>'15%','20'=>'20%'),array('class'=>'form-control'))?>
		<?php echo $form->error($model,'comissao'); ?>
	</div>
	<br>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Cadastrar' : 'Salvar',array('class'=>'btn btn-success')); ?>
		<a href="index.php?r=vendedor/admin" class="btn btn-primary">Listar</a>
		<button type="button" id="botao" class="btn btn-primary">Ajax</button>
		<span id="local"></span>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->