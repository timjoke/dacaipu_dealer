<tr height="30" bgcolor="#FFFFFF">
    <td align="center"><?php echo CHtml::encode(substr($data['time_point'], 0, 5)); ?></td>
    <td align="center"><?php echo CHtml::encode(busTableOrderTimePoint::$DINNER_TYPE_NAME[$data['dinner_type']]); ?></td>
    <td align="center">
        <?php
        echo CHtml::link('删除', '#', array('onclick' => 'return postDelete(this,' . $data['table_order_time_point_id'] . ');'));
        ?> 
        <a href="#" onclick="openDialogAuto('/tableOrderTimePoint/update/id/<?php echo $data['table_order_time_point_id']; ?>', 'auto', 'auto', '桌台时间修改'); return false;" class="PopwinShow">修改</a>
    </td>
</tr>