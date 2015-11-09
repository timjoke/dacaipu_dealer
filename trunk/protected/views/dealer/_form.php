
<script src="<?php echo $this->get_static_url(); ?>js/jquery.validate.min.js" type="text/javascript"></script>
<script src="/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
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
</style>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>餐厅信息</span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_4">
                <div class="BlockContArea" style="border: 0px;">
                    <div class="scroll-content Scroller-Container">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'dealer-form',
                            'enableAjaxValidation' => false,
                            'action' => array('/dealer/update/areaid/updatedealer'),
                            'htmlOptions' => array('enctype' => 'multipart/form-data')
                        ));
                        ?>
                        <fieldset>
                            <legend>商家基本信息</legend>
                            <table cellpadding="5" cellspacing="5" border="0" width="99%" >
                                <tr height="35">
                                    <td align="right" style="width: 150px;">所在城市：</td>
                                    <td colspan="3">
                                        <?php
                                        //$city = City::model()->findByPk($model->city_code);
                                        $cityFull = City::model()->getFullName($model->city_code);
                                        echo $cityFull
                                        ?>
                                        <?php echo $form->error($model, 'city_code'); ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td align="right" style="width:100px;">商家logo：</td>
                                    <td colspan="3" class="PicLoadArea">
                                        <?php echo CHtml::hiddenField('dealerLogo_PicName', $picurl_logo) ?>
                                        <h6>
                                            <input id="dealerLogo" name="dealerLogo" type="file" multiple="false">
                                        </h6>
                                    </td>

                                </tr>                               
                                <tr height="35">
                                    <td align="right">商家名称：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_name', array('size' => 30, 'maxlength' => 50, 'class' => 'Input_5')); ?>
                                        <?php echo $form->error($model, 'dealer_name'); ?>
                                    </td>
                                    <td align="right">地址：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_addr', array('size' => 30, 'maxlength' => 100, 'class' => 'Input_5')); ?> 
                                        <?php echo $form->error($model, 'dealer_addr'); ?>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right">商家邮编 ：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_postcode', array('size' => 10, 'maxlength' => 10, 'class' => 'Input_5')); ?> 
                                        <?php echo $form->error($model, 'dealer_postcode'); ?>
                                    </td>
                                    <td align="right">简介：</td>
                                    <td>
                                        <?php echo $form->textField($model, 'dealer_introduction', array('size' => 30, 'maxlength' => 4000, 'class' => 'Input_5')); ?>
                                        <?php echo $form->error($model, 'dealer_introduction'); ?>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right">纬度 ：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_lat', array('size' => 11, 'maxlength' => 11, 'class' => 'Input_5')); ?>
                                        <?php echo $form->error($model, 'dealer_lat'); ?> 
                                    </td>

                                    <td align="right">经度：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_lon', array('size' => 11, 'maxlength' => 11, 'class' => 'Input_5')); ?>
                                        <?php echo $form->error($model, 'dealer_lon'); ?>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right">电话 ：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_tel', array('size' => 25, 'maxlength' => 25, 'class' => 'Input_5')); ?> 
                                        <?php echo $form->error($model, 'dealer_tel'); ?>
                                    </td>
                                    <td align="right">状态：</td>
                                    <td >
                                        <?php $statuslist = array(1 => "营业中", 0 => "已下线", 2 => "暂停营业"); ?>
                                        <?php echo $form->radioButtonList($model, 'dealer_status', $statuslist, array('separator' => ' ')); ?>
                                        <?php echo $form->error($model, 'dealer_status'); ?>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right">人均消费(元)：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_percap', array('size' => 20, 'maxlength' => 20, 'class' => 'Input_5')); ?>
                                        <?php echo $form->error($model, 'dealer_percap'); ?>
                                    </td>
                                    <td align="right">停车费：</td>
                                    <td >
                                        <?php $is_free_parklist = array(1 => '免费', 0 => '付费'); ?>
                                        <?php echo $form->radioButtonList($model, 'is_free_park', $is_free_parklist, array('separator' => ' ')) ?>
                                        <?php echo $form->error($model, 'is_free_park'); ?>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right">商家类型：</td>
                                    <td >
                                        <?php
                                        if ($model->dealer_type == 1)
                                        {
                                            echo CHtml::encode('集团客户');
                                        } elseif ($model->dealer_type == 2)
                                        {
                                            echo CHtml::encode('门店客户');
                                        }
                                        ?>
                                        <?php echo $form->error($model, 'dealer_type'); ?>
                                    </td>
                                    <td align="right">友好链接：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_link_word', array('size' => 20, 'maxlength' => 50, 'class' => 'Input_5')); ?>
                                        <?php echo $form->error($model, 'dealer_link_word'); ?>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right">自定义域名：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_domain', array('class' => 'Input_5')); ?>
                                        <?php echo $form->error($model, 'dealer_domain'); ?>
                                    </td>
                                    <td align="right">配送费：</td>
                                    <td >
                                        <?php echo $form->textField($model, 'dealer_express_fee', array('size' => 20, 'maxlength' => 20, 'class' => 'Input_5')); ?>
                                        <?php echo $form->error($model, 'dealer_express_fee'); ?>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right">创建时间：</td>
                                    <td colspan="3" >
                                        <?php echo CHtml::encode(date('Y年m月d日 H:i', strtotime($model->dealer_create_date))); ?>
                                        <?php echo $form->error($model, 'dealer_create_date'); ?>
                                    </td>

                                </tr>
                                <tr height="35">
                                    <td></td>
                                    <td></td>
                                    <td align="right" colspan="2"><?php echo CHtml::submitButton('保存', array('class' => 'Btn_2')); ?></td>

                                </tr>
                            </table>
                        </fieldset>
                        <?php $this->endWidget(); ?>
                    </div>
                    <div class="scroll-content Scroller-Container">
                        <?php
                        $setting_form = $this->beginWidget('CActiveForm', array(
                            'id' => 'setting-form', 'enableAjaxValidation' => false,
                            'action' => array('/dealer/update/areaid/takeoutparam')
                        ));
                        ?>
                        <fieldset>
                            <legend>商家参数设置</legend>
                            <table cellpadding="5" cellspacing="5" border="0" width="99%" >
                                <tr height="35">
                                    <td align="right" style="width: 150px;">微信用户关注：</td>
                                    <td>
                                        <?php
                                        echo CHtml::radioButtonList('setting_key_weixin_subscribe', $weixin_subscribe, busDealer::$WEIXIN_SUBSCRIBE_NAME, array('separator' => ' '));
                                        ?>
                                    </td>
                                    <td align = "right" >商家起送最低间隔(分钟)：</td>
                                    <td>
                                        <?php
                                        echo CHtml::dropDownList('setting_key_dealer_takeout_min_timespan', $dealer_takeout, busDealer::$DEALER_TAKEOUT_MIN_TIMESPAN);
                                        ?>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right" style="width: 150px;">自动接单：</td>
                                    <td>
                                        <?php
                                        echo CHtml::radioButtonList('auto_accept_order', $auto_accept_order, busDealer::$AUTO_ACCEPT_ORDER, array('separator' => ' '));
                                        ?>
                                    </td>
                                    <td align="right"></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr height="35">
                                    <td align="right">接受订单提醒短信：</td>
                                    <td>
                                        <?php
                                        echo CHtml::radioButtonList('send_message_accepted_order', $send_message_accepted_order, busDealer::$SEND_MESSAGE_ACCEPTED_ORDER, array('separator' => ' '));
                                        ?>
                                    </td>
                                    <td align="right" style="width: 150px;">短信接收号码：</td>
                                    <td>
                                        <?php
                                        echo
                                        CHtml::textField('contactTel', $contactTel, array('size' => 20, 'maxlength' => 50, 'class' => 'Input_5'));
                                        ?></td>
                                </tr>
                                <tr height="35">
                                    <td align="right">是否外送：</td>
                                    <td>
                                        <?php
                                        echo CHtml::radioButtonList('delivery', $delivery, busDealer::$NO_DELEVERY, array('separator' => ' '));
                                        ?>
                                    </td>
                                    <td align="right">菜品是否显示图片：</td>
                                    <td>
                                        <?php
                                        echo CHtml::radioButtonList('dish_image_display', $dish_image_display, busDealer::$DISH_IMAGE_HIDDEN, array('separator' => ' '));
                                        ?>
                                    </td>
                                </tr>
                                <tr height = "35">
                                    <td></td>
                                    <td></td>
                                    <td align = "right" colspan = "2">
                                        <?php echo CHtml::submitButton('保存', array('class' => 'Btn_2', 'onclick' => 'return validation_setting();'));
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <?php $this->endWidget(); ?>
                    </div>
                    <div class="scroll-content Scroller-Container">
                        <?php
                        $pictures_form = $this->beginWidget('CActiveForm', array(
                            'id' => 'pictures-form', 'enableAjaxValidation' => false,
                            'action' => array('/dealer/update/areaid/pictures')
                        ));
                        ?>
                        <fieldset>
                            <legend>banner图片设置</legend>
                            <table cellpadding="5" cellspacing="5" border="0" width="99%" >
                                <tr>
                                    <td align="right" style="width:100px;">banner：</td>
                                    <td class="PicLoadArea">
                                        <?php echo CHtml::hiddenField('banner_PicName', $picurl_banner) ?>
                                        <h6>
                                            <input id="banner" name="banner" type="file" multiple="false">
                                        </h6>
                                        <span>上传图片尺寸请符合640*258</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="width:100px;">微信banner：</td>
                                    <td colspan="3" class="PicLoadArea">
                                        <?php echo CHtml::hiddenField('weixinbanner_PicName', $picurl_wxbanner) ?>
                                        <h6>
                                            <input id="weixin_banner" name="weixin_banner" type="file" multiple="false">
                                        </h6>
                                        <span>上传图片尺寸请符合360*200</span>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <?php $this->endWidget(); ?>
                    </div>
                    <div class="scroll-content Scroller-Container">
                        <?php
                        $funindex_form = $this->beginWidget('CActiveForm', array(
                            'id' => 'funindex-form', 'enableAjaxValidation' => false,
                            'action' => array('/dealer/update/areaid/funindex')
                        ));
                        ?>
                        <fieldset>
                            <legend>手机端功能设置</legend>
                            <table cellpadding="5" cellspacing="5" border="0" width="99%" >
                                <tr>
                                    <td style="width: 20%"></td>
                                    <td style="width: 30%"></td>
                                    <td style="width: 20%"></td>
                                    <td style="width: 30%"></td>
                                </tr>
                                <tr height="35">
                                    <td align="right">手机端功能：</td>
                                    <td colspan="3"><?php echo CHtml::checkBoxList('dealer_funlist', $dealer_funlist, busDealer::get_all_function_name(), array('separator' => ' '));
                        ?></td>
                                </tr>
                                <tr height="35">
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">
                                        <?php echo CHtml::submitButton('保存', array('class' => 'Btn_2')); ?>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
<?php
$timestamp = time();
?>
    function validation_setting() {
        var $contactTel = $('#contactTel');
        var telnum = $contactTel.val();
        var ischeck_telnum = $("#send_message_accepted_order_1").is(':checked');
        if (ischeck_telnum == true) {//验证手机号
            if (!(/^1[0-9]\d{2,10}$/.test(telnum))) {
                $contactTel.focus();
                alert('电话请输入有效的手机号码');
                return false;
            }
            return true;
        } else {//不验证手机号
            return true;
        }
    }
    $(function() {
        jqValidation();
        $('#dealerLogo').uploadify({
            'height': 120,
            'width': 120,
            'swf': '/uploadify/uploadify.swf',
            'uploader': '/dealer/upload_logo/',
            'buttonImage': '<?php echo $this->get_static_url() . $picurl_logo; ?>',
            'onUploadSuccess': function(file, data, response)
            {
                var obj = $.parseJSON(data);
//                $('#dish_img').attr('src', obj.file_path);
                $('#dealerLogo_PicName').attr('value', obj.name);
                $('#dealerLogo-button').css('backgroundImage', 'url(' + obj.file_path + ')');
            },
            'onUploadError': function(file, errorCode, errorMsg, errorString) {
                alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            }
        });
        $('#banner').uploadify({
            'height': 129,
            'width': 320,
            'swf': '/uploadify/uploadify.swf',
            'uploader': '/dealer/upload_banner/',
            'buttonImage': '<?php echo $this->get_static_url() . $picurl_banner; ?>',
            'onUploadSuccess': function(file, data, response)
            {
                var obj = $.parseJSON(data);
//                $('#dish_img').attr('src', obj.file_path);
                $('#banner_PicName').attr('value', obj.name);
                $('#banner-button').css('backgroundImage', 'url(' + obj.file_path + ')');
            },
            'onUploadError': function(file, errorCode, errorMsg, errorString) {
                alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            }
        });
        $('#weixin_banner').uploadify({
            'height': 100,
            'width': 180,
            'swf': '/uploadify/uploadify.swf',
            'uploader': '/dealer/upload_weixin_banner/',
            'buttonImage': '<?php echo $this->get_static_url() . $picurl_wxbanner; ?>',
            'onUploadSuccess': function(file, data, response)
            {
                var obj = $.parseJSON(data);
                $('#weixinbanner_PicName').attr('value', obj.name);
                $('#weixin_banner-button').css('backgroundImage', 'url(' + obj.file_path + ')');
            },
            'onUploadError': function(file, errorCode, errorMsg, errorString) {
                alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            }
        });
    });
    function jqValidation() {
        $("#dealer-form").validate({
            rules: {
                "Dealer[dealer_name]": "required",
                "Dealer[dealer_addr]": "required",
                "Dealer[dealer_postcode]": {required: true, digits: true, maxlength: 6, minlength: 6},
                "Dealer[dealer_lat]": {number: true},
                "Dealer[dealer_lon]": {number: true},
                "Dealer[dealer_tel]": "required",
                "Dealer[dealer_percap]": {required: true, number: true},
                "Dealer[dealer_express_fee]": {required: true, number: true},
            },
            messages: {
                "Dealer[dealer_name]": "请输入商家名称",
                "Dealer[dealer_addr]": "请输入地址",
                "Dealer[dealer_postcode]": {
                    required: "请输入邮编",
                    digits: "请输入6位整数",
                    maxlength: "请输入6位整数",
                    minlength: "请输入6位整数",
                },
                "Dealer[dealer_lat]": "经度请输入小数",
                "Dealer[dealer_lon]": "纬度请输入小数",
                "Dealer[dealer_tel]": "请输入电话",
                "Dealer[dealer_percap]": {required: "请输入人均消费", number: "人均消费请输入小数"},
                "Dealer[dealer_express_fee]": {required: "请输入配送费", number: "配送费请输入小数"},
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