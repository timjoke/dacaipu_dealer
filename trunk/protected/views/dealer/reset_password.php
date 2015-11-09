<script src="<?php echo $this->get_static_url(); ?>js/jquery.validate.min.js" type="text/javascript"></script>

<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>修改密码</span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_4">
                <div class="BlockContArea">
                    <div class="scroll-pane" id="Container">
                        <div id="ListConts">
                            <div class="scroll-content Scroller-Container">
                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'dealer-form',
                                    'enableAjaxValidation' => false
                                ));
                                ?>
                                <table cellpadding="5" cellspacing="5" border="0" width="99%" >
                                    <tr height="35">
                                        <td align="right" style="width: 150px;">现在的密码：</td>
                                        <td>
                                            <input class="Input_6" autocomplete="off" name="oldpassword" id="oldpassword" type="password">
                                        </td>
                                    </tr>
                                    <tr height="35">
                                        <td align="right" style="width: 150px;">设置新的密码：</td>
                                        <td>
                                            <input class="Input_6" autocomplete="off" name="newpassword" id="newpassword" type="password">
                                        </td>
                                    </tr>
                                    <tr height="35">
                                        <td align="right" style="width: 150px;">重复新的密码：</td>
                                        <td>
                                            <input class="Input_6" autocomplete="off" name="secnewpassword" id="secnewpassword" type="password">
                                        </td>
                                    </tr>
                                    <tr height="35">
                                        <td></td>
                                        <td>
                                            <?php echo CHtml::submitButton('修改', array('class' => 'Btn_2')); ?>
                                            <span><?php echo $msg; ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <?php $this->endWidget(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        jqValidation();
    });
    function jqValidation() {
        $("#dealer-form").validate({
            rules: {
                "oldpassword": "required",
                "newpassword": {required: true, minlength: 3, maxlength: 10},
                "secnewpassword": {required: true, equalTo: "#secnewpassword"}
            },
            messages: {
                "oldpassword": "请输入现在的密码",
                "newpassword": {required: "请输入新密码", minlength: "新密码长度不能小于5位", maxlength: "新密码长度不能大于10位"},
                "secnewpassword": {required: "请输入重复新的密码", equalTo: "两次密码输入不一致"}
            }
        });
    }
</script>