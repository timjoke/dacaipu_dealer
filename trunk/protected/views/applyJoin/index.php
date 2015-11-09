<?php
/* @var $this ApplyJoinController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Apply Joins',
);

$this->menu=array(
	array('label'=>'Create ApplyJoin', 'url'=>array('create')),
	array('label'=>'Manage ApplyJoin', 'url'=>array('admin')),
);
?>

<h1>Apply Joins</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
