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
                        'id' => 'dish-category-form',
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <table cellpadding="5" cellspacing="5" border="0" width="400">

                        <tr height="35">
                            <td align="right" style="width: 100px;">类别名称：</td>
                            <td>
                                <?php echo $form->textField($model, 'category_name', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1')); ?>
                                <?php echo $form->error($model, 'category_name'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td align="right" style="width: 100px;">状态：</td>
                            <td>

                                <?php echo $form->radioButtonList($model, "category_status", busDishCategory::$CATEGORY_STATUS_NAME, array('separator' => ' '));
                                ?>
                                <?php echo $form->error($model, 'category_status'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td align="right" style="width: 100px;">所属类别：</td>
                            <td class="Select_1">
                                <?php echo $form->dropDownList($model, 'category_parent_id', $categories, array('class' => 'Input_1')); ?>
                                <?php echo $form->error($model, 'category_parent_id'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td align="right" style="width: 100px;">排序优先级：</td>
                            <td>
                                <?php echo $form->textField($model, 'dish_category_order', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1')); ?>
                                <?php echo $form->error($model, 'dish_category_order'); ?>
                            </td>
                        </tr>
                        <tr height="40">
                            <td>&nbsp;</td>
                            <td>
                                <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改', array('class' => 'Btn_1')); ?>
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
                jQuery.validator.addMethod("mustSeleted", function(value, element) {
                    return (parseFloat(value) > -1);
                }, "mustSeleted");
                $("#dish-category-form").validate({
                    rules: {
                        "DishCategory[category_name]": "required",
                    },
                    messages: {
                        "DishCategory[category_name]": "请输入类别名称"
                    }
                });
            });
        </script>