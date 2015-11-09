<?php
/* @var $this DealerDinnerController */
/* @var $model DealerDinner */

$this->breadcrumbs=array(
	'Dealer Dinners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DealerDinner', 'url'=>array('index')),
	array('label'=>'Manage DealerDinner', 'url'=>array('admin')),
);
?>

<h1>Create DealerDinner</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>