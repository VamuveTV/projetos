<?php
/* @var $this VendedorController */
/* @var $model Vendedor */

$this->breadcrumbs=array(
	'Vendedors'=>array('index'),
	'Create',
);

/*
$this->menu=array(
	array('label'=>'List Vendedor', 'url'=>array('index')),
	array('label'=>'Manage Vendedor', 'url'=>array('admin')),
);
*/
?>

<h1>Cadastro de Vendedor</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>