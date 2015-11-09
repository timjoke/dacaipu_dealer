<?php
/* @var $this DishCategoryController */
/* @var $model DishCategory */

$this->breadcrumbs=array(
	'Dish Categories'=>array('index'),
	$model->category_id,
);

$this->menu=array(
	array('label'=>'List DishCategory', 'url'=>array('index')),
	array('label'=>'Create DishCategory', 'url'=>array('create')),
	array('label'=>'Update DishCategory', 'url'=>array('update', 'id'=>$model->category_id)),
	array('label'=>'Delete DishCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->category_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DishCategory', 'url'=>array('admin')),
);
?>

<h1>View DishCategory #<?php echo $model->category_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'category_id',
		'category_name',
		'category_status',
		'dealer_name',
		'pcategory_name',
	),
)); ?>
