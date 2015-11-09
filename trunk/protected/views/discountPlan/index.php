<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_discountPlan").addClass("Active");');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
?>
<script type="text/javascript">
    url = "<?php echo Yii::app()->request->hostInfo . '/' . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/'; ?>";
    function postDelete(obj, id) {
        openConfirmDialog("你确认将该折扣计划下线吗？", function() {
            $.post("/discountPlan/delete/id/" + id.toString(), "",
                    function(data, status) {
                        if (status === 'success') {
                            location.reload(location.href);
                        } else {
                            alert('系统错误，请联系管理员');
                        }
                        $('.ContentArea').unmask();
                    });
        });
        return false;
    }

    function postCancelDelete(obj, id) {
        openConfirmDialog("你确认将该折扣计划上线吗？", function() {
            $.post("/discountPlan/cancelDelete/id/" + id.toString(), "",
                    function(data, status) {
                        if (status === 'success') {
                            if (data == '') {
                                location.reload(location.href);
                            }
                            else
                            {
                                alert(data);
                            }
                        } else {
                            alert('系统错误，请联系管理员');
                        }
                        $('.ContentArea').unmask();
                    });
        });
        return false;
    }

    /**
     * 全选折扣计划
     */
    function selectAllDiscount() {
        var $select_all = $("#select_all");
        $("input[name='cb_discount']").each(function() {
            $(this).attr("checked", $select_all.is(':checked'));
        });
    }

    /**
     * 批量下线折扣计划
     * @returns {undefined}
     */
    function postbatchOffline() {
        return batchOperationDish('batchOfflineDiscountPlan', '下线');
    }

    /**
     * 批量上线折扣计划
     * @returns {undefined}
     */
    function postbatchOnline() {
        return batchOperationDish('batchOnlineDiscountPlan', '上线');
    }

    /**
     * 批量操作折扣计划
     * @param {type} actionName 
     * @param {type} message 提示信息的动作名称
     * @returns {undefined}
     */
    function batchOperationDish(actionName, message) {
        var idarr = selectDiscountId();
        var dishcount = idarr.length;
        if (dishcount == 0) {
            alert('请选择需要' + message + '的折扣计划');
            return false;
        }
        var idstr = idarr.join(',');
        openConfirmDialog('你确认批量' + message + '选中的' + dishcount + '项折扣计划吗？', function() {
            $.post('/discountPlan/' + actionName + '/discountids/' + idstr, '',
                    function(data, status) {
                        if (status === "success") {
                            if (data.indexOf('error') == -1) {
                                if (data == '0') {
                                    alert('没有符合条件的折扣计划被' + message);
                                } else {
                                    alert('您已成功' + message + data + '项折扣计划');
                                    location.reload(location.href);
                                }
                            }
                            else {
                                alert(data);
                            }
                        }
                        else {
                            alert('服务器异常，请联系管理员');
                        }
                        $('.ContentArea').unmask();
                    });
        });
        return false;
    }

    /**
     * 获取选中的折扣计划的id
     * @returns {Array|getSelectDishid.selectDishidArray}
     */
    function selectDiscountId() {
        var selectDiscountArray = [];
        $("input[name='cb_discount']").each(function() {
            var $item_cbdish = $(this);
            if ($item_cbdish.is(':checked')) {
                selectDiscountArray.push($item_cbdish.val());
            }
//            $(this).attr("checked", $select_all.is(':checked'));
        });
        return selectDiscountArray;
    }
</script>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>折扣计划</span><em class="Btn"><a href="#" onclick="openDialogAuto('/discountPlan/create', 'auto', 'auto', '折扣计划添加');
                return false;"><strong>+</strong>添加折扣计划</a></em></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class='BlockArea_4' style="padding-left:15px;padding-bottom:15px;">
                <input type="checkbox" id="select_all" onclick="selectAllDiscount();" />
                <label for="select_all">全选</label>
                <input type="button" class="BatchBtn" style="width:57px;"  value="上线" onclick="postbatchOnline();" />
                <input type="button" class="BatchBtn" style="width:57px;"  value="下线" onclick="postbatchOffline();" />
            </div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th width="50px"></th>
                        <th width="120px">实体名称</th>
                        <th align="center">折扣模板</th>
                        <th align="center" width="131px">有效时间</th>
                        <th align="center">状态</th>
                        <th align="center">下单类别</th>
                        <th align="center" width="42px">优先级</th>
                        <th align="center" width="48px">操作</th>
                    </tr>
                    <?php
                    $dataProvider->setPagination(array('pageVar' => 'page'));
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
                        'emptyText' => '',
                        'template' => '<div id="mygoods" style="display:none;" class="PagesArea">{pager}<span style="display:none;">{summary}</span></div>{items}{sorter}',
                        'pager' => array(
                            'firstPageLabel' => '首页',
                            'class' => 'CLinkPager',
                            'header' => '',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'maxButtonCount' => 3,
                        ),
                    ));
                    ?>
                </table>
                <?php
                busUlitity::dataEmptyMessage($dataProvider);
                ?>
                <div id="mypage" style="text-align: center;padding-bottom: 24px;">

                </div>               

            </div>
        </div>
    </div>
</div>
