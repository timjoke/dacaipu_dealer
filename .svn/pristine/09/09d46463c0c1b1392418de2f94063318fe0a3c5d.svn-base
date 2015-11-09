<?php
    $c = new Controller($this);
    Yii::app()->clientScript->registerCssFile('http://union.tenpay.com/bankList/css_col4.css');
?>

<style type="text/css">
    .bank_list{width:650px;background-color: #FFFFFF;}
    input[type="text"]{width:300px;}
</style>
<script type="text/javascript">
    function form_submit()
    {
        if($('#bank_type_value').val() == '0')
        {
            alert('请选择支付银行！');
            return false;
        }
        return true;
    }
</script>
<?php echo CHtml::beginForm(); ?>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2>
            <span>付款</span>
        </h2>
        <div class="ContArea">
            
            <div class="BlockArea_4" style="background-color:#FFFFFF;padding-top:20px;">
                <table width="99%" align="center">
                    <tr>
                        <td style="width:100px">订单号：</td>
                        <td>
                            <?php echo CHTML::textField('order_no',$dealerBill->dealer_bill_id,array("readonly"=>"readonly","class"=>"Input_5"));?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>商品名称：</td>
                        <td>
                            <?php 
                                $dealer = Dealer::model()->findByPk($dealerBill->dealer_id);
                                
                                echo CHTML::textField('product_name',"大菜谱手续费",array("readonly"=>"readonly","class"=>"Input_5",));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>交易金额：</td>
                        <td>
                            <?php echo CHTML::textField('order_price',$dealerBill->fee,array("readonly"=>"readonly","class"=>"Input_5"));?>
                            元
                        </td>
                    </tr>
                    
                    <tr>
                        <td>说明：</td>
                        <td>
                            <?php 
                            
                            $name = sprintf("%s-大菜谱平台(%s - %s)手续费",
                                    $dealer->dealer_name,
                                    Carbon\Carbon::parse($dealerBill->begin_date)->format('Y年m月d日'),
                                    Carbon\Carbon::parse($dealerBill->end_date)->format('Y年m月d日'));
                            echo CHTML::textArea('remarkexplain',$name,array("readonly"=>"readonly","class"=>"Input_5","style"=>"width:300px;height:50px;","rows" => 10));?>
                        </td>
                    </tr>
                    <tr>
                        <td>支付方式：</td>
                        <td>
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="tenpayBankList" class="bank_list"></div>
                            <input type="hidden" name="bank_type_value" id="bank_type_value" value="0"/>
                        </td>
                    </tr>
                </table>
                
                <br/>
                
                <br/>
                
                <br/>
                
                <?php echo CHtml::submitButton('支付',array('onclick'=>'return form_submit();',
                    'style'=> 'width:100px;height:50px;margin-bottom:200px;margin-left:300px;')); ?>    
            </div>
            
            
            
            <script type="text/javascript">
                $.getScript("http://union.tenpay.com/bankList/bank.js");
            </script>
            
        </div>
    </div>
</div>
<?php echo CHtml::endForm();?>