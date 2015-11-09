<?php

/**
 * This is the model class for table "apply_join".
 *
 * The followings are the available columns in table 'apply_join':
 * @property string $apply_id
 * @property string $dealer_name
 * @property string $dealer_tel
 * @property string $dealer_add
 * @property string $contact_name
 * @property string $contact_tel
 * @property string $id_image_file_url
 * @property string $create_time
 * @property integer $status 
 */
class ApplyJoin extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'apply_join';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dealer_name, dealer_tel', 'length', 'max'=>100),
			array('dealer_add', 'length', 'max'=>200),
                        array('dealer_name,dealer_tel,contact_name,dealer_add,contact_tel,id_image_file_url', 'required'),
			array('contact_name, id_image_file_url', 'length', 'max'=>50),
			array('contact_tel', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('apply_id, dealer_name, dealer_tel, dealer_add, contact_name, contact_tel, id_image_file_url,create_time,status', 'safe', 'on'=>'search'),
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
			'apply_id' => '申请单id',
			'dealer_name' => '商家名称',
			'dealer_tel' => '商家电话',
			'dealer_add' => '商家地址',
			'contact_name' => '联系人',
			'contact_tel' => '联系人电话',
			'id_image_file_url' => '身份证附件',
                        'create_time' => '申请日期',
                        'status'=>'状态：0-未联系；1-已联系'
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

		$criteria->compare('apply_id',$this->apply_id,true);
		$criteria->compare('dealer_name',$this->dealer_name,true);
		$criteria->compare('dealer_tel',$this->dealer_tel,true);
		$criteria->compare('dealer_add',$this->dealer_add,true);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_tel',$this->contact_tel,true);
		$criteria->compare('id_image_file_url',$this->id_image_file_url,true);
                $criteria->compare('create_time',$this->create_time,true);
                $criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ApplyJoin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
