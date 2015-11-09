<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_order_report").addClass("Active");');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/timepicker.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.js');

Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.zh_cn.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/highcharts.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/exporting.js');

Yii::app()->clientScript->registerScript('begintime', "jQuery('#beginDate').datepicker({'dateFormat':'yy-mm-dd','showOn':'focus','value':'','tabularLevel':null});");
Yii::app()->clientScript->registerScript('endtime', "jQuery('#endDate').datepicker({'dateFormat':'yy-mm-dd','showOn':'focus','value':'','tabularLevel':null});");
?>
<script type="text/javascript">
    function createChart(divId, title, x_report_arr, y_title_left, column_data, line_one_name, line_one_arr, line_two_name, line_two_arr) {
        $('#' + divId).highcharts({
            chart: {
                zoomType: 'xy'
            },
            credits: {
                enabled: true,
                text: '大菜谱提供'
            },
            title: {
                text: title,
                style: {
                    color: '#4572a7',
                }
            },
            xAxis: {
                categories: x_report_arr,
                labels: {rotation: -45,
                    align: 'right'
                }
            },
            yAxis: [{// Primary yAxis
                    labels: {
                        formatter: function() {
                            return this.value;
                        },
                        style: {
                            color: '#666666'
                        }
                    },
                    title: {
                        text: '订单数量',
                        style: {
                            color: '#666666'
                        }
                    },
                    min: 0,
                    opposite: true,
//                    tickInterval: 2,
                    allowDecimals: false

                }, {// Secondary yAxis
                    gridLineWidth: 0,
                    title: {
                        text: y_title_left,
                        style: {
                            color: '#4572A7'
                        }
                    },
                    labels: {
                        formatter: function() {
                            return this.value + ' 元';
                        },
                        style: {
                            color: '#4572A7'
                        }
                    },
                    allowDecimals: false,
                    min: 0,
//                    max: 700, //如果不设置最大值，所有数据为0时，报表会显示一条横线在中央，
                    //如果设置，那么一旦有超过max的数据就不会显示更高的柱状图了。
//                    opposite: true,
//                    tickInterval: 1
                }, {// Tertiary yAxis
                    gridLineWidth: 0,
                    title: {
                        text: '',
                        style: {
                            color: '#AA4643'
                        }
                    },
                    labels: {
                        formatter: function() {
//                            return this.value + ' 元';
                        },
                    },
                    allowDecimals: false,
                    min: 0,
                    opposite: true,
//                    tickInterval: 2
                }],
            tooltip: {
                shared: true
            },
            series: [{
                    name: y_title_left,
                    color: '#AA4643',
//                    type: 'spline',
                    yAxis: 1,
                    data: column_data,
                    tooltip: {
                        valueSuffix: ' 元'
                    },
                    zIndex: 100,
                }, {
                    name: line_one_name,
                    type: 'column',
                    color: '#2f7ed8',
                    yAxis: 2,
                    data: line_one_arr,
                    marker: {
                        enabled: false
                    },
                    zIndex: 50,
                }, {
                    name: line_two_name,
                    color: '#8bbc21',
                    type: 'column',
                    data: line_two_arr,
                    marker: {
                        enabled: false
                    },
                    zIndex: 50,
                }]
        });
    }

    $(function() {
        createChart('report_order_takeout', '外卖订单统计', [<?php echo $x_report_takeout; ?>], '外卖总金额', [<?php echo $turnove_takeout_sum; ?>],
                '外卖下单数', [<?php echo $create_order_takeout_count; ?>], '外卖接单数', [<?php echo $effective_order_takeout_count; ?>]);
        createChart('report_order_table', '桌台订单统计', [<?php echo $x_report_takeout; ?>], '订台总金额', [<?php echo $turnove_table_sum; ?>],
                '桌台下单数', [<?php echo $create_order_table_count; ?>], '桌台接单数', [<?php echo $effective_order_table_count; ?>]);
        createChart('report_order_hall', '堂内点菜订单统计', [<?php echo $x_report_takeout; ?>], '堂内点餐总金额', [<?php echo $turnove_hall_sum; ?>],
                '堂内点餐下单数', [<?php echo $create_order_hall_count; ?>], '堂内点餐接单数', [<?php echo $effective_order_hall_count; ?>]);

    });
</script>

<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>订单统计</span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="SearchArea">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'orderReport-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="ItemLeft">
                    <a href="orderReport?sort=today">今天</a>
                    <a href="orderReport?sort=yesterday">昨天</a>
                    <a href="orderReport?sort=week">最近7天</a>
                    <a href="orderReport?sort=month">最近30天</a>
                </div>
                <div class="ItemLeft">
                    <?php echo CHtml::textField('beginDate', $beginDate, array('readonly' => 'readonly')); ?>
                    --
                    <?php echo CHtml::textField('endDate', $endDate, array('readonly' => 'readonly')); ?>
                </div>
                <div class="ItemRight">
                    <?php echo CHtml::submitButton('查询', array('onclick' => 'return validatorDate("beginDate","endDate",true,"起始时间需要早于结束时间");', 'class' => 'Btn_1')); ?>
                </div>
                <?php $this->endWidget(); ?>
                <div style="clear: both"></div>
            </div>

            <div class="BlockArea_3">
                <div id='report_order_takeout'style="max-width: 812px;" ></div>
                <div id='report_order_table' style="margin-top: 10px; max-width: 812px;"></div>
                <div id='report_order_hall' style="margin-top: 10px; max-width: 812px;"></div>
                <div style="margin-top: 10px;width: 100%;"></div>
            </div>
        </div>
    </div>
</div>
