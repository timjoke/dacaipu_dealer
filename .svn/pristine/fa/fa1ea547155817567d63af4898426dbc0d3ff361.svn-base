<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_my_bill").addClass("Active");');
?>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>每日订单--外卖订单--<?php echo $year_month_day; ?></span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th align="center" width="160">日期</th>
                        <th align="center" width="160">外卖总金额</th>
                        <th align="center">手续费</th>
                    </tr>
                    <?php
                    $data_takeout->setPagination(array('pageVar' => 'page'));
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $data_takeout,
                        'itemView' => '_view_my_bill_day_takeout',
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
                busUlitity::dataEmptyMessage($data_takeout);
                ?>
                <div id="mypage" style="text-align: center;padding-bottom: 24px;">

                </div>

            </div>
        </div>
    </div>
    
    <div class="ContentArea">
        <h2><span>每日订单--订台订单--<?php echo $year_month_day; ?></span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th align="center" width="160">日期</th>
                        <th align="center">手续费</th>
                    </tr>
                    <?php
                    $data_table->setPagination(array('pageVar' => 'page'));
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $data_table,
                        'itemView' => '_view_my_bill_day_table',
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
                busUlitity::dataEmptyMessage($data_table);
                ?>
                <div id="mypage" style="text-align: center;padding-bottom: 24px;">

                </div>

            </div>
        </div>
    </div>
</div>    