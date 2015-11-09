<?php
/* @var $this CouponController */
/* @var $model Coupon */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'coupon-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'dealer_id'); ?>
		<?php echo $form->textField($model,'dealer_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'dealer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_no'); ?>
		<?php echo $form->textField($model,'coupon_no',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'coupon_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_value'); ?>
		<?php echo $form->textField($model,'coupon_value',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'coupon_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_start_time'); ?>
		<?php echo $form->textField($model,'coupon_start_time'); ?>
		<?php echo $form->error($model,'coupon_start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_end_time'); ?>
		<?php echo $form->textField($model,'coupon_end_time'); ?>
		<?php echo $form->error($model,'coupon_end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_status'); ?>
		<?php echo $form->textField($model,'coupon_status'); ?>
		<?php echo $form->error($model,'coupon_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_customer_id'); ?>
		<?php echo $form->textField($model,'coupon_customer_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'coupon_customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_create_time'); ?>
		<?php echo $form->textField($model,'coupon_create_time'); ?>
		<?php echo $form->error($model,'coupon_create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'order_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->