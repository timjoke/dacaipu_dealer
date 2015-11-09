<tr>
    <td >
        <?php echo CHtml::encode($data['dish_name'] .($data['is_presell']=='1'?'(预定)':'') .' x ' . $data['order_count']); ?>
    </td>
    <td style="text-align:right;">
        +￥<?php echo busUlitity::formatMoney(($data['dish_price'] + $data['dish_package_fee']) * $data['order_count']); ?>元
    </td>
</tr>


