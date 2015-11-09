<tr height="30" bgcolor="#FFFFFF">
    <td align="center"><?php echo CHtml::encode($data->table_name); ?></td>
    <td align="center"><?php echo CHtml::encode(busDinnerTable::$DINNERTABLE_STATUS_NAME[$data->table_status]); ?></td>
    <td align="center"><?php echo CHtml::encode($data->table_sit_count); ?></td>
<!--    <td align="center"><?php echo CHtml::encode($data->table_service_price); ?></td>-->
    <td align="center"><?php echo CHtml::encode(busDinnerTable::$DINNERTABLE_ISROOM_NAME[$data->table_is_room]); ?></td>
<!--    <td align="center"><?php echo CHtml::encode($data->table_lower_case); ?></td>-->
    <td align="center"><?php echo CHtml::encode(busDinnerTable::$DINNERTABLE_ISSMOKE_NAME[$data->table_is_smoke]); ?></td>
    <td align="center">
        <?php
        if ($data->table_status != -1) {
            echo CHtml::link('删除', '#', array('onclick' => 'return postDelete(this,' . $data->table_id . ');'));
        }
        ?> 
        <a href="#" onclick="openDialogAuto('/dinnerTable/update/id/<?php echo $data->table_id; ?>', 'auto', 'auto', '桌台修改'); return false;" class="PopwinShow">修改</a>
    </td>
</tr>