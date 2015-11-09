<?php
Yii::app()->clientScript->registerScript(
        'jqmodel' . $data['order_id'], '$(\'#processed_order_' . $data['order_id'] . '\').click(function(){
    openDialogAuto("'.Yii::app()->request->hostInfo.'/OrderWaitProcess/Processed_order/id/'. $data['order_id'].'","auto","auto","订单详情");
}); return false;');
?>

<div class="BlockArea_1" id="processed_order_<?php echo $data['order_id']; ?>"
     style="bottom:<?php echo $index * 102 ?>px;">
    <div class="Bg_1">
        <h4>总金额<span class="sp_money">￥</span><?php echo CHtml::encode($data['order_paid']); ?>元
            &nbsp;共<?php echo CHtml::encode($data['dish_count']); ?>个菜</h4>
        <h5>送餐地址：<?php echo CHtml::encode($data['contact_addr']); ?></h5>
    </div>
</div>