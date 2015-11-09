<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_my_history_bill").addClass("Active");');
?>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>历史账单</span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th align="center" >起始日期</th>
                        <th align="center">结束日期</th>
                        <th align="center">外卖总金额</th>
                        <th align="center">订台下单量</th>
                        <th align="center">手续费</th>
                        <th align="center">操作</th>
                    </tr>
                    <?php
                    $dataProvider->setPagination(array('pageVar' => 'page'));
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view_my_history_bill',
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
