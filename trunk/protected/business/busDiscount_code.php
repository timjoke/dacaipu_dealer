<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of busDiscount_code
 *
 * @author lts
 */
class busDiscount_code
{

    /**
     * 分配给用户一个打折码
     * @param type $dealer_id 商家id
     * @param type $customer_name 用户名
     */
    public function addDiscount_code($dealer_id, $customer_name)
    {
        $model = DiscountCode::model()->findByAttributes(array('dealer_id' => $dealer_id, 'customer_name' => $customer_name));
        if (isset($model))
        {//此用户已经拥有打折码
            return ERR_DISCOUNTCODE_EXIST;
        }
        else
        {
            $model = new DiscountCode;
            $model->discount_code = $this->makeDiscountCode($dealer_id);
            $model->dealer_id = $dealer_id;
            $model->customer_name = $customer_name;
            $model->status = DISCOUNTCODE_STATUS_UNUSE;
            $model->used_time = date('Y-m-d H:i:s', time());
            $model->discount_create_time = date('Y-m-d H:i:s', time());
            if ($model->save())
            {
                return $model->discount_code;
            }
            else
            {
                return ERR_DISCOUNTCODE_SYS_ERR;
            }
        }
    }

    /**
     * 生成一个8位的打折码
     * @param type $dealer_id 商家id
     */
    private function makeDiscountCode($dealer_id)
    {
        for ($i = 0; $i < 3; $i++)
        {
            //生成一个打折码
            $code = '';
            for ($j = 0; $j < 8; $j++)
            {
                $codeitem = rand(0, 9);
                $code.=$codeitem;
            }
            //检查这个打折码在这个商家下是否存在
            $model = DiscountCode::model()->findByAttributes(
                    array('dealer_id' => $dealer_id, 'discount_code' => $code));
            if (!isset($model))
            {
                return $code;
            }
        }
    }

    /**
     * 显示折扣码使用状态
     * @param type $model
     * @return string
     */
    static function showdiscountcode_status($model)
    {
        $showname = '';
        switch ($model)
        {
            case 0:
                $showname = '未使用';
                break;
            case 1:
                $showname = '已使用';
                break;
            default:
                break;
        }
        return $showname;
    }

}
