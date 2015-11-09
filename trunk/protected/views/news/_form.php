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
                'id' => 'news-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <table cellpadding="5" cellspacing="5" border="0" width="600">
                <tr height="35">
                    <td class="column_title">标题：</td>
                    <td>
                        <?php echo $form->textField($model, 'news_title', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1')); ?>
                    </td>
                </tr>
                <tr height="35">
                    <td class="column_title">类别：</td>
                    <td>
                        <?php
                        echo $form->radioButtonList($model, 'news_category', busNews::$NEWS_CATEGORY_NAME, array('separator' => ' '));
                        echo $msg;
                        echo CHtml::hiddenField('hd_news_category', $model->news_category);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        Yii::import('ext.krichtexteditor.KRichTextEditor');
                        $this->widget('KRichTextEditor', array(
                            'model' => $model,
                            'value' => $model->news_content ? '' : $model->news_content,
                            'attribute' => 'news_content',
                            'options' => array(
                                'theme_advanced_resizing' => 'true',
                                'theme_advanced_statusbar_location' => 'bottom',
                            ),
                        ));
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
                        <a style="border: 2px outset buttonface;height: 31px;width:93px;" class="Btn_1 CloseBtn" href="/news/index">取消</a>
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
        $("#news-form").validate({
            rules: {
            "News[news_title]": {required: true}
            },
        messages: {
            "News[news_title]": {required: "请输入标题"}
            }

                });
    }
</script> 
</body>
</html>