<?php

/**
 * 桌台订单查询条件
 */
class TableByOrdersSearch extends CFormModel {

    public $is_smoke;
    public $sit_count;
    public $reserv_date;
    public $dealer_id;

    function __construct() {
        $this->is_smoke = -1;
        $this->sit_count = -1;
        $this->reserv_date = '';
        $this->dealer_id = 0;
    }

    public function rules() {
        return array(
            array('is_smoke, sit_count, reserv_date, dealer_id', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'is_smoke' => '是否吸烟',
            'sit_count' => '座位数',
            'reserv_date' => '日期',
            'dealer_id' => '商家id'
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            
        }
    }

}
