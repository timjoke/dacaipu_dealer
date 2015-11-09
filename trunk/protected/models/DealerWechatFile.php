<?php

/**
 * This is the model class for table "dealer_wechat_file".
 *
 * The followings are the available columns in table 'dealer_wechat_file':
 * @property string $wechat_file_id
 * @property string $dealer_wechat_id
 * @property string $wechat_file_name
 * @property string $wechat_file_url
 */
class DealerWechatFile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dealer_wechat_file';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dealer_wechat_id', 'length', 'max'=>20),
			array('wechat_file_name', 'length', 'max'=>50),
			array('wechat_file_url', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wechat_file_id, dealer_wechat_id, wechat_file_name, wechat_file_url', 'safe', 'on'=>'search'),
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
			'wechat_file_id' => '附件id',
			'dealer_wechat_id' => '微信信息id',
			'wechat_file_name' => '附件名称',
			'wechat_file_url' => '附件路径',
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

		$criteria->compare('wechat_file_id',$this->wechat_file_id,true);
		$criteria->compare('dealer_wechat_id',$this->dealer_wechat_id,true);
		$criteria->compare('wechat_file_name',$this->wechat_file_name,true);
		$criteria->compare('wechat_file_url',$this->wechat_file_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealerWechatFile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
