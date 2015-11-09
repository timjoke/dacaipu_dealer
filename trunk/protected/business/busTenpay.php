<?php

require ("tenpay/ResponseHandler.class.php");
require ("tenpay/RequestHandler.class.php");
require ("tenpay/client/ClientResponseHandler.class.php");
require ("tenpay/client/TenpayHttpClient.class.php");
require ("tenpay/function.php");

/**
 * 支付业务
 *
 * @作者 roy
 */
class busTenpay
{

    public function __construct()
    {
        $this->spname = "大菜谱网";
        $this->partner = Yii::app()->params['tenpay_partner'];  //财付通商户号
        $this->key = Yii::app()->params['tenpay_key'];  //财付通密钥
        $this->return_url = Yii::app()->params['tenpay_return_url'];      //显示支付结果页面,*替换成payReturnUrl.php所在路径
        $this->notify_url = Yii::app()->params['tenpay_notify_url']; //支付完成后的回调处理页面,*替换成payNotifyUrl.php所在路径
        $this->order_prefix = Yii::app()->params['tenpay_order_prefix'];
    }

    public function get_request_handler()
    {
        $spname = $this->spname;
        $partner = $this->partner;  //财付通商户号
        $key = $this->key;          //财付通密钥

        $return_url = $this->return_url;
        $notify_url = $this->notify_url;


        /* 获取提交的订单号 */
        $out_trade_no = $this->order_prefix . $_REQUEST["order_no"];
        /* 获取提交的商品名称 */
        $product_name = $_REQUEST["product_name"];
        /* 获取提交的商品价格 */
        $order_price = $_REQUEST["order_price"];
        /* 获取提交的备注信息 */
        $remarkexplain = $_REQUEST["remarkexplain"];
        /* 支付方式 1:及时到账；2：中介担保；3：后台选择 */
        $trade_mode = 1;

        $strDate = date("Ymd");
        $strTime = date("His");

        /* 商品价格（包含运费），以分为单位 */
        $total_fee = $order_price * 100;

        /* 商品名称 */
        $desc = "商品：" . $product_name . ",备注:" . $remarkexplain;

        /* 创建支付请求对象 */
        $reqHandler = new RequestHandler();
        $reqHandler->init();
        $reqHandler->setKey($key);
        $reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");

        //----------------------------------------
        //设置支付参数 
        //----------------------------------------
        $reqHandler->setParameter("partner", $partner);
        $reqHandler->setParameter("out_trade_no", $out_trade_no);
        $reqHandler->setParameter("total_fee", $total_fee);  //总金额
        $reqHandler->setParameter("return_url", $return_url);
        $reqHandler->setParameter("notify_url", $notify_url);
        $reqHandler->setParameter("body", $desc);
        $reqHandler->setParameter("bank_type", "DEFAULT");     //银行类型，默认为财付通
        //用户ip
        $reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']); //客户端IP
        $reqHandler->setParameter("fee_type", "1");               //币种
        $reqHandler->setParameter("subject", $product_name);          //商品名称，（中介交易时必填）
        //系统可选参数
        $reqHandler->setParameter("sign_type", "MD5");       //签名方式，默认为MD5，可选RSA
        $reqHandler->setParameter("service_version", "1.0");    //接口版本号
        $reqHandler->setParameter("input_charset", "utf-8");      //字符集
        $reqHandler->setParameter("sign_key_index", "1");       //密钥序号
        //业务可选参数
        $reqHandler->setParameter("attach", "");                //附件数据，原样返回就可以了
        $reqHandler->setParameter("product_fee", "");           //商品费用
        $reqHandler->setParameter("transport_fee", "0");         //物流费用
        $reqHandler->setParameter("time_start", date("YmdHis"));  //订单生成时间
        $reqHandler->setParameter("time_expire", "");             //订单失效时间
        $reqHandler->setParameter("buyer_id", "");                //买方财付通帐号
        $reqHandler->setParameter("goods_tag", "");               //商品标记
        $reqHandler->setParameter("trade_mode", $trade_mode);              //交易模式（1.即时到帐模式，2.中介担保模式，3.后台选择（卖家进入支付中心列表选择））
        $reqHandler->setParameter("transport_desc", "");              //物流说明
        $reqHandler->setParameter("trans_type", "1");              //交易类型
        $reqHandler->setParameter("agentid", "");                  //平台ID
        $reqHandler->setParameter("agent_type", "");               //代理模式（0.无代理，1.表示卡易售模式，2.表示网店模式）
        $reqHandler->setParameter("seller_id", $this->partner);                //卖家的商户号


        return $reqHandler;
    }

    public function dealer_bill_notice()
    {
        /* 创建支付应答对象 */
        $resHandler = new ResponseHandler();
        $resHandler->setKey($this->key);

        //判断签名
        if ($resHandler->isTenpaySign())
        {
            //通知id
            $notify_id = $resHandler->getParameter("notify_id");

            //通过通知ID查询，确保通知来至财付通
            //创建查询请求
            $queryReq = new RequestHandler();
            $queryReq->init();
            $queryReq->setKey($this->key);
            $queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
            $queryReq->setParameter("partner", $this->partner);
            $queryReq->setParameter("notify_id", $notify_id);

            //通信对象
            $httpClient = new TenpayHttpClient();
            $httpClient->setTimeOut(5);
            //设置请求内容
            $httpClient->setReqContent($queryReq->getRequestURL());

            //后台调用
            if ($httpClient->call())
            {
                //设置结果参数
                $queryRes = new ClientResponseHandler();
                $queryRes->setContent($httpClient->getResContent());
                $queryRes->setKey($this->key);

                if ($resHandler->getParameter("trade_mode") == "1")
                {
                    //判断签名及结果（即时到帐）
                    //只有签名正确,retcode为0，trade_state为0才是支付成功
                    if ($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $resHandler->getParameter("trade_state") == "0")
                    {
                        Yii::log("即时到帐验签ID成功", CLogger::LEVEL_INFO, 'tenpay');
                        //取结果参数做业务处理
                        $out_trade_no = str_replace($this->order_prefix,'',$resHandler->getParameter("out_trade_no"));
                        
                        //财付通订单号
                        $transaction_id = $resHandler->getParameter("transaction_id");
                        //金额,以分为单位
                        $total_fee = $resHandler->getParameter("total_fee");
                        
                        //金额，换算成元
                        $total_fee = $total_fee / 100;
                        
                        //如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
                        $discount = $resHandler->getParameter("discount");

                        //------------------------------
                        //处理业务开始
                        //------------------------------
                        $db = Yii::app()->db;
                        $trans = $db->beginTransaction();

                        //验证账单
                        $dealerBill = DealerBill::model()->findByPk($out_trade_no);
                        if (!isset($dealerBill))
                        {
                            Yii::log("即使到账后台回调失败：订单号不存在。相关信息：" . $out_trade_no, CLogger::LEVEL_INFO, 'tenpay');
                            echo 'fail';
                            $trans->rollback();
                            Yii::app()->end();
                        }

                        if ($dealerBill->fee != $total_fee)
                        {
                            Yii::log("即使到账后台回调失败：金额错误！相关信息：" . $out_trade_no, CLogger::LEVEL_INFO, 'tenpay');
                            echo 'fail';
                            $trans->rollback();
                            Yii::app()->end();
                        }

                        if ($dealerBill->is_pay == 1)
                        {
                            Yii::log("即使到账后台回调失败：该订单已支付.", CLogger::LEVEL_INFO, 'tenpay');
                            echo 'fail';
                            $trans->rollback();
                            Yii::app()->end();
                        }

                        $db->createCommand()->insert('dealer_bill_pay',array(
                            'dealer_bill_id' => $dealerBill->dealer_bill_id,
                            'pay_way' => PAY_WAY_TENPAY,
                            'transaction_id' => $transaction_id,
                            'total_fee' => $total_fee,
                            'discount' => $discount,
                            'customer_id' => 0,
                            'pay_time' => date('Y-m-d H:i:s',time()),
                        ));

                        
                        $dealerBill->is_pay = 1;
                        $dealerBill->update();
                        

                        $trans->commit();


                        //处理数据库逻辑
                        //注意交易单不要重复处理
                        //注意判断返回金额
                        //------------------------------
                        //处理业务完毕
                        //------------------------------
                        Yii::log("即时到帐后台回调成功", CLogger::LEVEL_INFO, 'tenpay');
                        echo "success";
                    }
                    else
                    {
                        //错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
                        //echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->                         getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
                        Yii::log("即时到帐后台回调失败", CLogger::LEVEL_INFO, 'tenpay');
                        echo "fail";
                    }
                }
                else
                {
                    Yii::log("本次回调失败，只支持及时到账交易，本次交易非实时到账。", CLogger::LEVEL_INFO, 'tenpay');
                    echo 'fail';
                }
            }
            else
            {
                //通信失败
                echo "fail";
                //后台调用通信失败,写日志，方便定位问题
                echo "<br>call err:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
                Yii::log("本次回调失败:"."call err:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() , CLogger::LEVEL_INFO, 'tenpay');
            }
        }
        else
        {
            echo "<br/>" . "认证签名失败" . "<br/>";
            echo $resHandler->getDebugInfo() . "<br>";
        }
    }

    public function dealer_bill_return()
    {
        $result = new OperResult();
        /* 创建支付应答对象 */
        $resHandler = new ResponseHandler();
        $resHandler->setKey($this->key);

        //判断签名
        if ($resHandler->isTenpaySign())
        {
            //通知id
            $notify_id = $resHandler->getParameter("notify_id");
            //商户订单号
            $out_trade_no = str_replace($this->order_prefix,'',$resHandler->getParameter("out_trade_no"));
            //财付通订单号
            $transaction_id = $resHandler->getParameter("transaction_id");
            //金额,以分为单位
            $total_fee = $resHandler->getParameter("total_fee");
            //如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
            $discount = $resHandler->getParameter("discount");
            //支付结果
            $trade_state = $resHandler->getParameter("trade_state");
            //交易模式,1即时到账
            $trade_mode = $resHandler->getParameter("trade_mode");


            if ("1" == $trade_mode)
            {
                if ("0" == $trade_state)
                {
                    $result->msg = "即时到帐支付成功";
                }
                else
                {
                    //当做不成功处理
                    $result->msg = "即时到帐支付失败";
                }
            }
        }
        else
        {
            $result->msg = "认证签名失败，请联系管理员";
            Yii::log("支付返回失败：认证签名失败.".$resHandler->getDebugInfo(), CLogger::LEVEL_INFO, 'tenpay');
        }
        
        return $result;
    }

}
