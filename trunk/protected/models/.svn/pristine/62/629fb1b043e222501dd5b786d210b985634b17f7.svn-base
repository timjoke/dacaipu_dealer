<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrdersHistorySearch
 *
 * @author lts
 */
class OrdersHistorySearch extends CFormModel {

    public $start_time;
    public $end_time; //= date('Y-m-d H:i:s');
    public $order_id;
    public $contact_tel;
    public $has_coupon;
    
    public function rules() {
        return array(
            array('start_time, end_time, order_id, contact_tel,has_coupon', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'start_time' => '起始时间',
            'end_time' => '结束时间',
            'order_id'=>'',
            'contact_tel'=>'',
            'has_coupon'=>'',
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            
        }
    }

}
