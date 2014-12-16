<?php
/* @var $this VendaController */
/* @var $model Venda */

$this->breadcrumbs=array(
	'Vendas'=>array('index'),
	$model->codvenda,
);

$this->menu=array(
	array('label'=>'List Venda', 'url'=>array('index')),
	array('label'=>'Create Venda', 'url'=>array('create')),
	array('label'=>'Update Venda', 'url'=>array('update', 'id'=>$model->codvenda)),
	array('label'=>'Delete Venda', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codvenda),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Venda', 'url'=>array('admin')),
);
?>

<h1>View Venda #<?php echo $model->codvenda; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codvenda',
		'matricula',
		'data',
		'datapreventrega',
		'totalvenda',
		'status',
	),
)); ?>
