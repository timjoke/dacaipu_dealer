<?php
/* @var $this ApplyJoinController */
/* @var $model ApplyJoin */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'apply-join-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'dealer_name'); ?>
		<?php echo $form->textField($model,'dealer_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'dealer_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dealer_tel'); ?>
		<?php echo $form->textField($model,'dealer_tel',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'dealer_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dealer_add'); ?>
		<?php echo $form->textField($model,'dealer_add',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'dealer_add'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_name'); ?>
		<?php echo $form->textField($model,'contact_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contact_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_tel'); ?>
		<?php echo $form->textField($model,'contact_tel',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'contact_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_image_file_url'); ?>
		<?php echo $form->textField($model,'id_image_file_url',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'id_image_file_url'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->