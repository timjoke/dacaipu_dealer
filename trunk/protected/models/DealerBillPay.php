<?php

/**
 * This is the model class for table "dealer_bill_pay".
 *
 * The followings are the available columns in table 'dealer_bill_pay':
 * @property string $pay_id
 * @property string $dealer_bill_id
 * @property string $pay_time
 * @property integer $pay_way
 * @property string $transaction_id
 * @property string $total_fee
 * @property string $discount
 * @property string $customer_id
 */
class DealerBillPay extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dealer_bill_pay';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pay_time', 'required'),
			array('pay_way', 'numerical', 'integerOnly'=>true),
			array('dealer_bill_id, customer_id', 'length', 'max'=>20),
			array('transaction_id', 'length', 'max'=>50),
			array('total_fee, discount', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pay_id, dealer_bill_id, pay_time, pay_way, transaction_id, total_fee, discount, customer_id', 'safe', 'on'=>'search'),
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
			'pay_id' => '支付id',
			'dealer_bill_id' => '账单id',
			'pay_time' => '支付日期',
			'pay_way' => '支付平台：
            1 财付通；
            2 支付宝；
            3 微信支付；',
			'transaction_id' => '支付平台订单号',
			'total_fee' => '金额',
			'discount' => '折扣',
			'customer_id' => '操作人id',
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

		$criteria->compare('pay_id',$this->pay_id,true);
		$criteria->compare('dealer_bill_id',$this->dealer_bill_id,true);
		$criteria->compare('pay_time',$this->pay_time,true);
		$criteria->compare('pay_way',$this->pay_way);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('total_fee',$this->total_fee,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('customer_id',$this->customer_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealerBillPay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
