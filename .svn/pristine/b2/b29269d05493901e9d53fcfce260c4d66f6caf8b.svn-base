<?php
/* @var $this DiscountPlanController */
/* @var $model DiscountPlan */

$this->breadcrumbs=array(
	'Discount Plans'=>array('index'),
	$model->ar_id,
);

$this->menu=array(
	array('label'=>'List DiscountPlan', 'url'=>array('index')),
	array('label'=>'Create DiscountPlan', 'url'=>array('create')),
	array('label'=>'Update DiscountPlan', 'url'=>array('update', 'id'=>$model->ar_id)),
	array('label'=>'Delete DiscountPlan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ar_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DiscountPlan', 'url'=>array('admin')),
);
?>

<h1>View DiscountPlan #<?php echo $model->ar_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ar_id',
		'ar_entity_id',
		'discount_id',
		'ar_start_time',
		'ar_end_time',
		'ar_status',
		'ar_type',
		'ar_order',
		'ar_dealer_id',
	),
)); ?>
