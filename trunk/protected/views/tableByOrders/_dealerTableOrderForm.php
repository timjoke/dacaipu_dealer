<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<?php
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.validate.min.js');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
?>



<div class="PopWinArea">
    <div class="ContArea">

        <div class="MidArea" align="center">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'tableorder-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <table cellpadding="5" cellspacing="5" border="0" width="400">
                <tr height="35">
                    <td align="right">桌台：</td>
                    <td class="Select_1">
                        <?php
                        if (isset($_GET['reserv_id']))
                        {
                            echo CHtml::hiddenField('reserv_id', $_GET['reserv_id']);
                        }
                        ?>
                        <?php echo $dinner_table_name; ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">预约日期：</td>
                    <td>
                        <?php echo $reserv_date; ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">就餐时间：</td>
                    <td>
                        <?php
                        if ($isNewRecord)
                        {
                            echo CHtml::dropDownList('reserv_start_time', $time_point, $timepointlist, array('class' => 'Input_1'));
                        } else
                        {
                            echo $time_point;
                        }
                        ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">联系人：</td>
                    <td>
                        <?php
                        if ($isNewRecord)
                        {
                            ?>
                            <input name="contact_name" id="contact_name" class="Input_1"
                                   type="text"  value="<?php echo $contact_name; ?>">
                                   <?php
                               } else
                               {
                                   echo $contact_name;
                               }
                               ?>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">电话：</td>
                    <td>
                        <?php
                        if ($isNewRecord)
                        {
                            ?>
                            <input name="contact_tel" id="contact_tel" class="Input_1"
                                   type="text"  value="<?php echo $contact_tel; ?>">
                                   <?php
                               } else
                               {
                                   echo $contact_tel;
                               }
                               ?>
                    </td>
                </tr>
                <tr height="40" align="center">
                    <td>&nbsp;</td>
                    <td>
                        <?php
                        echo CHtml::submitButton($isNewRecord ? '创建' : '取消预定', array(
                            'class' => 'Btn_1'));
                        if ($isNewRecord)
                        {
                            ?>
                            <input id='cancel' class="Btn_1 CloseBtn" onclick="window.top.closeDialog();" value="取消" type="button" />
                        <?php } ?>
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
        $("#tableorder-form").validate({
            rules: {
                "contact_name": "required",
                "contact_tel": "required",
            },
            messages: {
                "contact_name": "请输入联系人",
                "contact_tel": "请输入电话",
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