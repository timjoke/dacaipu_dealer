<?php
$ss = Yii::app()->clientScript->registerScript('left_script', '$("#li_discount").addClass("Active");');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
?>

<script type="text/javascript">
    url = "<?php echo Yii::app()->request->hostInfo . '/' . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/'; ?>";
    function postDelete(obj, id) {
//        if (!confirm('你确认删除该折扣计划吗？'))
//            return false;
        openConfirmDialog("你确认删除该折扣计划吗？", function() {
            $.post("/discount/delete/id/" + id.toString(), "",
                    function(data, status) {
                        if (status === "success") {
                            if (data === '1')
                                location.reload(location.href);
                            else if (data === '0')
                                alert('内容不能删除，有计划！');
                        } else {
                            alert('系统错误，请联系管理员');
                        }
                        $('.ContentArea').unmask();
                    });
        });
        return false;
    }
</script>

<div class="MiddleArea">
    <div class="ContentArea">

        <h2>
            <span>折扣模板</span>
            <em class="Btn">
                <a href="#" onclick="openDialogAuto('/discount/create', 'auto', 'auto', '折扣模板添加'); return false;" class="PopwinShow"><strong>+</strong>添加折扣模板</a>
            </em>
        </h2> 

        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th width="160">折扣名称</th>
                        <th align="center">折扣模式</th>
                        <th align="center">折扣值</th>
                        <th align="center">折扣条件</th>
                        <th align="center">比较值</th>
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
