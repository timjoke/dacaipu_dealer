<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_dealerWechatReply").addClass("Active");');
Yii::app()->clientScript->registerScript('url', 'url = " ' . Yii::app()->request->hostInfo . '/'
        . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/";');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
?>
<script type="text/javascript">
    function postDelete(obj, id) {
        openConfirmDialog("你确认删除该自动回复吗？", function() {
            $.post("/dealerWechatReply/delete/id/" + id.toString(), "",
                    function(data, status) {
                        if (status === "success") {
                            location.reload(location.href);
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
        <h2><span>微信自动回复</span><em class="Btn">
                <a href='#' onclick="openDialogAuto('/dealerWechatReply/create', 'auto', 'auto', '微信自动回复添加');
                return false;">
                    <strong>+</strong>添加自动回复</a></em></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th align="center" width="160">关键字</th>
                        <th align="center">操作符</th>
                        <th align="center">内容类型</th>
                        <th align="center">回复内容</th>
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