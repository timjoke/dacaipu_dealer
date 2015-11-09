<?php

/**
 * This is the model class for table "valid_code".
 *
 * The followings are the available columns in table 'valid_code':
 * @property string $code_id
 * @property string $code_content
 * @property string $code_create_time
 * @property integer $code_valid_minutes
 * @property string $code_mobile
 */
class ValidCode extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'valid_code';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code_create_time', 'required'),
			array('code_valid_minutes', 'numerical', 'integerOnly'=>true),
			array('code_content', 'length', 'max'=>20),
			array('code_mobile', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('code_id, code_content, code_create_time, code_valid_minutes, code_mobile', 'safe', 'on'=>'search'),
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
			'code_id' => '验证码id',
			'code_content' => '验证码内容',
			'code_create_time' => '验证码创建时间',
			'code_valid_minutes' => '验证码有效期（分钟）',
			'code_mobile' => 'Code Mobile',
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

		$criteria->compare('code_id',$this->code_id,true);
		$criteria->compare('code_content',$this->code_content,true);
		$criteria->compare('code_create_time',$this->code_create_time,true);
		$criteria->compare('code_valid_minutes',$this->code_valid_minutes);
		$criteria->compare('code_mobile',$this->code_mobile,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ValidCode the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * 根据手机号获得当天发送的验证码条数
         * @param type $mobile 手机号
         * @return type 条数
         */
        public function GetCountPerDay($mobile)
        {
            $sql = "SELECT count(code_id) as day_count from valid_code where code_mobile=:mobile  and date_format(code_create_time,'%Y-%m-%d')=:now_date";
            $db = Yii::app()->db;
            $count = $db->createCommand($sql)->queryScalar(array(
                ':mobile' => $mobile,
                ':now_date' => date('Y-m-d'),
            ));
            
            return $count;
        }
}
