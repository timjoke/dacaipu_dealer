<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_frequency_report").addClass("Active");');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/timepicker.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.zh_cn.js');
Yii::app()->clientScript->registerScript('begintime', "jQuery('#beginDate').datepicker({'dateFormat':'yy-mm-dd','showOn':'focus','value':'','tabularLevel':null});");
Yii::app()->clientScript->registerScript('endtime', "jQuery('#endDate').datepicker({'dateFormat':'yy-mm-dd','showOn':'focus','value':'','tabularLevel':null});");
?>
<script type="text/javascript">
    function frequencySingleDish(dish_name) {
//        $("#dish_name").val(dish_name);
//$('<input />').attr('type','hidden')
//        .attr('name')
//        $('#dish_name').attr('value',dish_name);
        $("#frequencyReport-form")[0].action = 'frequencySingleDishReport?dishName=' + dish_name;
        $("#frequencyReport-form").submit();
    }
</script>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>菜品热度</span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="SearchArea">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'frequencyReport-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="ItemLeft">
                    <a href="frequencyReport?sort=today">今天</a>
                    <a href="frequencyReport?sort=yesterday">昨天</a>
                    <a href="frequencyReport?sort=week">最近7天</a>
                    <a href="frequencyReport?sort=month">最近30天</a>
                </div>
                <div class="ItemLeft">
                    <?php echo CHtml::textField('beginDate', $beginDate, array('readonly' => 'readonly')); ?>
                    --
                    <?php echo CHtml::textField('endDate', $endDate, array('readonly' => 'readonly')); ?>
                </div>
                <div class="ItemLeft">
                    <input id="dish_name" name='dish_name' type="hidden" />
                    <?php echo CHtml::submitButton('查询', array('onclick' => 'return validatorDate("beginDate","endDate",true,"起始时间需要早于结束时间");', 'class' => 'Btn_1')); ?>
                </div>
                <?php $this->endWidget(); ?>
                <div style="clear: both"></div>
            </div>

            <div class="BlockArea_3">
                <table cellpadding="5" cellspacing="0" border="0" width="97%" align="center">
                    <tr height="30" align="left">
                        <th align="center" width="160">菜品名称</th>
                        <th align="center">下单数量</th>
                        <th align="center">操作</th>
                    </tr>
                    <?php
                    $dataProvider->setPagination(array('pageVar' => 'page'));
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'viewData' => array('beginDate' => $beginDate, 'endDate' => $endDate),
                        'itemView' => '_view_frequency',
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