<?php

/**
 * This is the model class for table "orders_team".
 *
 * The followings are the available columns in table 'orders_team':
 * @property string $order_id
 * @property string $order_customer_id
 * @property string $order_createtime
 * @property string $order_dinnertime
 * @property string $order_amount
 * @property string $order_paid
 * @property integer $order_status
 * @property integer $order_type
 * @property integer $order_ispay
 * @property integer $order_pay_type
 * @property string $contact_id
 * @property string $dealer_id
 * @property integer $order_person_count
 */
class OrdersTeam extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orders_team';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_createtime', 'required'),
			array('order_status, order_type, order_ispay, order_pay_type, order_person_count', 'numerical', 'integerOnly'=>true),
			array('order_customer_id, contact_id, dealer_id', 'length', 'max'=>20),
			array('order_amount, order_paid', 'length', 'max'=>10),
			array('order_dinnertime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, order_customer_id, order_createtime, order_dinnertime, order_amount, order_paid, order_status, order_type, order_ispay, order_pay_type, contact_id, dealer_id, order_person_count', 'safe', 'on'=>'search'),
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
			'order_id' => '订单id',
			'order_customer_id' => 'Order Customer',
			'order_createtime' => '创建时间',
			'order_dinnertime' => '用餐时间',
			'order_amount' => '应收金额',
			'order_paid' => '实收金额',
			'order_status' => '订单状态
            1 待付款；
            2 待处理；
            3 处理中；
            4 已拒绝；
            5 待派送；
            6 待取餐；
            7 派送中；
            8 已完成； 
            9 已结束；',
			'order_type' => '订单类型
            1 外卖送餐；
            2 外卖自取；
            3 预订桌台；
            4 预订桌台+点菜；
            ',
			'order_ispay' => '是否支付
            0 否；
            1 是；
            ',
			'order_pay_type' => '付款方式
            1 上门派送POS刷卡；
            2 上门派送现金支付；
            3 门店POS刷卡；
            4 门店现金支付；
            5 在线支付宝；
            6 在线网银；
            7 在线会员充值卡；',
			'contact_id' => '联系人id',
			'dealer_id' => '商家id',
			'order_person_count' => '就餐人数',
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

		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('order_customer_id',$this->order_customer_id,true);
		$criteria->compare('order_createtime',$this->order_createtime,true);
		$criteria->compare('order_dinnertime',$this->order_dinnertime,true);
		$criteria->compare('order_amount',$this->order_amount,true);
		$criteria->compare('order_paid',$this->order_paid,true);
		$criteria->compare('order_status',$this->order_status);
		$criteria->compare('order_type',$this->order_type);
		$criteria->compare('order_ispay',$this->order_ispay);
		$criteria->compare('order_pay_type',$this->order_pay_type);
		$criteria->compare('contact_id',$this->contact_id,true);
		$criteria->compare('dealer_id',$this->dealer_id,true);
		$criteria->compare('order_person_count',$this->order_person_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrdersTeam the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
