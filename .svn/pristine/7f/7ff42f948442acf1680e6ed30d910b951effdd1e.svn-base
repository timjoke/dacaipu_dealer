<?php
/* @var $this DinnerTableController */
/* @var $model DinnerTable */

$this->breadcrumbs=array(
	'Dinner Tables'=>array('index'),
	$model->table_id,
);

$this->menu=array(
	array('label'=>'List DinnerTable', 'url'=>array('index')),
	array('label'=>'Create DinnerTable', 'url'=>array('create')),
	array('label'=>'Update DinnerTable', 'url'=>array('update', 'id'=>$model->table_id)),
	array('label'=>'Delete DinnerTable', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->table_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DinnerTable', 'url'=>array('admin')),
);
?>

<h1>View DinnerTable #<?php echo $model->table_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'table_id',
		'table_name',
		'dealer_id',
		'table_status',
		'table_sit_count',
		'table_service_price',
		'table_is_room',
		'table_lower_case',
		'table_is_smoke',
	),
)); ?>
