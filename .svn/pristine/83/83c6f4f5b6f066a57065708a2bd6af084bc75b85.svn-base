<tr height="30" align="center" bgcolor="#FFFFFF">
    <td>
        <input type="checkbox" name="cb_dish" value="<?php echo $data['dish_id'] ?>" />
    </td>
    <td align="left">
        <?php
        $dish_name = $data['dish_name'];
        if (isset($data['over_id']))
        {
            $dish_name.='【估清】';
        }
        ?>
        <a href="#" onclick="openDialogAuto('/dish/update/id/<?php echo $data['dish_id'] ?>', 'auto', 'auto', '菜品信息修改');
                return false;" class="PopwinShow"><?php echo CHtml::encode($dish_name); ?></a>
    </td>
    <td>
        <div style="position: relative;width: 50px; height: 50px; cursor: pointer;">                                
            <?php
            $picurl = '';
            if ((!isset($data['pic_url'])) || strlen($data['pic_url']) == 0)
            {
                $picurl = $this->get_static_url() . '50_50/' . 'mobile/img/dish_default.png';
            } else
            {
                $picurl = $this->get_static_url() . '50_50/' . $data['pic_url'];
            }
            ?>
            <img src="<?php echo $picurl; ?>" onclick="openDialogAuto('/dish/update/id/<?php echo $data['dish_id'] ?>', 'auto', 'auto', '菜品信息修改');
                    return false;" style="width: 50px; height: 50px;" />

            <?php
            if ($data['dish_recommend'] == DISH_RECOMMEND_YES)
            {
                ?>
                <div style="right:0px;top:0px; width:12px; height:15px; position:absolute; background:url(<?php echo $this->get_static_url(); ?>pc/images/jian.png)">
                </div>
            <?php } ?>
        </div>


    </td>

    <td>￥<?php echo CHtml::encode($data['dish_price']); ?></td>
    <td>￥<?php echo CHtml::encode($data['dish_package_fee']); ?> </td>

    <td>
        <?php echo busDish::$DISH_STATUS[$data['dish_status']]; ?>
        <?php
//        for ($i = 1; $i <= $data['dish_spicy_level']; $i++) {
//            echo '<img src="' . $this->get_static_url() . 'pc/images/LajiaoIco_1.png" />';
//        }
//        $is_vaget_icon = $data['dish_is_vaget'] == 1 ? 'cabbage.png' : 'steak.png';
//        echo sprintf('<img src="%s/pc/images/%s" title="%s" />', $this->get_static_url(), $is_vaget_icon, busDish::$ISVAGET[$data['dish_is_vaget']]);
//
//        $status_imgname = '';
//        $status_title = '';
//        if ($data['dish_status'] == DISH_STATUS_ONLINE) {
//            $status_imgname = 'dish_online.png';
//            $status_title = busDish::$DISH_STATUS[DISH_STATUS_ONLINE];
//        } elseif ($data['dish_status'] == DISH_STATUS_OFFLINE) {
//            $status_imgname = 'dish_offline.png';
//            $status_title = busDish::$DISH_STATUS[DISH_STATUS_OFFLINE];
//        }
//        echo sprintf('<img src="%s/pc/images/%s" title="%s" />', $this->get_static_url(), $status_imgname, $status_title);
        ?>
    </td>

    <!-- <td><?php echo CHtml::encode(busUlitity::formatDate($data['dish_modifytime'])); ?></td> -->

    <td>
        <?php
        ?>
        <?php
        if (isset($data['over_id']))
        {
//            $dish_name.='【估清】';
            echo CHtml::link('取消估清', '#', array('onclick' => 'return cancelOverDish(this,' . $data['over_id'] . ');'));
        } else
        {
            echo CHtml::link('估清', '#', array('onclick' => 'return overDish(this,' . $data['dish_id'] . ');'));
        }

        if ($data['dish_status'] == 1)
        {
            echo CHtml::link('下架', '#', array('onclick' => 'return postDelete(this,' . $data['dish_id'] . ');'));
        } else
        {
            echo CHtml::link('上架', '#', array('onclick' => 'return postcancelDelete(this,' . $data['dish_id'] . ');'));
        }
        ?> 
        <a href="#" onclick="openDialogAuto('/dish/update/id/<?php echo $data['dish_id'] ?>', 'auto', 'auto', '菜品信息修改');
                return false;" class="PopwinShow">修改</a>
        <?php echo CHtml::link('删除', '#', array('onclick' => 'return postDel(this,' . $data['dish_id'] . ');')); ?>
    </td>
</tr>