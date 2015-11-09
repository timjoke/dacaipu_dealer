<?php
Yii::app()->clientScript->registerScript('left_script', '$("#li_discountCode").addClass("Active");');
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/page.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/page.js');
?>
<script type="text/javascript">
    url = "<?php echo Yii::app()->request->hostInfo . '/' . Yii::app()->controller->id . '/' . $this->getAction()->getId() . '/page/'; ?>";
    function postUsed(obj, id) {
        openConfirmDialog("你确认使用该打折码吗？", function() {
            $.post("/discountCode/used/id/" + id.toString(), "",
                    function(data, status) {
                        if (status === 'success') {
                            location.reload(location.href);
                        } else {
                            alert('系统错误，请联系管理员');
                        }
                        $('.ContentArea').unmask();
                    });
        });
        return false;
    }
</script>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>折扣码</span></h2>
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
                    <span class="searchTitle">折扣码：</span><?php echo $form->textField($search, 'discount_code', array('class' => 'SearchInput_1')); ?>
                    <?php $statuslist = array(0 => '未使用', 1 => '已使用'); ?>
                </div>
                <div class="ItemLeft">
                    <span class="searchTitle">状态：</span>
                    <?php echo $form->radioButtonList($search, 'discountCodeStatus', $statuslist, array('separator' => ' ')) ?>
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
                        <th align="center">折扣码</th>
                        <th align="center">状态</th>
                        <th align="center">使用时间</th>
                        <th align="center">创建时间</th>
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
