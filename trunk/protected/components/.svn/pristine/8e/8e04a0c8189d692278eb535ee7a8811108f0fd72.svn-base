<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DealerLoginForm
 *
 * @author lts
 */
class DealerLoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;
    public $verifyCode;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password, verifyCode', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            //输入用户验证码
            array('verifyCode', 'captcha', 'message' => '请输入正确的验证码'),
            array('verifyCode', 'captcha', 'on' => 'login'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember me next time',
            'username' => '用户名',
            'password' => '密　码',
            'verifyCode' => '验证码',
            'rememberMe' => '记住登录状态'
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new DealerUserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate())
                $this->addError('password', '用户名或密码输入错误!');
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new DealerUserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === DealerUserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 7 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }

}
