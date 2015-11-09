<?php
/* @var $this DinnerTableController */
/* @var $model DinnerTable */

$this->breadcrumbs=array(
	'Dinner Tables'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DinnerTable', 'url'=>array('index')),
	array('label'=>'Create DinnerTable', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#dinner-table-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Dinner Tables</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dinner-table-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'table_id',
		'table_name',
		'dealer_id',
		'table_status',
		'table_sit_count',
		'table_service_price',
		/*
		'table_is_room',
		'table_lower_case',
		'table_is_smoke',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
