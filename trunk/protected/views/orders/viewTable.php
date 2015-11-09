<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<?php
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/InformationCss.css');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
?>
<div class="PopWinArea">
    <div class="ContArea">
        <div class="MidArea" align="center">
            <h4>订单信息</h4>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'order-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
            ?>
            <table cellpadding="5" cellspacing="5" border="0" align="left" class="Table_1" >
                <tr height="35">
                    <td align="right">订单号:</td>
                    <td><?php echo $model->order_id; ?></td>
                    <td align="right">下单时间:</td>
                    <td><?php echo busUlitity::formatDate($model->order_createtime); ?></td>
                    <td align="right">用餐时间:</td>
                    <td><?php echo busUlitity::formatDate($table_resermodel->reserv_start_time); ?></td>
                </tr>
                <tr height="35">
                    <td align="right">应收金额:</td>
                    <td><span class="sp_money">￥</span><?php echo busUlitity::formatMoney($model->order_paid); ?></td>
                    <td align="right">订单类型:</td>
                    <td><?php echo CHtml::encode(busOrder::$ORDER_TYPE_NAME[$model->order_type]); ?></td>
                    <td align="right">桌台信息:</td>
                    <td><?php echo $dinner_tablemodel->table_name; ?></td>
                </tr>
                <tr height="35">
                    <td align="right">备注:</td>
                    <td colspan="5">
                        <em>
                            <?php echo CHtml::textField('memo', '', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1')); ?>
                        </em>
                    </td>
                </tr>
                <tr height="35">
                    <td align="right">订单状态:</td>
                    <td ><?php echo CHtml::encode(busOrder::$ORDER_STATUS_NAME [$model->order_status]); ?></td>
                    <td colspan="3">
                        <?php echo CHtml::hiddenField('status', $model->order_status); ?>
                        <?php echo CHtml::hiddenField('type', $model->order_type); ?>
                        <?php
                        $btn_name = '';
                        switch ($model->order_status)
                        {
                            case ORDER_STATUS_PROCESSING:
                                $btn_name = '订单结束';
                                break;
//                            case ORDER_STATUS_COMPLETE:
//                                if ($model->order_type == ORDER_TYPE_TAKEOUT) {
//                                    $btn_name = '派送';
//                                } elseif ($model->order_type == ORDER_TYPE_TAKEOUT_SELFTAKE) {
//                                    $btn_name = '取餐';
//                                } else {
//                                    $btn_name = '程序待开发';
//                                }
//                                break;
//                            case ORDER_STATUS_EXPRESSING:
//                                $btn_name = '订单结束';
//                                break;
//                            case ORDER_STATUS_WAIT_PAY:
//                                $btn_name = '订单结束';
//                                break;
                            default:
                                break;
                        }

                        echo CHtml::submitButton($btn_name, array(
                            'onclick' => 'return confirm("您确定要操作此订单吗？");', 'class' => 'Btn_1'
                        ));
                        ?>
                    </td>
                </tr>
            </table>

            <?php $this->endWidget(); ?>
            <div class="clear"></div>
            <h4>联系人信息</h4>
            <table cellpadding="5" cellspacing="5" border="0" align="left" class="Table_1" >
                <tr height="35">
                    <td align="right">联系人姓名:</td>
                    <td><?php echo $contactmodel->contact_name; ?></td>
                    <td align="right">联系电话:</td>
                    <td><?php echo $contactmodel->contact_tel; ?></td>
                </tr>
            </table>
            <?php
            if ($order_dish_flash_list->itemCount > 0)
            {
                ?>
                <div class="clear"></div>
                <h4>菜品列表</h4>
                <table cellpadding="5" cellspacing="0" border="0" align="center" class="Table_2" width="650">
                    <tr height="25" align="center">
                        <th></th>
                        <th>菜品名称</th>
                        <th>菜品单价</th>
                        <th>数量</th>
                        <th></th>
                    </tr>

                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $order_dish_flash_list,
                        'itemView' => '_view_order_dish_flash',
                        'emptyText' => '',
                        'enablePagination' => false,
                        'enableSorting' => false,
                        'summaryText' => '',));
                    ?>
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $discount_list,
                        'itemView' => '_view_discount',
                        'emptyText' => '',
                        'enablePagination' => false,
                        'enableSorting' => false,
                        'summaryText' => '',));
                    ?>
                    <?php
                    if ($coupon_value != 0)
                    {
                        ?>
                        <tr height="25" align="center">
                            <td align="left">打折码金额:</td>
                            <td><span class="sp_money">￥</span><?php echo $coupon_value; ?></td>
                            <td></td>
                            <td>-<span class="sp_money">￥</span><?php echo $coupon_value; ?></td>
                        </tr>
                    <?php } ?>
                </table>           
            <?php } ?>
            <table cellpadding="5" cellspacing="0" border="0" align="center" width="650">
                <tr height="25" width='100' align="right">
                    <td>总计:</td>
                    <td width='80'><span class="sp_money">￥</span><?php echo busUlitity::formatMoney($model->order_paid); ?></td>
                </tr>
            </table>

        </div>
    </div>
</div>
        </body>
</html>