<tr height="25" align="center">
    <td width="20px"></td>
    <td align="left"><?php
        echo CHtml::encode($data['dish_name']);
        for ($i = 1; $i <= $data['dish_spicy_level']; $i++)
        {
            echo '<img src="' . $this->get_static_url() . 'pc/images/LajiaoIco_1.png" />';
        }
        $is_vaget_icon = $data['dish_is_vaget'] == 1 ? 'cabbage.png' : 'steak.png';
        echo sprintf('<img src="%s/pc/images/%s" title="%s" />', $this->get_static_url(), $is_vaget_icon, busDish::$ISVAGET[$data['dish_is_vaget']]);
        ?></td>
    <td><span class="sp_money">￥</span><?php echo CHtml::encode($data['dish_price']); ?></td>
    <td><?php echo CHtml::encode($data['order_count']); ?></td>
    <td>
        +<span class="sp_money">￥</span><?php echo busUlitity::formatMoney(($data['dish_price']) * $data['order_count']); ?>
    </td>
</tr>