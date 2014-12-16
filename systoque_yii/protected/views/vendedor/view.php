<?php
/* @var $this VendedorController */
/* @var $model Vendedor */

$this->breadcrumbs=array(
	'Vendedors'=>array('index'),
	$model->matricula,
);

$this->menu=array(
	array('label'=>'List Vendedor', 'url'=>array('index')),
	array('label'=>'Create Vendedor', 'url'=>array('create')),
	array('label'=>'Update Vendedor', 'url'=>array('update', 'id'=>$model->matricula)),
	array('label'=>'Delete Vendedor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->matricula),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Vendedor', 'url'=>array('admin')),
);
?>

<h1>View Vendedor #<?php echo $model->matricula; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'matricula',
		'nome',
		'datanasc',
		'comissao',
	),
)); ?>
