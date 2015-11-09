<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
        Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.validate.min.js');
        Yii::app()->clientScript->registerScriptFile('/uploadify/jquery.uploadify.min.js');
        ?>


        <script type="text/javascript">
            function select_img()
            {
                $('#qqfile').uploadify('upload', '*');
                $('#SWFUpload_0').focus();
            }
        </script> 

        <style type="text/css">
            .uploadify-button {
                border: none;
                padding: 0;
                width:60px;
                height:70px;
                background-size: 100% 100%;
            }

            .uploadify:hover .uploadify-button {
                background-color: transparent;
            }
            .selebg1
            {
                border-right: #ffffff 0px solid;
                border-top: #ffffff 0px solid;
                border-left: #ffffff 0px solid;
                border-bottom: #ffffff 0px solid;
                color: #333333;
                background-image: url(../../../images/selem2.gif);
                background-color: #e7e7e7;
                font-size: 12px;
                font-family: "宋体", arial, verdana,helvetica, sans-serif;
                height: 25px;
                width: 187px;
                margin-top:5px;
                cursor:pointer;
            }
            ul{
                width:100%;
                height:100%;
                line-height:30px;
                color:gray;
                list-style-type:none;

            }
            ul,li{
                list-style: none;
                margin: 0;
                padding: 0;
                vertical-align: bottom;
            }
            li{
                /*                display:-webkit-box;
                                -webkit-box-pack:center;
                                -webkit-box-align: center;
                                -webkit-backface-visibility: hidden;*/

                list-style-type: none;
                float: left;
                width: 170px;
                margin-left: 20px;
                line-height: 25px;
                vertical-align: middle;
                text-align: left;
                cursor:pointer;
            }


            ul li:hover { background-color: #ffa22e; color: #ffffff; }
        </style>

        <div id="id_select_dishtype" style="margin-left: 128px;
             margin-top: 185px;
             background-color: cornsilk;
             height: auto;
             width: 80%;
             overflow-y: auto;
             position: absolute;
             border:1px solid orange;
             display:none;">
            <ul>
                <?php
                foreach ($categories as $key => $value)
                {
                    $flag = true;
                    foreach ($cateogry_id_arr as $key_id => $value_id)
                    {
                        if ($key_id == $key)
                        {
                            echo "<li><input onclick='cb_click(this)'"
                            . " checked='checked'"
                            . " data-id='" . $key
                            . "' id='cb_id_" . $key
                            . "' type='checkbox'/><label for='cb_id_"
                            . $key . "'>"
                            . $value . "</label></li>";
                            $flag = false;
                            break;
                        }
                    }
                    if ($flag)
                    {
                        echo "<li><input onclick='cb_click(this)'"
                        . " data-id='" . $key
                        . "' id='cb_id_" . $key
                        . "' type='checkbox'/><label for='cb_id_"
                        . $key . "'>"
                        . $value . "</label></li>";
                    }
                }
                ?>
            </ul>
        </div>
        <div class="PopWinArea">
            <div class="ContArea">
                <div class="MidArea" align="center">


                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'dish-form',
                        'enableAjaxValidation' => false,
                        'htmlOptions' => array('enctype' => 'multipart/form-data')
                    ));
                    ?>
                    <table cellpadding="5" cellspacing="5" border="0" width="800">
                        <tr height="35">
                            <td align="right" style="width: 100px;">菜品名称：</td>
                            <td>
                                <?php echo $form->textField($model, 'dish_name', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1'));
                                ?>
                                <?php echo $form->error($model, 'dish_name'); ?>
                            </td>
                            <td rowspan="3" align="right">菜品图片：</td>
                            <td rowspan="3" class="PicLoadArea">
                                <?php echo CHtml::hiddenField('newPicName', $picurl_dish) ?>
                                <h6>
                                    <input id="qqfile" name="qqfile" type="file" multiple="false">
                                </h6>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">菜品价格：</td>
                            <td>
                                <?php echo $form->textField($model, 'dish_price', array('size' => 10, 'maxlength' => 10, 'class' => 'Input_1')); ?>
                                <?php echo $form->error($model, 'dish_price'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">打包费：</td>
                            <td>
                                <?php echo $form->textField($model, 'dish_package_fee', array('size' => 10, 'maxlength' => 10, 'class' => 'Input_1')); ?>
                                <?php echo $form->error($model, 'dish_package_fee'); ?>
                            </td>
                        </tr>

                        <tr height="35">
                            <td align="right" name='$cateogry_id'>类型：</td>
                            <td class="Select_1">
                                <?php //echo CHtml::dropDownList('dish_category', $cateogry_id, $categories); ?>
                                <?php //echo $form->errorSummary(array($model)); ?>
                                <?php
                                //$select_dish_cagegory = implode(",", $cateogry_id_arr);
                                $select_dish_cagegory="";
                                $select_dish_cagegory_id = "";
                                foreach ($cateogry_id_arr as $key => $value)
                                {
                                    $select_dish_cagegory.=$value . "；";
                                    $select_dish_cagegory_id.=$key . ",";
                                }
                                if ($select_dish_cagegory == "")
                                    $select_dish_cagegory = "选择/修改";
                                ?>
                                <input id="btn_dish_type" name="dish_category_1" value="<?php echo $select_dish_cagegory?>" type="button" class="selebg1" align="absmiddle"/>
                                <input id="selected_dish_type" type="hidden" name="dish_category" value="<?php echo $select_dish_cagegory_id ?>">
                            </td>
                            <td align="right" style="width: 100px;" for='Dish[dish_recommend]'>是否推荐：</td>
                            <td for='Dish[dish_recommend]'><?php // $recommendlist = array(1 => '推荐', 0 => '不推荐');                                 ?>
                                <?php echo $form->radioButtonList($model, 'dish_recommend', busDish::$RECOMMEND, array('separator' => ' ')) ?>
                                <?php echo $form->error($model, 'dish_recommend'); ?></td>
                        </tr>
                        <tr height="35">
                            <td align="right">辣度：</td>
                            <td class="Select_1">
                                <?php echo $form->dropDownList($model, 'dish_spicy_level', busDish::$SPICY_LEVEL); ?>
                                <?php echo $form->error($model, 'dish_spicy_level'); ?>
                            </td>
                            <td align="right" name='dish_is_vaget'>是否素菜：</td>
                            <td>
                                <?php echo $form->radioButtonList($model, 'dish_is_vaget', busDish::$ISVAGET, array('separator' => ' ')) ?>
                                <?php echo $form->error($model, 'dish_is_vaget'); ?></td>
                        </tr>
                        <tr height="35">
                            <td align="right">菜品模式：</td>
                            <td class="Select_1">

                                <?php
                                if ($dish_mode_isable)
                                {
                                    echo $form->dropDownList($model, 'dish_mode', busDish::$DISH_MODE, array('style' => 'width:200px;'));
                                }
                                else
                                {
                                    echo $form->dropDownList($model, 'dish_mode', busDish::$DISH_MODE, array('style' => 'width:200px;', 'disabled' => 'disabled'));
                                    echo $form->hiddenField($model, 'dish_mode', array('style' => 'width:200px;'));
                                }
                                ?>
                                <?php echo $form->error($model, 'dish_mode'); ?>
                            </td>
                            <td align="right" name='dish_is_vaget'>套餐最多选择数量：</td>
                            <td>
                                <?php echo $form->textField($model, 'dish_child_count', array('size' => 10, 'maxlength' => 10, 'style' => 'width:200px;', 'class' => 'Input_1', 'placeholder' => '菜品模式为套餐时，才有意义')); ?>
                                <?php echo $form->error($model, 'dish_child_count'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td align="right">菜品显示类别：</td>
                            <td class="Select_1">
                                <?php echo CHtml::checkBoxList('dish_display_type', $dish_display_type_select, busDish::$DISH_DISPLAY_TYPE_NAME, array('separator' => ' '));
                                ?>
                            </td>
                            <td align="right">状态：</td>
                            <td class="Select_1">
                                <?php echo $form->radioButtonList($model, 'dish_status', busDish::$DISH_STATUS, array('separator' => ' ')) ?>
                                <?php echo $form->error($model, 'dish_status'); ?>
                            </td>
                        </tr>
                        <tr height="35">
                            <td align="right" style="width: 100px;">排序优先级：</td>
                            <td>
                                <?php echo $form->textField($model, 'dish_order', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1'));
                                ?>
                                <?php echo $form->error($model, 'dish_order'); ?>
                            </td>
                        </tr>
                        <?php
                        if ($model->isNewRecord == FALSE)
                        {
                            ?>
                            <tr height="35">
                                <td align="right">创建时间：</td>
                                <td class="TimeArea"><?php echo busUlitity::formatDate($model->dish_createtime); ?>
                                    <?php echo $form->error($model, 'dish_createtime'); ?>
                                </td>

                                <td align="right">修改时间：</td>
                                <td class="TimeArea"><?php echo busUlitity::formatDate($model->dish_modifytime); ?>
                                    <?php echo $form->error($model, 'dish_modifytime'); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr height="65">
                            <td align="right" valign="top">简介：</td>
                            <td colspan="3" class="Input_4"><em><?php echo $form->textArea($model, 'dish_introduction', array('size' => 60, 'maxlength' => 8000)); ?>
                                    <?php echo $form->error($model, 'dish_introduction'); ?></em></td>
                        </tr>
                        <tr height="40" align="center">
                            <td>&nbsp;</td>
                            <td colspan="3">
                                <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改', array('class' => 'Btn_1')); ?>
                                <input id='cancel' onclick="window.top.closeDialog();" class="Btn_1 CloseBtn" value="关闭" type="button" />
                            </td>
                        </tr>
                    </table>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
<?php
$timestamp = time();
if (!isset($picurl_dish) || $picurl_dish == '')
{
    $picurl_dish = $this->get_static_url() . 'mobile/img/dish_default.png';
}
else
{
    $picurl_dish = $this->get_static_url() . $picurl_dish;
}
?>
            $(function() {
                jqValidation();
                $('#qqfile').uploadify({
                    'height': 120,
                    'width': 120,
                    'swf': '/uploadify/uploadify.swf',
                    'uploader': '/dish/upload/',
                    'buttonImage': '<?php echo $picurl_dish; ?>',
                    'onUploadSuccess': function(file, data, response)
                    {
                        var obj = $.parseJSON(data);
                        $('#dish_img').attr('src', obj.file_path);
                        $('#newPicName').attr('value', obj.name);
                        $('#qqfile-button').css('backgroundImage', 'url(' + obj.file_path + ')');
                    },
                    'onUploadComplete': function(file) {

                    },
                    'onUploadError': function(file, errorCode, errorMsg, errorString) {
                        alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                    }
                });
            });
            function jqValidation() {
                jQuery.validator.addMethod("mustSeleted", function(value, element) {
                    return (parseFloat(value) > -1);
                }, "mustSeleted");
                $("#dish-form").validate({
                    rules: {
                        "Dish[dish_name]": "required",
                        "Dish[dish_price]": {required: true, number: true},
                        "Dish[dish_package_fee]": {required: true, number: true},
                        "dish_category": {
                            mustSeleted: true
                        },
                        "dish_display_type[]": {required: true, minlength: 1}
                    },
                    messages: {
                        "Dish[dish_name]": "请输入菜品名称",
                        "Dish[dish_price]": {
                            required: "请输入菜品价格",
                            number: "菜品价格请输入小数"},
                        "Dish[dish_package_fee]": {
                            required: "请输入打包费",
                            number: "打包费请输入小数"},
                        "dish_category": "请选择类型",
                        "dish_display_type[]": {required: "请选择菜品显示类别", minlength: "至少选择一项"}
                    },
                    errorPlacement: function(error, element) {
                        if ($(element).is(":radio") || $(element).is(":checkbox")) {
                            $(element).parent().parent().append(error);
                        } else
                            $(element).after(error);
                    }
                });
            }

            var dish_type_ele = document.getElementById("selected_dish_type");
            var btn_dish_type = document.getElementById("btn_dish_type");
            $("#btn_dish_type").click(function(e) {
                $("#id_select_dishtype").show();
            });
            $("#id_select_dishtype").mouseleave(function(e) {
                $("#id_select_dishtype").hide();
            });

            function cb_click(e)
            {
                if (e.checked)
                {
                    if (btn_dish_type.value == "选择/修改")
                    {
                        btn_dish_type.value = e.nextElementSibling.innerHTML + "；";
                        dish_type_ele.value = e.dataset.id + ",";
                    }
                    else
                    {
                        btn_dish_type.value = btn_dish_type.value + e.nextElementSibling.innerHTML + "；";
                        dish_type_ele.value = dish_type_ele.value + e.dataset.id + ",";
                    }
                }
                else
                {
                    btn_dish_type.value = btn_dish_type.value.replace(e.nextElementSibling.innerHTML + "；", "");
                    dish_type_ele.value = dish_type_ele.value.replace(e.dataset.id + ",", "");
                    if (dish_type_ele.value == "")
                    {
                        btn_dish_type.value = "选择/修改";
                    }
                }
            }
        </script>
    </body>
</html>

