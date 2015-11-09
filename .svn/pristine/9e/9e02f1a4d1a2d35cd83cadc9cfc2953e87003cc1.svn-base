<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_customer_id'); ?>
		<?php echo $form->textField($model,'order_customer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_createtime'); ?>
		<?php echo $form->textField($model,'order_createtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_amount'); ?>
		<?php echo $form->textField($model,'order_amount',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_paid'); ?>
		<?php echo $form->textField($model,'order_paid',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_status'); ?>
		<?php echo $form->textField($model,'order_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_type'); ?>
		<?php echo $form->textField($model,'order_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_ispay'); ?>
		<?php echo $form->textField($model,'order_ispay'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_pay_type'); ?>
		<?php echo $form->textField($model,'order_pay_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->