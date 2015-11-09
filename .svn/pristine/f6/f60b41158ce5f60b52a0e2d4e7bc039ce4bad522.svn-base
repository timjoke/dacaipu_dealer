<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_tableByOrders").addClass("Active");');
Yii::app()->clientScript->registerScript('url', 'url = " ' . Yii::app()->request->hostInfo . '/'
        . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/";');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/timepicker.css');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/zhuotai.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.js');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.ui.timepicker.zh_cn.js');
Yii::app()->clientScript->registerScript('starttime', "jQuery('#TableByOrdersSearch_reserv_date').datepicker({'dateFormat':'yy-mm-dd','showOn':'focus','value':'','tabularLevel':null});");
?>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>桌台订单</span></h2>
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
                <div class="ItemLeft">
                    <span class="searchTitle">是否吸烟：</span>
                    <?php
                    $is_smokelist = busDinnerTable::$DINNERTABLE_ISSMOKE_NAME;
                    $is_smokelist['-1'] = '请选择';
                    ksort($is_smokelist);
                    echo $form->dropDownList($TableByOrdersSearch, 'is_smoke', $is_smokelist, array('class' => 'dropdownlist'));
                    ?>
                </div>
                <div class="ItemLeft">
                    <span class="searchTitle">几人台：</span>
                    <?php
                    $sits = array(-1 => '请选择');
                    for ($i = 0; $i < count($sit_countlist); $i++) {
                        $sits[$sit_countlist[$i]] = $sit_countlist[$i];
                    }
                    echo $form->dropDownList($TableByOrdersSearch, 'sit_count', $sits, array('class' => 'dropdownlist'));
                    ?>
                </div>
                <div class="ItemLeft">
                    <span class="searchTitle">订餐日期：</span>
                    <?php echo $form->textField($TableByOrdersSearch, 'reserv_date', array('readonly' => 'readonly')); ?>
                </div>
                <div class="ItemRight">
                    <?php echo CHtml::submitButton('查询', array('class' => 'Btn_1')); ?>
                </div>
                <?php $this->endWidget(); ?>
                <div style="clear: both"></div>

            </div>

            <div class="all">

                <div class="biaoge_in">

                    <div class="line1">
                        <?php if (count($dinnertypelist) > 0 || count($dinner_tablelist) > 0) { ?>
                            <div class="row1 shang1"></div>
                        <?php } ?>
                        <?php for ($i = 0; $i < count($dinnertypelist); $i++) { ?> 
                            <div class="row2 shang2" style="background:#F2F2F2; text-shadow:none;">
                                <!-- 餐市名称 -->
                                <?php echo busTableOrderTimePoint::$DINNER_TYPE_NAME[$dinnertypelist[$i]->dinner_type]; ?>
                            </div>
                        <?php } ?>
                    </div>

                    <?php for ($i = 0; $i < count($dinner_tablelist); $i++) { ?>
                        <div class="line3">
                            <div class="row1">
                                <?php echo $dinner_tablelist[$i]->table_name; ?><!-- 桌台名称 -->
                            </div>
                            <?php
                            //内容单元格
                            for ($j = 0; $j < count($dinnertypelist); $j++) {
                                $dinnertype = $dinnertypelist[$j]->dinner_type; //餐市类型
                                $tableid = $dinner_tablelist[$i]->table_id; //桌台id
                                $orderid = ''; //订单id
                                $status = 0; //当前餐台在当前时间是否被预定，0空闲；1锁定； 2已定
                                $from_type = 0;
                                $reserv_id = 0;
                                //从订桌台数据中查找
                                foreach ($dataProvider as $item) {
                                    if ($item['dinner_type'] == $dinnertype && $item['table_id'] == $tableid) {
                                        $status = $item['reserv_status'];
                                        $orderid = $item['order_id'];
                                        $from_type = $item['from_type'];
                                        $reserv_id = $item['reserv_id'];
                                        break;
                                    }
                                }
                                $style_class_name = '';
                                $div_content = '';
                                $content_url = Yii::app()->request->hostInfo . '/';
                                $iframe_width = 0;
                                $iframe_height = 0;
                                $iframe_title = '';
                                switch ($status) {
                                    case TABLE_RESERVATION_STATUS_CANCEL://0空闲
                                        $style_class_name = 'lie3';
                                        $div_content = '空闲';
                                        $content_url.='tableByOrders/createDealerTableOrder?dinnertype=' . $dinnertype . '&tableid=' . $tableid
                                                . '&reserv_date=' . $TableByOrdersSearch->reserv_date;
                                        $iframe_width = 613;
                                        $iframe_height = 315;
                                        $iframe_title = '创建桌台订单';
                                        break;
                                    case TABLE_RESERVATION_STATUS_LOCK://1锁定
                                        $style_class_name = 'lie4';
                                        $div_content = '锁定';
                                        //锁定状态不能点
//                                        if ($from_type == TABLE_RESERVATION_FROMTYPE_DACAIPU) {
//                                            $content_url.='ordersHistory/viewTable/id/' . $orderid;
//                                            $iframe_width = 893;
//                                            $iframe_height = 600;
//                                            $iframe_title = '查看桌台订单';
//                                        } elseif ($from_type == TABLE_RESERVATION_FROMTYPE_DEALERSELF) {//暂时这种情况没用到，预留
//                                            $content_url.='tableByOrders/updateDealerTableOrder?reserv_id='
//                                                    . $reserv_id . '&table_id=' . $tableid;
//                                            $iframe_width = 893;
//                                            $iframe_height = 600;
//                                            $iframe_title = '查看桌台订单';
//                                        }

                                        break;
                                    case TABLE_RESERVATION_STATUS_SUCCESS:// 2已定
                                        $style_class_name = 'lie2';
                                        $div_content = '已定';
                                        if ($from_type == TABLE_RESERVATION_FROMTYPE_DACAIPU) {
                                            $content_url.='ordersHistory/viewTable/id/' . $orderid;
                                            $iframe_width = 'auto';
                                            $iframe_height = 'auto';
                                            $iframe_title = '查看桌台订单';
                                        } elseif ($from_type == TABLE_RESERVATION_FROMTYPE_DEALERSELF) {
                                            $content_url.='tableByOrders/updateDealerTableOrder?reserv_id='
                                                    . $reserv_id . '&table_id=' . $tableid;
                                            $iframe_width = 'auto';
                                            $iframe_height = 'auto';
                                            $iframe_title = '创建桌台订单';
                                        }
                                        break;
                                    default:
                                        break;
                                }
                                ?> 
                                <div class="row2 <?php echo $style_class_name; ?>">
                                    <a href="#" onclick="
                                    <?php if ($status != TABLE_RESERVATION_STATUS_LOCK) { ?>
                                                        openDialogAuto('<?php echo $content_url; ?>', '<?php echo $iframe_width; ?>', '<?php echo $iframe_height; ?>', '<?php echo $iframe_title; ?>');
                                    <?php } ?>
                                                    return false;"><?php echo $div_content; ?></a></div>
                                <?php } ?>
                        </div>
                    <?php } ?>


                </div>
            </div>
        </div>
    </div>
</div>