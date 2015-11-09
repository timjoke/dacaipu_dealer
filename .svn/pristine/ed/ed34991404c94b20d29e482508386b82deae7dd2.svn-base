<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_order_history").addClass("Active");');
//Yii::app()->clientScript->registerScript('loadorders', 'loadOrders();');
Yii::app()->clientScript->registerScript('url', 'url = " ' . Yii::app()->request->hostInfo . '/'
        . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/";');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/timepicker.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.zh_cn.js');
Yii::app()->clientScript->registerScript('starttime', "jQuery('#OrdersHistorySearch_start_time').datetimepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
Yii::app()->clientScript->registerScript('endtime', "jQuery('#OrdersHistorySearch_end_time').datetimepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm tt','showOn':'focus','showSecond':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
?>

<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>历史订单查询</span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
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
                    <span class="searchTitle">下单时间：</span><?php echo $form->textField($search, 'start_time', array('style' => 'width:120px', 'readonly' => 'readonly')); ?>--
                    <?php echo $form->textField($search, 'end_time', array('style' => 'width:120px', 'readonly' => 'readonly')); ?>
                </div>
                <div class="ItemLeft">
                    <span class="searchTitle">订单编号：</span>
                    <?php echo $form->textField($search, 'order_id', array('class' => 'SearchInput_1', 'style' => 'width: 60px;', 'maxlength' => 8,)); ?>
                </div>
                <div class="ItemLeft">
                    <span class="searchTitle">联系电话：</span><?php echo $form->textField($search, 'contact_tel', array('class' => 'SearchInput_1', 'maxlength' => 11)); ?>  
                </div>
                <div class="ItemLeft">
                    <span class="searchTitle">是否使用优惠券：</span>
                    <?php
                    $has_coupon_list = array('1'=>'使用','2'=>'未使用','3'=>'全部');
                    ?>
                    <?php echo $form->radioButtonList($search, 'has_coupon', $has_coupon_list, array('separator' => ' ')) ?>
                </div>
                <div class="ItemRight">
                    <?php
                    echo CHtml::submitButton('查询'
                            , array('onclick' => 'return validatorDate("OrdersHistorySearch_start_time","OrdersHistorySearch_end_time",false,"起始时间需要早于结束时间");'
                        , 'class' => 'Btn_1'));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
                <div style="clear: both"></div>
            </div>
            <div class="BlockArea_1">
                <table id="history_orders" cellpadding="0" cellspacing="0" border="0" width="100%" class="Table_1">
                    <tr height="31">
                        <th width="110"><b>订单编号</b></th>
                        <th width="120"><b>订单内容</b></th>
                        <th width="120"><b>地址/桌台</b></th>
                        <th width="70"><b>菜品数量</b></th>
                        <th width="90"><b>总金额</b></th>
                        <th width="100"><b>接收订单时间</b></th>
                        <th width="90"><b>预定就餐时间</b></th>
                        <th width="75"><b>当前状态</b></th>
                        <th width="60"><b>优惠券NO</b></th>
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
