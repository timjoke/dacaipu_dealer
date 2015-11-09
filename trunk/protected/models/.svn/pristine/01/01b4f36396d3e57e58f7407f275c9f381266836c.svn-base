<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username', 'required','message'=>'用户名必填'),
			array('password', 'required','message'=>'密码必填'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
            'username' => '手机号',
			'rememberMe'=>'下次不用再登录',
            'password' => '密&nbsp;&nbsp;&nbsp;码'
		);
	}
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new CustomerIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','手机号或密码错误.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new CustomerIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===CustomerIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			//$duration=0;
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
        
        /**
         * 下单时自动登录
         */
        public function order_auto_login() 
        {
            $this->_identity=new CustomerIdentity($this->username,$this->password);
            Yii::app()->user->login($this->_identity,3600 * 24 * 365);
        }
}
