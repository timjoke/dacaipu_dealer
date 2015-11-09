<?php Yii::app()->clientScript->registerScript('top_script', '$("#tab_report").addClass("Active");'); ?>
<?php $this->beginContent('/layouts/order_manage_top'); ?>

<div class="LeftArea">
    <ul>
        <li id="li_order_report"><a href="<?php echo Yii::app()->request->hostInfo ?>/report/orderReport" class="Ico_3_1"><span></span><p class="pp01">订单统计</p></a></li>
        <li id="li_frequency_report"><a href="<?php echo Yii::app()->request->hostInfo ?>/report/frequencyReport" class="Ico_3_2"><span></span><p class="pp01">菜品热度</p></a></li>
        <li id="li_my_bill"><a href="<?php echo Yii::app()->request->hostInfo ?>/report/myBill" class="Ico_3_3"><span></span><p class="pp01">我的账单</p></a></li>
        <li id="li_my_history_bill"><a href="<?php echo Yii::app()->request->hostInfo ?>/report/myHistoryBill" class="Ico_3_4"><span></span><p class="pp01">历史账单</p></a></li>
    </ul>
</div>
<div class="menuBar" onclick="menuBarClick();"></div>
<?php echo $content; ?>
<?php $this->endContent(); ?>