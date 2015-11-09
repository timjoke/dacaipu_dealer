
<tr height="30" bgcolor="#FFFFFF">
    <td align="center"><?php echo CHtml::encode($data->coupon_no); ?></td>
    <td align="center">￥<?php echo CHtml::encode(busUlitity::formatMoney($data->coupon_value)); ?></td>
    <td align="center"><?php echo CHtml::encode(BusCoupon::show_coupon_status($data->coupon_status)); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatDate($data->coupon_start_time)); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatDate($data->coupon_end_time)); ?></td>
    <td align="center">
        <a href="#" onclick="openDialogAuto('/ordersHistory/view/id/<?php echo $data['order_id'] ?>', 'auto', 'auto', '订单详情');return false;"  ><?php echo $data['order_id'] ?>
        </a>
    </td>
</tr>
