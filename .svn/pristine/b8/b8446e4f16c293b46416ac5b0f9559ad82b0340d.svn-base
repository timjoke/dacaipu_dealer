<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_dish").addClass("Active");');
Yii::app()->clientScript->registerScript('url', 'url = " ' . Yii::app()->request->hostInfo . '/'
        . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/";');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
?>
<script type="text/javascript">
    function postDel(obj, id) {
        openConfirmDialog("你确认删除该菜品吗？", function() {
            $.post("/dish/del/id/" + id.toString(), "",
                    function(data, status) {
                        if (status === "success") {
                            if (data == '') {
                                location.reload(location.href);
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
    function postDelete(obj, id) {
        openConfirmDialog("你确认下架该菜品吗？", function() {
            $.post("/dish/delete/id/" + id.toString(), "",
                    function(data, status) {
                        if (status === "success") {
                            if (data == '') {
                                location.reload(location.href);
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
    function postcancelDelete(obj, id) {
        openConfirmDialog("你确认上架该菜品吗？", function() {
            $.post("/dish/cancelDelete/id/" + id.toString(), "",
                    function(data, status) {
                        if (status === "success") {
                            if (data == '') {
                                location.reload(location.href);
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
     * 批量下架菜品
     * @returns {undefined}
     */
    function postbatchDelete() {
        return batchOperationDish('batchDeleteDish', '下架');
    }
    /**
     * 批量删除菜品
     * @returns {undefined}
     */
    function postbatchDel() {
        return batchOperationDish('batchDelDish', '删除');
    }
    /**
     * 批量上架菜品
     * @returns {undefined}
     */
    function postbatchOnboardDish() {
        return batchOperationDish('batchOnboardDish', '上架');
    }

    /**
     * 取消估清
     * @param {type} obj
     * @param {type} id
     * @returns {undefined}
     */
    function cancelOverDish(obj, overid) {
        openConfirmDialog("你确认取消该菜品估清吗？", function() {
            $.post("/dish/cancelOverDish/overid/" + overid.toString(), "",
                    function(data, status) {
                        if (status === "success") {
                            if (data == '') {
                                location.reload(location.href);
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
     * 估清
     * @param {type} obj
     * @param {type} dishid
     * @returns {Boolean}
     */
    function overDish(obj, dishid) {
        openConfirmDialog("你确认设置该菜品估清吗？", function() {
            $.post("/dish/overDish/dishid/" + dishid.toString(), "",
                    function(data, status) {
                        if (status === "success") {
                            if (data == '') {
                                location.reload(location.href);
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
     * 批量估清菜品
     * @returns {undefined}
     */
    function batchOverDish() {
        return batchOperationDish('batchOverDish', '估清');
    }

    function batchCancelOverDish() {
        return batchOperationDish('batchCancelOverDish', '取消估清');
    }

    /**
     * 获取选中的菜品的id
     * @returns {Array|getSelectDishid.selectDishidArray}
     */
    function getSelectDishid() {
        var selectDishidArray = [];
        $("input[name='cb_dish']").each(function() {
            var $item_cbdish = $(this);
            if ($item_cbdish.is(':checked')) {
                selectDishidArray.push($item_cbdish.val());
            }
//            $(this).attr("checked", $select_all.is(':checked'));
        });
        return selectDishidArray;
    }

    /**
     * 全选菜品
     */
    function selectAllDish() {
        var $select_all = $("#select_all");
        $("input[name='cb_dish']").each(function() {
            $(this).attr("checked", $select_all.is(':checked'));
        });
    }

    /**
     * 批量操作菜品
     * @param {type} actionName 
     * @param {type} message 提示信息的动作名称
     * @returns {undefined}
     */
    function batchOperationDish(actionName, message) {
        var idarr = getSelectDishid();
        var dishcount = idarr.length;
        if (dishcount == 0) {
            alert('请选择需要' + message + '的菜品');
            return false;
        }
        var idstr = idarr.join(',');
        openConfirmDialog('你确认批量' + message + '选中的' + dishcount + '项菜品吗？', function() {
            $.post('/dish/' + actionName + '/dishids/' + idstr, '',
                    function(data, status) {
                        if (status === "success") {
                            if (data.indexOf('error') == -1) {
                                if (data == '0') {
                                    alert('没有符合条件的菜品被' + message);
                                } else {
                                    alert('您已成功' + message + data + '项菜品');
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
</script>
<style type="text/css">
    ul.cates{
        list-style-type:none;
    }
    ul.cates li{float:left;line-height:30px;margin-right:30px;
                font-size:14px;
                margin-top:10px;}
    ul.cates li.cur a
    {
        /*font-weight: bold;*/
        color:#DEBB31;
        padding-left:20px;
        padding-right:20px;
        border:1px solid #DEBB31;
        background-color:#FFFFFF;
        padding-top:2px;
        padding-bottom:2px;
    }
    ul.cates li a{
        color:#FFFFFF;
        padding-left:20px;
        padding-right:20px;
        border:1px solid #DEBB31;
        background-color:#DEBB31;
        padding-top:2px;
        padding-bottom:2px;
    }

    ul.cates li a:hover{
        text-decoration:underline;
    }
</style>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>查看菜品</span>
            <em class="Btn">
                <a href="#"  onclick="openDialogAuto('/dish/create', 'auto', 'auto', '菜品信息添加');
                        return false;"><strong>+</strong>添加菜品</a>
            </em>
            <em class="Btn">
                <a href="/dish/outputExcel">Excel导出</a>
            </em>
            <em class="Btn">
                <a href="/dish/importExcel">Excel导入</a>
            </em>
        </h2>  
        <div class="ContArea">
            <div class="Bg"></div>
            <div class='BlockArea_4' style="padding-left:15px;padding-bottom:15px;">
                <ul class="cates">
                    <?php
                    foreach ($categories as $category)
                    {
                        echo '<li';
                        if ($category->category_id == $c)
                        {
                            echo ' class=\'cur\'';
                        }
                        echo '><a href=/dish?c=' . $category->category_id;
                        echo '>';
                        echo $category->category_name;
                        echo '</a></li>';
                    }
                    ?>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="SearchArea">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'dish-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="ItemLeft">
                    <span class="searchTitle">菜品名称：</span>
                    <input id="dish_name" name="dish_name" type="text" class="SearchInput_1" /> 
                </div>
                <div class="ItemLeft">
                    <?php echo CHtml::submitButton('查询', array('class' => 'Btn_1')); ?>
                </div>
                <?php $this->endWidget(); ?>
                <div style="clear: both"></div>

            </div>
            <div class='BlockArea_4' style="padding-left:15px;padding-bottom:15px;">
                <input type="checkbox" id="select_all" onclick="selectAllDish();" />
                <label for="select_all">全选</label>
                <input type="button" class="BatchBtn" style="width:57px;" value="估清" onclick="batchOverDish();" />
                <input type="button" class="BatchBtn" style="width:107px;" value="取消估清" onclick="batchCancelOverDish();" />
                <input type="button" class="BatchBtn" style="width:57px;"  value="下架" onclick="postbatchDelete();" />
                <input type="button" class="BatchBtn" style="width:57px;"  value="上架" onclick="postbatchOnboardDish();" />
                <input type="button" class="BatchBtn" style="width:57px;"  value="删除" onclick="postbatchDel();" />
            </div>
            <div class="BlockArea_4">

                <div class="BlockContArea">

                    <div class="scroll-pane" id="Container">

                        <div id="ListConts">
                            <div class="scroll-content Scroller-Container">
                                <table cellpadding="5" cellspacing="0" border="0" width="100%" align="center">
                                    <tr height="30" align="center">
                                        <th></th>
                                        <th>菜品名称</th>
                                        <th></th>
                                        <th>菜品价格</th>
                                        <th>打包费</th>
                                        <th></th>

<!--                                        <th>修改时间</th>-->
                                        <th>操作</th>
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
                                            'maxButtonCount' => 10,
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
            </div>
            <div class='BlockArea_4' style="padding-left:15px;padding-bottom:15px;">
                <input type="checkbox" id="select_all" onclick="selectAllDish();" />
                <label for="select_all">全选</label>
                <input type="button" class="BatchBtn" style="width:57px;" value="估清" onclick="batchOverDish();" />
                <input type="button" class="BatchBtn" style="width:107px;" value="取消估清" onclick="batchCancelOverDish();" />
                <input type="button" class="BatchBtn" style="width:57px;"  value="下架" onclick="postbatchDelete();" />
                <input type="button" class="BatchBtn" style="width:57px;"  value="上架" onclick="postbatchOnboardDish();" />
                <input type="button" class="BatchBtn" style="width:57px;"  value="删除" onclick="postbatchDel();" />
            </div>
        </div>
    </div>
</div>