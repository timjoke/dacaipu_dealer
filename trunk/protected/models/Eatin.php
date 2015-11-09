<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Takeout 的注释
 *
 * @作者 roy
 */
class Eatin
{
    public $wechat_id;
    public $username;
    public $mobile;
    public $passwd;
    
    public $addr;
    
    public $dealer_id;
    public $area_code = -1;
    
    public $dinner_count = 0;
    public $dinner_time;
    public $coupon_no;
    public $order_type;
    
    public $memo;
    
    public $reserv_id;
    
    public $order_id_team;
    
    public $table_id;//堂食点餐桌台ID
    
    public $customer_id;

    public $table_reservation;//桌台预定model

    /**
     *
     * @var array 提交的菜品集合 
     */
    public $dishes = array();
    /**
     *
     * @var array 验证后的菜品集合
     */
    private $dish_list = array();
    
    
    function save_order()
    {
        $result = $this->check_args();
        if($result->code < 0)
            return $result;                
        
        //保存
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try
        {
            $busDis = new BusDiscount();
            $data = $busDis->getDiscountByDishes($this->dealer_id, $this->dishes, $this->coupon_no,  $this->order_type);
            
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
                    'customer_reg_time' => date('Y-m-d H:i:s',time()),
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
                'order_pay_type' => ORDER_PAY_TYPE_RESTAURANT_CASH,
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
            
            //把order_id更新到reservation
            $reservation= TableReservation::model()->findByPk($this->reserv_id);
            if(!isset($reservation)){
                $result->code = ERR_ORDER_SYS_ERR;
                $trans->rollback();
                $result->msg = '保存订单失败：更新预订桌台失败！';
                return $result;
            }
            $reservation->order_id=$order_id;
            $reservation->reserv_status=2;//预订成功
            if (!$reservation->save()) {
                $result->code = ERR_ORDER_SYS_ERR;
                $trans->rollback();
                $result->msg = '保存订单失败：更新预订桌台失败！';
                return $result;
            }

            //订单状态维护
            $db->createCommand()->insert('order_status_message', array(
                'order_id' => $order_id,
                'memo' => $this->memo,                
                'cur_order_status' => ORDER_STATUS_WAIT_PROCESS,
                'modifier_id' => $customer_id,
                'create_time' => date('Y-m-d H:i:s',time()),
            ));
            
            
            
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
            
            //保存菜品快照
            foreach ($this->dishes as $ds)
            {
                $dish = $this->dish_list[$ds->dish_id];
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
                ));
                
            }
            
            if(!$insert_odf)
            {
                $result->code = ERR_ORDER_SYS_ERR;
                $result->msg = '保存订单失败：保存菜品快照失败。';
                return $result;
            }
            
//            if($this->order_id_team>0){         
//                $finish_result=$this->finish_oders_team ();
//                if (!$finish_result) {
//                    $result->code = ERR_ORDER_SYS_ERR;
//                    $result->msg = '保存订单失败：更新多人点菜订单失败。';
//                    $trans->rollback();
//                    return $result;
//                }
//            }
            $trans->commit();

            $result->code = SUCCESS;
            $result->order_id = $order_id;
                        
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
    
    /**
     * 保存预定桌台订单
     * @return type
     */
    function save_booking_order() {
        $result = $this->check_booking_args();
        if($result->code < 0)
            return $result;                
        
        //保存
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try
        {
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
                    'customer_reg_time' => date('Y-m-d H:i:s',time()),
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
                'order_person_count' => 0,
                'order_dinnertime' => $this->dinner_time,
                'order_amount' => 0,
                'order_paid' => 0,
                'order_status' => ORDER_STATUS_WAIT_PROCESS,
                'order_type' => $this->order_type,
                'order_ispay' => 0,
                'order_pay_type' => ORDER_PAY_TYPE_RESTAURANT_CASH,
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
            
            //保存桌台信息            
            $this->table_reservation->order_id=$order_id;;
            if (!$this->table_reservation->save()) {
                $result->code = ERR_ORDER_SYS_ERR;
                $trans->rollback();
                $result->msg = '保存订单失败：预定桌台失败！';
                return $result;
            }

            //订单状态维护
            $db->createCommand()->insert('order_status_message', array(
                'order_id' => $order_id,
                'memo' => $this->memo,                
                'cur_order_status' => ORDER_STATUS_WAIT_PROCESS,
                'modifier_id' => $customer_id,
                'create_time' => date('Y-m-d H:i:s',time()),
            ));                                                            
            
            $trans->commit();

            $result->code = SUCCESS;
            $result->order_id = $order_id;
            $result->reserv_id =$this->table_reservation->reserv_id;
                        
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
    
    function save_hall_order()
    {
        $result = $this->check_hall_args();
        if($result->code < 0)
            return $result;                
        
        //保存
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try
        {
            $busDis = new BusDiscount();
            $data = $busDis->getDiscountByDishes($this->dealer_id, $this->dishes, $this->coupon_no,  $this->order_type);
        
            //检查联系人地址
            $contact_data = array(
                'customer_id' => $this->customer_id             
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
                'order_customer_id' => $this->customer_id,
                'order_createtime' => date('Y-m-d H:i:s',time()),
                'order_dinnertime' => date('Y-m-d H:i:s',time()),
                'order_amount' => $data->pre_total_money,
                'order_paid' => $data->total_money,
                'order_status' => ORDER_STATUS_WAIT_PROCESS,
                'order_type' => $this->order_type,
                'order_ispay' => 0,
                'order_pay_type' => ORDER_PAY_TYPE_VISIT_CASH,
                'contact_id' => $contact_id,
                'dealer_id' => $this->dealer_id,
                'table_id'=>$this->table_id,
            ));

            if(!$insertResult)
            {
                $result->code = ERR_ORDER_SYS_ERR;
                $trans->rollback();
                $result->msg = '保存订单失败！';
                return $result;
            }

            $order_id = Yii::app()->db->lastInsertID;
            $result->order_id=$order_id;
            //订单状态维护
            $db->createCommand()->insert('order_status_message', array(
                'order_id' => $order_id,
                'memo' => $this->memo,                
                'cur_order_status' => ORDER_STATUS_WAIT_PROCESS,
                'modifier_id' => $this->customer_id,
                'create_time' => date('Y-m-d H:i:s',time())
            ));
                                    
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
            
            //保存菜品快照
            foreach ($this->dishes as $ds)
            {
                $dish = $this->dish_list[$ds->dish_id];
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
                ));
                
            }
            
            if(!$insert_odf)
            {
                $result->code = ERR_ORDER_SYS_ERR;
                $result->msg = '保存订单失败：保存菜品快照失败。';
                return $result;
            }
            $trans->commit();

            $result->code = SUCCESS;
            $result->order_id = $order_id;
                        
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
    
    function create_team_order() {
        //创建多人公用订单
        $db = Yii::app()->db;
            $insertResult = $db->createCommand()->insert('orders_team',array(
                'order_customer_id' => -1,
                'order_createtime' => date('Y-m-d H:i:s',time()),
                'order_person_count' => 0,
                'order_dinnertime' => date('Y-m-d H:i:s',time()),
                'order_amount' => 0,
                'order_paid' => 0,
                'order_status' => ORDER_STATUS_WAIT_PROCESS,
                'order_type' => ORDER_TYPE_EATIN,
                'order_ispay' => 0,
                'order_pay_type' => ORDER_PAY_TYPE_VISIT_CASH,
                'contact_id' => -1,
                'dealer_id' => $this->dealer_id,
            ));

            if(!$insertResult)
            {
                return -1;
            }
            else{
                $order_id = Yii::app()->db->lastInsertID;
                return $order_id;
            }
    }
    
    public function finish_team_order($order_id_team) {
        $result = new OperResult();
        $result->code = ERR_ORDER_TAKEOUT_ARGS;
        $db = Yii::app()->db;
        $updateResult = $db->createCommand()->update('orders_team', array(
            'order_customer_id' => -1,
            'order_createtime' => date('Y-m-d H:i:s', time()),
            'order_person_count' => 0,
            'order_dinnertime' => date('Y-m-d H:i:s', time()),
            'order_amount' => 0,
            'order_paid' => 0,
            'order_status' => ORDER_STATUS_COMPLETE,
            'order_type' => ORDER_TYPE_EATIN,
            'order_ispay' => 0,
            'order_pay_type' => ORDER_PAY_TYPE_VISIT_CASH,
            'contact_id' => -1,
                ), 'order_id=:order_id', array(
            ':order_id' => $order_id_team));
        if ($updateResult) {
            $result->code=SUCCESS;            
        } 
        return $result;
    }
    
    function add_order_dish_flash_team(){
        $result = new OperResult();
        $result->code = ERR_ORDER_TAKEOUT_ARGS;
        $busDis = new BusDiscount();        
        foreach ($this->dishes as $dish)
        {
            $ds = Dish::model()->findByPk($dish->dish_id);
            if(isset($ds))
            {
                $this->dish_list[$dish->dish_id] = $ds;
            }
            else
            {
                $result->msg = '菜品'.$ds->dish_id.'不存在';
                return $result;
            }
        }
        
        //保存
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try
        {                       
            //保存菜品快照
            foreach ($this->dishes as $ds)
            {
                $dish = $this->dish_list[$ds->dish_id];
                $category = DishCategoryRelation::model()->findByAttributes(array('dish_id' => $ds->dish_id));   
                $insert_odf = $db->createCommand()->insert('order_dish_flash_team',array(
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
                    'order_id' => $this->order_id_team,
                    'order_count' => $ds->count,
                    'order_sum_price' => $ds->total_price,
                    'dish_mode' => $dish->dish_mode,
                    'dish_child_count' => $dish->dish_child_count,
                    'dish_quanpin' => $dish->dish_quanpin,
                    'dish_jianpin' => $dish->dish_jianpin,
                ));
                
            }            
            if(!$insert_odf)
            {
                $result->code = ERR_ORDER_SYS_ERR;
                $trans->rollback();
                $result->msg = '保存多人点餐信息失败：保存菜品快照失败。';
                return $result;
            }

            $trans->commit();

            $result->code = SUCCESS;
            $result->order_id = $this->order_id_team;                        
            
            return $result;
            
        }
        catch(Exception $ex)
        {
            $trans->rollback();
            
            $result->code = ERR_ORDER_SYS_ERR;
            $result->msg = $ex->getMessage();
            Yii::log('提交多人点餐信息失败：'.$ex->getMessage(), CLogger::LEVEL_ERROR);
            return $result;
        }
    }
    
    /**
     * 下单后将多人点餐订单状态设为完成
     */
    private function finish_oders_team(){
        $db = Yii::app()->db;
        $updateResult = $db->createCommand()->update('orders_team',array(
                'order_customer_id' => -1,
                'order_createtime' => date('Y-m-d H:i:s',time()),
                'order_person_count' => $this->dinner_count,
                'order_dinnertime' => date('Y-m-d H:i:s',time()),
                'order_amount' => 0,
                'order_paid' => 0,
                'order_status' => ORDER_STATUS_COMPLETE,
                'order_type' => ORDER_TYPE_SUB_TALE_DISH,
                'order_ispay' => 0,
                'order_pay_type' => ORDER_PAY_TYPE_VISIT_CASH,
                'contact_id' => -1,
                'dealer_id' => $this->dealer_id,
            ),'order_id=:order_id',array(':order_id'=>  $this->order_id_team));
        if(!$updateResult)
        {
            return FALSE;
        }
       else{            
            return TRUE;
        }
    }


    /*
     * 检查参数
     */
    private function check_args()
    {
        $result = new OperResult();
        $result->code = ERR_ORDER_TAKEOUT_ARGS;
        
//        if(empty($this->username))
//        {
//            $result->msg = '用户名为空';
//            return $result;
//        }
        
        if(empty($this->mobile))
        {
            $result->msg = '手机号为空';
            return $result;
        }       
        
        if((!is_array($this->dishes)) || count($this->dishes) == 0)
        {
            $result->msg = '菜品为空';
            return $result;
        }
        
        if(empty($this->reserv_id))
        {
            $result->msg = '没有订台';
            return $result;
        }
        
        
        /*
         * post dish format:{dish_id,dish_name,count,per_price,total_price,
         */
        foreach ($this->dishes as $dish)
        {
            $ds = Dish::model()->findByPk($dish->dish_id);
            if(isset($ds))
            {
                $this->dish_list[$dish->dish_id] = $ds;
            }
            else
            {
                $result->msg = '菜品'.$ds->dish_id.'不存在';
                return $result;
            }
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
    
    /*
     * 检查堂食点菜参数
     */
    private function check_hall_args()
    {
        $result = new OperResult();
        $result->code = ERR_ORDER_TAKEOUT_ARGS;
             
        
        if((!is_array($this->dishes)) || count($this->dishes) == 0)
        {
            $result->msg = '菜品为空';
            return $result;
        }        
        
        /*
         * post dish format:{dish_id,dish_name,count,per_price,total_price,
         */
        foreach ($this->dishes as $dish)
        {
            $ds = Dish::model()->findByPk($dish->dish_id);
            if(isset($ds))
            {
                $this->dish_list[$dish->dish_id] = $ds;
            }
            else
            {
                $result->msg = '菜品'.$ds->dish_id.'不存在';
                return $result;
            }
        }
                
        $result->code = SUCCESS;
        return $result;
    }
    
    /**
     * 检查预定桌台信息
     * @return \OperResult
     */
    private function check_booking_args()
    {
        $result = new OperResult();
        $result->code = ERR_ORDER_TAKEOUT_ARGS;
        
//        if(empty($this->username))
//        {
//            $result->msg = '用户名为空';
//            return $result;
//        }
        
        if(empty($this->mobile))
        {
            $result->msg = '手机号为空';
            return $result;
        }               
        
//        if(empty($this->reserv_id))
//        {
//            $result->msg = '没有订台';
//            return $result;
//        }               
        
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
