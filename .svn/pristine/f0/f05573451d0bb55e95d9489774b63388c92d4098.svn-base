<?php
/* @var $this DiscountPlanController */
/* @var $model DiscountPlan */

$this->breadcrumbs=array(
	'Discount Plans'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DiscountPlan', 'url'=>array('index')),
	array('label'=>'Create DiscountPlan', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#discount-plan-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Discount Plans</h1>

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
	'id'=>'discount-plan-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ar_id',
		'ar_entity_id',
		'discount_id',
		'ar_start_time',
		'ar_end_time',
		'ar_status',
		/*
		'ar_type',
		'ar_order',
		'ar_dealer_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
