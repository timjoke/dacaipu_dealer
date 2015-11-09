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
Yii::app()->clientScript->registerScript('starttime', "jQuery('#DiscountPlan_ar_start_time').datetimepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'changeMonth':false,'changeYear':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
Yii::app()->clientScript->registerScript('endtime', "jQuery('#DiscountPlan_ar_end_time').datetimepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'changeMonth':false,'changeYear':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.validate.min.js');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
if ($msg != '')
{
    Yii::app()->clientScript->registerScript('msg', 'alert("' . $msg . '");');
}
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
                'id' => 'discount-plan-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <table cellpadding="5" cellspacing="5" border="0" width="400">
                <tr height="35">
                    <td class="column_title">折扣模板：</td>
                    <td>
                        <?php
                        echo $form->dropDownList($model, 'discount_id', $stencils, array(
                            'separator' => ' ',
                            'class' => 'Input_1'));
                        ?>
                        <?php echo $form->error($model, 'discount_id'); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td class="column_title">优惠政策：</td>
                    <td>
                        <?php
                        echo $form->dropDownList($model, 'ar_type', BusDiscount::$DISCOUNT_PLAN_TYPE, array('class' => 'Input_1',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('discountPlan/dynamicEntity'),
                                'data' => array('policy_id' => 'js:this.value'),
                                'success' => 'function(html){jQuery("#DiscountPlan_ar_entity_id").html(html);}'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'ar_type'); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td class="column_title">优惠实体：</td>
                    <td>
                        <?php
                        if (!isset($entities))
                        {
                            echo $form->dropDownList($model, 'ar_entity_id', array('0' => '全店'), array('class' => 'Input_1'));
                        } else
                        {
                            echo $form->dropDownList($model, 'ar_entity_id', $entities, array('class' => 'Input_1'));
                        }
                        ?>
                        <?php echo $form->error($model, 'ar_entity_id'); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td class="column_title">开始时间：</td>
                    <td>
                        <?php echo $form->textField($model, 'ar_start_time', array('class' => 'Input_1', 'style' => 'width:150px')); ?>
                        <?php echo $form->error($model, 'ar_start_time'); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td class="column_title">结束时间：</td>
                    <td>
                        <?php echo $form->textField($model, 'ar_end_time', array('class' => 'Input_1', 'style' => 'width:150px')); ?>
                        <?php echo $form->error($model, 'ar_end_time'); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td class="column_title">计划状态：</td>
                    <td >
                        <?php
                        echo $form->radioButtonList($model, 'ar_status', BusDiscount::$DISCOUNT_PLAN_STATUS, array(
                            'separator' => ' '
                        ));
                        ?>
                        <?php echo $form->error($model, 'ar_status'); ?></td>
                </tr>
                <tr height="35">
                    <td class="column_title">下单类别：</td>
                    <td >
                        <?php
                        if ($model->isNewRecord)
                        {
                            echo CHtml::checkBoxList('orders_type_list', array(), BusDiscount::$DISCOUNT_ORDERS_TYPE, array('separator' => ' '));
                        } else
                        {
                            echo $form->dropDownList($model, 'ar_orders_type', BusDiscount::$DISCOUNT_ORDERS_TYPE, array(
                                'separator' => ' ',
                                'class' => 'Input_1'));
                        }
                        ?>
                </tr>

                <tr height="35">
                    <td class="column_title">优先级：</td>
                    <td>
                        <?php
                        echo $form->textField($model, 'ar_order', array(
                            'class' => 'Input_1'));
                        ?>
                        <?php echo $form->error($model, 'ar_order'); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td class="column_title">VIP优先级：</td>
                    <td>
                        <?php
                        echo $form->textField($model, 'ar_vip_level', array(
                            'class' => 'Input_1'));
                        ?>
                        <?php echo $form->error($model, 'ar_vip_level'); ?>
                    </td>
                </tr>
                <tr height="40">
                    <td>&nbsp;</td>
                    <td>
                        <?php
                        echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改', array(
                            'class' => 'Btn_1'));
//                        echo $msg;
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
        $("#discount-plan-form").validate({
            rules: {
                "DiscountPlan[ar_order]": {required: true, digits: true},
                "DiscountPlan[discount_id]": {
                    mustSeleted: true
                },
                "DiscountPlan[ar_entity_id]": {
                    mustSeleted: true
                },
                "DiscountPlan[ar_start_time]": "required",
                "DiscountPlan[ar_end_time]": {required: true, compareDate: "#DiscountPlan_ar_start_time"},
            },
            messages: {
                "DiscountPlan[ar_order]": {required: "请输入优先级", digits: "请输入整数"},
                "DiscountPlan[discount_id]": "请选择折扣模板",
                "DiscountPlan[ar_entity_id]": "请选择优惠实体",
                "DiscountPlan[ar_start_time]": "请选择开始时间",
                "DiscountPlan[ar_end_time]": {required: "请选择结束时间", compareDate: "结束时间必须大于开始时间"},
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