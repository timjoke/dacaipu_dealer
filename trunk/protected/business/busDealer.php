<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of busDealer
 *
 * @author lts
 */
class busDealer
{

    /**
     * 微信用户订阅后触发的事件
     * @var type 
     */
    public static $WEIXIN_SUBSCRIBE_NAME = array('0' => '无事件', '1' => '发送打折码');

    /**
     * 设置表key键规则 商家起送最低间隔
     * @var type 
     */
    public static $DEALER_TAKEOUT_MIN_TIMESPAN = array(30 => 30, 35 => 35, 40 => 40);
    public static $AUTO_ACCEPT_ORDER = array('0' => '否', '1' => '是');
    public static $SEND_MESSAGE_ACCEPTED_ORDER = array('0' => '否', '1' => '是');
    public static $NO_DELEVERY = array('0' => '是', '1' => '否');
    public static $DISH_IMAGE_HIDDEN = array('0' => '是', '1' => '否');
    //public static $DEALER_FUN_NAME = array(1 => '外卖订餐', 2 => '预定桌台',5=>'订台点菜', 3 => '店内点菜', 4 => '我的订单');
    //public static $DEALER_FUN_NAME = $this->get_all_function_name();

    /**
     * 设置表key键规则
     * @param type $keyname key
     * @param type $value 
     * @param type $dealer_id
     */
    public function saveSetting($keyname, $value, $dealer_id)
    {
        $sets = Setting::model()->findByAttributes(array('setting_key' => $keyname . $dealer_id));
        if (!isset($sets))
        {
            $sets = new Setting();
        }
        $sets->setting_key = $keyname . $dealer_id;
        $sets->setting_value = $value;

        $sets->save();
    }

    /**
     * 获取设置表key键规则
     * @param type $key 
     * @param type $default_value 默认值为0
     * @return type
     */
    private function get_settings($key, $default_value = 0)
    {
        $sets = Setting::model()->findByAttributes(array('setting_key' => $key));
        if (!isset($sets))
        {
            $sets = new Setting();
            $sets->setting_key = $key;
            $sets->setting_value = $default_value;

            $sets->save();
            return $default_value;
        }

        return $sets->setting_value;
    }

    /**
     * 获取配置项值 商家起送最低间隔
     * @param type $dealer_id
     * @return type
     */
    public function get_dealer_takeout_min_timespan($dealer_id)
    {
        return $this->get_settings(SETTING_KEY_DEALER_TAKEOUT_MIN_TIMESPAN . $dealer_id, 30);
    }

    /**
     * 获取配置项值 微信用户关注商家后是否发送打折码
     * @param type $dealer_id
     * @return type
     */
    public function get_weixin_subscribe($dealer_id)
    {
        return $this->get_settings(SETTING_KEY_WEIXIN_SUBSCRIBE . $dealer_id, 0);
    }

    /**
     * 获取配置项值 商家是否自动接单
     * @param type $dealer_id
     * @return type
     */
    public function get_auto_accept_order($dealer_id)
    {
        return $this->get_settings(SETTING_KEY_AUTO_ACCEPT_ORDER . $dealer_id, 0);
    }

    /**
     * 获取配置项值 商家是否自动接单
     * @param type $dealer_id
     * @return type
     */
    public function get_delivery($dealer_id)
    {
        return $this->get_settings(SETTING_KEY_NO_DELIVERY . $dealer_id, 0);
    }
    
    /**
     * 获取配置项值 商家是否自动接单
     * @param type $dealer_id
     * @return type
     */
    public function get_dish_image_display($dealer_id)
    {
        return $this->get_settings(SETTING_KEY_DISH_IMAGE_HIDDEN . $dealer_id, 0);
    }

    /**
     * 获取配置项值 是否接受订单提醒短信
     * @param type $dealer_id 商家id
     * @return type 1:开启；0：未开启
     */
    public function get_send_message_accepted_order($dealer_id)
    {
        return $this->get_settings(SETTING_KEY_SEND_MESSAGE_ACCEPTED_ORDER . $dealer_id, 0);
    }

    /**
     * 获取所有商家可开通的功能
     * @return type
     */
    public static function get_all_function_name()
    {
        $sql = 'SELECT * FROM functions';
        $ary = Functions::model()->findAll();
        //$ary = $this->findAllBySql($sql);
        $ret_ary = array();
        foreach ($ary as $value)
        {
            $ret_ary[$value->function_id] = $value->function_name;
        }
        return $ret_ary;
    }

}
