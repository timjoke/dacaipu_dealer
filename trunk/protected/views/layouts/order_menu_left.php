<?php Yii::app()->clientScript->registerScript('top_script', '$("#tab_order").addClass("Active");'); ?>
<?php $this->beginContent('/layouts/order_manage_top'); ?>

<div class="LeftArea">
    <ul>
        <li id="li_order_today"><a href="<?php echo Yii::app()->request->hostInfo ?>/orders/" class="Ico_1_1"><span></span><p class="pp01">今日订单</p></a></li>
        <li id="li_order_history"><a href="<?php echo Yii::app()->request->hostInfo ?>/ordersHistory/" class="Ico_1_2"><span></span><p class="pp01">历史订单</p></a></li>
<!--        <li id="li_month_last"><a href="#" class="Ico_3"><span></span><p class="pp01">上月对帐单</p></a></li>-->
        <li id="li_tableByOrders"><a href="<?php echo Yii::app()->request->hostInfo ?>/tableByOrders/" class="Ico_1_3"><span></span><p class="pp01">桌台订单</p></a></li>
    </ul>
</div>
<div class="menuBar" onclick="menuBarClick();"></div>
<?php echo $content; ?>
<?php $this->endContent(); ?>