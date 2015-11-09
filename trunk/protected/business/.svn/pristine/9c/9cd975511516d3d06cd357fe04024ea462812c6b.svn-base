<?php

/**
 * 打折类逻辑实现
 *
 * @author roy
 */
class BusCoupon
{
    public static $COUPON_STATUS = array(0 => "未激活", 1 => "已激活",2=>"已失效");
    
        /**
     * 显示优惠券使用状态
     * @param type $model
     * @return string
     */
    static function show_coupon_status($status)
    {
        $showname = '';
        switch ($status)
        {
            case 0:
                $showname = '未激活';
                break;
            case 1:
                $showname = '已激活';
                break;
            case 2:
                $showname = '已失效';
                break;
            default:
                break;
        }
        return $showname;
    }
}
