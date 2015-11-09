<?php

/**
 * This is the model class for table "order_discount".
 *
 * The followings are the available columns in table 'order_discount':
 * @property string $ao_id
 * @property string $order_id
 * @property string $discount_id
 * @property string $discount_name
 * @property integer $discount_mode
 * @property string $discount_value
 * @property string $discount_money_value
 */
class OrderDiscount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_discount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('discount_mode', 'numerical', 'integerOnly'=>true),
			array('order_id, discount_id', 'length', 'max'=>20),
			array('discount_name', 'length', 'max'=>50),
			array('discount_value, discount_money_value', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ao_id, order_id, discount_id, discount_name, discount_mode, discount_value, discount_money_value', 'safe', 'on'=>'search'),
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
			'ar' => array(self::BELONGS_TO, 'DiscountPlan', 'ar_id'),
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ao_id' => '订单折扣id',
			'order_id' => '订单id',
			'discount_id' => '折扣id',
			'discount_name' => '折扣名称',
			'discount_mode' => '折扣模式：
            1 现金；
            2 百分比；',
			'discount_value' => '折扣值',
			'discount_money_value' => '折扣金额',
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

		$criteria->compare('ao_id',$this->ao_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('discount_id',$this->discount_id,true);
		$criteria->compare('discount_name',$this->discount_name,true);
		$criteria->compare('discount_mode',$this->discount_mode);
		$criteria->compare('discount_value',$this->discount_value,true);
		$criteria->compare('discount_money_value',$this->discount_money_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderDiscount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
     /**
     * 根据订单号获取优惠计划
     * @param type $order_id 订单号
     * @return type
     */
    public function getOrderDiscountByOrderId($order_id)
    {
        $sql = 'SELECT
            discount.discount_name as name,
            discount.discount_value as discount_value,
            order_discount.discount_money_value as discount_money_value 
            FROM order_discount
            LEFT JOIN discount ON order_discount.discount_id = discount.discount_id
            WHERE order_discount.order_id = ?';

        $attr = array($order_id);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();
        
        return $ary;
    }
}
