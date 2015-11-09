<tr height="30">
    <td align="center"><?php echo CHtml::encode($data['order_id']); ?></td>
    <td align="center"><?php
        echo CHtml::encode(busUlitity::formatDate($data['reserv_start_time']) . '～' .
                busUlitity::formatOnlyTime($data['reserv_end_time']));
        ?></td>

    <td align="center"><?php echo CHtml::encode($data['customer_name']); ?></td>
    <td align="center">
        <a href="#" onclick="openDialogAuto('/ordersHistory/viewTable/id/<?php echo $data['order_id']; ?>', 'auto', 'auto', '营业时间修改'); return false;" class="PopwinShow">查看详情</a>
    </td>
</tr>