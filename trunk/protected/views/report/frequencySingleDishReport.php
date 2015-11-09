<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_frequency_report").addClass("Active");');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/timepicker.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.zh_cn.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/highcharts.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/exporting.js');
Yii::app()->clientScript->registerScript('begintime', "jQuery('#beginDate').datepicker({'dateFormat':'yy-mm-dd','showOn':'focus','value':'','tabularLevel':null});");
Yii::app()->clientScript->registerScript('endtime', "jQuery('#endDate').datepicker({'dateFormat':'yy-mm-dd','showOn':'focus','value':'','tabularLevel':null});");
?>
<script type="text/javascript">
    $(function() {
        $('#canvasDiv').highcharts({
            chart: {
                zoomType: 'xy'
            },
            credits: {
                enabled: true,
                text: '大菜谱提供'
            },
            title: {
                text: ''
            },
            xAxis: [{
                    categories: [<?php echo $x_report; ?>],
                    labels: {rotation: -45,
                        align: 'right'
                    }
                }],
            yAxis: [{// Primary yAxis
                    labels: {
                        style: {
                            color: '#89A54E'
                        }
                    },
                    title: {
                        text: '',
                        style: {
                            color: '#89A54E'
                        }
                    },
                    min: 0,
//                    tickInterval: 1
                }],
            tooltip: {
                shared: true
            },
            legend: {
                enabled: false,
            },
            series: [{
                    name: '热度',
                    color: '#89A54E',
                    type: 'spline',
                    data: [<?php echo $data; ?>]
                }]
        });
    });

</script>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>菜品热度--<?php echo $dish_name; ?></span></h2>
        <div class="ContArea">
            <div class="Bg"></div>
            <div class="SearchArea">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'frequencySingleDishReport-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="ItemLeft">
                    <a href=<?php echo Yii::app()->request->hostInfo . '/report/frequencySingleDishReport?dishName=' . $_GET['dishName'] . '&sort=today'; ?>>今天</a>
                    <a href=<?php echo Yii::app()->request->hostInfo . '/report/frequencySingleDishReport?dishName=' . $_GET['dishName'] . '&sort=yesterday'; ?>>昨天</a>
                    <a href=<?php echo Yii::app()->request->hostInfo . '/report/frequencySingleDishReport?dishName=' . $_GET['dishName'] . '&sort=week'; ?>>最近7天</a>
                    <a href=<?php echo Yii::app()->request->hostInfo . '/report/frequencySingleDishReport?dishName=' . $_GET['dishName'] . '&sort=month'; ?>>最近30天</a>
                </div>
                <div class="ItemLeft">
                    <?php echo CHtml::textField('beginDate', $beginDate, array('readonly' => 'readonly')); ?>
                    --
                    <?php echo CHtml::textField('endDate', $endDate, array('readonly' => 'readonly')); ?>
                </div>
                <div class="ItemLeft">
                    <input id="dish_name" name='dish_name' value="<?php echo $dish_name; ?>" type="hidden" />
                </div>
                <div class="ItemLeft">
                    <?php echo CHtml::submitButton('查询', array('onclick' => 'return validatorDate("beginDate","endDate",true,"起始时间需要早于结束时间");', 'class' => 'Btn_1')); ?>
                </div>
                <?php $this->endWidget(); ?>
                <div style="clear: both"></div>
            </div>
            <div class="BlockArea_3">
                <div id='canvasDiv' style="max-width: 812px;"></div>
            </div>
        </div>
    </div>
</div>
