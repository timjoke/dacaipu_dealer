<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_ordersTable").addClass("Active");');
Yii::app()->clientScript->registerScript('url', 'url = " ' . Yii::app()->request->hostInfo . '/'
        . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/";');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/timepicker.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.zh_cn.js');
Yii::app()->clientScript->registerScript('starttime', "jQuery('#reserv_date').datepicker({'dateFormat':'yy-mm-dd','showOn':'focus','value':'','tabularLevel':null});");
?>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>桌台订单</span><em class="Btn">
                <a href="#" onclick="openDialogAuto('/tableByOrders/createDealerTableOrder', 'auto', 'auto', '创建桌台订单'); return false;" ><strong>+</strong>创建桌台订单</a></em></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="SearchArea">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'ordersTable-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <span class="searchTitle">订餐日期：</span>
                <?php echo CHtml::textField('reserv_date', $reserv_date); ?>
                <?php echo CHtml::submitButton('查询', array('class' => 'Btn_1')); ?>
                <?php $this->endWidget(); ?>

            </div>
            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th align="center">订单号</th>
                        <th align="center">预约时间</th>
                        <th align="center">预订人</th>
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
                        //  'cssFile'=>'',
                        ),
                    ));
                    ?>

                    </tr>
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