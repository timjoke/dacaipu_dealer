<?php
/* @var $this DealerServiceTimeController */
/* @var $model DealerServiceTime */

$this->breadcrumbs=array(
	'Dealer Service Times'=>array('index'),
	$model->st_id,
);

$this->menu=array(
	array('label'=>'List DealerServiceTime', 'url'=>array('index')),
	array('label'=>'Create DealerServiceTime', 'url'=>array('create')),
	array('label'=>'Update DealerServiceTime', 'url'=>array('update', 'id'=>$model->st_id)),
	array('label'=>'Delete DealerServiceTime', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->st_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DealerServiceTime', 'url'=>array('admin')),
);
?>

<h1>View DealerServiceTime #<?php echo $model->st_id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'st_start_time',
		'st_end_time',
		'st_name',
	),
)); ?>
