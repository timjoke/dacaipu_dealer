<?php Yii::app()->clientScript->registerScript('top_script', '$("#tab_dealer").addClass("Active");'); ?>
<?php $this->beginContent('/layouts/order_manage_top'); ?>
<div class="LeftArea">
    <ul>
        <li id="li_dishCategory"><a href="<?php echo Yii::app()->request->hostInfo ?>/dishCategory/" class="Ico_2_1"><span></span><p class="pp01">菜品类别</p></a></li>
        <li id="li_dish" ><a href="<?php echo Yii::app()->request->hostInfo ?>/dish/" class="Ico_2_2"><span></span><p class="pp01">查看菜品</p></a></li>
        <li id="li_dish" ><a href="<?php echo Yii::app()->request->hostInfo ?>/dish/dishPackage" class="Ico_2_2"><span></span><p class="pp01">查看套餐</p></a></li>
        <li id="li_dealerServiceTime"><a href="<?php echo Yii::app()->request->hostInfo ?>/dealerServiceTime/" class="Ico_2_3"><span></span><p class="pp01">营业时间</p></a></li>
        <li id="li_discountPlan"><a href="<?php echo Yii::app()->request->hostInfo ?>/discountPlan/" class="Ico_2_4"><span></span><p class="pp01">折扣计划</p></a></li>
        <li id="li_discount"><a href="<?php echo Yii::app()->request->hostInfo ?>/discount/" class="Ico_2_5"><span></span><p class="pp01">折扣模板</p></a></li>
        <li id="li_dinnerTable"><a href="<?php echo Yii::app()->request->hostInfo ?>/dinnerTable/" class="Ico_2_6"><span></span><p class="pp01">桌台信息</p></a></li>
        <li id="li_tableOrderTimePoint"><a href="<?php echo Yii::app()->request->hostInfo ?>/tableOrderTimePoint/" class="Ico_2_7"><span></span><p class="pp01">桌台时间</p></a></li>
        <li id="li_news"><a href="<?php echo Yii::app()->request->hostInfo ?>/news/" class="Ico_2_8"><span></span><p class="pp01">查看资讯</p></a></li> 
<!--        <li id="li_discountCode"><a href="<?php echo Yii::app()->request->hostInfo ?>/discountCode/" class="Ico_2_9"><span></span><p class="pp01">打折码</p></a></li>-->
        <li id="li_coupon"><a href="<?php echo Yii::app()->request->hostInfo ?>/coupon/" class="Ico_2_9"><span></span><p class="pp01">优惠券</p></a></li>
      <!--   <li id="li_dealerWechatReply"><a href="<?php echo Yii::app()->request->hostInfo ?>/dealerWechatReply/" class="Ico_2_8"><span></span><p class="pp01">微信自动回复</p></a></li> -->
    </ul>
</div>
<div class="menuBar" onclick="menuBarClick();"></div>
<?php echo $content; ?>
<!--<script type="text/javascript" src="<?php echo $this->get_static_url() ?>js/InformationJs.js"></script>-->
<?php $this->endContent(); ?>