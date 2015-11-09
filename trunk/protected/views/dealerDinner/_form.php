<?php
/* @var $this DealerDinnerController */
/* @var $model DealerDinner */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dealer-dinner-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'dealer_dinner_id'); ?>
		<?php echo $form->textField($model,'dealer_dinner_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'dealer_dinner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dealer_id'); ?>
		<?php echo $form->textField($model,'dealer_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'dealer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dinner_type'); ?>
		<?php echo $form->textField($model,'dinner_type'); ?>
		<?php echo $form->error($model,'dinner_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->