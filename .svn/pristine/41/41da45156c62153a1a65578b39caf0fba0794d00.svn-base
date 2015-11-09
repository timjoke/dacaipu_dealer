<?php
/* @var $this DealerController */
/* @var $model Dealer */

$this->breadcrumbs=array(
	'Dealers'=>array('index'),
	$model->dealer_id,
);

$this->menu=array(
	array('label'=>'List Dealer', 'url'=>array('index')),
	array('label'=>'Create Dealer', 'url'=>array('create')),
	array('label'=>'Update Dealer', 'url'=>array('update', 'id'=>$model->dealer_id)),
	array('label'=>'Delete Dealer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->dealer_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Dealer', 'url'=>array('admin')),
);
?>

<h1>View Dealer #<?php echo $model->dealer_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'dealer_id',
		'city_code',
		'dealer_name',
		'dealer_addr',
		'dealer_postcode',
		'dealer_lon',
		'dealer_lat',
		'dealer_introduction',
		'dealer_tel',
		'dealer_status',
		'dealer_percap',
		'is_free_park',
		'dealer_type',
		'dealer_parent_id',
		'dealer_create_date',
		'dealer_link_word',
		'dealer_domain',
		'dealer_express_fee',
	),
)); ?>
