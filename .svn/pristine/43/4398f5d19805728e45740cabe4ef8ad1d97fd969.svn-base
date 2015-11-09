<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_dishCategory").addClass("Active");');
Yii::app()->clientScript->registerScript('url', 'url = " ' . Yii::app()->request->hostInfo . '/'
        . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/";');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
?>
<script type="text/javascript">
    function postDelete(obj, id) {
//        if (!confirm("你确认删除该菜品类别吗？"))
//            return false;
        openConfirmDialog("你确认禁用该菜品类别吗？", function() {
            $.post("/dishCategory/delete/id/" + id.toString(), "",
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
</script>

<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>查看菜品类别</span><em class="Btn">
                <a href="#"  onclick="openDialogAuto('/dishCategory/create', 'auto', 'auto', '菜品类别添加'); return false;" >
                    <strong>+</strong>添加菜品类别</a></em></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th width="160">类别名称</th>
                        <th>状态</th>
                        <th>所属类别</th>
                        <th align="center">操作</th>
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



