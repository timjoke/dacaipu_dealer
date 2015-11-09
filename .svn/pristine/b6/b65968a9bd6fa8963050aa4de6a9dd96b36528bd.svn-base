<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_coupon").addClass("Active");');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.zh_cn.js');
Yii::app()->clientScript->registerScript('starttime', "jQuery('#CouponSearch_start_time').datetimepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm:ss','showOn':'focus','showSecond':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
Yii::app()->clientScript->registerScript('endtime', "jQuery('#CouponSearch_end_time').datetimepicker({'dateFormat':'yy-mm-dd','timeFormat':'hh:mm:ss','showOn':'focus','showSecond':false,'value':'','tabularLevel':null,'hourGrid':4,'minuteGrid':10});");
?>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>优惠券</span>
            <em class="Btn">
                <a href='#' onclick="openDialogAuto('/coupon/create', 'auto', 'auto', '生成优惠券');
                        return false;">
                    <strong>+</strong>生成优惠券
                </a>
            </em>
            <em class="Btn">
                <a href="/coupon/outputExcel">Excel导出优惠券</a>
            </em>
        </h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="SearchArea">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'coupon-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="ItemLeft">
                    <span class="searchTitle">开始时间：</span><?php echo $form->textField($search, 'start_time', array('style' => 'width:120px', 'readonly' => 'readonly')); ?>--
                    <?php echo $form->textField($search, 'end_time', array('style' => 'width:120px', 'readonly' => 'readonly')); ?>
                </div>
                <div class="ItemLeft">
                    <span class="searchTitle">优惠券NO：</span><?php echo $form->textField($search, 'coupon_no', array('class' => 'SearchInput_1')); ?>
                </div>
                <div class="ItemLeft">
                    <span class="searchTitle">状态：</span>
                    <?php
                    $coupon_status_list = BusCoupon::$COUPON_STATUS;
                    $coupon_status_list[3] = '全部';
                    ?>
                    <?php echo $form->radioButtonList($search, 'coupon_status', $coupon_status_list, array('separator' => ' ')) ?>
                </div>
                <div class="ItemRight">
                    <?php echo CHtml::submitButton('查询', array('class' => 'Btn_1')); ?>
                </div>
                <?php $this->endWidget(); ?>
                <div style="clear: both"></div>
            </div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th align="center">优惠券NO</th>
                        <th align="center">金额</th>
                        <th align="center">状态</th>
                        <th align="center">开始时间</th>
                        <th align="center">结束时间</th>
                        <th align="center">使用订单号</th>
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
