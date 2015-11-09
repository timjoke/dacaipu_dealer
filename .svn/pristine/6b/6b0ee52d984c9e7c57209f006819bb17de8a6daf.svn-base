<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<?php
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/InformationCss.css');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
?>
<div class="PopWinArea" style="overflow-x: hidden;">
    <div class="ContArea">
        <div class="MidArea" align="center">
            <h4>订单信息&nbsp;
                <a href='#' onclick="return printOrder(<?php echo $model->order_id; ?>);" >
                    <img src="<?php echo $this->get_static_url() . 'pc/images/icon_printer-alt.png'; ?>" width="16px" height="16px" border='0' alt='打印' title='打印'/>
                </a>
            </h4>
            <table cellpadding="5" cellspacing="5" border="0" align="left" class="Table_1" >
                <tr height="35">
                    <td align="right">订单号:</td>
                    <td><?php echo $model->order_id; ?></td>
                    <td align="right">下单时间:</td>
                    <td><?php echo busUlitity::formatDate($model->order_createtime); ?></td>
                    <td align="right">用餐时间:</td>
                    <td><?php echo busUlitity::formatDate($model->order_dinnertime); ?></td>
                </tr>
                <tr height="35">
                    <td align="right">应收金额:</td>
                    <td><span class="sp_money">￥</span><?php echo busUlitity::formatMoney($model->order_paid); ?></td>
                    <td align="right">订单类型:</td>
                    <td><?php echo CHtml::encode(busOrder::$ORDER_TYPE_NAME[$model->order_type]); ?></td>
                    <td align="right">就餐人数:</td>
                    <td><?php echo CHtml::encode($model->order_person_count); ?></td>
                </tr>
                <tr height="35">
                    <td align="right">订单状态:</td>
                    <td><?php echo CHtml::encode(busOrder::$ORDER_STATUS_NAME [$model->order_status]); ?></td>
                    <td align="right">付款方式:</td>
                    <td><?php echo CHtml::encode(busOrder::$ORDER_PAY_TYPE_NAME[$model->order_pay_type]); ?></td>
                    <td align="right">用户备注:</td>
                    <td><?php echo $user_remark; ?></td>
                </tr>
                <?php
                if ($model->order_status == ORDER_STATUS_DENIED)
                {
                    ?>
                    <tr height="35">
                        <td align="right">商家备注:</td>
                        <td colspan="5"><?php echo $rejectMemo; ?></td>
                    </tr>
                <?php } ?>
            </table>

            <div class="clear"></div>
            <h4>联系人信息</h4>
            <table cellpadding="5" cellspacing="5" border="0" align="left" class="Table_1" >
                <tr height="35">
                    <td align="right">联系人姓名:</td>
                    <td><?php echo $contactmodel->contact_name; ?></td>
                    <td align="right">联系电话:</td>
                    <td><?php echo $contactmodel->contact_tel; ?></td>
                </tr>
                <?php
                if ($model->order_type == ORDER_TYPE_TAKEOUT)
                {
                    ?>
                    <tr height="35">
                        <td align="right">地址:</td>
                        <td colspan="3"><?php echo $contactmodel->contact_addr; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <div class="clear"></div>
            <h4>菜品列表</h4>
            <table cellpadding="5" cellspacing="0" border="0" align="center" class="Table_2" width="650">
                <tr height="25" align="center">
                    <th></th>
                    <th>菜品名称</th>
                    <th>菜品单价</th>
                    <th>数量</th>
                    <th></th>
                </tr>

                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $order_dish_flash_list,
                    'itemView' => '../orders/_view_order_dish_flash_takeout',
                    'enablePagination' => false,
                    'enableSorting' => false,
                    'summaryText' => '',));
                ?>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $discount_list,
                    'itemView' => '../orders/_view_discount',
                    'emptyText' => '',
                    'enablePagination' => false,
                    'enableSorting' => false,
                    'summaryText' => '',));
                ?>
                <?php
                if ($model->order_type == ORDER_TYPE_TAKEOUT)
                {
                    ?>
                    <tr height="25" align="center">
                        <td></td>
                        <td align="left">配送费</td>
                        <td><span class="sp_money">￥</span><?php echo busUlitity::formatMoney($dealer_express_fee); ?></td>
                        <td></td>
                        <td>+<span class="sp_money">￥</span><?php echo busUlitity::formatMoney($dealer_express_fee); ?></td>
                    </tr>
                <?php } ?>
                <?php
                if ($coupon_value != 0)
                {
                    ?>
                    <tr height="25" align="center">
                        <td></td>
                        <td align="left">打折码金额:</td>
                        <td><span class="sp_money">￥</span><?php echo $coupon_value; ?></td>
                        <td></td>
                        <td>-<span class="sp_money">￥</span><?php echo $coupon_value; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <table cellpadding="5" cellspacing="0" border="0" align="center" width="650">
                <tr height="25" width='100' align="right">
                    <td>总计:</td>
                    <td width='80'><span class="sp_money">￥</span><?php echo busUlitity::formatMoney($model->order_paid); ?></td>
                </tr>
            </table>

        </div>
    </div>
</div>
        </body>
</html>