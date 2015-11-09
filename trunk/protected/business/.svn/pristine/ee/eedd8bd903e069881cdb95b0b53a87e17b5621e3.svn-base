<?php

/**
 * 打折类逻辑实现
 *
 * @author roy
 */
class BusDiscount
{

    public static $DISCOUNT_MODE = array(1 => '金额', 2 => '百分比',3=>'数量');
    public static $DISCOUNTCONDITION = array('>' => '大于', '>=' => '大于等于',
        '=' => '等于', '<' => '小于', '<=' => '小于等于');
    public static $DISCOUNT_PLAN_STATUS = array(1 => "已上线", 0 => "已下线");
    public static $DISCOUNT_PLAN_TYPE = array(1 => '全店', 2 => '类别', 3 => '单品');
     public static $DISCOUNT_ORDERS_TYPE = array(1 => '外卖送餐', 2 => '外卖自取', 
        3 => '预定桌台', 4 => '预定桌台+点菜', 5 => '堂食点菜');
    private $_use_disct = array();

    /**
     * 根据商家和菜品获得折扣价格
     * @param int $dealer_id
     * @param array $dishes
     * @return OperResult
     */
    public function getDiscountByDishes($dealer_id, $dishes = array(), $coupon_no, $order_type)
    {
        if (!isset($order_type))
            throw new Exception('订单类型不可为空');

        $dealer = Dealer::model()->findByPk($dealer_id);
        $result = new OperResult();

        if (!isset($dishes))
        {
            $result->code = -1;
            $result->message = '菜品不符合格式';
            return $result;
        }

        $discount_plan = DiscountPlan::model()->getDiscountByOrderType($dealer_id,$order_type);

        $total_money = 0;

        foreach ($dishes as $dish)
        {
            $total_money += $dish->per_price * $dish->count;
        }

        $original_total_money = $total_money;

        foreach ($discount_plan as $discount)
        {
            /*
             * 单品打折
             */
            if ($discount->ar_type == DISCOUNT_PLAN_TYPE_DISH &&
                            $discount->ar_orders_type == $order_type)
            {
                foreach ($dishes as $dish)
                {
                    try
                    {
                        $dish_cate = DishCategoryRelation::model()->findByAttributes(array('dish_id' => $dish->dish_id));
                    } catch (Exception $e)
                    {
                        Yii::log($e->getMessage());
                    }

                    if (!isset($dish_cate))
                    {
                        Yii::log('获取折扣信息-获取菜品类别失败；相关信息：' . json_encode($dishes), CLogger::LEVEL_INFO);
                        $result->code = -1;
                        $result->message = '获取菜品类别失败，类别名称：' . $dish->dish_name;

                        return $result;
                    }

                    //单品优惠打折
                    if ($discount->ar_entity_id == $dish->dish_id &&
                            $discount->ar_orders_type == $order_type)
                    {
                        $condition = 'return ' . $dish->per_price . $discount->discount_condition . $discount->discount_compare_value . ';';
                        if (eval($condition))
                        {
                            $dis_money = 0;
                            if ($discount->discount_mode == DISCOUNT_MODE_MONEY)
                            {
                                $dis_money = $discount->discount_value * $dish->count;
                                $total_money -= $dis_money;
                            }
                            else
                            {
                                $dis_money = $dish->per_price * $discount->discount_value * $dish->count;
                                $total_money -= $dis_money;
                            }

                            $this->add_use_discount($discount, $dis_money);
                        }
                    }
                }
            }
            elseif ($discount->ar_type == DISCOUNT_PLAN_TYPE_CATEGORY &&
                    $discount->ar_orders_type == $order_type)
            {
                $ar_cate = array();
                foreach ($dishes as $dish)
                {
                    $dish_cate = DishCategoryRelation::model()->findByAttributes(array('dish_id' => $dish->dish_id));
                    if (!isset($dish_cate))
                    {
                        Yii::log('获取折扣信息-获取菜品类别失败；相关信息：' . json_encode($dishes), CLogger::LEVEL_INFO);
                        $result->code = -1;
                        $result->message = '获取菜品类别失败，类别名称：' . $dish->dish_name;
                        return $result;
                    }

                    if (array_key_exists($dish_cate->category_id, $ar_cate))
                    {
                        $ar_cate[$dish_cate->category_id] += $dish->per_price;
                    }
                    else
                    {
                        $ar_cate[$dish_cate->category_id] = $dish->per_price;
                    }
                }

                if (array_key_exists($discount->ar_entity_id, $ar_cate))
                {
                    $dis_money = 0;
                    $condition = 'return ' . $ar_cate[$discount->ar_entity_id] . $discount->discount_condition . $discount->discount_compare_value . ';';
                    if (eval($condition))
                    {
                        if ($discount->discount_mode == DISCOUNT_MODE_MONEY)
                        {
                            $dis_money = $discount->discount_value;
                            $total_money -= $dis_money;
                        }
                        else
                        {
                            $dis_money = $ar_cate[$discount->ar_entity_id] * $discount->discount_value;
                            $total_money -= $dis_money;
                        }

                        $this->add_use_discount($discount, $dis_money);
                    }
                }
            }
            elseif ($discount->ar_type == DISCOUNT_PLAN_TYPE_VENDOR &&
                    $discount->ar_orders_type == $order_type)
            {
                $condition = 'return ' . $total_money . $discount->discount_condition . $discount->discount_compare_value . ';';
                if (eval($condition))
                {
                    $dis_money = 0;
                    if ($discount->discount_mode == DISCOUNT_MODE_MONEY)
                    {
                        $dis_money = $discount->discount_value;
                        $total_money -= $dis_money;
                    }
                    else
                    {
                        $dis_money = $total_money * $discount->discount_value;
                        $total_money -= $dis_money;
                    }


                    $this->add_use_discount($discount, $dis_money);
                }
            }
        }

        //coupon
        $coupon = $this->getCoupon($dealer_id, $coupon_no);
        $result->coupon_value = 0;
        if ($coupon->code == 0)
        {
            $result->coupon_value = busUlitity::formatMoney($coupon->coupon_value, 2);
            $result->coupon = $coupon->coupon;
        }

        $total_money -= $result->coupon_value;

        $result->code = 0;
        //原始菜品价格总和
        $result->original_total_money = busUlitity::formatMoney($original_total_money, 2);

        //打折后的菜品总价
        $result->dish_total_money = $total_money; //busUlitity::formatMoney($total_money - $result->coupon_value, 2);

        $dsc_al = array();
        foreach ($this->_use_disct as $k => $dsc)
        {
            array_push($dsc_al, $dsc);
        }


        //使用到的折扣计划
        //$result->discount = $this->_use_disct;
        $result->discount = $dsc_al;

        //折扣去掉的价格(包含折扣券）
        $result->discount_money = busUlitity::formatMoney($original_total_money - $result->dish_total_money, 2);

        //运费
        $result->express_fee = busUlitity::formatMoney($dealer->dealer_express_fee, 2);
        if($order_type != ORDER_TYPE_TAKEOUT)
            $result->express_fee = 0.00;

        //优惠前总计金额（带配送费）
        $result->pre_total_money = busUlitity::formatMoney($original_total_money + $result->express_fee, 2);

        //总额（打折后，减去优惠券，加配送费）
        $result->total_money = busUlitity::formatMoney($total_money + $result->express_fee, 2);





        return $result;
    }

    /**
     * 根据商家和菜品获得打折价格，用于商家管理显示使用（外卖打折算法）
     * @param int $dealer_id 商家id
     * @param type $order_id 订单id
     * @return \OperResult
     */
    public function getDiscountforDealeradmin($order_id)
    {
        //打折码金额
        $coupon_value = Coupon::model()->getCoupon_valueByorderId($order_id);
        //折扣项目
        $discount_list = new CActiveDataProvider('OrderDiscount', array(
            'criteria' => array(
                'condition' => 'order_id=' . $order_id,
            )
        ));
        $results = new OperResult();
        $results->coupon_value = $coupon_value;
        $results->discount_list = $discount_list;
        return $results;
    }

    /**
     * 将菜品列表处理为getDiscountByDishes函数需要的列表格式
     * @param CActiveDataProvider $order_dish_flash_list 
     * @return type
     */
    public function getDishlist($order_dish_flash_list)
    {
        $count = $order_dish_flash_list->itemCount;
        $strjson = '[';
        for ($i = 0; $i < $count; $i++)
        {
            $item = sprintf('{"dish_id":"%s","dish_name":"%s","count":%s,"per_price":%s,"total_price":%s}'
                    , $order_dish_flash_list->data[$i]->dish_id, $order_dish_flash_list->data[$i]->dish_name
                    , $order_dish_flash_list->data[$i]->order_count, $order_dish_flash_list->data[$i]->dish_price
                    , $order_dish_flash_list->data[$i]->order_sum_price);
            $strjson = $strjson . $item;
            if ($i != $count - 1)
            {
                $strjson = $strjson . ',';
            }
        }
        $strjson = $strjson . ']';
        $objlst = json_decode($strjson);
        return $objlst;
    }

    /**
     * 根据商家和菜品获得堂食折扣价格
     * @param int $dealer_id
     * @param array $dishes
     * @return OperResult
     */
    public function getDiscountEatinByDishes($dealer_id, $dishes = array(), $coupon_no, $order_type)
    {
        $dealer = Dealer::model()->findByPk($dealer_id);
        $result = new OperResult();

        if (!isset($dishes))
        {
            $result->code = -1;
            $result->message = '菜品不符合格式';
            return $result;
        }

        $discount_plan = DiscountPlan::model()->getEatInDiscountByDealerId($dealer_id);

        $total_money = 0;

        foreach ($dishes as $dish)
        {
            $total_money += $dish->per_price * $dish->count;
        }

        $original_total_money = $total_money;

        foreach ($discount_plan as $discount)
        {
            /*
             * 单品打折
             */
            if ($discount->ar_type == DISCOUNT_PLAN_TYPE_DISH)
            {
                foreach ($dishes as $dish)
                {
                    try
                    {
                        $dish_cate = DishCategoryRelation::model()->findByAttributes(array('dish_id' => $dish->dish_id));
                    } catch (Exception $e)
                    {
                        Yii::log($e->getMessage());
                    }

                    if (!isset($dish_cate))
                    {
                        Yii::log('获取折扣信息-获取菜品类别失败；相关信息：' . json_encode($dishes), CLogger::LEVEL_INFO);
                        $result->code = -1;
                        $result->message = '获取菜品类别失败，类别名称：' . $dish->dish_name;

                        return $result;
                    }

                    //单品优惠打折
                    if ($discount->ar_entity_id == $dish->dish_id)
                    {
                        $condition = 'return ' . $dish->per_price . $discount->discount_condition . $discount->discount_compare_value . ';';
                        if (eval($condition))
                        {
                            $dis_money = 0;
                            if ($discount->discount_mode == DISCOUNT_MODE_MONEY)
                            {
                                $dis_money = $discount->discount_value * $dish->count;
                                $total_money -= $dis_money;
                            }
                            else
                            {
                                $dis_money = $dish->per_price * $discount->discount_value * $dish->count;
                                $total_money -= $dis_money;
                            }

                            $this->add_use_discount($discount, $dis_money);
                        }
                    }
                }
            }
            elseif ($discount->ar_type == DISCOUNT_PLAN_TYPE_CATEGORY)
            {
                $ar_cate = array();
                foreach ($dishes as $dish)
                {
                    $dish_cate = DishCategoryRelation::model()->findByAttributes(array('dish_id' => $dish->dish_id));
                    if (!isset($dish_cate))
                    {
                        Yii::log('获取折扣信息-获取菜品类别失败；相关信息：' . json_encode($dishes), CLogger::LEVEL_INFO);
                        $result->code = -1;
                        $result->message = '获取菜品类别失败，类别名称：' . $dish->dish_name;
                        return $result;
                    }

                    if (array_key_exists($dish_cate->category_id, $ar_cate))
                    {
                        $ar_cate[$dish_cate->category_id] += $dish->per_price;
                    }
                    else
                    {
                        $ar_cate[$dish_cate->category_id] = $dish->per_price;
                    }
                }

                if (array_key_exists($discount->ar_entity_id, $ar_cate))
                {
                    $dis_money = 0;
                    $condition = 'return ' . $ar_cate[$discount->ar_entity_id] . $discount->discount_condition . $discount->discount_compare_value . ';';
                    if (eval($condition))
                    {
                        if ($discount->discount_mode == DISCOUNT_MODE_MONEY)
                        {
                            $dis_money = $discount->discount_value;
                            $total_money -= $dis_money;
                        }
                        else
                        {
                            $dis_money = $ar_cate[$discount->ar_entity_id] * $discount->discount_value;
                            $total_money -= $dis_money;
                        }

                        $this->add_use_discount($discount, $dis_money);
                    }
                }
            }
            elseif ($discount->ar_type == DISCOUNT_PLAN_TYPE_VENDOR)
            {
                $condition = 'return ' . $total_money . $discount->discount_condition . $discount->discount_compare_value . ';';
                if (eval($condition))
                {
                    $dis_money = 0;
                    if ($discount->discount_mode == DISCOUNT_MODE_MONEY)
                    {
                        $dis_money = $discount->discount_value;
                        $total_money -= $dis_money;
                    }
                    else
                    {
                        $dis_money = $total_money * $discount->discount_value;
                        $total_money -= $dis_money;
                    }

                    $this->add_use_discount($discount, $dis_money);
                }
            }
        }

        //coupon
        $coupon = $this->getCoupon($dealer_id, $coupon_no);
        $result->coupon_value = 0;
        if ($coupon->code == 0)
        {
            $result->coupon_value = busUlitity::formatMoney($coupon->coupon_value, 2);
            $result->coupon = $coupon->coupon;
        }

        $total_money -= $result->coupon_value;

        $result->code = 0;
        //原始菜品价格总和
        $result->original_total_money = busUlitity::formatMoney($original_total_money, 2);

        //打折后的菜品总价
        $result->dish_total_money = busUlitity::formatMoney($total_money - $result->coupon_value, 2);

        $dsc_al = array();
        foreach ($this->_use_disct as $k => $dsc)
        {
            array_push($dsc_al, $dsc);
        }


        //使用到的折扣计划
        //$result->discount = $this->_use_disct;
        $result->discount = $dsc_al;

        //折扣去掉的价格(包含折扣券）
        $result->discount_money = busUlitity::formatMoney($original_total_money - $result->dish_total_money, 2);

        //优惠前总计金额
        $result->pre_total_money = busUlitity::formatMoney($original_total_money, 2);

        //总额（打折后，减去优惠券）
        $result->total_money = busUlitity::formatMoney($total_money, 2);





        return $result;
    }

    /**
     * 
     * @param type $discount
     * @param type $dis_money
     */
    private function add_use_discount($discount, $dis_money)
    {
        if (!array_key_exists($discount->discount_id, $this->_use_disct))
        {
            $disRes = new OperResult();

            $disRes->discount_id = $discount->discount_id;
            $disRes->discount_name = $discount->discount_name;
            $disRes->discount_mode = $discount->discount_mode;
            $disRes->discount_value = $discount->discount_value;
            $disRes->discount_money = busUlitity::formatMoney($dis_money, 2);

            $this->_use_disct[$discount->discount_id] = $disRes;
        }
        else
        {
            $this->_use_disct[$discount->discount_id]->discount_money += busUlitity::formatMoney($dis_money, 2);
        }
    }

    public function getCoupon($dealer_id, $coupon_no)
    {
        $result = new OperResult();
        if (empty($coupon_no))
        {
            $result->code = -1;
            $result->message = '优惠券为空';

            return $result;
        }
        $coupon = Coupon::model()->getValidCouponByNO($coupon_no, $dealer_id);
        if (!isset($coupon))
        {
            $result->code = -1;
            $result->message = '优惠券不存在';

            return $result;
        }

        $result->coupon = $coupon;
        $result->code = 0;
        $result->coupon_value = busUlitity::formatMoney($coupon->coupon_value, 2);
        return $result;
    }

    public function showDiscountValue($mode, $value)
    {
        if ($mode == DISCOUNT_MODE_PERCENT)
        {//百分比
            return ($value * 100) . '%';
        }
        elseif ($mode == DISCOUNT_MODE_MONEY)
        {//金额
            return '￥' . busUlitity::formatMoney($value);
        }
        else
        {
            return '';
        }
    }

}
