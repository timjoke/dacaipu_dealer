<?php
/* @var $this DiscountController */
/* @var $model Discount */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'discount_id'); ?>
		<?php echo $form->textField($model,'discount_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_name'); ?>
		<?php echo $form->textField($model,'discount_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dealer_id'); ?>
		<?php echo $form->textField($model,'dealer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_mode'); ?>
		<?php echo $form->textField($model,'discount_mode'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_value'); ?>
		<?php echo $form->textField($model,'discount_value',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_condition'); ?>
		<?php echo $form->textField($model,'discount_condition',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_compare_value'); ?>
		<?php echo $form->textField($model,'discount_compare_value',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->