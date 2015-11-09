<?php

/**
 * This is the model class for table "setting".
 *
 * The followings are the available columns in table 'setting':
 * @property string $setting_key
 * @property string $setting_value
 */
class Setting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setting_key', 'required'),
			array('setting_key', 'length', 'max'=>50),
			array('setting_value', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('setting_key, setting_value', 'safe', 'on'=>'search'),
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
			'setting_key' => '配置key',
			'setting_value' => '配置value',
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

		$criteria->compare('setting_key',$this->setting_key,true);
		$criteria->compare('setting_value',$this->setting_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Setting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * 
         * @param type $dealer_id
         * @return type返回0或1，0为配送，1为不配送
         */
        public function getTakeoutSetting($dealer_id) {            
            $db=  Yii::app()->db;
            $sql="select setting_value from setting where setting_key=?";
            $command=$db->createCommand($sql);            
            $result=$command->query(array(SETTING_KEY_NO_DELIVERY.$dealer_id));
            $ary = $result->readAll();
            $result=0;
            if(count($ary)>0){
                $result=  intval( $ary[0]['setting_value']);
            } 
            return $result;
        }
        
        /**
         * 
         * @param type $dealer_id
         * @return type返回0或1，0为自取，1为不自取
         */
        public function getTakeoutSettingSelf($dealer_id) {            
            $db=  Yii::app()->db;
            $sql="select setting_value from setting where setting_key=?";
            $command=$db->createCommand($sql);            
            $result=$command->query(array(SETTING_KEY_SELF_DELIVERY.$dealer_id));
            $ary = $result->readAll();
            $result=0;
            if(count($ary)>0){
                $result=  intval( $ary[0]['setting_value']);
            } 
            return $result;
        }
        
        /**
         * 
         * @param type $dealer_id
         * @return type返回0或1，0为显示图片，1为隐藏图片
         */
        public function getImgDisplaySetting($dealer_id) {            
            $db=  Yii::app()->db;
            $sql="select setting_value from setting where setting_key=?";
            $command=$db->createCommand($sql);            
            $result=$command->query(array(DISH_IMAGE_HIDDEN.$dealer_id));
            $ary = $result->readAll();
            $result=0;
            if(count($ary)>0){
                $result=  intval( $ary[0]['setting_value']);
            } 
            return $result;
        }
}
