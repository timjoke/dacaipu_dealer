<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'news_id'); ?>
		<?php echo $form->textField($model,'news_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'news_category'); ?>
		<?php echo $form->textField($model,'news_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'news_title'); ?>
		<?php echo $form->textField($model,'news_title',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'news_content'); ?>
		<?php echo $form->textField($model,'news_content',array('size'=>60,'maxlength'=>4000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dealer_id'); ?>
		<?php echo $form->textField($model,'dealer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->