<?php
/* @var $this ProdutoController */
/* @var $data Produto */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cb')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cb), array('view', 'id'=>$data->cb)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor')); ?>:</b>
	<?php echo CHtml::encode($data->valor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qtde')); ?>:</b>
	<?php echo CHtml::encode($data->qtde); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qtdeminprod')); ?>:</b>
	<?php echo CHtml::encode($data->qtdeminprod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('validade')); ?>:</b>
	<?php echo CHtml::encode($data->validade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lote')); ?>:</b>
	<?php echo CHtml::encode($data->lote); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('garantia')); ?>:</b>
	<?php echo CHtml::encode($data->garantia); ?>
	<br />

	*/ ?>

</div>