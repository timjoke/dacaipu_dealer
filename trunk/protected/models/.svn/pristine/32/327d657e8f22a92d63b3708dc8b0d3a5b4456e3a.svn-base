<?php

/**
 * This is the model class for table "v_table_order_dinner_time".
 *
 * The followings are the available columns in table 'v_table_order_dinner_time':
 * @property string $table_order_time_point_id
 * @property string $dealer_dinner_id
 * @property string $time_point
 * @property string $dealer_id
 * @property integer $dinner_type
 * @property integer $status
 */
class VTableOrderDinnerTime extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_table_order_dinner_time';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dinner_type, status', 'numerical', 'integerOnly'=>true),
			array('table_order_time_point_id, dealer_dinner_id, dealer_id', 'length', 'max'=>20),
			array('time_point', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('table_order_time_point_id, dealer_dinner_id, time_point, dealer_id, dinner_type, status', 'safe', 'on'=>'search'),
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
			'table_order_time_point_id' => 'Table Order Time Point',
			'dealer_dinner_id' => 'Dealer Dinner',
			'time_point' => 'Time Point',
			'dealer_id' => '商家id',
			'dinner_type' => '餐市类型
            1、早市
            2、午市
            3、晚市
            4、夜宵',
			'status' => '状态
            0、无效
            1、有效',
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

		$criteria->compare('table_order_time_point_id',$this->table_order_time_point_id,true);
		$criteria->compare('dealer_dinner_id',$this->dealer_dinner_id,true);
		$criteria->compare('time_point',$this->time_point,true);
		$criteria->compare('dealer_id',$this->dealer_id,true);
		$criteria->compare('dinner_type',$this->dinner_type);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VTableOrderDinnerTime the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
