<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'order_customer_id'); ?>
		<?php echo $form->textField($model,'order_customer_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'order_customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_createtime'); ?>
		<?php echo $form->textField($model,'order_createtime'); ?>
		<?php echo $form->error($model,'order_createtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_amount'); ?>
		<?php echo $form->textField($model,'order_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'order_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_paid'); ?>
		<?php echo $form->textField($model,'order_paid',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'order_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_status'); ?>
		<?php echo $form->textField($model,'order_status'); ?>
		<?php echo $form->error($model,'order_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_type'); ?>
		<?php echo $form->textField($model,'order_type'); ?>
		<?php echo $form->error($model,'order_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_ispay'); ?>
		<?php echo $form->textField($model,'order_ispay'); ?>
		<?php echo $form->error($model,'order_ispay'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_pay_type'); ?>
		<?php echo $form->textField($model,'order_pay_type'); ?>
		<?php echo $form->error($model,'order_pay_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->