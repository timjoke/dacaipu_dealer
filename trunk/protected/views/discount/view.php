<?php
/* @var $this DiscountController */
/* @var $model Discount */




$this->breadcrumbs=array(
	'Discounts'=>array('index'),
	$model->discount_id,
);

$this->menu=array(
	array('label'=>'List Discount', 'url'=>array('index')),
	array('label'=>'Create Discount', 'url'=>array('create')),
	array('label'=>'Update Discount', 'url'=>array('update', 'id'=>$model->discount_id)),
	array('label'=>'Delete Discount', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->discount_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Discount', 'url'=>array('admin')),
);
?>

<h1>View Discount #<?php echo $model->discount_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'discount_id',
		'discount_name',
		'dealer_id',
		'discount_mode',
		'discount_value',
		'discount_condition',
		'discount_compare_value',
	),
)); ?>
