<?php
/* @var $this CouponController */
/* @var $model Coupon */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'coupon_id'); ?>
		<?php echo $form->textField($model,'coupon_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dealer_id'); ?>
		<?php echo $form->textField($model,'dealer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_no'); ?>
		<?php echo $form->textField($model,'coupon_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_value'); ?>
		<?php echo $form->textField($model,'coupon_value',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_start_time'); ?>
		<?php echo $form->textField($model,'coupon_start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_end_time'); ?>
		<?php echo $form->textField($model,'coupon_end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_status'); ?>
		<?php echo $form->textField($model,'coupon_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_customer_id'); ?>
		<?php echo $form->textField($model,'coupon_customer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coupon_create_time'); ?>
		<?php echo $form->textField($model,'coupon_create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->