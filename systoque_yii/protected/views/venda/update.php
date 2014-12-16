<?php
/* @var $this VendaController */
/* @var $model Venda */

$this->breadcrumbs=array(
	'Vendas'=>array('index'),
	$model->codvenda=>array('view','id'=>$model->codvenda),
	'Update',
);

$this->menu=array(
	array('label'=>'List Venda', 'url'=>array('index')),
	array('label'=>'Create Venda', 'url'=>array('create')),
	array('label'=>'View Venda', 'url'=>array('view', 'id'=>$model->codvenda)),
	array('label'=>'Manage Venda', 'url'=>array('admin')),
);
?>

<h1>Update Venda <?php echo $model->codvenda; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>