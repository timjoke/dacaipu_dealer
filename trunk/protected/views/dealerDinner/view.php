<?php
/* @var $this DealerDinnerController */
/* @var $model DealerDinner */

$this->breadcrumbs=array(
	'Dealer Dinners'=>array('index'),
	$model->dealer_dinner_id,
);

$this->menu=array(
	array('label'=>'List DealerDinner', 'url'=>array('index')),
	array('label'=>'Create DealerDinner', 'url'=>array('create')),
	array('label'=>'Update DealerDinner', 'url'=>array('update', 'id'=>$model->dealer_dinner_id)),
	array('label'=>'Delete DealerDinner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->dealer_dinner_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DealerDinner', 'url'=>array('admin')),
);
?>

<h1>View DealerDinner #<?php echo $model->dealer_dinner_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'dealer_dinner_id',
		'dealer_id',
		'dinner_type',
		'status',
	),
)); ?>
