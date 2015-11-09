<?php

/**
 * This is the model class for table "dealer_wechat".
 *
 * The followings are the available columns in table 'dealer_wechat':
 * @property string $dealer_wechat_id
 * @property string $dealer_id
 * @property string $wechat_email
 * @property string $wechat_email_pwd
 * @property string $wechat_pwd
 * @property string $wechat_name
 * @property string $wechat_original_id
 * @property integer $wechat_type
 * @property string $wechat_id
 * @property string $wechat_manager_org
 * @property string $wechat_org_code
 * @property string $wechat_manager
 * @property string $wechat_manager_no
 * @property integer $wechat_manager_sex
 * @property integer $wechat_sign
 */
class DealerWechat extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dealer_wechat';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('wechat_type, wechat_manager_sex, wechat_sign', 'numerical', 'integerOnly' => true),
            array('dealer_id', 'length', 'max' => 20),
            array('dealer_id', 'mustChoseValidator'),
            array('wechat_email', 'length', 'max' => 100),
            array('wechat_email_pwd, wechat_pwd, wechat_name, wechat_original_id, wechat_id, wechat_manager_org, wechat_org_code, wechat_manager, wechat_manager_no', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('dealer_wechat_id, dealer_id, wechat_email, wechat_email_pwd, wechat_pwd, wechat_name, wechat_original_id, wechat_type, wechat_id, wechat_manager_org, wechat_org_code, wechat_manager, wechat_manager_no, wechat_manager_sex, wechat_sign', 'safe', 'on' => 'search'),
        );
    }

    /**
     * 所属商家为必选项必选项验证
     */
    public function mustChoseValidator()
    {
        if ($this->dealer_id == 0)
        {
            $this->addError('dealer_id', '所属商家为必选项');
        }
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
            'dealer_wechat_id' => '信息id',
            'dealer_id' => '商家id',
            'wechat_email' => '微信登陆邮箱',
            'wechat_email_pwd' => '微信邮箱密码',
            'wechat_pwd' => '微信登陆密码',
            'wechat_name' => '微信名称',
            'wechat_original_id' => '微信原始ID',
            'wechat_type' => '微信账户类型',
            'wechat_id' => '微信号',
            'wechat_manager_org' => '运营机构名称',
            'wechat_org_code' => '组织机构代码',
            'wechat_manager' => '授权运营人名称',
            'wechat_manager_no' => '授权运营人身份证号',
            'wechat_manager_sex' => '授权运营人性别',
            'wechat_sign' => '是否认证',
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

        $criteria->compare('dealer_wechat_id', $this->dealer_wechat_id, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('wechat_email', $this->wechat_email, true);
        $criteria->compare('wechat_email_pwd', $this->wechat_email_pwd, true);
        $criteria->compare('wechat_pwd', $this->wechat_pwd, true);
        $criteria->compare('wechat_name', $this->wechat_name, true);
        $criteria->compare('wechat_original_id', $this->wechat_original_id, true);
        $criteria->compare('wechat_type', $this->wechat_type);
        $criteria->compare('wechat_id', $this->wechat_id, true);
        $criteria->compare('wechat_manager_org', $this->wechat_manager_org, true);
        $criteria->compare('wechat_org_code', $this->wechat_org_code, true);
        $criteria->compare('wechat_manager', $this->wechat_manager, true);
        $criteria->compare('wechat_manager_no', $this->wechat_manager_no, true);
        $criteria->compare('wechat_manager_sex', $this->wechat_manager_sex);
        $criteria->compare('wechat_sign', $this->wechat_sign);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DealerWechat the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
