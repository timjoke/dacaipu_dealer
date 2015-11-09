<tr height="30" bgcolor="#FFFFFF">
    <td><?php echo CHtml::encode($data->discount_name); ?></td>
    <td align="center"><?php echo CHtml::encode(BusDiscount::$DISCOUNT_MODE[$data->discount_mode]); ?></td>
    <td align="center"><?php
//        echo $data->discount_value;
        $busDicount = new BusDiscount();
        echo $busDicount->showDiscountValue($data->discount_mode, $data->discount_value);
        ?> </td>
    <td align="center"><?php echo CHtml::encode(BusDiscount::$DISCOUNTCONDITION[$data->discount_condition]); ?></td>
    <td align="center"><?php echo CHtml::encode($data->discount_compare_value); ?></td>
    <td align="center">
           <?php echo CHtml::link('删除', '#', array('onclick' => 'return postDelete(this,' . $data->discount_id . ');')); ?> 
        <a href="#" onclick="openDialogAuto('/discount/update/id/<?php echo $data->discount_id ?>', 'auto', 'auto', '折扣模板修改');
                return false;" class="PopwinShow">修改</a></td>
</tr>

