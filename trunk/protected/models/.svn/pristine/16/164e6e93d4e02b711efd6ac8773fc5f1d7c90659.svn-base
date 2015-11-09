<?php

class CouponSearch extends CFormModel{
    public $start_time;
    public $end_time; //= date('Y-m-d H:i:s');
    public $coupon_no;
    public $coupon_status;
    public $dealer_id;


    public function rules() {
        return array(
            array('start_time, end_time,coupon_no, coupon_status, dealer_id', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'coupon_no' => '折扣码',
            'coupon_status'=>'状态',
            'dealer_id'=>''
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            
        }
    }
}
