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
                        'id' => 'dealerWechatReply-form',
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <table cellpadding="5" cellspacing="5" border="0" width="400">
                        <tr height="35">
                            <td class="column_title">关键字：</td>
                            <td>
                                <?php
                                echo $form->textField($model, 'keyword', array(
                                    'class' => 'Input_1'));
                                ?>
                                <?php echo $form->error($model, 'keyword'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td class="column_title">操作符：</td>
                            <td>
                                <?php
                                echo $form->dropDownList($model, 'operat', busDealerWechatReply::$OPERAT_LIST, array(
                                    'separator' => ' ',
                                    'class' => 'Input_1'));
                                ?>
                                <?php echo $form->error($model, 'operat'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td class="column_title">内容类型：</td>
                            <td>
                                <?php
                                echo $form->dropDownList($model_content, 'content_type', busDealerWechatReply::$CONTENT_TYPE_LIST, array(
                                    'separator' => ' ',
                                    'class' => 'Input_1'));
                                ?>
                                <?php echo $form->error($model_content, 'content_type'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td class="column_title">回复内容：</td>
                            <td>
                                <?php
                                echo $form->textArea($model_content, 'content', array(
                                    'class' => 'Input_1','style'=>'height:300px;'));
                                ?>
                                <?php echo $form->error($model_content, 'operat'); ?>
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
                $("#dealerWechatReply-form").validate({
                    rules: {
                        "DealerWechatReply[keyword]": "required",
                        "DealerWechatReply[content]": "required",
                        "DealerWechatReply[operat]": {
                            mustSeleted: true
                        },
                        "DealerWechatReply[content_type]": {
                            mustSeleted: true
                        },
                    },
                    messages: {
                        "DealerWechatReply[keyword]": {required: "请输入关键字"},
                        "DealerWechatReply[content]": {required: "请输入回复内容"},
                        "DealerWechatReply[operat]":'请选择操作符',
                        "DealerWechatReply[content_type]":'请选择内容类型',
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