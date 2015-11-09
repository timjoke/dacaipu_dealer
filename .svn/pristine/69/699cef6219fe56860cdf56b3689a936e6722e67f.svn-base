<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<?php
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/timepicker.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.zh_cn.js');
Yii::app()->clientScript->registerScript('time_point', "jQuery('#TableOrderTimePoint_time_point').timepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'changeMonth':false,'changeYear':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.validate.min.js');
?>
<div class="PopWinArea">
    <div class="ContArea">

        <div class="MidArea" align="center ">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'table-order-time-point-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <table cellpadding="5" cellspacing="5" border="0" width="500">
                <tr height="35">
                    <td align="right">时间：</td>
                    <td class="Select_1">
                        <?php
                        echo $form->textField($model, 'time_point', array('class' => 'Input_1', 'style' => 'width:120px'));
                        ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">餐市类型：</td>
                    <td class="Select_1">
                        <?php
                        echo CHtml::dropDownList('dinner_type', $dinner_type, busTableOrderTimePoint::$DINNER_TYPE_NAME);
                        ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right"></td>
                    <td class="Select_1">

                    </td>
                </tr>
                <tr height="40" align="center">
                    <td>&nbsp;</td>
                    <td>
                        <?php
                        echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改', array(
                            'class' => 'Btn_1'));
                        ?>
                        <input id='cancel' class="Btn_1 CloseBtn" onclick="window.top.closeDialog();" value="取消" type="button" />
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
        </body>
</html>