<?php

/**
 * This is the model class for table "v_order_dish_count".
 *
 * The followings are the available columns in table 'v_order_dish_count':
 * @property string $dish_id
 * @property string $dish_name
 * @property string $count
 */
class VOrderDishCount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_order_dish_count';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dish_id', 'length', 'max'=>20),
			array('dish_name', 'length', 'max'=>50),
			array('count', 'length', 'max'=>21),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dish_id, dish_name, count', 'safe', 'on'=>'search'),
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
			'dish_id' => '菜品id',
			'dish_name' => '菜品名称',
			'count' => 'Count',
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

		$criteria->compare('dish_id',$this->dish_id,true);
		$criteria->compare('dish_name',$this->dish_name,true);
		$criteria->compare('count',$this->count,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VOrderDishCount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * 根据菜品id获得该菜品被下单过的数量
         * @param type $dish_id 菜品id
         * @return type int
         */
        public function get_count_by_dish_id($dish_id)
        {
            $obj = $this->findByAttributes(array('dish_id' => $dish_id));
            return isset($obj) ? $obj->count : 0;
        }
}
