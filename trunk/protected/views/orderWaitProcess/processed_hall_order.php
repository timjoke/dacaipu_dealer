<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<?php
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/InformationCss.css');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/PopWinCss.css');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/jquery.loadmask.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.loadmask.js');
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<div class="PopWinArea">
    <div class="ContArea">

        <div class="MidArea" align="center">
            <h4>订单信息</h4>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'processed_order_form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <table cellpadding="5" cellspacing="5" border="0" align="left" class="Table_1" >
                <tr height="35">
                    <td align="right">订单号:</td>
                    <td><?php echo $model->order_id; ?></td>
                    <td align="right">下单时间:</td>
                    <td><?php echo busUlitity::formatDate($model->order_createtime); ?></td>
                    <td align="right">桌台信息:</td>
                    <td><?php echo $dinner_tablemodel->table_name; ?></td>
                </tr>
                <tr height="35">
                    <td align="right">应收金额:</td>
                    <td><span class="sp_money">￥</span><?php echo busUlitity::formatMoney($model->order_paid); ?></td>
                    <td align="right">订单类型:</td>
                    <td colspan="3"><?php echo CHtml::encode(busOrder::$ORDER_TYPE_NAME[$model->order_type]); ?></td>
                </tr>
                <tr height="35">
                    <td align="right">备注:</td>
                    <td colspan="5">
                        <em>
                            <?php echo CHtml::textField('memo', '', array('size' => 50, 'maxlength' => 50, 'class' => 'Input_1')); ?>
                            <?php
                            Yii::app()->clientScript->registerScript('submit', '$("#bt_agree").click(function(){' .
                                    '$(\'.ContArea\').mask(\'正在提交请稍后...\');' .
                                    '$("#processed_order_form")[0].action = "/OrderWaitProcess/agreeHall/id/' . $model->order_id . '";
        $("#processed_order_form").submit();
        });  '
                                    . '$("#bt_reject").click(function(){'
                                    . 'if($("#memo").val()==""){alert("拒绝请填写原因"); return false;} else{ $("#processed_order_form")[0].action = "/OrderWaitProcess/rejectHall/id/' . $model->order_id . '";'
                                    . '$(\'.ContArea\').mask(\'正在提交请稍后...\');'
                                    . '$("#processed_order_form").submit();}}); '
                            );
                            ?></em>
                    </td>
                </tr>
                <tr height="40" align="center">
                    <td>&nbsp;</td>
                    <td colspan="3">
                        <?php
                        if ($model->order_status == ORDER_STATUS_WAIT_PROCESS)
                        {
                            echo CHtml::submitButton('接受', array(
                                'id' => 'bt_agree', 'class' => 'Btn_1'
                            ));
                            echo CHtml::submitButton('拒绝', array(
                                'id' => 'bt_reject', 'class' => 'Btn_1'
                            ));
                        } else
                        {
                            echo '<input class="Btn_1" style="cursor:pointer" id="bt_cancel" value="关闭" onclick="window.top.closeDialog();">';
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
            <div class="clear"></div>
<!--            <h4>联系人信息</h4>
            <table cellpadding="5" cellspacing="5" border="0" align="left" class="Table_1" >
                <tr height="35">
                    <td align="right">联系人:</td>
                    <td><?php
                        echo $contactmodel->contact_name;
                        ?></td>
                    <td align="right">电话:</td>
                    <td><?php
                        echo $contactmodel->contact_tel;
                        ?></td>
                </tr>
            </table>

            <div class="clear"></div>-->
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
                    'itemView' => '../orders/_view_order_dish_flash',
                    'enablePagination' => false,
                    'enableSorting' => false,
                    'summaryText' => '',));
                ?>
                <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $discount_list,
                        'itemView' => '../orders/_view_discount',
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
                        <th></th>
                        <td align="left">打折码金额:</td>
                        <td><span class="sp_money">￥</span><?php echo $coupon_value; ?></td>
                        <td></td>
                        <td>-<span class="sp_money">￥</span><?php echo $coupon_value; ?></td>
                    </tr>
<?php } ?>
            </table>
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