<?php

/**
 * This is the model class for table "contact".
 *
 * The followings are the available columns in table 'contact':
 * @property string $contact_id
 * @property string $customer_id
 * @property string $contact_name
 * @property string $contact_tel
 * @property string $contact_addr
 *
 * The followings are the available model relations:
 * @property Customer $customer
 */
class Contact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id', 'length', 'max'=>20),
			array('contact_name, contact_tel', 'length', 'max'=>50),
			array('contact_addr', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('contact_id, customer_id, contact_name, contact_tel, contact_addr', 'safe', 'on'=>'search'),
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
			'contact_id' => '联系人id',
			'customer_id' => '客户id',
			'contact_name' => '联系人姓名',
			'contact_tel' => '联系人电话',
			'contact_addr' => '联系人地址',
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

		$criteria->compare('contact_id',$this->contact_id,true);
		$criteria->compare('customer_id',$this->customer_id,true);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_tel',$this->contact_tel,true);
		$criteria->compare('contact_addr',$this->contact_addr,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
     /**
     * 根据订单号获取联系人信息
     * @param type $contact_id 订单号
     * @return type
     */
    public function getContractByOrderId($contact_id)
    {
        $sql = 'SELECT 
            contact.contact_name as name,
            contact.contact_tel as tel,
            contact.contact_addr as addr
            FROM contact
            WHERE contact_id = ?';


        $attr = array($contact_id);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();
        
        return count($ary) > 0 ? busUlitity::arrayToObject($ary[0]) : null;
    }
}
