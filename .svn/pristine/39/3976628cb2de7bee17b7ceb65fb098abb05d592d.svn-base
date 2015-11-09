<?php
/* @var $this OrdersController */
/* @var $data Orders */
?>
<tr height="88">
    <td>
        <?php echo CHtml::link(CHtml::encode($data['order_id']), array('view', 'id' => $data['order_id'])); ?>
        <?php echo CHtml::encode($data['order_id']); ?></td>
    <td>
        <?php
        if (isset($data['dishpicurllist'])) {
            $picurllist = explode(',', $data['dishpicurllist']);
            foreach ($picurllist as $picinfo) {
                $picinfoarr = explode('|', $picinfo);
                $picurl = $picinfoarr[0];
                $picalt = $picinfoarr[1];
                echo '<h6><img height="50px" width="50px" title="' . $picalt . '" src="' . $this->get_static_url() . $picurl . '" /></h6>';
            }
        }
        ?>


    <td><?php echo CHtml::encode($data['contact_name']); ?>
        <br />
        <?php echo CHtml::encode($data['contact_addr']); ?>
    </td>

    <td align="center"><?php echo CHtml::encode($data['dish_count']); ?></td>
    <td align="center"><span class="sp_money">￥</span><?php echo CHtml::encode($data['order_amount']); ?></td>
    <td><?php echo CHtml::encode($data['order_createtime']); ?></td>
    <td><?php echo CHtml::encode($data['order_dinnertime']); ?></td>
    <td align="center"><?php echo CHtml::encode(busOrder::$ORDER_STATUS_NAME[$data['order_status']]); ?></td>
    <td align="center">
        <a href="#" onclick="openDialogAuto('/orders/view/id/<?php echo $data['order_id']; ?>', 'auto', 'auto','订单详情'); return false;" class="Btn_1">操作</a>
    </td>

</tr>

