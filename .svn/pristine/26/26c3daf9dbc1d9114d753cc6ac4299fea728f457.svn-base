<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<?php
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.validate.min.js');
?>
<!--<style>
    body{height: 0;}
</style>-->
<script src="<?php echo $this->get_static_url(); ?>js/jquery.validate.min.js" type="text/javascript"></script>
<div class="PopWinArea">
    <div class="ContArea">
        <div class="MidArea" align="center">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>  
            <table cellpadding="5" cellspacing="5" border="0" width="430">
                <tr height="35">
                    <td align="right">折扣名称：</td>
                    <td>
                        <?php echo $form->textField($model, 'discount_name', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1')); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">折扣模式：</td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'discount_mode', BusDiscount::$DISCOUNT_MODE, array('separator' => ' ')); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">折 扣 值：</td>
                    <td>
                        <?php echo $form->textField($model, 'discount_value', array('size' => 10, 'maxlength' => 10, 'class' => 'Input_1')); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">折扣条件：</td>
                    <td>
                        <?php echo $form->dropDownList($model, 'discount_condition', BusDiscount::$DISCOUNTCONDITION) ?>
                        <?php echo $form->textField($model, 'discount_compare_value'); ?>
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
    <div style="clear:both"></div>
</div>

<script type="text/javascript">

    $().ready(function() {
        jqValidation();
    });

    function jqValidation() {
        jQuery.validator.addMethod("mustSeleted", function(value, element) {
            return (parseFloat(value) > -1);
        }, "mustSeleted");
        $("#login-form").validate({
            rules: {
                "Discount[discount_name]": "required",
                "Discount[discount_value]": {required: true, number: true},
                "Discount[discount_compare_value]": {required: true, number: true},
            },
            messages: {
                "Discount[discount_name]": "请输入折扣名称",
                "Discount[discount_value]": {required: "请输入折扣值", number: "折扣值请输入小数"},
                "Discount[discount_compare_value]": {required: "请输入折扣条件", number: "折扣条件比较值请输入小数"}
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