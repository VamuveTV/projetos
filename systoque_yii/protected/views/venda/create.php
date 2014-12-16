<?php
/* @var $this VendaController */
/* @var $model Venda */

$this->breadcrumbs=array(
	'Vendas'=>array('index'),
	'Create',
);

?>

<h1>Cadastrar Venda</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'vendedores'=>$vendedores,'produtos'=>$produtos)); ?>