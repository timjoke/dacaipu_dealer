<?php

class DiscountCodeSearch extends CFormModel{
    public $discount_code;
    public $discountCodeStatus;
    public $dealer_id;


    public function rules() {
        return array(
            array('discount_code, discountCodeStatus, dealer_id', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'discount_code' => '折扣码',
            'discountCodeStatus'=>'',
            'dealer_id'=>''
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            
        }
    }
}
