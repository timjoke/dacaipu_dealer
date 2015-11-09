<?php

/**
 * 堂食下单业务类
 *
 * @作者 roy
 */
class busPickOrder
{
    private $cache_limit = 3;
    
    public function get_dish()
    {
        //请求订单
        //请求/同步菜品
        //
    }
    
    /**
     * 获得最新的未提交的点菜单
     * @param type $dealer_id   商家id
     * @param type $table_id    桌台id
     */
    public function get_last_order($dealer_id,$table_id)
    {
        //该订台的当前订单，如果没有则生成一个
        $tb_order_key = 'tb_od_'.$dealer_id.'_'.$table_id;
        $order = Yii::app()->cache->get($tb_order_key);
        if($order)
        {
            return $order;
        }
        else
        {
            $order = new OperResult();
            $order->create_time = new DateTime();
            $order->dealer_id = $dealer_id; 
            $order->table_id = $table_id;
            
            Yii::app()->cache->set($tb_order_key, $order);
            return $order;
        }
    }
    
    
    public function get_update($dealer_id,$table_id,$user_id)
    {
        set_time_limit(0);
        
        
        $req_time = new DateTime();
        $req_out_time = $req_time->add(date_interval_create_from_date_string($this->cache_limit.' second'));
        $result = new OperResult();
        while(true)
        {
            $now = new DateTime();
            if($now > $req_time)
            {
                $result->code = 2;
                echo json_encode($result);
                ob_flush();
                flush();
                return;
            }
            
            //订台变化队列
        $up_que_key = 'table_order_update_queue_'.$dealer_id.'_'.$table_id;
        $up_que = Yii::app()->cache->get($up_que_key);
        
        //订单变化通知队列
        $up_notice_que_key = 'table_order_update_notice_queue_'.$dealer_id.'_'.$table_id;
        $up_notice_que = Yii::app()->cache->get($up_notice_que_key);
        
        if(!$up_que)
        {
            $up_que = array();
            Yii::app()->cache->set($up_que_key, $up_que);
        }
        
        if(!$up_notice_que)
        {
            $up_notice_que = array();
            Yii::app()->cache->set($up_notice_que_key, $up_notice_que);
        }
        
            
            //给用户下发的通知
            $up_list = array();
            
            foreach($up_que as $up)
            {
                $up_notice_item = $this->get_item($up_notice_que,$up->id);
                
                if(!$up_notice_item)
                {
                    $up_notice_item = array();
                }
                
                
                if(in_array($user_id,$up_notice_item))
                {
                    continue;
                }
                else
                {
                    array_push($up_list, $up);
                    array_push($up_notice_item,$user_id);
                    $up_notice_que[$up->id] = $up_notice_item;
                    Yii::app()->cache->set($up_notice_que_key,$up_notice_que);
                }
            }
            
            if(count($up_list) != 0)
            {
                $result->code = 1;
                $result->up_list = $up_list;
                echo json_encode($result);
                ob_flush();
                flush();
                return;
            }
            else
            {
                sleep(0.1);
            }
        }
    }
    
    
    /**
     * 
     * @param type $dealer
     * @param type $table
     * @param type $user_id
     * @param type $dish_id
     * @param type $operation
     */
    public function add_update($dealer_id,$table_id,$user_id,$dish_id,$operation)
    {
        //订台变化队列
        $up_que_key = 'table_order_update_queue_'.$dealer_id.'_'.$table_id;
        $up_que = Yii::app()->cache->get($up_que_key);
        
        //订单变化通知队列
        $up_notice_que_key = 'table_order_update_notice_queue_'.$dealer_id.'_'.$table_id;
        $up_notice_que = Yii::app()->cache->get($up_notice_que_key);
        
        if(!$up_que)
        {
            $up_que = array();
            Yii::app()->cache->set($up_que_key, $up_que);
        }
        
        if(!$up_notice_que)
        {
            $up_notice_que = array();
            Yii::app()->cache->set($up_notice_que_key, $up_notice_que);
        }
        
        $up = new OperResult();
        $up->id = time();
        $up->dish_id = $dish_id;
        $up->operation = $operation;
        $up->user_id = $user_id;

        if(!is_array($up_que))
        {
            $up_que = array();
        }
        
        array_push($up_que,$up);
        Yii::app()->cache->set($up_que_key, $up_que);
        
        
        $up_notice_item = $this->get_item($up_notice_que,$up->id);
        if(!isset($up_notice_item))
        {
            $up_notice_item = array();
        }
        
        array_push($up_notice_item, $user_id);
        $up_notice_que[$up->id] = $up_notice_item;
        Yii::app()->cache->set($up_notice_que_key,$up_notice_que);
        
        $result = new OperResult();
        $result->code = 1;
        
        echo json_encode($result);
    }
    
    
    private function get_item($ary,$key)
    {
        return array_key_exists($key, $ary) ? $ary[$key]:null;
    }
    
    
    
    
}
