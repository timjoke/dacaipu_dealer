<tr>
    <td>
        <?php echo CHtml::encode($data['modifierName']); ?>
    </td>
    <td>
        <?php echo CHtml::encode($data['memo']); ?>
    </td>
    <td align="center">
        <?php echo CHtml::encode($data['create_time']); ?>
    </td>
    <td align="center">
        <?php echo CHtml::encode(busOrder::$ORDER_STATUS_NAME[$data['cur_order_status']]); ?>
    </td>
</tr>