<?php
/* @var $this DealerWechatReplyContentController */
/* @var $model DealerWechatReplyContent */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dealer-wechat-reply-content-form',
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
		<?php echo $form->labelEx($model,'content_type'); ?>
		<?php echo $form->textField($model,'content_type'); ?>
		<?php echo $form->error($model,'content_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textField($model,'content',array('size'=>60,'maxlength'=>2000)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->