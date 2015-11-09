<tr height="30" bgcolor="#FFFFFF">
    <td align="center"><?php echo CHtml::encode($data['keyword']); ?></td>
    <td align="center"><?php echo CHtml::encode(busDealerWechatReply::show_operat_str($data['operat'])); ?></td>
    <td align="center"><?php echo CHtml::encode(busDealerWechatReply::show_content_type_str($data['content_type'])); ?></td>
    <td align="center"><?php echo CHtml::encode($data['content']); ?></td>
    <td align="center">
        <?php echo CHtml::link('删除', '#', array('onclick' => 'return postDelete(this,' . $data['reply_id'] . ');')); ?> 
        <a href='/dealerWechatReply/update/id/<?php echo $data['reply_id']; ?>' 
           class="PopwinShow" onclick="openDialogAuto('/dealerWechatReply/update/id/<?php echo $data['reply_id']; ?>', 'auto', 'auto', '微信自动回复修改');
                return false;">修改</a></td>
</tr>