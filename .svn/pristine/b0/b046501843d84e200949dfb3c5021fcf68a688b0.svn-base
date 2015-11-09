<tr height="30" bgcolor="#FFFFFF">
    <td align="center"><?php echo CHtml::encode($data->discount_code); ?></td>
    <td align="center"><?php echo CHtml::encode(busDiscount_code::showdiscountcode_status($data->status)); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatDate($data->used_time)); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatDate($data->discount_create_time)); ?></td>
    <td align="center">
        <?php
        if ($data->status == 0) {
            echo CHtml::link('使用', '#', array('onclick' => 'return postUsed(this,' . $data->discountCode_id . ');'));
        }
        ?>
    </td>
</tr>