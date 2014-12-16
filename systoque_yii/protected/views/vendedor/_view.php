<?php
/* @var $this VendedorController */
/* @var $data Vendedor */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('matricula')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->matricula), array('view', 'id'=>$data->matricula)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datanasc')); ?>:</b>
	<?php echo CHtml::encode($data->datanasc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comissao')); ?>:</b>
	<?php echo CHtml::encode($data->comissao); ?>
	<br />


</div>