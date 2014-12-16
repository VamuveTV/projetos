<?php
/* @var $this VendaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vendas',
);

$this->menu=array(
	array('label'=>'Create Venda', 'url'=>array('create')),
	array('label'=>'Manage Venda', 'url'=>array('admin')),
);
?>

<h1>Vendas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
