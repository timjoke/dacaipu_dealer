<?php
/* @var $this DealerDinnerController */
/* @var $data DealerDinner */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('dealer_dinner_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->dealer_dinner_id), array('view', 'id'=>$data->dealer_dinner_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dealer_id')); ?>:</b>
	<?php echo CHtml::encode($data->dealer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dinner_type')); ?>:</b>
	<?php echo CHtml::encode($data->dinner_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>