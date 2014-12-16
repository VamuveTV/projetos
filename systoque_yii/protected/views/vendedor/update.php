<?php
/* @var $this VendedorController */
/* @var $model Vendedor */

$this->breadcrumbs=array(
	'Vendedors'=>array('index'),
	$model->matricula=>array('view','id'=>$model->matricula),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vendedor', 'url'=>array('index')),
	array('label'=>'Create Vendedor', 'url'=>array('create')),
	array('label'=>'View Vendedor', 'url'=>array('view', 'id'=>$model->matricula)),
	array('label'=>'Manage Vendedor', 'url'=>array('admin')),
);
?>

<h1>Update Vendedor <?php echo $model->matricula; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>