<?php

/**
 * Takeout 的注释
 *
 * @作者 roy
 */
class TakeoutDS
{
    public $wechat_id;
    public $username;
    public $mobile;
    public $passwd;
    public $is_split = false;
    
    public $addr;
    
    public $dealer_id;
    public $area_code = -1;
    
    public $dinner_count = 0;
    public $dinner_time;
    public $coupon_no;
    public $order_type;
    
    public $memo;
    
    
    /**
     *
     * @var array 提交的菜品集合 
     */
    public $dishes = array();
    /**
     *
     * @var array 验证后的菜品集合
     */
    public $dish_list = array();
    
    
    function save_order()
    {
        Yii::log('----开始保存订单-----');
        
        
        
        //保存
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try
        {
            $result = $this->check_args();
        
            if($result->code < 0)
            {
                $trans->rollback();
                Yii::log('-----error:ags miss-----');
                Yii::log($result->msg);
                
                return $result;
            }
            
            $busDis = new BusDiscount();
            $data = $busDis->getDiscountByDishes($this->dealer_id, $this->dishes, $this->coupon_no,$this->order_type);
            
            Yii::log(json_encode($data));
        
            //如果存在微信id则用微信id，否则用手机号
            $customer_name = empty($this->wechat_id) ? $this->mobile : $this->wechat_id;
            
            //检查账户
            $customer = Customer::model()->findByAttributes(array(
                'customer_name' => $customer_name,
            ));
            
            $customer_id = 0;
            if(!isset($customer))
            {
                $customer_data = array(
                    'customer_name' => $customer_name,
                    'customer_mobile' => $this->mobile,
                    'customer_pwd' => Customer::model()->encryptPassword($this->mobile, $this->passwd),
                    'customer_status' => CUSTOMER_STATUS_ENABLE,
                    'customer_wechat_id' => $this->wechat_id,
                );
                
                if(!$db->createCommand()->insert('customer',$customer_data))
                {
                    $trans->rollback();
                    $result->code = ERR_ORDER_SYS_ERR;
                    $result->msg = '保存订单失败：保存用户失败！';
                    Yii::log($result->msg, CLogger::LEVEL_ERROR);
                }
                
                $customer_id = $db->getLastInsertID();
                
                //为用户指定角色
                Yii::app()->authManager->assign(CUSTOMER_ROLENAME_CUSTOMER,$customer_id);
            }
            else
            {
                $customer_id = $customer->customer_id;
            }
            
            
            //检查联系人地址
            $contact_data = array(
                'customer_id' => $customer_id,
                'contact_name' => $this->username,
                'contact_tel' => $this->mobile,
                'contact_city_code' => $this->area_code,
                'contact_addr' => $this->addr
            );
            $contact = Contact::model()->findByAttributes($contact_data);
            $contact_id = 0;
            if(isset($contact))
            {
                $contact_id = $contact->contact_id;
            }
            else
            {
                if(!$db->createCommand()->insert('contact', $contact_data))
                {
                    $trans->rollback();
                    $result->code = ERR_ORDER_SYS_ERR;
                    $result->msg = '保存订单失败：保存联系人失败！';
                    Yii::log($result->msg, CLogger::LEVEL_ERROR);
                    return $result;
                }
                
                $contact_id = $db->lastInsertID;
            }
            
            //保存订单
            $insertResult = $db->createCommand()->insert('orders',array(
                'order_customer_id' => $customer_id,
                'order_createtime' => date('Y-m-d H:i:s',time()),
                'order_person_count' => $this->dinner_count,
                'order_dinnertime' => $this->dinner_time,
                'order_amount' => $data->pre_total_money,
                'order_paid' => $data->total_money,
                'order_status' => ORDER_STATUS_WAIT_PROCESS,
                'order_type' => $this->order_type,
                'order_ispay' => 0,
                'order_pay_type' => ORDER_PAY_TYPE_VISIT_CASH,
                'contact_id' => $contact_id,
                'dealer_id' => $this->dealer_id,
            ));

            if(!$insertResult)
            {
                $result->code = ERR_ORDER_SYS_ERR;
                $trans->rollback();
                $result->msg = '保存订单失败！';
                return $result;
            }

            $order_id = Yii::app()->db->lastInsertID;

            //订单状态维护
            $bo = new busOrder();
            $bo->insert_order_status($order_id, ORDER_STATUS_WAIT_PROCESS, $customer_id,$this->memo);
            
            //保存折扣
            foreach($data->discount as $k => $d)
            {
                if(!$db->createCommand()->insert('order_discount',array(
                    'order_id' => $order_id,
                    'discount_id' => $d->discount_id,
                    'discount_name' => $d->discount_name,
                    'discount_mode' => $d->discount_mode,
                    'discount_value' => $d->discount_value,
                    'discount_money_value' => $d->discount_money,
                )))
                {
                    $trans->rollback();
                    $result->code = ERR_ORDER_SYS_ERR;
                    $result->msg = '保存订单失败：保存折扣关联失败。';
                    return $result;
                }
            }
            
            //优惠券
            if($data->coupon_value != 0)
            {
                $coupon = $data->coupon;
                $coupon->coupon_status = COUPON_STATUS_INVALID;
                
                $coupon->coupon_customer_id = $customer_id;
                $coupon->order_id = $order_id;
                
                if(!$coupon->save())
                {
                    $trans->rollback();
                    $result->code = ERR_ORDER_SYS_ERR;
                    $result->msg = '保存订单失败：更新优惠券失败！';
                    return $result;
                }
            }
            
            Yii::log('----开始.2.-----');
            foreach ($this->dishes as $ds)
            {
                $dish = $this->dish_list[$ds->dish_id];
                
                //更新菜品数量
                $dish->dish_count = intval($dish->dish_count) - intval($ds->count);
                
                /*
                if($dish->dish_count < 0 || $dish->save() === FALSE)
                {
                    Yii::log('---更新数量失败了---');
                    $trans->rollback();
                    $result->code = ERR_ORDER_SYS_ERR;
                    $result->msg = '保存订单失败：更新商品数量失败！';
                    Yii::log($result->msg, CLogger::LEVEL_INFO);
                    return $result;
                }
                 * 
                 */
                
                
                
                //保存菜品快照
                $category = DishCategoryRelation::model()->findByAttributes(array('dish_id' => $ds->dish_id));
                $insert_odf = $db->createCommand()->insert('order_dish_flash',array(
                    'dish_id' => $dish->dish_id,
                    'dish_name' => $dish->dish_name,
                    'dish_price' => $dish->dish_price,
                    'dish_recommend' => $dish->dish_recommend,
                    'dish_package_fee' => $dish->dish_package_fee,
                    'dish_is_vaget' => $dish->dish_is_vaget,
                    'dish_spicy_level' => $dish->dish_spicy_level,
                    'dish_introduction' => $dish->dish_introduction,
                    'dish_category_id' => $category->category_id,
                    'dealer_id' => $dish->dealer_id,
                    'dish_status' => $dish->dish_status,
                    'dish_createtime' => $dish->dish_createtime,
                    'order_id' => $order_id,
                    'order_count' => $ds->count,
                    'order_sum_price' => $ds->total_price,
                    'dish_mode' => $dish->dish_mode,
                    'dish_child_count' => $dish->dish_child_count,
                    'dish_quanpin' => $dish->dish_quanpin,
                    'dish_jianpin' => $dish->dish_jianpin,
                    'is_presell' => $dish->is_presell,
                ));
                
                $d = Dish::model()->findByPk($ds->dish_id);
                if($d->is_presell == 0)
                {
                    //更新菜品数量
                    $d->dish_count = intval($d->dish_count) - intval($ds->count);
                    $d->update();
                }
            }
            
            Yii::log('----开始3..-----');
            
            if(!$insert_odf)
            {
                $trans->rollback();
                $result->code = ERR_ORDER_SYS_ERR;
                $result->msg = '保存订单失败：保存菜品快照失败。';
                Yii::log('----开始.err.flash err.-----');
                return $result;
            }

            $trans->commit();

            $result->code = SUCCESS;
            $result->order_id = $order_id;
            
            Yii::app()->cache->flush();
            
            return $result;
            
        }
        catch(Exception $ex)
        {
            $trans->rollback();
            
            $result->code = ERR_ORDER_SYS_ERR;
            $result->msg = $ex->getMessage();
            Yii::log('下单失败：'.$ex->getMessage(), CLogger::LEVEL_ERROR);
            return $result;
        }
    }
    
    
    /*
     * 检查参数
     */
    private function check_args()
    {
        $result = new OperResult();
        $result->code = ERR_ORDER_TAKEOUT_ARGS;
        
        if(empty($this->username))
        {
            $result->msg = '用户名为空';
            return $result;
        }
        
        if(empty($this->mobile))
        {
            $result->msg = '手机号为空';
            return $result;
        }
        if($this->order_type==ORDER_TYPE_TAKEOUT){
            if($this->area_code <= 0)
            {
                $result->msg = '地区为空';
                return $result;
            }

            if(empty($this->addr))
            {
                $result->msg = '地址为空';
                return $result;
            }
        }
        if($this->dinner_count == -1)
        {
            $result->msg = '就餐人数为空';
            return $result;
        }
        
        if(empty($this->dinner_time))
        {
            $result->msg = '取货时间为空';
            return $result;
        }
        
        if((!is_array($this->dishes)) || count($this->dishes) == 0)
        {
            $result->msg = '商品为空';
            return $result;
        }        
        $result->dish_error_list=array();
        /*
         * post dish format:{dish_id,dish_name,count,per_price,total_price,
         */
        foreach ($this->dishes as $dish)
        {
            $ds = Dish::model()->findByAttributes(
                    array('dish_id' => $dish->dish_id,
                        'dish_status'=>1));
            
            if(isset($ds))
            {
                $this->dish_list[$dish->dish_id] = $ds;
            }
            else
            {
                $result->code = ERR_ORDER_SYS_ERR;
                $result->msg = '商品'.$ds->dish_id.'不存在';
                Yii::log($result->msg);
                
                return $result;
            }            
            
            if($ds->dish_count < $dish->count)
            {                
                $result->dish_error_list[]=$ds->dish_name;
                
            }
            
        }
        if(count($result->dish_error_list)>0){
            $result->code = ERR_ORDER_SYS_ERR;
            $result->msg = '商品库存数量小于购买数量';
            return $result;
        }
        $customer = Customer::model()->findByAttributes(array(
                'customer_mobile' => $this->mobile,
            ));
        if(isset($customer))
        {
           if($customer->customer_status == CUSTOMER_STATUS_UNENABLE)
           {
               $result->code = ERR_CUSTOMER_FOBIDDEN;
               $result->msg = '用户已被禁用';
               return $result;
           }
           
           $result->customer = $customer;
        }
        
        $result->code = SUCCESS;
        return $result;
    }
    
    
    
}
