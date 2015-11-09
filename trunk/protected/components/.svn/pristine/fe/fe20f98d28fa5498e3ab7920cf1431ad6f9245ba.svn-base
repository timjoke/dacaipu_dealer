<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CustomerIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() 
    {
        $username = strtolower($this->username);
        $user = Customer::model()->findByAttributes(array('customer_name' => $username));
        if ($user === null)
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else if (!$user->validatePassword($user->customer_name, $this->password, $user->customer_pwd))
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else 
        {
            $h = new Helper();
            $roles = Yii::app()->authManager->getAuthItems(AUTHITEM_TYPE_ROLE, $user->customer_id);
            if(!array_key_exists(CUSTOMER_ROLENAME_CUSTOMER, $roles))
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            else 
            {
                $this->_id = $user->customer_id;
                $this->username = $user->customer_name;
                $this->errorCode = self::ERROR_NONE;
            }
        }
        
        return $this->errorCode == self::ERROR_NONE;
    }
    
    
    /**
     * 自动登录调用
     * @return type
     */
    public function autoLogin_auth() 
    {
        $username = strtolower($this->username);
        $user = Customer::model()->findByAttributes(array('customer_name' => $username));
        if ($user === null)
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else 
        {
            $h = new Helper();
            $roles = Yii::app()->authManager->getAuthItems(AUTHITEM_TYPE_ROLE, $user->customer_id);
            if(!array_key_exists(CUSTOMER_ROLENAME_CUSTOMER, $roles))
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            else 
            {
                $this->_id = $user->customer_id;
                $this->username = $user->customer_name;
                $this->errorCode = self::ERROR_NONE;
            }
        }
        
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}
