<tr height="50">
    <td align="center">
        <?php if ($data['order_type'] == ORDER_TYPE_TAKEOUT || $data['order_type'] == ORDER_TYPE_TAKEOUT_SELFTAKE)
        { ?>
            <a href="#" onclick="openDialogAuto('/ordersHistory/view/id/<?php echo $data['order_id'] ?>', 'auto', 'auto', '订单详情');
                        return false;"  ><?php echo $data['order_id'] ?></a>
           <?php } ?>
           <?php if ($data['order_type'] == ORDER_TYPE_SUB_TABLE || $data['order_type'] == ORDER_TYPE_SUB_TALE_DISH)
           { ?>
            <a href="#" onclick="openDialogAuto('/ordersHistory/viewTable/id/<?php echo $data['order_id'] ?>', 'auto', 'auto', '订单详情');
                        return false;"  ><?php echo $data['order_id'] ?></a>
           <?php } ?>
           <?php if ($data['order_type'] == ORDER_TYPE_EATIN)
           { ?>
            <a href="#" onclick="openDialogAuto('/ordersHistory/viewHall/id/<?php echo $data['order_id'] ?>', 'auto', 'auto', '订单详情');
                        return false;"  ><?php echo $data['order_id'] ?></a>
        <?php } ?>
    </td>
    <td align="left">
        <?php
        if (isset($data['dishpicurllist']))
        {
            $picurllist = explode(',', $data['dishpicurllist']);
            $disharr = array();
            for ($j = 0; $j < count($picurllist); $j++)
            {
                $picinfoarr = array();
                $picinfoarr = explode('|', $picurllist[$j]);
                $dish_count = $picinfoarr[0];
                $dish_name = $picinfoarr[1];
                $disharr[$j] = $dish_name . 'x' . $dish_count;
            }
            $dishstr = join('<br />', $disharr);
            echo $dishstr;
        }
        ?>
    <td><?php
        echo CHtml::encode($data['contact_name']);
        if ($data['order_type'] != ORDER_TYPE_TAKEOUT_SELFTAKE)
        {
            echo '<br />' . CHtml::encode($data['contact_addr']);
        }
        ?>
    </td>
    <td align="center"><?php echo CHtml::encode($data['dish_count']); ?></td>
    <td align="center"><span class="sp_money">￥</span><?php echo CHtml::encode(busUlitity::formatMoney($data['order_paid'])); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatDate($data['order_createtime'])); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatDate($data['order_dinnertime'])); ?></td>
    <td align="center"><?php echo CHtml::encode(busOrder::$ORDER_STATUS_NAME[$data['order_status']]); ?></td>
    <td align="center"><?php echo CHtml::encode($data['coupon_no']); ?></td>
</tr>