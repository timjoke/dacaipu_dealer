<?php

/**
 * 粤厨少帅微信响应类
 *
 * @作者 roy
 */
class busWechatJxt extends busWechatDefault
{

    public function Proc($dealer_id)
    {
        try
        {
            //网址接入时使用 
            if (isset($_GET['echostr']))
            {
                $weixin = new BusWechat($_GET);
                //TODO:各商家自己的token,及自定义各自回复的消息图文
                $weixin->token = 'dacaiputoken';
                $weixin->debug = true;
                $weixin->valid();
            }

            $dealer = Dealer::model()->findByPk($dealer_id);
            $weixin = new BusWechat($_POST);
            $weixin->token = 'dacaiputoken';
            $weixin->debug = true;

            $weixin->init();
            $reply = '';
            $msgType = empty($weixin->msg->MsgType) ? '' : strtolower($weixin->msg->MsgType);
            $fromUser = empty($weixin->msg->FromUserName) ? '' : $weixin->msg->FromUserName;
            $event = empty($weixin->msg->Event) ? '' : $weixin->msg->Event;

            if ($fromUser === '')
            {
                exit("非法访问，请从微信进入");
            }
            $event_key = empty($weixin->msg->EventKey) ? '' : $weixin->msg->EventKey;

            switch ($msgType)
            {
                case 'text':
                    {
//                        $content = strtolower($weixin->msg->Content);
//                        if ($weixin->keywords($dealer_id, $content))
//                        {
//                            return;
//                        }

                        $reply = $weixin->makeText("Call鸡电话：18310395515;用“百度直达号订餐”需在百度搜索栏填上：@鸡兄堂，即可订餐");
                        $weixin->reply($reply);
                        return;
                    }

                    break;
                case 'image':
                    //你要处理图文消息代码
                    break;
                case 'location':
                    {
                        $lat = empty($weixin->msg->Location_X) ? '' : $weixin->msg->Location_X;
                        $lon = empty($weixin->msg->Location_Y) ? '' : $weixin->msg->Location_Y;

                        $busMap = new busBaiduMap();
                        try
                        {
                            $addr = $busMap->getAddrByGeo($lat, $lng);
                        }
                        catch (Exception $e)
                        {
                            $addr = $e->getMessage();
                        }

                        $reply = $weixin->makeText('lat:' . $lat . ',lng:' . $lon . $addr);
                        $weixin->reply($reply);
                        return;
                    }
                    break;
                case 'link':
                    //你要处理链接消息代码
                    break;
                case 'event':
                    {
                        $event_key = empty($weixin->msg->EventKey) ? '' : $weixin->msg->EventKey;

                        //你要处理事件消息代码
                        if ($event == 'subscribe')
                        {
                            //关注事件
                            if (!empty($event_key))
                            {
                                //带参数的二维码
                                $event_key = str_ireplace('qrscene_', '', $event_key);
                                $banner_url = busUlitity::get_http_static_url() . 'mobile/img/canzhuo.jpg';
                                $news = array(
                                    array(
                                        'title' => '欢迎就坐' . $event_key . '号桌台',
                                        'description' => $event_key . '号桌',
                                        'picurl' => $banner_url,
                                        'url' => Yii::app()->request->hostInfo . '/wechat/takeout?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser),
                                    array(
                                        'title' => '开始点菜',
                                        'description' => '开始点菜',
                                        'picurl' => busUlitity::get_http_static_url() . 'mobile/img/1122613.png',
                                        'url' => Yii::app()->request->hostInfo . '/wechat/takeout?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser),
                                );

                                $reply = $weixin->makeNews($news);
                                $weixin->reply($reply);
                                return;
                            }

                            //关注
                            $reply = $weixin->makeText('Call鸡电话：18310395515;用“百度直达号订餐”需在百度搜索栏填上：@鸡兄堂，即可订餐');
                            $weixin->reply($reply);
                        }
                        else if ($event == 'SCAN')
                        {

                            $banner_url = busUlitity::get_http_static_url() . 'mobile/img/canzhuo.jpg';
                            $news = array(
                                array(
                                    'title' => '欢迎就坐' . $event_key . '号桌台',
                                    'description' => $event_key . '号桌',
                                    'picurl' => $banner_url,
                                    'url' => Yii::app()->request->hostInfo . '/wechat/takeout?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser),
                                array(
                                    'title' => '开始点菜',
                                    'description' => '开始点菜',
                                    'picurl' => busUlitity::get_http_static_url() . 'mobile/img/1122613.png',
                                    'url' => Yii::app()->request->hostInfo . '/wechat/takeout?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser),
                            );

                            $reply = $weixin->makeNews($news);
                            $weixin->reply($reply);
                            return;

                            $m = $weixin->makeText('event_key:' . $event_key);
                            $weixin->reply($m);
                            return;
                        }
                        else if ($event == 'LOCATION')
                        {
                            $lat = empty($weixin->msg->Latitude) ? '' : $weixin->msg->Latitude;
                            $lon = empty($weixin->msg->Longitude) ? '' : $weixin->msg->Longitude;

                            $busMap = new busBaiduMap();
                            $addr = $busMap->getAddrByGeo($lat, $lng);
                            $reply = $weixin->makeText('您现在在：' . $addr);
                            $weixin->reply($reply);
                        }
                        else if ($event == 'CLICK')
                        {
                            //关注事件
                            if (!empty($event_key))
                            {
                                if ($event_key == 'takeout-call')
                                {
                                    $reply = $weixin->makeText("Call鸡电话：18310395515;用“百度直达号订餐”需在百度搜索栏填上：@鸡兄堂，即可订餐");
                                    $weixin->reply($reply);
                                    return;
                                }
                            }
                        }
                    }
                    break;
                default:
                    {
                        
                    }
                    break;
            }


            $pic_url = Pic::model()->getWXPic($dealer_id);
            $banner_url = (!empty($pic_url)) ? busUlitity::get_http_static_url() . $pic_url : busUlitity::get_http_static_url() . 'mobile/img/banner_wx_default.jpg';

            $funcs = DealerFunction::model()->getFunidBydealerid($dealer->dealer_id);
            $news = array();
            $ts = time();

            array_push($news, array(
                'title' => '',
                'description' => '欢迎进入' . $dealer->dealer_name,
                'picurl' => $banner_url,
                'url' => Yii::app()->request->hostInfo . '/wechat/dealer?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser . '&ts=' . $ts));



            //近期优惠
            array_push($news, array(
                'title' => '最新活动',
                'description' => '最新活动',
                'picurl' => busUlitity::get_http_static_url() . 'mobile/img/youhui.png',
                'url' => Yii::app()->request->hostInfo . '/wechat/news?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser . '&ts=' . $ts));

            //店内点菜
            if (in_array(3, $funcs))
            {
                array_push($news, array(
                    'title' => '店内点菜',
                    'description' => '店内点菜',
                    'picurl' => busUlitity::get_http_static_url() . 'mobile/img/tupian03.png',
                    'url' => Yii::app()->request->hostInfo . '/wechat/hall?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser . '&ts=' . $ts));
            }

            //订台点菜
            if (in_array(5, $funcs))
            {
                array_push($news, array(
                    'title' => '订台点菜',
                    'description' => '订台点菜',
                    'picurl' => busUlitity::get_http_static_url() . 'mobile/img/tupian02.png',
                    'url' => Yii::app()->request->hostInfo . '/wechat/eatin?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser . '&ts=' . $ts));
            }



            //预订桌台
            if (in_array(2, $funcs))
            {
                array_push($news, array(
                    'title' => '预订桌台',
                    'description' => '预订桌台',
                    'picurl' => busUlitity::get_http_static_url() . 'mobile/img/tupian02.png',
                    'url' => Yii::app()->request->hostInfo . '/wechat/booking?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser . '&ts=' . $ts));
            }

            //外卖订餐
            if (in_array(1, $funcs))
            {
                array_push($news, array(
                    'title' => '微信订餐',
                    'description' => '微信订餐',
                    'picurl' => busUlitity::get_http_static_url() . 'mobile/img/jxtlogo.png',
                    'url' => Yii::app()->request->hostInfo . '/wechat/takeout?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser . '&ts=' . $ts));
            }

            //我的订单
            if (in_array(4, $funcs))
            {
                array_push($news, array(
                    'title' => '我的订单',
                    'description' => '我的订单',
                    'picurl' => busUlitity::get_http_static_url() . 'mobile/img/dingcan01.png',
                    'url' => Yii::app()->request->hostInfo . '/wechat/orders?dealer_id=' . $dealer_id . '&wechat_id=' . $fromUser . '&ts=' . $ts));
            }

            //关于我们
            array_push($news, array(
                'title' => '品牌介绍',
                'description' => '品牌介绍',
                'picurl' => busUlitity::get_http_static_url() . 'mobile/img/tupian04.png',
                'url' => 'http://wx.iyaohe.cc/wx.php/jxt3.html'));

            $reply = $weixin->makeNews($news);
            $weixin->reply($reply);
        }
        catch (Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

}
