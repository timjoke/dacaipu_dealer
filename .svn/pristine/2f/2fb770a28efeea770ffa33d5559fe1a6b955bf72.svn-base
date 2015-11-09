<tr height="30" bgcolor="#FFFFFF">
    <td align="center"><?php echo CHtml::encode(busNews::$NEWS_CATEGORY_NAME[$data['news_category']]); ?></td>
    <td><?php echo CHtml::encode($data['news_title']); ?></td>
    <td align="center">
        <?php echo CHtml::link('删除', '#', array('onclick' => 'return postDelete(this,' . $data['news_id'] . ');')); ?> 
        <a href='/news/update/id/<?php echo $data['news_id']; ?>' 
           class="PopwinShow">修改</a></td>
</tr>