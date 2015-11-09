<?php
/* @var $this DinnerTableController */
/* @var $model DinnerTable */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'table_id'); ?>
		<?php echo $form->textField($model,'table_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_name'); ?>
		<?php echo $form->textField($model,'table_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dealer_id'); ?>
		<?php echo $form->textField($model,'dealer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_status'); ?>
		<?php echo $form->textField($model,'table_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_sit_count'); ?>
		<?php echo $form->textField($model,'table_sit_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_service_price'); ?>
		<?php echo $form->textField($model,'table_service_price',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_is_room'); ?>
		<?php echo $form->textField($model,'table_is_room'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_lower_case'); ?>
		<?php echo $form->textField($model,'table_lower_case',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_is_smoke'); ?>
		<?php echo $form->textField($model,'table_is_smoke'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->