<?php
/* @var $this DealerServiceTimeController */
/* @var $model DealerServiceTime */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'st_id'); ?>
		<?php echo $form->textField($model,'st_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dealer_id'); ?>
		<?php echo $form->textField($model,'dealer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_start_time'); ?>
		<?php echo $form->textField($model,'st_start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_end_time'); ?>
		<?php echo $form->textField($model,'st_end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_name'); ?>
		<?php echo $form->textField($model,'st_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->