<?php
/* @var $this TableOrderTimePointController */
/* @var $model TableOrderTimePoint */

$this->breadcrumbs=array(
	'Table Order Time Points'=>array('index'),
	$model->table_order_time_point_id,
);

$this->menu=array(
	array('label'=>'List TableOrderTimePoint', 'url'=>array('index')),
	array('label'=>'Create TableOrderTimePoint', 'url'=>array('create')),
	array('label'=>'Update TableOrderTimePoint', 'url'=>array('update', 'id'=>$model->table_order_time_point_id)),
	array('label'=>'Delete TableOrderTimePoint', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->table_order_time_point_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TableOrderTimePoint', 'url'=>array('admin')),
);
?>

<h1>View TableOrderTimePoint #<?php echo $model->table_order_time_point_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'table_order_time_point_id',
		'dealer_dinner_id',
		'time_point',
	),
)); ?>
