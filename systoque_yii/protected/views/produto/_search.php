<?php
/* @var $this ProdutoController */
/* @var $model Produto */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'cb'); ?>
		<?php echo $form->textField($model,'cb',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nome'); ?>
		<?php echo $form->textField($model,'nome',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'valor'); ?>
		<?php echo $form->textField($model,'valor',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qtde'); ?>
		<?php echo $form->textField($model,'qtde'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qtdeminprod'); ?>
		<?php echo $form->textField($model,'qtdeminprod'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'validade'); ?>
		<?php echo $form->textField($model,'validade'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lote'); ?>
		<?php echo $form->textField($model,'lote',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'garantia'); ?>
		<?php echo $form->textField($model,'garantia',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->