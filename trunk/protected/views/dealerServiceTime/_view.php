<tr height="30" bgcolor="#FFFFFF">
    <td align="center"><?php echo CHtml::encode(substr($data->st_start_time, 0, 5)); ?></td>
    <td align="center"><?php echo CHtml::encode(substr($data->st_end_time, 0, 5)); ?></td>
    <td align="center"><?php echo CHtml::encode($data->st_name); ?></td>
    <td align="center">
        <?php echo CHtml::link('删除', '#', array('onclick' => 'return postDelete(this,' . $data->st_id . ');')); ?> 
        <a href="#" onclick="openDialogAuto('/dealerServiceTime/update/id/<?php echo $data->st_id; ?>', 'auto', 'auto', '营业时间修改'); return false;" class="PopwinShow">修改</a>
    </td>

</tr>