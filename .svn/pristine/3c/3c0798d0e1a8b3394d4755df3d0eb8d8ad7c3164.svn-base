<?php
/* @var $this DishController */
/* @var $model Dish */

$this->breadcrumbs=array(
	'Dishes'=>array('index'),
	$model->dish_id,
);

$this->menu=array(
	array('label'=>'List Dish', 'url'=>array('index')),
	array('label'=>'Create Dish', 'url'=>array('create')),
	array('label'=>'Update Dish', 'url'=>array('update', 'id'=>$model->dish_id)),
	array('label'=>'Delete Dish', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->dish_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Dish', 'url'=>array('admin')),
);
?>

<h1>View Dish #<?php echo $model->dish_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'dish_name',
		'dish_price',
		'dish_recommend',
		'dish_package_fee',
		'dish_is_vaget',
		'dish_spicy_level',
		'dish_introduction',
		'dealer_name',
		'dish_status',
		'dish_createtime',
		'dish_mode',
		'dish_name_parent',
	),
)); ?>
