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
Yii::app()->clientScript->registerScript('starttime', "jQuery('#DealerServiceTime_st_start_time').timepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'changeMonth':false,'changeYear':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
Yii::app()->clientScript->registerScript('endtime', "jQuery('#DealerServiceTime_st_end_time').timepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'changeMonth':false,'changeYear':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.validate.min.js');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
?>
<div class="PopWinArea">
    <div class="ContArea">

        <div class="MidArea" align="center">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'dealer-servicetime-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <table cellpadding="5" cellspacing="5" border="0" width="500">
                <tr height="35">    
                    <td align="right">开始时间*：</td>
                    <td>
                        <?php echo $form->textField($model, 'st_start_time', array('class' => 'Input_1', 'style' => 'width:120px')); ?>
                        <?php echo $form->error($model, 'st_start_time'); ?>
                    </td>
                </tr>

                <tr height="35">    
                    <td align="right">结束时间*：</td>
                    <td>
                        <?php echo $form->textField($model, 'st_end_time', array('class' => 'Input_1', 'style' => 'width:120px')); ?>
                        <?php echo $form->error($model, 'st_end_time'); ?>
                    </td>
                </tr>
                <tr height="35"> 
                    <td align="right">时段名称*：</td>
                    <td>
                        <?php
                        echo $form->textField($model, 'st_name', array(
                            'size' => 50,
                            'maxlength' => 50, 'class' => 'Input_1'));
                        ?>
                        <?php echo $form->error($model, 'st_name');
                        ?>
                    </td>
                </tr>
                <tr height="40">
                    <td align="right"></td>
                    <td>
                        <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改', array('class' => 'Btn_1')); ?>
                        <input id='cancel' class="Btn_1 CloseBtn" onclick="window.top.closeDialog();" value="取消" type="button" />
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
            <br><br>
        </div>
    </div>
    <div style="clear:both"></div>
</div>


<script type="text/javascript">
    $().ready(function() {
        jQuery.validator.addMethod("mustSeleted", function(value, element) {
            return (parseFloat(value) > -1);
        }, "mustSeleted");

        jQuery.validator.methods.compareDate = function(value, element, param) {
            var startDate = jQuery(param).val();

            var date1 = Date.parse("2014/1/1 " + startDate + ":00");
            var date2 = Date.parse("2014/1/1 " + value + ":00");
            return date1 < date2;
        };
        $("#dealer-servicetime-form").validate({
            rules: {
                "DealerServiceTime[st_start_time]": "required",
                "DealerServiceTime[st_end_time]": {required: true, compareDate: "#DealerServiceTime_st_start_time"},
                "DealerServiceTime[st_name]": "required"
            },
            messages: {
                "DealerServiceTime[st_start_time]": "请输入开始时间",
                "DealerServiceTime[st_end_time]": {required: "请输入结束时间", compareDate: "结束时间必须大于开始时间"},
                "DealerServiceTime[st_name]": "请输入时段名称"
            }
        });
    });
</script>
</body>
</html>