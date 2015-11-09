<?php
/* @var $this TableOrderTimePointController */
/* @var $model TableOrderTimePoint */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'table_order_time_point_id'); ?>
		<?php echo $form->textField($model,'table_order_time_point_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dealer_dinner_id'); ?>
		<?php echo $form->textField($model,'dealer_dinner_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_point'); ?>
		<?php echo $form->textField($model,'time_point'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->