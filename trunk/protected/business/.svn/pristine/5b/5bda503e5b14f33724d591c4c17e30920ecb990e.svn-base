<?php

/**
 * 京汉置业业务类
 *
 * @作者 roy
 */
class busKingHand
{

    /**
     * 生成随机码
     * @param array $no_of_codes 数量
     * @param array $exclude_codes_array 排除
     * @param type $code_length 长度
     * @return array
     */
    function generate_promotion_code($no_of_codes, $exclude_codes_array = '', $code_length = 5)
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $promotion_codes = array(); //这个数组用来接收生成的优惠码
        for ($j = 0; $j < $no_of_codes; $j++)
        {
            $code = "";
            for ($i = 0; $i < $code_length; $i++)
            {
                $code .= $characters[mt_rand(0, strlen($characters) - 1)];
            }
            //如果生成的4位随机数不再我们定义的$promotion_codes函数里面
            if (!in_array($code, $promotion_codes))
            {
                if (is_array($exclude_codes_array))//
                {
                    if (!in_array($code, $exclude_codes_array))//排除已经使用的优惠码
                    {
                        $promotion_codes[$j] = $code; //将生成的新优惠码赋值给promotion_codes数组
                    }
                    else
                    {
                        $j--;
                    }
                }
                else
                {
                    $promotion_codes[$j] = $code; //将优惠码赋值给数组
                }
            }
            else
            {
                $j--;
            }
        }
        return $promotion_codes;
    }

    /**
     * 获得京汉大厦菜单响应消息
     * @param type $dealer_id
     * @param type $fromUser
     * @param type $weixin
     * @param type $event_key
     * @return \OperResult
     */
    public function getEventMsg($dealer_id, $fromUser, $weixin, $event_key, $static_url_base)
    {
        try
        {
            $event = empty($weixin->msg->Event) ? '' : $weixin->msg->Event;
            $result = new OperResult();
            $result->code = 0;


            //检查用户是否存在
            $customer = Customer::model()->findByAttributes(array(
                'customer_name' => $fromUser));
            $customer_id = 0;
            if (!isset($customer))
            {
                //关注乐生活用户不存在，开始创建用户
                $customer_id = Customer::model()->createWechatUser($fromUser);

//                $coupon_code = '';
//                $now = date('Y-m-d H:i:s', time());
//                $end_time = date('Y-m-d H:i:s', strtotime("+1 year"));
//                $exclude_codes_array = Coupon::model()->getAllCoupon_codeByDealer($dealer_id);
//                $coupon_code_arr = $this->generate_promotion_code(1, $exclude_codes_array);
//                if (isset($coupon_code_arr))
//                {
//                    $coupon_code = $coupon_code_arr[0];
//                }
//                //默认折扣10元
//                Coupon::model()->insertNew($dealer_id, $coupon_code, 10, $now, $end_time, $customer_id);
//                $reply = $weixin->makeText('欢迎关注，首次关注赠送10元优惠券：' . $coupon_code . ',下单使用即可消费！');
                $reply = $weixin->makeText('欢迎关注京汉大厦餐厅！');
                $weixin->reply($reply);
                $result->code = 1;

                return $result;
            }
//            else
//            {
//                if ($event == 'subscribe')
//                {
//                    $customer_id = $customer->customer_id;
//                    $coupon_code = '';
//                    $now = date('Y-m-d H:i:s', time());
//                    $end_time = date('Y-m-d H:i:s', strtotime("+1 year"));
//                    $exclude_codes_array = Coupon::model()->getAllCoupon_codeByDealer($dealer_id);
//                    $coupon_code_arr = $this->generate_promotion_code(1, $exclude_codes_array);
//                    if (isset($coupon_code_arr))
//                    {
//                        $coupon_code = $coupon_code_arr[0];
//                    }
//                    //默认折扣10元
//                    Coupon::model()->insertNew($dealer_id, $coupon_code, 10, $now, $end_time, $customer_id);
//                    $reply = $weixin->makeText('欢迎关注，首次关注赠送10元优惠券：' . $coupon_code . ',下单使用即可消费！');
//                    $weixin->reply($reply);
//                    $result->code = 1;
//
//                    return $result;
//                }
//            }
            //26号后开通
            //if ($event_key == 'sales')
            //{
            //京汉大厦小卖部商家id
            $sales_dealer_id = 35;
            $sales_dealer = Dealer::model()->findByPk($sales_dealer_id);
            $pic_url = Pic::model()->getWXPic($sales_dealer_id);

            $banner_url = (!empty($pic_url)) ? $static_url_base . $pic_url : $static_url_base . 'mobile/img/banner_wx_default.jpg';
            $funcs = DealerFunction::model()->getFunidBydealerid($sales_dealer_id);
            $news = array();

            array_push($news, array(
                'title' => $sales_dealer->dealer_name,
                'description' => '欢迎进入' . $sales_dealer->dealer_name,
                'picurl' => $banner_url,
                'url' => Yii::app()->request->hostInfo . '/wechatds/dealer?dealer_id=' . $sales_dealer_id . '&wechat_id=' . $fromUser));

            //外卖商品
            if (in_array(1, $funcs))
            {
                array_push($news, array(
                    'title' => '外送零食',
                    'description' => '外送零食',
                    'picurl' => $static_url_base . 'mobile/img/tupian01.png',
                    'url' => Yii::app()->request->hostInfo . '/wechatds/takeout?dealer_id=' . $sales_dealer_id . '&wechat_id=' . $fromUser));
            }

            //我的订单
            if (in_array(4, $funcs))
            {
                array_push($news, array(
                    'title' => '我的订单',
                    'description' => '我的订单',
                    'picurl' => $static_url_base . 'mobile/img/tupian04.png',
                    'url' => Yii::app()->request->hostInfo . '/wechatds/orders?dealer_id=' . $sales_dealer_id . '&wechat_id=' . $fromUser));
            }


            Yii::log('获取京汉商品菜单，', 'info');
            $reply = $weixin->makeNews($news);
            $weixin->reply($reply);

            $result->code = 1;
            return $result;
            //}

            return $result;
        } catch (Exception $e)
        {
            Yii::log($e->getMessage());
            $result->code = 1;
            return $result;
        }
    }

}
