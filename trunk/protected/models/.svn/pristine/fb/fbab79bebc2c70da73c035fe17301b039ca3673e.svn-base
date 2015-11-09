<?php

/**
 * This is the model class for table "dealer_customer".
 *
 * The followings are the available columns in table 'dealer_customer':
 * @property string $dc_id
 * @property string $dealer_id
 * @property string $customer_id
 * @property integer $dc_relat_type
 *
 * The followings are the available model relations:
 * @property Customer $customer
 */
class DealerCustomer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dealer_customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dc_relat_type', 'numerical', 'integerOnly'=>true),
			array('dealer_id, customer_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dc_id, dealer_id, customer_id, dc_relat_type', 'safe', 'on'=>'search'),
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
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dc_id' => '关联id',
			'dealer_id' => '商家id',
			'customer_id' => '客户id',
			'dc_relat_type' => '关联类别：
            1 操作者；
            2 销售经理；',
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

		$criteria=new CDbCriteria;

		$criteria->compare('dc_id',$this->dc_id,true);
		$criteria->compare('dealer_id',$this->dealer_id,true);
		$criteria->compare('customer_id',$this->customer_id,true);
		$criteria->compare('dc_relat_type',$this->dc_relat_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealerCustomer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * 获取所有销售经理用户
         * @return type
         */
        public function GetAllSalesManager()
        {
            $sql = 'SELECT customer.customer_id,customer.customer_name FROM customer 
                INNER JOIN auth_assignment
                ON customer.customer_id = auth_assignment.userid
                AND auth_assignment.itemname = ?';
            $attr = array('销售经理');
            $conn = Yii::app()->db;
            $cmd = $conn -> createCommand($sql);
            $reader = $cmd -> query($attr);
            $ary = $reader -> readAll();
            return $ary;
        }
}
