<?php
/* @var $this VendaController */
/* @var $data Venda */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codvenda')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codvenda), array('view', 'id'=>$data->codvenda)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('matricula')); ?>:</b>
	<?php echo CHtml::encode($data->matricula); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data')); ?>:</b>
	<?php echo CHtml::encode($data->data); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datapreventrega')); ?>:</b>
	<?php echo CHtml::encode($data->datapreventrega); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('totalvenda')); ?>:</b>
	<?php echo CHtml::encode($data->totalvenda); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>