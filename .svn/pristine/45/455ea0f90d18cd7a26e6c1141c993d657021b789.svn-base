<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>北京爱吆喝信息技术有限公司</title>
        <link type="text/css" rel="stylesheet" href="../../css/style.css"/>
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap/css/bootstrap.css"/>
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    </head>

    <body>
        <div id="all">
            <div class="headarea">
                <div class="head_in">
                    <div class="logoarea">爱吆喝</div>
                    <div class="phone">咨询热线：4006-766-917</div>
                </div>
            </div>
            <div style="margin-top: 30px;border-bottom: 1px solid #aaa"><h1>申请开通大菜谱微信餐厅</h1></div>
            <!--<div class="bannerarea">
                <img src="../../images/banner.jpg" alt="" width="100%" />
                <img src="../../images/bannerzi.png" alt="" width="20.5%" class="banner_in"/>
                <div class="banner_in"></div>
            </div>-->
            <div class="container-fluid" style="border-bottom:1px solid #aaa;">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'apply-join-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                ?>
                <div class="row-fluid">
                    <?php echo $form->errorSummary($model); ?>
                    <div class="well" style="border:0px;">
                        <div class="content_row">
                            <div class="row_left">
                                <p>商家名称</p>		
                            </div>
                            <div class="row_right">
                                <?php echo $form->textField($model, 'dealer_name', array('size' => 60, 'maxlength' => 100)); ?>
                                <?php echo $form->error($model, 'dealer_name'); ?>
                            </div>
                        </div>

                        <div class="content_row">
                            <div class="row_left">
                                <p>商家电话</p>		
                            </div>
                            <div class="row_right">
                                <?php echo $form->textField($model, 'dealer_tel', array('size' => 60, 'maxlength' => 100)); ?>
                                <?php echo $form->error($model, 'dealer_tel'); ?>
                            </div>
                        </div>

                        <div class="content_row">
                            <div class="row_left">
                                <p>商家地址</p>		
                            </div>
                            <div class="row_right">
                                <?php echo $form->textField($model, 'dealer_add', array('size' => 60, 'maxlength' => 200)); ?>
                                <?php echo $form->error($model, 'dealer_add'); ?>
                            </div>
                        </div>

                        <div class="content_row">
                            <div class="row_left">
                                <p>联系人</p>		
                            </div>
                            <div class="row_right">
                                <?php echo $form->textField($model, 'contact_name', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($model, 'contact_name'); ?>
                            </div>
                        </div>

                        <div class="content_row">
                            <div class="row_left">
                                <p>联系人电话</p>		
                            </div>
                            <div class="row_right">
                                <?php echo $form->textField($model, 'contact_tel', array('size' => 20, 'maxlength' => 20)); ?>
                                <?php echo $form->error($model, 'contact_tel'); ?>
                            </div>
                        </div>

                        <div class="content_row">
                            <div class="row_left">
                                <p>身份证附件</p>		
                            </div>
                            <div class="row_right">
                                <?php echo CHtml::activeFileField($model, 'id_image_file_url'); ?>
                                <?php echo $form->error($model, 'id_image_file_url'); ?>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary" style="margin-left: 700px;">
                                <i class="icon-save"></i> 确定
                            </button>
                        </div>

                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div><!-- form -->
            <div class="footarea">
                <div class="foot_in">
                    北京爱吆喝信息技术有限公司，联系电话：4006-766-917
                </div>
            </div>
        </div>
</html>