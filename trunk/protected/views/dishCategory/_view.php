<tr height="30" bgcolor="#FFFFFF">
    <td><?php echo CHtml::encode($data['category_name']); ?></td>
    <td><?php echo CHtml::encode(busDishCategory::$CATEGORY_STATUS_NAME[$data['category_status']]); ?></td>
    <td><?php echo CHtml::encode($data['categ_parent_name']); ?></td>
    <td align="center">
        <?php
        if ($data['category_status'] == 1) {
            echo CHtml::link('禁用', '#', array('onclick' => 'return postDelete(this,' . $data['category_id'] . ');'));
        }
        ?> 
        <a href="#" onclick="openDialogAuto('/dishCategory/update/id/<?php echo $data['category_id']; ?>', 'auto', 'auto', '菜品类别修改'); return false;" 
           class="PopwinShow">修改</a></td>
</tr>