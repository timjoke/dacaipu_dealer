<?php
/* @var $this ApplyJoinController */
/* @var $model ApplyJoin */

$this->breadcrumbs=array(
	'Apply Joins'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ApplyJoin', 'url'=>array('index')),
	array('label'=>'Create ApplyJoin', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#apply-join-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Apply Joins</h1>

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
	'id'=>'apply-join-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'apply_id',
		'dealer_name',
		'dealer_tel',
		'dealer_add',
		'contact_name',
		'contact_tel',
		/*
		'id_image_file_url',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
