<?php

/**
 * This is the model class for table "discount".
 *
 * The followings are the available columns in table 'discount':
 * @property string $discount_id
 * @property string $discount_name
 * @property string $dealer_id
 * @property integer $discount_mode
 * @property string $discount_value
 * @property string $discount_condition
 * @property string $discount_compare_value
 */
class Discount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'discount';
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
			array('discount_name, discount_condition', 'length', 'max'=>50), 
                    	//array('discount_name, required', 'on'=>'create', 'message'=>'不能这样写大哥'),  
			array('dealer_id', 'length', 'max'=>20),
			array('discount_value, discount_compare_value', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('discount_id, discount_name, dealer_id, discount_mode, discount_value, discount_condition, discount_compare_value', 'safe', 'on'=>'search'),
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
			'discount_id' => '折扣id',
			'discount_name' => '折扣名称',
			'dealer_id' => '所属商家',
			'discount_mode' => '折扣模式
            1 金额；
            2 百分比；',
			'discount_value' => '折扣值',
			'discount_condition' => '折扣条件
            > 大于；
            >= 大于等于；
            = 等于；
            < 小于；
            <= 小于等于；
            != 不等于；
            ',
			'discount_compare_value' => '折扣条件比较值',
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

		$criteria->compare('discount_id',$this->discount_id,true);
		$criteria->compare('discount_name',$this->discount_name,true);
		$criteria->compare('dealer_id',$this->dealer_id,true);
		$criteria->compare('discount_mode',$this->discount_mode);
		$criteria->compare('discount_value',$this->discount_value,true);
		$criteria->compare('discount_condition',$this->discount_condition,true);
		$criteria->compare('discount_compare_value',$this->discount_compare_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Discount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
