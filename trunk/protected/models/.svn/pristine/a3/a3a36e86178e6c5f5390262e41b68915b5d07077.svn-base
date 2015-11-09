<?php

/**
 * This is the model class for table "dish_over".
 *
 * The followings are the available columns in table 'dish_over':
 * @property string $over_id
 * @property string $dish_id
 * @property string $over_date
 * @property string $over_createtime
 */
class DishOver extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dish_over';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('over_createtime', 'required'),
			array('dish_id', 'length', 'max'=>20),
			array('over_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('over_id, dish_id, over_date, over_createtime', 'safe', 'on'=>'search'),
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
			'over_id' => '估清id',
			'dish_id' => '菜品id',
			'over_date' => '估清日期',
			'over_createtime' => '创建日期',
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

		$criteria->compare('over_id',$this->over_id,true);
		$criteria->compare('dish_id',$this->dish_id,true);
		$criteria->compare('over_date',$this->over_date,true);
		$criteria->compare('over_createtime',$this->over_createtime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DishOver the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
