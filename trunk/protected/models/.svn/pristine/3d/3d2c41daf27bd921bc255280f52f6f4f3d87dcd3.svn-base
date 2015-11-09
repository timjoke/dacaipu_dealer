<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property string $customer_id
 * @property string $customer_name
 * @property string $customer_mobile
 * @property string $customer_email
 * @property string $customer_pwd
 * @property string $customer_reg_time
 * @property integer $customer_status
 * @property string $customer_wechat_id
 * @property string $customer_yixin_id
 * @property string $customer_tel
 * @property string $customer_lic_no
 * @property integer $customer_sex
 * @property string $customer_saler_rate
 */
class Customer extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'customer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('customer_reg_time,customer_saler_rate', 'required'),
            array('customer_status, customer_sex', 'numerical', 'integerOnly' => true),
            array('customer_name, customer_pwd, customer_wechat_id, customer_yixin_id, customer_tel, customer_lic_no', 'length', 'max' => 50),
            array('customer_mobile', 'length', 'max' => 11),
            array('customer_email', 'length', 'max' => 100),
            array('customer_saler_rate', 'length', 'max' => 20),
            array('customer_saler_rate', 'intRangeValidator'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('customer_id, customer_name, customer_mobile, customer_email, customer_pwd, customer_reg_time, customer_status, customer_wechat_id, customer_yixin_id, customer_tel, customer_lic_no, customer_sex, customer_saler_rate', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'customer_id' => '客户id',
            'customer_name' => '姓名',
            'customer_mobile' => '手机号',
            'customer_email' => '邮箱',
            'customer_pwd' => '密码',
            'customer_reg_time' => 'Customer Reg Time',
            'customer_status' => '状态
            0 已禁用；
            1 有效；',
            'customer_wechat_id' => '微信openid',
            'customer_yixin_id' => '易信openid',
            'customer_tel' => '固定电话',
            'customer_lic_no' => '身份证号',
            'customer_sex' => '0 待识别；
            1 男；
            2 女；',
            'customer_saler_rate' => '提成费率',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('customer_id', $this->customer_id, true);
        $criteria->compare('customer_name', $this->customer_name, true);
        $criteria->compare('customer_mobile', $this->customer_mobile, true);
        $criteria->compare('customer_email', $this->customer_email, true);
        $criteria->compare('customer_pwd', $this->customer_pwd, true);
        $criteria->compare('customer_reg_time', $this->customer_reg_time, true);
        $criteria->compare('customer_status', $this->customer_status);
        $criteria->compare('customer_wechat_id', $this->customer_wechat_id, true);
        $criteria->compare('customer_yixin_id', $this->customer_yixin_id, true);
        $criteria->compare('customer_tel', $this->customer_tel, true);
        $criteria->compare('customer_lic_no', $this->customer_lic_no, true);
        $criteria->compare('customer_sex', $this->customer_sex);
        $criteria->compare('customer_saler_rate', $this->customer_saler_rate, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Customer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * customer_saler_rate最大值不得大于1.0
     */
    public function intRangeValidator()
    {
        if ($this->customer_saler_rate > 1)
        {
            $this->addError('customer_saler_rate', '最大值不得大于1.0');
        }
    }

    /**
     * 获取用户信息，登录使用(商铺用户)
     * @param type $username 用户名
     * @return type
     */
    public function getDealerUserInfo($username)
    {
        $sql = 'SELECT d.dealer_name, c.`customer_name`, c.`customer_pwd`, c.`customer_id`, r.dealer_id FROM '
                . '`customer` as c inner join dealer_customer as r on c.customer_id = r.customer_id '
                . ' inner join dealer as d on d.dealer_id = r.dealer_id '
                . 'WHERE customer_status='
                . CUSTOMER_STATUS_ENABLE . ' and customer_name=\'' . $username . '\''
                . ' and customer_status=' . CUSTOMER_STATUS_ENABLE;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryRow();
        return busUlitity::arrayToObject($obj);
    }

    /**
     * 根据商家ID取管理员信息
     * @param type $dealer_id
     * @return type
     */
    public function getDealerCustomer($dealer_id)
    {
        $sql = 'select c.* from dealer_customer d left join customer c on d.customer_id=c.customer_id where dealer_id=:dealer_id and d.dc_relat_type=1 order by dc_id asc limit 0,1;';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $cmd->bindParam(':dealer_id', $dealer_id);
        $obj = $cmd->queryRow();
        return busUlitity::arrayToObject($obj);
    }

    /**
     * 验证密码，将密码明文加密后得到密文字符串 验证字符串为用户+密码明文
     * @param type $username 用户名
     * @param type $password 用户输入的密码
     * @param type $customer_pwd 数据库中保存的密码
     * @return type
     */
    public function validatePassword($username, $password, $customer_pwd)
    {
        $inpsd = Customer::model()->encryptPassword($username, $password);
        $dbpsd = $customer_pwd;
        return $inpsd === $dbpsd;
    }

    /**
     * 验证门店用户
     * @param type $username 用户名
     * @param type $password 密码
     * @return type 1：成功；0：失败；
     */
    public function validDealerUser($username, $password)
    {
        $md5pwd = $this->encryptPassword($username, $password);
        $user = $this->findByAttributes(array(
            'customer_name' => $username,
            'customer_pwd' => $md5pwd,
        ));

        if (!isset($user))
            return 0;

        $auth = AuthAssignment::model()->findByAttributes(
                array(
                    'itemname' => CUSTOMER_ROLENAME_DEALERUSER,
                    'userid' => $user->customer_id));
        return isset($auth) ? 1 : 0;
    }

    /**
     * 修改用户密码
     * @param type $username 用户名
     * @param type $newpassword 用户输入的新密码
     * @return boolean 是否修改成功
     */
    public function changePassword($username, $newpassword)
    {
        $newpsd = $this->encryptPassword($username, $newpassword); //密码加密
        $count = Customer::model()->updateAll(array('customer_pwd' => $newpsd), 'customer_name=:customer_name'
                , array(':customer_name' => $username));
        if ($count > 0)
        {
            return true;
        } else
        {
            return false;
        }
    }

    /**
     * 获取用户密码的密文
     * @param type $username 用户名
     * @param type $password 密码
     * @return type
     */
    public function encryptPassword($username, $password)
    {
        $inpsd = md5($username . $password);
        return $inpsd;
    }

    /**
     * 根据微信id创建默认用户
     * @param string $wechat_id 微信id
     * @return int 用户id
     */
    public function createWechatUser($wechat_id)
    {
        $db = Yii::app()->db;
        $c = new Customer();
        $cmd = $db->createCommand();
        $cmd->insert('customer', array(
            'customer_name' => $wechat_id,
            'customer_status' => CUSTOMER_STATUS_ENABLE,
            'customer_reg_time' => date('Y-m-d H:i:s', time()),
            'customer_wechat_id' => $wechat_id));

        $customer_id = $db->getLastInsertID();
        Yii::app()->authManager->assign(CUSTOMER_ROLENAME_CUSTOMER, $customer_id);
        return $customer_id;
    }

}
