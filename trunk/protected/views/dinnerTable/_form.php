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
                    <td align="right">桌台名称：</td>
                    <td>
                        <?php echo $form->textField($model, 'table_name', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1')); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">桌台状态：</td>
                    <td>
                        <?php $statuslist = array(1 => '已上线', 0 => '已下线', -1 => '已删除'); ?>
                        <?php echo $form->radioButtonList($model, 'table_status', $statuslist, array('separator' => ' ')) ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">座位数：</td>
                    <td>
                        <?php echo $form->textField($model, 'table_sit_count', array('class' => 'Input_1')); ?>
                    </td>
                </tr>
<!--                    <tr height="35">
                    <td align="right">服务费：</td>
                    <td>
                <?php echo $form->textField($model, 'table_service_price', array('class' => 'Input_1')); ?>
                    </td>
                </tr>-->
                <tr height="35">
                    <td align="right">是否包间：</td>
                    <td>
                        <?php $isroomlist = array(0 => '堂食', 1 => '包间'); ?>
                        <?php echo $form->radioButtonList($model, 'table_is_room', $isroomlist, array('separator' => ' ')) ?>
                    </td>
                </tr>
<!--                    <tr height="35">
                    <td align="right">最低消费：</td>
                    <td>
                <?php echo $form->textField($model, 'table_lower_case', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1')); ?>
                    </td>
                </tr>-->
                <tr height="35">
                    <td align="right">允许抽烟：</td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'table_is_smoke', busDinnerTable::$DINNERTABLE_ISSMOKE_NAME, array('separator' => ' ')) ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">点菜桌号：</td>
                    <td>
                        <?php
                        echo CHtml::textField('hallTableNum', $hallTableNum, array('class' => 'Input_1'));
                        ?>
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
                    "DinnerTable[table_name]": "required",
            "DinnerTable[table_sit_count]": {required: true, digits: true}
            },
                messages: {
                    "DinnerTable[table_name]": "请输入桌台名称",
                    "DinnerTable[table_sit_count]": {required: "请输入座位数", digits: "座位数请输入整数"}
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