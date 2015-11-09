<?php

require_once 'carbon.php';

use Carbon\Carbon;

/**
 * 下单相关业务
 *
 * @作者 roy
 */
class busOrder
{

    /**
     * 订单状态中文名称
     * @var string 
     */
    public static $ORDER_STATUS_NAME = array(-1 => '未知', 0 => '', 1 => '待付款', 2 => '待处理', 3 => '处理中', 4 => '已拒绝',
        5 => '待派送', 6 => '待取餐', 7 => '派送中', 8 => '已完成 ', 9 => '已结束');

    /**
     * 用于手机端显示的订单状态
     * @var string
     */
    public static $ORDER_SHOW_GENERAL_STATUS_NAME = array(0 => '订单生成', 1 => '厨房制作中', 2 => '正在派送', 3 => '派送完成');
    /*_DS:电商版*/
    public static $ORDER_SHOW_GENERAL_STATUS_NAME_DS = array(0 => '订单生成', 1 => '配货中', 2 => '正在派送', 3 => '派送完成');
    /**
     * 用于手机端显示的自取订单状态
     * @var string
     */
    public static $ORDER_SHOW_STATUS_NAME_SELFTAKE = array(0 => '订单生成', 1 => '厨房制作中', 2 => '完成');
    public static $ORDER_SHOW_STATUS_NAME_SELFTAKE_DS = array(0 => '订单生成', 1 => '配货中', 2 => '完成');

    /**
     * 用于手机端显示的堂食订单状态
     * @var string
     */
    public static $ORDER_SHOW_GENERAL_STATUS_NAME_EATIN = array(0 => '订单生成', 1 => '已接受', 2 => '完成');

    /**
     * 用于手机店显示的异常订单状态
     * @var type 
     */
    public static $ORDER_SHOW_ABNORMAL_STATUS_NAME = array(0 => '订单生成', 1 => '已拒绝');
    
    public static $ORDER_SHOW_ABNORMAL_STATUS_NAME_DS = array(0 => '订单生成', 1 => '已拒绝');

    /**
     * 用于手机店显示的系统自动完成订单状态
     * @var type 
     */
    public static $ORDER_SHOW_SYSTEM_STATUS_NAME = array(0 => '订单生成', 1 => '已完成*');
    public static $ORDER_SHOW_SYSTEM_STATUS_NAME_DS = array(0 => '订单生成', 1 => '已完成*');

    /**
     * 订单类型中文名称
     * @var string 
     */
    public static $ORDER_TYPE_NAME = array('', '外卖送餐', '外卖自取', '预定桌台', '预定桌台+点菜', '堂内点餐');

    /**
     *
     * @var type 支付方式中文名称
     */
    public static $ORDER_PAY_TYPE_NAME = array('', '上门派送POS刷卡', '上门派送现金支付', '门店POS刷卡', '门店现金支付', '在线支付宝', '在线网银', '在线会员充值卡');

    /**
     * 获取商家的营业时间
     * @param type $dealer_id 商家id
     * @return array[Carbon]
     */
    public function getTakeoutTimes($dealer_id)
    {
        $service_timespans = DealerServiceTime::model()->findAllByAttributes(array('dealer_id' => $dealer_id));
        $service_times = array();
        $now = Carbon::now();

        foreach ($service_timespans as $ts)
        {
            $start_time = Carbon::createFromFormat('H:i:s', $ts->st_start_time);
            $end_time = Carbon::createFromFormat('H:i:s', $ts->st_end_time);

            $sets = Setting::model()->findByAttributes(array('setting_key' => SETTING_KEY_DEALER_TAKEOUT_MIN_TIMESPAN . $dealer_id));
            if (!isset($sets))
            {
                $sets = new Setting();
                $sets->setting_key = SETTING_KEY_DEALER_TAKEOUT_MIN_TIMESPAN . $dealer_id;
                $sets->setting_value = 30;

                $sets->save();
            }

            $st = Carbon::now()->addMinutes($sets->setting_value);

            for ($index = $start_time->hour; $index <= $end_time->hour; $index++)
            {
                for ($j = 0; $j <= 60; $j+=10)
                {
                    $dt = Carbon::createFromTime($index, $j);
                    if ($dt > $st && $dt <= $end_time)
                    {
                        array_push($service_times, $dt->toDateTimeString());
                    }
                }
            }
        }

        return $service_times;
    }

    /*
     * 外卖下单
     */

    public function order_takeout($takeout)
    {
        $result = $takeout->save_order();
        if ($result->code == SUCCESS)
        {
//            $res = new OperResult();
//            $res->order_id = 123;
//            
            $this->order_status_notice($result);
        }

        return $result;
    }

    /*
     * 订台点餐
     */

    public function order_eatin($eatin)
    {
        $result = $eatin->save_order();
        if ($result->code == SUCCESS)
        {
//            $res = new OperResult();
//            $res->order_id = 123;
//            
            $this->order_status_notice($result);
        }

        return $result;
    }

    /*
     * 预定桌台
     */

    public function order_booking($eatin)
    {
        $result = $eatin->save_booking_order();
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
                        $msg = sprintf("您的订单【订单号：%s】已进入厨房,已经开始料理！", $result->order_id);
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
                        $msg = sprintf("您的订单【订单号：%s】已制作完毕，送餐员正在赶来取餐！", $result->order_id);
                    }
                    break;
                /*
                 * 等待自取
                 */
                case ORDER_STATUS_WAIT_TAKE:
                    {
                        $msg = sprintf("您的订单【订单号：%s】已制作完毕，请尽快来取餐！", $result->order_id);
                    }
                    break;
                /*
                 * 配送中
                 */
                case ORDER_STATUS_EXPRESSING:
                    {
                        $msg = sprintf("您的订单【订单号：%s】已经在派送的路上了，肚子是否已经咕咕叫了？准备大吃一顿吧！", $result->order_id);
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

                        $msg = sprintf("您的订单【订单号：%s】已进入厨房,已经开始料理,请于%s到%s自取。地址：%s,电话：%s。", $result->order_id, date("Y年m月d日 H点i分", strtotime($order->order_dinnertime)), $dealer->dealer_name, $dealer->dealer_addr, $dealer->dealer_tel);
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
            $tr = TableReservation::model()->findByAttributes(array('order_id' => $order->order_id));
            if (!isset($tr))
            {
                Yii::log('订台预订短信通知失败，预订信息不存在。订单号：' . $order->order_id);
                return;
            }
            $st = new DateTime($tr->reserv_start_time);
//            $et = new DateTime($tr->reserv_end_time);
            $table = DinnerTable::model()->findByPk($tr->table_id);

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
                        $msg = sprintf("您的订单【订单号：%s】已创建成功,正在等待店员确认！", $result->order_id);
                    }
                    break;
                /*
                 * 处理中 
                 */
                case ORDER_STATUS_PROCESSING:
                    {
                        $msg = sprintf("您已成功预订 " . $dealer->dealer_name . " 【" . $st->format('Y-m-d H:i') . '】 ' . $table->table_name . "，请准时到店就餐。【订单号：%s】 ", $result->order_id);
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
        else if ($order->order_type == ORDER_TYPE_EATIN)
        {
            
        }




        if (!empty($msg))
        {
            $bs->send($contact->contact_tel, $msg, $dealer->dealer_name);
        }

        return true;
    }

    /**
     * 新增订单状态
     * @param type $order_id 订单id
     * @param type $status_code 状态值
     * @param type $customer_id 操作人id
     * @param type $memo 备注
     */
    public function insert_order_status($order_id, $status_code, $customer_id, $memo = NULL)
    {
        $db = Yii::app()->db;
        //订单状态维护
        $db->createCommand()->insert('order_status_message', array(
            'order_id' => $order_id,
            'create_time' => date('Y-m-d H:i:s', time()),
            'memo' => $memo,
            'cur_order_status' => $status_code,
            'modifier_id' => $customer_id
        ));
    }

    /**
     * 获取前段用户显示使用的状态代码
     * @param type $statusCode 订单实际的状态代码
     */
    public function getUserStatusCode($statusCode)
    {
        switch ($statusCode)
        {
            case ORDER_STATUS_WAIT_PROCESS:
                {
                    return 0;
                }
                break;
            case ORDER_STATUS_PROCESSING:
            case ORDER_STATUS_WAIT_EXPRESS:
            case ORDER_STATUS_WAIT_TAKE:
            case ORDER_STATUS_WAIT_PAY:
                {
                    return 1;
                }
                break;
            case ORDER_STATUS_EXPRESSING:
                {
                    return 2;
                }
                break;
            case ORDER_STATUS_COMPLETE:
            case ORDER_STATUS_CLOSE:
                {
                    return 3;
                }
                break;
            default :
                break;
        }
    }

    /**
     * 获取前段用户显示使用的状态代码
     * @param type $statusCode 订单实际的状态代码
     */
    public function getUserStatusCodeEatin($statusCode)
    {
        switch ($statusCode)
        {
            case ORDER_STATUS_WAIT_PROCESS:
                {
                    return 0;
                }
                break;
            case ORDER_STATUS_PROCESSING:
            case ORDER_STATUS_WAIT_EXPRESS:
            case ORDER_STATUS_WAIT_TAKE:
            case ORDER_STATUS_EXPRESSING:
            case ORDER_STATUS_WAIT_PAY:
                {
                    return 1;
                }
                break;
            case ORDER_STATUS_COMPLETE:
            case ORDER_STATUS_CLOSE:
                {
                    return 2;
                }
                break;
            default :
                break;
        }
    }

    /**
     * 获取前段用户显示使用的状态代码_异常终止的情况
     * @param type $statusCode
     * @return int
     */
    public function getUserStatusCode_abnormal($statusCode)
    {
        switch ($statusCode)
        {
            case ORDER_STATUS_WAIT_PROCESS:
                return 0;
            case ORDER_STATUS_DENIED:
                return 1;
        }
    }

    /**
     * 获取用于前台用户显示的状态时间列表
     * @param type $orderid 订单编号
     * @return int
     */
    public function getStatusTime($orderid)
    {
        $orderStatusMessageList = OrderStatusMessage::model()->findAllByAttributes(array('order_id' => $orderid));
        $statusMessageTime = array();
        $statusMessageTime_0 = array();
        $statusMessageTime_1 = array();
        $statusMessageTime_2 = array();
        $statusMessageTime_3 = array();

        foreach ($orderStatusMessageList as $value)
        {
            switch ($value->cur_order_status)
            {
                case ORDER_STATUS_WAIT_PROCESS:
                    {
                        $statusMessageTime_0[] = $value->create_time;
                        break;
                    }

                case ORDER_STATUS_DENIED:
                case ORDER_STATUS_PROCESSING:
                case ORDER_STATUS_WAIT_EXPRESS:
                case ORDER_STATUS_WAIT_TAKE:
                case ORDER_STATUS_WAIT_PAY:
                    {
                        $statusMessageTime_1[] = $value->create_time;
                        break;
                    }
                case ORDER_STATUS_EXPRESSING:
                    {
                        $statusMessageTime_2[] = $value->create_time;
                        break;
                    }
                case ORDER_STATUS_COMPLETE:
                case ORDER_STATUS_CLOSE:
                    {
                        $statusMessageTime_3[] = $value->create_time;
                        break;
                    }
                default :
                    return 0;
            }
        }
        $statusMessageTime[] = $this->getMintime($statusMessageTime_0);
        $statusMessageTime[] = $this->getMintime($statusMessageTime_1);
        if (!empty($statusMessageTime_2))
        {
            $statusMessageTime[] = $this->getMintime($statusMessageTime_2);
        }
        $statusMessageTime[] = $this->getMintime($statusMessageTime_3);

        return $statusMessageTime;
    }

    private function getMintime($timeArr)
    {
        if (count($timeArr) == 0)
        {
            return '';
        }
        else
        {
            return min($timeArr);
        }
    }

    /**
     * 计算菜品总金额，用于订单详情页面
     * @param CActiveDataProvider $order_dish_flash_list 菜品列表
     * @param bool $is_package_fee 是否计算打包费
     * @return int 菜品总金额
     */
    public function countDishAmount($order_dish_flash_list, $is_package_fee)
    {
        $dishAmount = 0;
        $count = $order_dish_flash_list->itemCount;
        for ($i = 0; $i < $count; $i++)
        {
            $temp_price = $order_dish_flash_list->data[$i]->dish_price;
            if ($is_package_fee === TRUE)
            {
                $temp_price = $temp_price + $order_dish_flash_list->data[$i]->dish_package_fee;
            }
            $dishAmount = $dishAmount + ($order_dish_flash_list->data[$i]->order_count * $temp_price);
        }
        return $dishAmount;
    }

    /**
     * 如果商家开启订单短信通知 ，给商家发送新订单通知
     * @param type $dealer
     */
    protected function sendNewMsgToDealer($dealer, $order, $contact)
    {
        //如果商家开启订单短信通知，给商家发送短信
        $bs = new busSms();
        $busDealer = new busDealer();

        $customer = Customer::model()->getDealerCustomer($dealer->dealer_id);
        $dishs = OrderDishFlash::model()->getDishsByOrdersid($order->order_id);

        if ($order->order_type == ORDER_TYPE_TAKEOUT)
        {
            $dealer_msg = "订单号：" . $order->order_id . "  联系人：" . $contact->contact_name . "（地址：" . $contact->contact_addr . "；手机号：" . $contact->contact_tel . '）' . ' ';
        }
        elseif ($order->order_type == ORDER_TYPE_TAKEOUT_SELFTAKE)
        {
            $dealer_msg = "订单号：" . $order->order_id . "  联系人：" . $contact->contact_name . "（手机号：" . $contact->contact_tel . '）' . ' ';
        }

        foreach ($dishs->rawData as $key => $value)
        {
            $dealer_msg.=$value["dish_name"] . "x" . $value["order_count"] . '份， ';
        }
        $dealer_msg.="合计¥" . busUlitity::formatMoney($order->order_paid) . "元，";
        $dealer_msg.="就餐时间：" . date("Y年m月d日 H时i分", strtotime($order->order_dinnertime));

        if ($busDealer->get_send_message_accepted_order($dealer->dealer_id) == 1)
        {
            $bs->send($customer->customer_mobile, $dealer_msg, '大菜谱微信餐厅');
        }

        //短信打印机，出单
        if (false)
        {
            //订单基本信息
            $mobile = '13601200601';
            $split = '%%============================';
            $sms = '###'.$dealer->dealer_name;
            $sms .= "$split";
            $sms .= "%%联系人：$contact->contact_name";
            $sms .= "%%手机号：$contact->contact_tel";
            $sms .= "%%就餐时间：" . date("m月d日H时i分", strtotime($order->order_dinnertime));
            if ($order->order_type == ORDER_TYPE_TAKEOUT)
            {
                $sms .= "%%地址：$contact->contact_addr";
            }

            $sms .= $split;
            $sms .= '%%菜品列表：';

            //菜品列表
            foreach ($dishs->rawData as $key => $value)
            {
                $price = busUlitity::formatMoney($value['dish_price']);
                if ($order->order_type == ORDER_TYPE_TAKEOUT || $order->order_type == ORDER_TYPE_TAKEOUT_SELFTAKE)
                {
                    $price = busUlitity::formatMoney($value['dish_price'] + $value['dish_package_fee']);
                }
                $sms .= '%%' . $value['dish_name'] . ' ¥' . $price . ' x' . $value['order_count'];
            }
            $sms .= '%%配送费¥' . busUlitity::formatMoney($dealer->dealer_express_fee, 2) . '元';
            //折扣
            $order_discounts = OrderDiscount::model()->findAllByAttributes(array('order_id' => $order->order_id));
            if (isset($order_discounts))
            {
                foreach ($order_discounts as $item)
                {
                    $sms .= $item->discount_name . '，折扣金额：-￥' . busUlitity::formatMoney($item->discount_money_value) . '元';
                }
            }
            
            $sms .= $split;
            $sms .= "%%折后小计：$order->order_paid";
            $sms .= $split;
            $sms .= "%%订单来自大菜谱微餐厅(支持电话：4006-766-917)";



            $bs->sendSmsOrder($mobile, $sms);
            //$bs->sendSmsOrder('18662095583', $sms);

            Orders::model()->updateStatus($order->order_id, ORDER_STATUS_PROCESSING);
            $this->insert_order_status($order->order_id, ORDER_STATUS_PROCESSING, -1, '短信打印,系统自动接单');

            Yii::log('订单' . $order->order_id . '短信打印接单成功。');
        }
    }

}
