<tr height="30" bgcolor="#FFFFFF">
    <td>
        <input type="checkbox" name="cb_discount" value="<?php echo $data->ar_id ?>" />
    </td>
    <td>
        <?php
        echo
//        CHtml::encode($data->ar_entity_id);
        CHtml::encode(DiscountPlanController::showEntity($data->ar_entity_id, $data->ar_type));
        ?>
    </td>
    <td><?php echo CHtml::encode(DiscountPlanController::showDiscountName($data->discount_id)); ?></td>
    <td>
        <p>
            <i class="ico-start">始</i>
            <?php echo CHtml::encode(busUlitity::formatDate($data->ar_start_time)); ?>
        </p>
        <p>
            <i class="ico-end">终</i>
            <?php echo CHtml::encode(busUlitity::formatDate($data->ar_end_time)); ?>
        </p>
    </td>
    <td align="center"><?php echo CHtml::encode(BusDiscount::$DISCOUNT_PLAN_STATUS[$data->ar_status]); ?></td>
    <td align="center"><?php echo CHtml::encode(BusDiscount::$DISCOUNT_ORDERS_TYPE[$data->ar_orders_type]); ?></td>
    <td align="center"><?php echo CHtml::encode($data->ar_order); ?></td>
    <td align="center">
        <?php
        if ($data->ar_status == DISCOUNT_PLAN_STATUS_ONLINE)
        {
            echo CHtml::link('下线', '#', array('onclick' => 'return postDelete(this,' . $data->ar_id . ');'));
        } else
        {
            echo CHtml::link('上线', '#', array('onclick' => 'return postCancelDelete(this,' . $data->ar_id . ');'));
        }echo '<br>';
        ?> 
        <a href="#" onclick="openDialogAuto('/discountPlan/update/id/<?php echo $data->ar_id; ?>', 'auto', 'auto', '折扣计划修改');
                return false;" class="PopwinShow">修改</a>
    </td>
</tr>