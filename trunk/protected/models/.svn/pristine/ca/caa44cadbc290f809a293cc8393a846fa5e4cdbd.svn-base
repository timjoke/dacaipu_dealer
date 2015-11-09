<?php

/**
 * This is the model class for table "customer_card".
 *
 * The followings are the available columns in table 'customer_card':
 * @property string $cc_id
 * @property string $customer_id
 * @property string $card_id
 * @property string $cc_date
 * @property string $operator_id
 */
class CustomerCard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, card_id, operator_id', 'length', 'max'=>20),
			array('cc_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cc_id, customer_id, card_id, cc_date, operator_id', 'safe', 'on'=>'search'),
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
			'cc_id' => '关联id',
			'customer_id' => 'Customer',
			'card_id' => 'Card',
			'cc_date' => 'Cc Date',
			'operator_id' => 'Operator',
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

		$criteria->compare('cc_id',$this->cc_id,true);
		$criteria->compare('customer_id',$this->customer_id,true);
		$criteria->compare('card_id',$this->card_id,true);
		$criteria->compare('cc_date',$this->cc_date,true);
		$criteria->compare('operator_id',$this->operator_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
