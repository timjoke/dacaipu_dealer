<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'fun-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>
<?php echo CHtml::checkBoxList('dealer_funlist', $dealer_funlist, busDealer::$DEALER_FUN_NAME, array('separator' => ' '));
?>
<?php echo CHtml::submitButton('保存', array('class' => 'Btn_1')); ?>
<?php $this->endWidget(); ?>