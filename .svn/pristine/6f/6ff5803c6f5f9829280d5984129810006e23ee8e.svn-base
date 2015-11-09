<?php
/* @var $this CouponController */
/* @var $model Coupon */

$this->breadcrumbs=array(
	'Coupons'=>array('index'),
	$model->coupon_id,
);

$this->menu=array(
	array('label'=>'List Coupon', 'url'=>array('index')),
	array('label'=>'Create Coupon', 'url'=>array('create')),
	array('label'=>'Update Coupon', 'url'=>array('update', 'id'=>$model->coupon_id)),
	array('label'=>'Delete Coupon', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->coupon_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Coupon', 'url'=>array('admin')),
);
?>

<h1>View Coupon #<?php echo $model->coupon_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'coupon_id',
		'dealer_id',
		'coupon_no',
		'coupon_value',
		'coupon_start_time',
		'coupon_end_time',
		'coupon_status',
		'coupon_customer_id',
		'coupon_create_time',
		'order_id',
	),
)); ?>
