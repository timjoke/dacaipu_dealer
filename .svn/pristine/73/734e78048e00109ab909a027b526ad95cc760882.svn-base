<tr height="30">
    <td align="center"><?php echo CHtml::encode($data['order_id']); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatOnlyTime($data['reserv_start_time'])); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatOnlyTime($data['reserv_end_time'])); ?></td>
    <td align="center"><?php echo CHtml::encode(busDinnerTable::$TABLE_RESERV_STATUS_NAME[$data['reserv_status']]); ?></td>
    <td align="center"><?php echo CHtml::encode(busUlitity::formatDate($data['reserv_time'])); ?></td>
    <td align="center">
        <?php
        if ($data['reserv_id'] != 0) {
            echo CHtml::link('删除', '#', array('onclick' => 'return postDelete(this,' . $data['reserv_id'] . ');'));
        }
        ?>
    </td>
</tr>