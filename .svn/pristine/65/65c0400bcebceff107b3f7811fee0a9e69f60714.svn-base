<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<div class="form">
    <div class="PopWinArea">
        <div class="ContArea">
            <div class="MidArea" align="center">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'frequencyReport-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <table cellpadding="5" cellspacing="5" border="0" align="left" class="Table_1" >
                    <tr height="35">
                        <td align="right">起始日期：</td>
                        <td><?php echo $model->begin_date; ?></td>
                        <td align="right">结束日期：</td>
                        <td><?php echo $model->end_date; ?></td>
                    </tr>
                    <tr height="35">
                        <td align="right">外卖总金额：</td>
                        <td>￥<?php echo $model->takeout_paid; ?></td>
                        <td align="right">订台下单量：</td>
                        <td><?php echo $model->table_count; ?></td>
                    </tr>
                    <tr height="35">
                        <td align="right">手续费：</td>
                        <td>￥<?php echo $model->fee; ?></td>
                        <td align="right"></td>
                        <td></td>
                    </tr>
                     <tr height="35">
                        <td></td>
                        <td><?php echo CHtml::submitButton('现在支付', array('class' => 'Btn_1')); ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <input id="dealer_bill_id" name='dealer_bill_id' value="<?php echo $model->dealer_bill_id; ?>" type="hidden" />
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
        </body>
</html>