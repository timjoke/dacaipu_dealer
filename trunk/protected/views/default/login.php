<?php
Yii::app()->clientScript->registerCssFile($this->get_static_url() . "pc/css/log.css");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
            <title>大菜谱-餐厅登录</title>
            <script type="text/javascript">
                if (window.top.location.toString() != window.location.toString()) {
                    window.top.location.href = window.location.toString();
                }
            </script>
    </head>
    <body>
        <div class="maxdiv">
            <div >
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="login">
                    <div class="lg_cont">
                        <p><b><?php echo $form->labelEx($model, 'username'); ?></b>
                            <?php echo $form->textField($model, 'username', array('class' => 'lg_text', 'autocomplete' => "off")) ?>
                            <?php echo $form->error($model, 'username'); ?>
                        </p>
                        <p><b>  <?php echo $form->labelEx($model, 'password'); ?></b>
                            <?php echo $form->passwordField($model, 'password', array('class' => 'lg_text', 'autocomplete' => "off")); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </p>   
                        <p>
                            <b>
                                <?php echo $form->labelEx($model, 'verifyCode'); ?></b>
                            <?php echo $form->textField($model, 'verifyCode', array('size' => 15, 'maxlength' => 4, 'width' => '30px', 'class' => 'lg_text1')); ?>
                            &nbsp; <!--显示验证码图片/使用小物件显示验证码-->
                            <?php
                            $this->widget('CCaptcha', array('showRefreshButton' => true,
                                'clickableImage' => true,
                                'buttonType' => 'link', 'buttonLabel' => '看不清,换一张',
                                'buttonOptions' => array("class" => "inputBg", 'size' => 14, 'maxlength' => 4,
                                    'style' => 'text-align:center;width:100px;font-size:10px;text-decoration:none;text-decoration:underline;margin-left:10px;border:0px;margin-top:10px;font-family:arial,"微软雅黑","黑体","宋体";'),
                                'imageOptions' => array('alt' => '点击获取', 'title' => '点击获取', 'style' => 'cursor:pointer')
                            ));
                            ?>
                            <?php echo $form->error($model, 'verifyCode'); ?>
                        </p>
                        <p>
                            <?php echo $form->checkBox($model, 'rememberMe'); ?>
                            <?php echo $form->label($model, 'rememberMe', array('style' => 'font-size:15px;')); ?>
                            <?php echo $form->error($model, 'rememberMe'); ?>
                        </p>
                        <div class='btn'>
                            <?php echo CHtml::submitButton('Login', array('class' => 'lg_btn', 'value' => '')); ?>
                        </div>
                        <?php $this->endWidget(); ?>	
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>




