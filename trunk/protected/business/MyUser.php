<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * MyUser 的注释
 *
 * @作者 roy
 */
class MyUser extends CWebUser {

    public $username;

    /**
     * 当前用户是否登录
     * @return bool
     */
    public function isLogin() {
        return isset($this->id);
    }

    public function customer() {
        return $this->isLogin() ? Customer::model()->findByPk($this->id) : null;
    }

    public function getRoles() {
        return $this->isLogin() ?
                Yii::app()->authManager->getAuthItems(AUTHITEM_TYPE_ROLE, Yii::app()->user->getId()) : null;
    }

    public function isAdmin() {
        return $this->isRole(CUSTOMER_ROLENAME_ADMIN);
    }

    private function isRole($role_name) {
        return $this->isLogin() ?
                array_key_exists($role_name, $this->getRoles()) : false;
    }

    public function isGroupUser() {
        return $this->isRole(CUSTOMER_ROLENAME_GROUPUSER);
    }

    public function isDealerUser() {
        return $this->isRole(CUSTOMER_ROLENAME_DEALERUSER);
    }

    public function isCustomer() {
        return $this->isRole(CUSTOMER_ROLENAME_CUSTOMER);
    }

    function login($identity, $duration = 0) {
        parent::login($identity, $duration);
    }

    function logout($destroySession = true) {
        parent::logout($destroySession);
    }

}
