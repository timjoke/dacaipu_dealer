<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerSearch
 *
 * @author zk
 */
class CustomerSearch extends CFormModel {

    public $name;
    public $phone; //= date('Y-m-d H:i:s');
    public $is_from_weixin;

    public function rules() {
        return array(
            array('name, phone, is_from_weixin', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => '会员名称',
            'phone' => '手机',
            'is_from_weixin' => '是否来自微信'
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            
        }
    }

}
