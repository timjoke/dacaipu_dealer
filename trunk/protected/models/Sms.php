<?php

/**
 * This is the model class for table "sms".
 *
 * The followings are the available columns in table 'sms':
 * @property string $sms_id
 * @property string $sms_content
 * @property string $sms_receiver
 * @property integer $sms_type
 * @property string $sms_create_time
 * @property integer $sms_status
 */
class Sms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sms_create_time', 'required'),
			array('sms_type, sms_status', 'numerical', 'integerOnly'=>true),
			array('sms_content', 'length', 'max'=>500),
			array('sms_receiver', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sms_id, sms_content, sms_receiver, sms_type, sms_create_time, sms_status', 'safe', 'on'=>'search'),
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
			'sms_id' => '短信id',
			'sms_content' => '短信内容',
			'sms_receiver' => '接收号码',
			'sms_type' => '短信类型
            1.注册；
            2.找回密码；
            3.订单状态变化；
            4.商家消息；
            5.系统消息；',
			'sms_create_time' => '创建日期',
			'sms_status' => '状态
            1.待发送；
            2.已发送；
            3.失败；',
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

		$criteria->compare('sms_id',$this->sms_id,true);
		$criteria->compare('sms_content',$this->sms_content,true);
		$criteria->compare('sms_receiver',$this->sms_receiver,true);
		$criteria->compare('sms_type',$this->sms_type);
		$criteria->compare('sms_create_time',$this->sms_create_time,true);
		$criteria->compare('sms_status',$this->sms_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
