<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DealerUserIdentity
 *
 * @author lts
 */
class DealerUserIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $usernametem = strtolower($this->username);
        $user = Customer::model()->getDealerUserInfo($usernametem);
        if ($user === null) {
            Yii::log('用户不存在，username：' . $this->username, CLogger::LEVEL_INFO);
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (!Customer::model()->validatePassword($user->customer_name, $this->password, $user->customer_pwd)) {
            Yii::log('用户输入密码错误，username:' . $this->username, CLogger::LEVEL_INFO);
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->customer_id;
            $this->username = $user->customer_name;
//            Yii::app()->cache->set('dealer_id', $user->dealer_id);
            Yii::app()->session['dealer_id'] = $user->dealer_id;
            Yii::log('用户登录成功，username:' . $this->username . ' customer_id:' . $user->customer_id
                    . ' dealer_id:' . $user->dealer_id, CLogger::LEVEL_INFO);
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}
