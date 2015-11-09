<?php

require_once 'carbon.php';

use Carbon\Carbon;

/**
 * 电商下单相关业务
 * @作者 roy
 */
class busOrderDS extends busOrder
{
    /*
     * 外卖下单
     */

    public function order_takeout($takeout)
    {
        
        $result = $takeout->save_order();
        if ($result->code == SUCCESS)
        {
            $this->order_status_notice($result);
        }

        return $result;
    }
    
    /**
     * 
     * @param type $result
     * $result->order_id 订单id；
     * $result->reason 订单拒绝原因；
     * @return type
     */
    public function order_status_notice($result)
    {
        $bs = new busSms();
        $order = Orders::model()->findByPk($result->order_id);
        $dealer = Dealer::model()->findByPk($order->dealer_id);

        if (!isset($order))
        {
            Yii::log('订单状态通知失败：订单不存在。订单号:' . $result->order_id);
            return false;
        }
        $order_status = $order->order_status;
        $contact = Contact::model()->findByPk($order->contact_id);

        $msg = '';
        if ($order->order_type == ORDER_TYPE_TAKEOUT)
        {
            switch ($order_status)
            {
                /*
                 * 等待付款
                 */
                case ORDER_STATUS_WAIT_PAY:
                    {
                        
                    }
                    break;
                /*
                 * 等待处理
                 */
                case ORDER_STATUS_WAIT_PROCESS:
                    {
                        //如果商家开启订单短信通知，给商家发送短信
                        $this->sendNewMsgToDealer($dealer, $order, $contact);
//                        $msg = sprintf("您的订单【订单号：%s】已创建成功,正在紧张挑选食材哦！", $result->order_id);
                    }
                    break;
                /*
                 * 处理中 
                 */
                case ORDER_STATUS_PROCESSING:
                    {
                        $msg = sprintf("您的订单【订单号：%s】已开始备货！", $result->order_id);
                    }
                    break;
                /*
                 * 已拒绝
                 */
                case ORDER_STATUS_DENIED:
                    {
                        $msg = sprintf("非常抱歉，您的订单【订单号：%s】被店家拒绝了,拒绝原因是 %s", $result->order_id, $result->reason);
                    }
                    break;
                /*
                 * 等待配送
                 */
                case ORDER_STATUS_WAIT_EXPRESS:
                    {
                        $msg = sprintf("您的订单【订单号：%s】备货完毕！", $result->order_id);
                    }
                    break;
                /*
                 * 等待自取
                 */
                case ORDER_STATUS_WAIT_TAKE:
                    {
                        $msg = sprintf("您的订单【订单号：%s】已备货完毕，请尽快来取货！", $result->order_id);
                    }
                    break;
                /*
                 * 配送中
                 */
                case ORDER_STATUS_EXPRESSING:
                    {
                        $msg = sprintf("您的订单【订单号：%s】已在配送途中，请准备收货！", $result->order_id);
                    }
                    break;
                /*
                 * 完成订单
                 */
                case ORDER_STATUS_COMPLETE:
                    {
                        //$msg = sprintf("您的订单【订单号：%s】已完成，感谢您的支持！", $result->order_id);
                    }
                    break;
                /*
                 * 订单结束
                 */
                case ORDER_STATUS_CLOSE:
                    {
                        
                    }
                    break;
                default:
                    break;
            }
        }
        else if ($order->order_type == ORDER_TYPE_TAKEOUT_SELFTAKE)
        {
            switch ($order_status)
            {
                /*
                 * 等待付款
                 */
                case ORDER_STATUS_WAIT_PAY:
                    {
                        
                    }
                    break;
                /*
                 * 等待处理
                 */
                case ORDER_STATUS_WAIT_PROCESS:
                    {
                        //如果商家开启订单短信通知，给商家发送短信
                        $this->sendNewMsgToDealer($dealer, $order, $contact);
//                        $msg = sprintf("您的订单【订单号：%s】已创建成功,正在紧张挑选食材哦！", $result->order_id);
                    }
                    break;
                /*
                 * 处理中 
                 */
                case ORDER_STATUS_PROCESSING:
                    {

                        $msg = sprintf("您的订单【订单号：%s】已开始备货,请于%s到%s自取。地址：%s,电话：%s。", $result->order_id, date("Y年m月d日 H点i分", strtotime($order->order_dinnertime)), $dealer->dealer_name, $dealer->dealer_addr, $dealer->dealer_tel);
                    }
                    break;
                /*
                 * 已拒绝
                 */
                case ORDER_STATUS_DENIED:
                    {
                        $msg = sprintf("非常抱歉，您的订单【订单号：%s】被店家拒绝了,拒绝原因是 %s", $result->order_id, $result->reason);
                    }
                    break;
                /*
                 * 完成订单
                 */
                case ORDER_STATUS_COMPLETE:
                    {
                        //$msg = sprintf("您的订单【订单号：%s】已完成，感谢您的支持！", $result->order_id);
                    }
                    break;
                /*
                 * 订单结束
                 */
                case ORDER_STATUS_CLOSE:
                    {
                        
                    }
                    break;
                default:
                    break;
            }
        }
        else if ($order->order_type == ORDER_TYPE_SUB_TABLE)
        {
            
        }
        else if ($order->order_type == ORDER_TYPE_SUB_TALE_DISH)
        {
        }
        else if ($order->order_type == ORDER_TYPE_EATIN)
        {
            
        }




        if (!empty($msg))
        {
            $bs->send($contact->contact_tel, $msg, $dealer->dealer_name);
        }

        return true;
    }

    

}
