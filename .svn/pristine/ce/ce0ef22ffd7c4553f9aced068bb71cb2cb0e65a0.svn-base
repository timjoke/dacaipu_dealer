<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_order_today").addClass("Active");');
Yii::app()->clientScript->registerScript('loadorders', 'loadOrders();');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.loadmask.js');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/jquery.loadmask.css');
?>
<script type="text/javascript">
    /**
     * 加载今日订单
     * @returns {undefined}
     */
    function loadOrders()
    {
        $('.MiddleArea').mask('正在加载请稍后...');
        $.post("/orders/LoadOrders/", "",
                function(data, status) {
                    if (status === "success") {
                        //删除表格中的数据
                        $("#today_orders tr").remove();
                        var $table_orders = $("#today_orders");
                        var title = '<tr height="31">' +
                                '<th width="80"><b>订单编号</b></th>' +
                                '<th><b>订单内容</b></th>' +
                                '<th width="120"><b>地址/桌台</b></th>' +
                                '<th width="90"><b>金额</b></th>' +
                                '<th width="80"><b>就餐时间</b></th>' +
                                '<th width="75"><b>当前状态</b></th>' +
                                '<th width="80"><b>操作</b></th>' +
                                '</tr>';
                        $table_orders.append($(title));

                        //加载表格数据
                        var dataObj = $.parseJSON(data);
                        dataObj = bubbleSort(dataObj);
                        if (dataObj.length == 0) {
                            $("#today_orders").after('<div class="emptyArea"><?php echo DATAEMPTYMESSAGE; ?></div>');
                        } else {
                            for (var i = 0; i < dataObj.length; i++) {
                                var dishpicurllist = dataObj[i].dishpicurllist;//菜品信息列表
                                var dishstr = '';
                                if (dishpicurllist !== null) {
                                    var picurllist = new Array();
                                    picurllist = dishpicurllist.split(",");
                                    var disharr = new Array();
                                    for (var j = 0; j < picurllist.length; j++) {
                                        var picinfoarr = new Array();
                                        picinfoarr = picurllist[j].split("|");
                                        var dish_count = picinfoarr[0];
                                        var dish_name = picinfoarr[1];
                                        disharr[j] = dish_name + 'x' + dish_count;
                                    }
                                    dishstr = disharr.join('<br />');
                                }
                                var btntext = getTransBtntext(dataObj[i].order_status, dataObj[i].order_type);
                                var dinnertimestr = dataObj[i].order_dinnertime.substr(11, 5);
                                var btncss = 'Btn_1';
                                if (dataObj[i].order_status == 7) {
                                    btncss = 'Btn_1_green';
                                } else if (dataObj[i].order_status == 3) {
                                    btncss = 'Btn_1';
                                }
                                var htmlstr = '';
                                if (dataObj[i].order_type ==<?php echo ORDER_TYPE_TAKEOUT ?>) {//外卖订单
                                    htmlstr = '<tr height="50">' +
                                            '<td align="center"><a href="#" onclick="openDialogAuto(\'view/id/' + dataObj[i].order_id + '\', \'auto\', \'auto\',\'订单详情\'); return false;"  >' + dataObj[i].order_id + '</a></td>' +
                                            '<td align="left">' + dishstr + ' </td>' +
                                            '<td>' + dataObj[i].contact_name + '<br />' + dataObj[i].contact_addr + ' </td>' +
                                            '<td align="center"><span class="sp_money">￥</span>' + dataObj[i].order_paid + ' </td>' +
                                            '<td align="center">' + dinnertimestr + ' </td>' +
                                            '<td align="center">' + dataObj[i].order_statusname + ' </td>' +
                                            '<td align="center">' +
                                            '<input type="hidden" id="order_status_' + dataObj[i].order_id + '" value="' + dataObj[i].order_status + '">' +
                                            '<span style="cursor:pointer" href="#" onclick="transformOrderStatus(\'' + dataObj[i].order_id + '\',\'' + dataObj[i].order_status + '\',\'' +
                                            dataObj[i].order_type + '\');" class="' + btncss + '" >' + btntext + '</span></td>';
                                } else if (dataObj[i].order_type ==<?php echo ORDER_TYPE_TAKEOUT_SELFTAKE ?>) {//外卖自取
                                    htmlstr = '<tr height="50">' +
                                            '<td align="center"><a href="#" onclick="openDialogAuto(\'view/id/' + dataObj[i].order_id + '\', \'auto\', \'auto\',\'订单详情\'); return false;"  >' + dataObj[i].order_id + '</a></td>' +
                                            '<td align="left">' + dishstr + ' </td>' +
                                            '<td>' + dataObj[i].contact_name + ' </td>' +
                                            '<td align="center"><span class="sp_money">￥</span>' + dataObj[i].order_paid + ' </td>' +
                                            '<td align="center">' + dinnertimestr + ' </td>' +
                                            '<td align="center">' + dataObj[i].order_statusname + ' </td>' +
                                            '<td align="center">' +
                                            '<input type="hidden" id="order_status_' + dataObj[i].order_id + '" value="' + dataObj[i].order_status + '">' +
                                            '<span style="cursor:pointer" href="#" onclick="transformOrderStatus(\'' + dataObj[i].order_id + '\',\'' + dataObj[i].order_status + '\',\'' +
                                            dataObj[i].order_type + '\');" class="' + btncss + '" >' + btntext + '</span></td>';
                                } else if (dataObj[i].order_type ==<?php echo ORDER_TYPE_SUB_TABLE ?> || dataObj[i].order_type ==<?php echo ORDER_TYPE_SUB_TALE_DISH ?>) {//桌台订单
                                    htmlstr = '<tr height="50">' +
                                            '<td align="center"><a href="#" onclick="openDialogAuto(\'viewTable/id/' + dataObj[i].order_id + '\', \'auto\', \'auto\',\'订单详情\'); return false;"  >' + dataObj[i].order_id + '</a></td>' +
                                            '<td align="left">' + dishstr + ' </td>' +
                                            '<td>' + dataObj[i].contact_name + '<br />' + dataObj[i].table_name + ' </td>' +
                                            '<td align="center"><span class="sp_money">￥</span>' + dataObj[i].order_paid + ' </td>' +
                                            '<td align="center">' + dinnertimestr + ' </td>' +
                                            '<td align="center">' + dataObj[i].order_statusname + ' </td>' +
                                            '<td align="center">' +
                                            '<input type="hidden" id="order_status_' + dataObj[i].order_id + '" value="' + dataObj[i].order_status + '">' +
                                            '<span style="cursor:pointer" href="#" onclick="transformOrderStatus(\'' + dataObj[i].order_id + '\',\'' + dataObj[i].order_status + '\',\'' +
                                            dataObj[i].order_type + '\');" class="' + btncss + '" >' + btntext + '</span></td>';
                                } else if (dataObj[i].order_type ==<?php echo ORDER_TYPE_EATIN ?>) {//堂食点餐订单
                                    htmlstr = '<tr height="50">' +
                                            '<td align="center"><a href="#" onclick="openDialogAuto(\'viewHall/id/' + dataObj[i].order_id + '\', \'auto\', \'auto\',\'订单详情\'); return false;"  >' + dataObj[i].order_id + '</a></td>' +
                                            '<td align="left">' + dishstr + ' </td>' +
                                            '<td>' + dataObj[i].contact_name + '<br />' + dataObj[i].table_name + ' </td>' +
                                            '<td align="center"><span class="sp_money">￥</span>' + dataObj[i].order_paid + ' </td>' +
                                            '<td align="center">' + dinnertimestr + ' </td>' +
                                            '<td align="center">' + dataObj[i].order_statusname + ' </td>' +
                                            '<td align="center">' +
                                            '<input type="hidden" id="order_status_' + dataObj[i].order_id + '" value="' + dataObj[i].order_status + '">' +
                                            '<span style="cursor:pointer" href="#" onclick="transformOrderStatus(\'' + dataObj[i].order_id + '\',\'' + dataObj[i].order_status + '\',\'' +
                                            dataObj[i].order_type + '\');" class="' + btncss + '" >' + btntext + '</span></td>';
                                }


                                $("#today_orders").append($(htmlstr));

                            }
                            $(".emptyArea").remove();
                        }
                    }
                    else {
                        alert('服务器异常，请联系管理员');
                    }
                    $('.MiddleArea').unmask();
                });
    }

    /**
     * 操作按钮的文字
     * @param {type} status 订单状态
     * @param {type} type 订单类型 1 外卖送餐；
     2 外卖自取；
     3 预订桌台；
     4 预订桌台+点菜；
     * @returns {String} */
    function getTransBtntext(status, type) {
        if (type ==<?php echo ORDER_TYPE_TAKEOUT; ?> || type ==<?php echo ORDER_TYPE_TAKEOUT_SELFTAKE; ?>) {
            switch (status) {
                case '<?php echo ORDER_STATUS_PROCESSING; ?>':
                    return '完成烹饪';
                    break;
                case '<?php echo ORDER_STATUS_COMPLETE; ?>':
                    if (type == '<?php echo ORDER_TYPE_TAKEOUT; ?>') {
                        return '派送';
                    } else if (type == '<?php echo ORDER_TYPE_TAKEOUT_SELFTAKE; ?>') {
                        return '取餐';
                    } else {
                        return '程序待开发';
                    }
                    break;
                case '<?php echo ORDER_STATUS_EXPRESSING; ?>':
                    return '完成派送';
                    break;
                case '<?php echo ORDER_STATUS_WAIT_PAY; ?>':
                    return '结束';
                    break;
                default:
                    return 'error';
                    break;

            }
        }
        else if (type ==<?php echo ORDER_TYPE_SUB_TABLE; ?> || type ==<?php echo ORDER_TYPE_SUB_TALE_DISH; ?> || type ==<?php echo ORDER_TYPE_EATIN; ?>) {
            switch (status) {
                case '<?php echo ORDER_STATUS_PROCESSING; ?>':
                    return '订单完成';
                    break;
                default:
                    return 'error';
                    break;
            }
        }
    }

    /**
     * 操作按钮的事件
     * @param {type} orderid 订单id
     * @param {type} status 订单状态
     * @param {type} type 订单类型
     * @returns {undefined}
     */
    function transformOrderStatus(orderid, status, type) {
        var comfText = '';
        switch (type) {
            case '<?php echo ORDER_TYPE_TAKEOUT; ?>':
                comfTest = getOrderTakeoutMsg(status, type);
                break;
            case '<?php echo ORDER_TYPE_TAKEOUT_SELFTAKE; ?>':
                comfTest = getOrderTakeoutMsg(status, type);
                break;
            case '<?php echo ORDER_TYPE_SUB_TABLE ?>':
                comfTest = getOrderTableMsg(status);
                break;
            case '<?php echo ORDER_TYPE_SUB_TALE_DISH ?>':
                comfTest = getOrderTableMsg(status);
                break;
            case '<?php echo ORDER_TYPE_EATIN ?>':
                comfTest = getOrderHallMsg(status);
                break;
            default:
                comfTest = 'error';
                break;
        }

        openConfirmDialog(comfTest, function() {
            var statusid = $('#order_status_' + orderid).val();
            $.post("<?php echo Yii::app()->request->hostInfo; ?>/orders/transformOrderStatus?orderid=" + orderid + "&statusid=" + statusid
                    , "", function(data, status) {
                        if (status === 'success') {
                            if (data.length > 0) {
                                alert(data);
                            }
                            loadOrders();
                        } else {
                            alert('服务器异常，请联系管理员');
                        }
                        $('.ContentArea').unmask();
                    });
        });
    }

    /**
     * 获取外卖订单的弹出确认框消息字符串
     * @param {type} status 
     * @returns {String} */
    function getOrderTakeoutMsg(status, type) {
        var comfText = '';
        switch (status) {
            case '<?php echo ORDER_STATUS_PROCESSING; ?>':
                comfText = '您确定该订单已打包完毕?';
                break;
            case '<?php echo ORDER_STATUS_COMPLETE; ?>':
                if (type == '<?php echo ORDER_TYPE_TAKEOUT; ?>') {
                    comfText = '您确定已经打包完毕，送餐员已经出发给客户送餐了吗?';
                } else if (type == '<?php echo ORDER_TYPE_TAKEOUT_SELFTAKE; ?>') {
                    comfText = '你确定要通知客户来取餐吗?';
                } else {
                    comfText = '程序待开发';
                }
                break;
            case '<?php echo ORDER_STATUS_EXPRESSING; ?>':
                comfText = '您确定该订单已派送完毕?';
                break;
            case '<?php echo ORDER_STATUS_WAIT_PAY; ?>':
                comfText = '您确定送客户付清餐费了吗?';
                break;
            default:
                comfText = 'error';
                break;

        }
        return comfText;
    }

    /**
     * 
     * @param {type} status
     * @returns {String}
     */
    function getOrderTableMsg(status) {
        var comfText = '';
        switch (status) {
            case '<?php echo ORDER_STATUS_PROCESSING; ?>':
                comfText = '您确定该订单已完成?';
                break;
            default:
                comfText = 'error';
                break;
        }
        return comfText;
    }

    /**
     * 
     * @param {type} status
     * @returns {String}
     */
    function getOrderHallMsg(status) {
        var comfText = '';
        switch (status) {
            case '<?php echo ORDER_STATUS_PROCESSING; ?>':
                comfText = '您确定该订单已完成?';
                break;
            default:
                comfText = 'error';
                break;
        }
        return comfText;
    }
</script>
<?php
//这是一段,在显示后定里消失的JQ代码,已集成至Yii中.
Yii::app()->clientScript->registerScript(
        'myHideEffect', '$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");', CClientScript::POS_READY
);
?>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>今日订单</span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_1">
                <table id="today_orders" cellpadding="0" cellspacing="0" border="0" width="100%" class="Table_1">
                    <tr height="31">
                        <th width="110"><b>订单编号</b></th>
                        <th>订单内容</th>
                        <th width="120">送餐地址</th>
                        <th width="90">总金额</th>
                        <th width="90">就餐时间</th>
                        <th width="75">当前状态</th>
                        <th width="75">操作</th>
                    </tr>
                </table>
            </div>
        </div>        
    </div>
</div>

