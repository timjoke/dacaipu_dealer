<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<div class="PopWinArea">
    <div class="ContArea">
        <div class="MidArea" align="center">
            <div class="BlockArea_4">
                <div class="BlockContArea">
                    桌台名称：<?php echo $tablename; ?>  日期：<?php echo $reserv_date; ?> 
                    <a href="createDealerTableOrder?table_id=<?php echo $table_id; ?>" >添加订单</a>
                    <div class="scroll-pane" id="Container">
                        <div id="ListConts">
                            <div class="scroll-content Scroller-Container">
                                <table cellpadding="5" cellspacing="0" border="0" width="100%" align="center">
                                    <tr height="30" align="center">
                                        <th>订单编号</th>
                                        <th>开始时间</th>
                                        <th>结束时间</th>
                                        <th>订单状态</th>
                                        <th>预定时间</th>
                                        <th>操作</th>
                                    </tr>
                                    <?php
                                    $dataProvider->setPagination(array('pageVar' => 'page'));
                                    $this->widget('zii.widgets.CListView', array(
                                        'dataProvider' => $dataProvider,
                                        'itemView' => '_viewTableByOrders',
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
//                                busUlitity::dataEmptyMessage($dataProvider);
                                ?>
                                <div id="mypage" style="text-align: center;padding-bottom: 24px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
