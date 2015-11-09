<?php
/* @var $this ApplyJoinController */
/* @var $model ApplyJoin */

$this->breadcrumbs=array(
	'Apply Joins'=>array('index'),
	$model->apply_id,
);

$this->menu=array(
	array('label'=>'List ApplyJoin', 'url'=>array('index')),
	array('label'=>'Create ApplyJoin', 'url'=>array('create')),
	array('label'=>'Update ApplyJoin', 'url'=>array('update', 'id'=>$model->apply_id)),
	array('label'=>'Delete ApplyJoin', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->apply_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ApplyJoin', 'url'=>array('admin')),
);
?>

<h1>View ApplyJoin #<?php echo $model->apply_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'apply_id',
		'dealer_name',
		'dealer_tel',
		'dealer_add',
		'contact_name',
		'contact_tel',
		'id_image_file_url',
	),
)); ?>
