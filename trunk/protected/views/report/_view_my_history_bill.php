<tr height="30" bgcolor="#FFFFFF">
    <td align="center"><?php echo CHtml::encode($data['begin_date']); ?></td>
    <td align="center"><?php echo CHtml::encode($data['end_date']); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatMoney($data['takeout_paid'])); ?></td>
    <td align="center"><?php echo CHtml::encode($data['table_count']); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatMoney($data['fee'])); ?></td>
    <td align="center">
        <a href="myBillMonth/dealer_bill_id/<?php echo $data['dealer_bill_id']; ?>" >查看明细</a>
    </td>
</tr>