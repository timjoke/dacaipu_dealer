<?php

/**
 * This is the model class for table "discount_code".
 *
 * The followings are the available columns in table 'discount_code':
 * @property string $discountCode_id
 * @property string $discount_code
 * @property string $dealer_id
 * @property string $customer_name
 * @property integer $status
 * @property string $used_time
 * @property string $discount_create_time
 *
 * The followings are the available model relations:
 * @property Dealer $dealer
 */
class DiscountCode extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'discount_code';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('discount_code, dealer_id, customer_name, status, discount_create_time', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('discount_code, customer_name', 'length', 'max' => 50),
            array('dealer_id', 'length', 'max' => 20),
            array('used_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('discountCode_id, discount_code, dealer_id, customer_name, status, used_time, discount_create_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dealer' => array(self::BELONGS_TO, 'Dealer', 'dealer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'discountCode_id' => '折扣码id',
            'discount_code' => '折扣码字符串',
            'dealer_id' => '所属商家',
            'customer_name' => '用户名',
            'status' => '折扣码状态
            0、未使用
            1、已使用',
            'used_time' => '使用时间',
            'discount_create_time' => '创建时间',
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
    public function search($search) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('discount_code', $search->discount_code, true);
        $criteria->compare('dealer_id', $search->dealer_id, true);
        $criteria->compare('status', $search->discountCodeStatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DiscountCode the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
