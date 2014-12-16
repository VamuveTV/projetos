<?php
/* @var $this ProdutoController */
/* @var $model Produto */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'produto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cb'); ?>
		<?php echo $form->textField($model,'cb',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nome'); ?>
		<?php echo $form->textField($model,'nome',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'nome'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor'); ?>
		<?php echo $form->textField($model,'valor',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'valor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qtde'); ?>
		<?php echo $form->textField($model,'qtde'); ?>
		<?php echo $form->error($model,'qtde'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qtdeminprod'); ?>
		<?php echo $form->textField($model,'qtdeminprod'); ?>
		<?php echo $form->error($model,'qtdeminprod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'validade'); ?>
		<?php echo $form->textField($model,'validade'); ?>
		<?php echo $form->error($model,'validade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lote'); ?>
		<?php echo $form->textField($model,'lote',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lote'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'garantia'); ?>
		<?php echo $form->textField($model,'garantia',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'garantia'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->