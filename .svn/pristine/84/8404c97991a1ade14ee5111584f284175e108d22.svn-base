<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8"></meta>
        <script type="text/javascript">
//            window.print();
        </script>
        <style>
            @media print {
                .noprint {display:none}
            }
            body{font-size:12px;line-height:20px;margin:5px;}
            td{font-size:12px;line-height:20px;}
            .content{font-size: 12px;}
            .content_title_a{font-size: 12px;  font-weight: bold; text-align:center; width: 100%; }
            .content_title_b{font-size: 12px; font-weight: bold}
        </style>
    </head>
    <body>
        <div  style="width:100%;">
            <a onclick="window.print();" class="noprint" href="#">打印</a>
            <div style="text-align:center; font-weight: bold;"><?php echo $dealer_name; ?></div>
            <div>------------------------------------------</div>
            <div style=" font-weight: bold;">订单编号：<?php echo $model->order_id; ?></div>
            <div>下单时间：<?php echo $model->order_createtime; ?></div>
            <div>打印时间：<?php echo date('Y-m-d H:i:s'); ?></div>
            <div>------------------------------------------</div>
            <div>菜品列表</div>
            <table style="width:95%">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $order_dish_flash_list,
                    'itemView' => '_view_print_orders',
                    'enablePagination' => false,
                    'enableSorting' => false,
                    'summaryText' => '',));
                ?>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $discount_list,
                    'itemView' => '_view_print_discount',
                    'emptyText' => '',
                    'enablePagination' => false,
                    'enableSorting' => false,
                    'summaryText' => '',));
                ?>
                <tr>
                    <td>配送费</td>
                    <td style="text-align:right;">+<span class="sp_money">￥</span><?php echo busUlitity::formatMoney($dealer_express_fee); ?>元</td>
                </tr>
                <?php
                if ($coupon_value != 0)
                {
                    ?>
                    <tr>
                        <td>打折码金额:</td>
                        <td style="text-align:right;">-<span class="sp_money">￥</span><?php echo $coupon_value; ?>元</td>
                    </tr>
                <?php } ?>
            </table>

            <div>------------------------------------------</div>
            <div  style="text-align:right; font-weight:bold; width: 95%">总计：￥<?php echo busUlitity::formatMoney($model->order_paid); ?>元</div>
            <div>------------------------------------------</div>
            <div style="width: 95%">联系人:<?php echo $contactmodel->contact_name ?> </div>
            <div style="width: 95%">电话:<?php echo $contactmodel->contact_tel; ?></div>
            <div style="width: 95%">地址:<?php echo $contactmodel->contact_addr; ?></div>
            <div style="width: 95%">备注:<?php
                if ($user_remark == '')
                {
                    echo '无';
                } else
                {
                    echo $user_remark;
                }
                ?></div>
            <div>------------------------------------------</div>
            <div style="width: 95%">北京爱吆喝信息技术有限公司提供微信订餐服务</div>
            <div style="width: 95%">联系电话:4006-766-917</div>
        </div>
    </body>
</html>