<?php
/* @var $this DishController */
/* @var $model Dish */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'dish_id'); ?>
		<?php echo $form->textField($model,'dish_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_name'); ?>
		<?php echo $form->textField($model,'dish_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_price'); ?>
		<?php echo $form->textField($model,'dish_price',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_recommend'); ?>
		<?php echo $form->textField($model,'dish_recommend'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_package_fee'); ?>
		<?php echo $form->textField($model,'dish_package_fee',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_is_vaget'); ?>
		<?php echo $form->textField($model,'dish_is_vaget'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_spicy_level'); ?>
		<?php echo $form->textField($model,'dish_spicy_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_introduction'); ?>
		<?php echo $form->textField($model,'dish_introduction',array('size'=>60,'maxlength'=>8000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dealer_id'); ?>
		<?php echo $form->textField($model,'dealer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_status'); ?>
		<?php echo $form->textField($model,'dish_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_createtime'); ?>
		<?php echo $form->textField($model,'dish_createtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_mode'); ?>
		<?php echo $form->textField($model,'dish_mode'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dish_child_count'); ?>
		<?php echo $form->textField($model,'dish_child_count',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->