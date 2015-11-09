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
        Yii::app()->clientScript->registerScript('starttime', "jQuery('#Coupon_coupon_start_time').datetimepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'changeMonth':false,'changeYear':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
        Yii::app()->clientScript->registerScript('endtime', "jQuery('#Coupon_coupon_end_time').datetimepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'changeMonth':false,'changeYear':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
        Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.validate.min.js');
        Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
        ?>
        <style type="text/css">
            form{
                margin: 0
            }
            .column_title{
                width: 100px;
                text-align:right;
            }
        </style>
        <div class="PopWinArea">
            <div class="ContArea">
                <div class="MidArea" align="center">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'coupon-form',
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <table cellpadding="5" cellspacing="5" border="0" width="400">
                        <tr height="35">
                            <td class="column_title">优惠券金额：</td>
                            <td>
                                <?php
                                echo $form->textField($model, 'coupon_value', array(
                                    'class' => 'Input_1'));
                                ?>
                                <?php echo $form->error($model, 'coupon_value'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td class="column_title">开始时间：</td>
                            <td>
                                <?php echo $form->textField($model, 'coupon_start_time', array('class' => 'Input_1', 'style' => 'width:150px')); ?>
                                <?php echo $form->error($model, 'coupon_start_time'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td class="column_title">结束时间：</td>
                            <td>
                                <?php echo $form->textField($model, 'coupon_end_time', array('class' => 'Input_1', 'style' => 'width:150px')); ?>
                                <?php echo $form->error($model, 'coupon_end_time'); ?>
                            </td>
                        </tr>

                        <tr height="35">
                            <td class="column_title">生成个数：</td>
                            <td>
                                <?php
                                echo $form->textField($model, 'coupon_count', array(
                                    'class' => 'Input_1'));
                                ?>
                                <?php echo $form->error($model, 'coupon_count'); ?>
                            </td>
                        </tr>
                        <tr height="40">
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

        <script type="text/javascript">
            $().ready(function() {
                jqValidation();
            });
            function jqValidation() {
                jQuery.validator.addMethod("mustSeleted", function(value, element) {
                    return (parseFloat(value) > -1);
                }, "mustSeleted");
                jQuery.validator.methods.compareDate = function(value, element, param) {
                    var startDate = jQuery(param).val();

                    var date1 = Date.parse(startDate.replace(/-/g, '/'));
                    var date2 = Date.parse(value.replace(/-/g, '/'));
                    return date1 < date2;
                };
                $("#coupon-form").validate({
                    rules: {
                        "Coupon[coupon_value]": {required: true, digits: true},
                        "Coupon[coupon_count]": {required: true, digits: true},
                        "Coupon[coupon_start_time]": "required",
                        "Coupon[coupon_end_time]": {required: true, compareDate: "#Coupon_coupon_start_time"},
                    },
                    messages: {
                        "Coupon[coupon_value]": {required: "请输入优惠券金额", digits: "请输入整数"},
                        "Coupon[coupon_count]": {required: "请输入生成个数", digits: "请输入整数"},
                        "Coupon[coupon_start_time]": "请选择开始时间",
                        "Coupon[coupon_end_time]": {required: "请选择结束时间", compareDate: "结束时间必须大于开始时间"},
                    },
                    errorPlacement: function(error, element) {
                        if ($(element).is(":radio") || $(element).is(":checkbox")) {
                            $(element).parent().parent().append(error);
                        } else
                            $(element).after(error);
                    }
                });
            }

        </script>
    </body>
</html>