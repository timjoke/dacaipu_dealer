<?php /* @var $this Controller */ 
    $dealer_id = Yii::app()->request->getParam('id',0);
    $logo_url = '';
    if($dealer_id != 0)
    {
        $logo = Pic::model()->findByAttributes(array('entity_id' => $dealer_id,
                'pic_type' => PIC_TYPE_DEALER_LOGO));
        if(isset($logo))
        {
            $logo_url = $logo->pic_url;
        }
    }
?>
<!DOCTYPE html>
<html  dir="ltr" lang="zh-CN">
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="<?php echo $this->get_static_url();?>js/zepto.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->get_static_url();?>js/common.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->get_static_url() ?>mobile/css/common.css" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="icon" type="image/png" href="./styles/capp/images/favicon-round.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->get_static_url().'72_72/'.$logo_url; ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->get_static_url().'114_114/'.$logo_url; ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $this->get_static_url().'144_144/'.$logo_url; ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $this->get_static_url().'57_57/'.$logo_url; ?>">
    <link rel="apple-touch-icon" href="./styles/capp/images/touch/apple-touch-icon.png">
    <style type="text/css">
        a, input, button {-ms-touch-action: none !important;}
        .main_footer{font-size:12px;width:100%;text-align:center;margin-lef:auto;margin-right:auto;padding-top:10px;line-height: 20px;margin-bottom:10px;}
        .main_footer hr{width:90%;margin-left:auto;margin-right:auto;border-style: solid none none;border-width:1px 0 0;margin-top: 20px;margin-bottom: 20px;border-top-color: #EEEEEE;}
    </style>
</head>
<body>
    <!-- <?php echo CHtml::encode(Yii::app()->name); ?> -->
        <?php echo $content;?>
    <div class="main_footer">
        &copy;  <?php echo date('Y');?>  该平台由北京爱吆喝信息技术有限公司提供
        <br/>
        京ICP备14010321号
    </div>
</body>
</html>
