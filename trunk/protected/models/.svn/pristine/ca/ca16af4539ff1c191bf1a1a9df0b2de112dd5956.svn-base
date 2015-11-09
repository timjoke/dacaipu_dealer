<?php

/**
 * This is the model class for table "order_dish_flash_team".
 *
 * The followings are the available columns in table 'order_dish_flash_team':
 * @property string $flash_id
 * @property string $dish_id
 * @property string $dish_name
 * @property string $dish_price
 * @property integer $dish_recommend
 * @property string $dish_package_fee
 * @property integer $dish_is_vaget
 * @property integer $dish_spicy_level
 * @property string $dish_introduction
 * @property string $dish_category_id
 * @property string $dealer_id
 * @property integer $dish_status
 * @property string $dish_createtime
 * @property string $order_id
 * @property integer $order_count
 * @property string $order_sum_price
 * @property integer $dish_mode
 * @property string $dish_group_no
 * @property string $dish_child_count
 * @property string $dish_quanpin
 * @property string $dish_jianpin
 */
class OrderDishFlashTeam extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_dish_flash_team';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dish_id, dish_createtime', 'required'),
			array('dish_recommend, dish_is_vaget, dish_spicy_level, dish_status, order_count, dish_mode', 'numerical', 'integerOnly'=>true),
			array('dish_id, dish_category_id, dealer_id, order_id, dish_group_no, dish_child_count', 'length', 'max'=>20),
			array('dish_name, dish_jianpin', 'length', 'max'=>50),
			array('dish_price, dish_package_fee, order_sum_price', 'length', 'max'=>10),
			array('dish_introduction', 'length', 'max'=>8000),
			array('dish_quanpin', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('flash_id, dish_id, dish_name, dish_price, dish_recommend, dish_package_fee, dish_is_vaget, dish_spicy_level, dish_introduction, dish_category_id, dealer_id, dish_status, dish_createtime, order_id, order_count, order_sum_price, dish_mode, dish_group_no, dish_child_count, dish_quanpin, dish_jianpin', 'safe', 'on'=>'search'),
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
			'flash_id' => '快照id',
			'dish_id' => '菜品id',
			'dish_name' => '菜品名称',
			'dish_price' => '菜品单价',
			'dish_recommend' => '是否推荐
            0 否；
            1 是；',
			'dish_package_fee' => '打包费',
			'dish_is_vaget' => '是否素菜',
			'dish_spicy_level' => '辣度',
			'dish_introduction' => '简介',
			'dish_category_id' => '所属类别',
			'dealer_id' => '所属商家',
			'dish_status' => '状态',
			'dish_createtime' => 'Dish Createtime',
			'order_id' => '订单id',
			'order_count' => '数量',
			'order_sum_price' => '菜品总价',
			'dish_mode' => '菜品模式
            1 单菜售卖；
            2 套餐组合售卖；
            3 单菜或分组都可售卖；',
			'dish_group_no' => '菜品套餐id',
			'dish_child_count' => '所属套餐菜品id',
			'dish_quanpin' => '名称全拼',
			'dish_jianpin' => '名称简拼',
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

		$criteria->compare('flash_id',$this->flash_id,true);
		$criteria->compare('dish_id',$this->dish_id,true);
		$criteria->compare('dish_name',$this->dish_name,true);
		$criteria->compare('dish_price',$this->dish_price,true);
		$criteria->compare('dish_recommend',$this->dish_recommend);
		$criteria->compare('dish_package_fee',$this->dish_package_fee,true);
		$criteria->compare('dish_is_vaget',$this->dish_is_vaget);
		$criteria->compare('dish_spicy_level',$this->dish_spicy_level);
		$criteria->compare('dish_introduction',$this->dish_introduction,true);
		$criteria->compare('dish_category_id',$this->dish_category_id,true);
		$criteria->compare('dealer_id',$this->dealer_id,true);
		$criteria->compare('dish_status',$this->dish_status);
		$criteria->compare('dish_createtime',$this->dish_createtime,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('order_count',$this->order_count);
		$criteria->compare('order_sum_price',$this->order_sum_price,true);
		$criteria->compare('dish_mode',$this->dish_mode);
		$criteria->compare('dish_group_no',$this->dish_group_no,true);
		$criteria->compare('dish_child_count',$this->dish_child_count,true);
		$criteria->compare('dish_quanpin',$this->dish_quanpin,true);
		$criteria->compare('dish_jianpin',$this->dish_jianpin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderDishFlashTeam the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
