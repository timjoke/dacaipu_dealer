<?php

/**
 * This is the model class for table "V_DealerEdit".
 *
 * The followings are the available columns in table 'V_DealerEdit':
 * @property string $dealer_id
 * @property string $city_code
 * @property string $dealer_name
 * @property string $dealer_addr
 * @property string $dealer_postcode
 * @property string $dealer_lon
 * @property string $dealer_lat
 * @property string $dealer_introduction
 * @property string $dealer_tel
 * @property integer $dealer_status
 * @property string $dealer_percap
 * @property integer $is_free_park
 * @property integer $dealer_type
 * @property string $dealer_parent_id
 * @property string $dealer_create_date
 * @property string $dealer_link_word
 * @property string $dealer_domain
 * @property string $dealer_express_fee
 * @property string $parentDealerName
 * @property string $city_name
 */
class VDealerEdit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'V_DealerEdit';
	}
        
        /**
         * 手动添加主键 
         * @return string dealer表的dealer_id字段
         */
        public function primaryKey()
        {
            return 'dealer_id';
        }

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dealer_status, is_free_park, dealer_type', 'numerical', 'integerOnly'=>true),
			array('dealer_id, city_code, dealer_percap, dealer_parent_id, dealer_express_fee', 'length', 'max'=>20),
			array('dealer_name, parentDealerName', 'length', 'max'=>100),
			array('dealer_addr', 'length', 'max'=>200),
			array('dealer_postcode', 'length', 'max'=>10),
			array('dealer_lon, dealer_lat', 'length', 'max'=>11),
			array('dealer_introduction', 'length', 'max'=>8000),
			array('dealer_tel, dealer_link_word, dealer_domain, city_name', 'length', 'max'=>50),
			array('dealer_create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dealer_id, city_code, dealer_name, dealer_addr, dealer_postcode, dealer_lon, dealer_lat, dealer_introduction, dealer_tel, dealer_status, dealer_percap, is_free_park, dealer_type, dealer_parent_id, dealer_create_date, dealer_link_word, dealer_domain, dealer_express_fee, parentDealerName, city_name', 'safe', 'on'=>'search'),
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
			'dealer_id' => '商家id',
			'city_code' => '城市代码',
			'dealer_name' => '商家名称',
			'dealer_addr' => '商家地址',
			'dealer_postcode' => '商家邮编',
			'dealer_lon' => '经度',
			'dealer_lat' => '纬度',
			'dealer_introduction' => '简介',
			'dealer_tel' => '电话',
			'dealer_status' => '状态             0 已下线；             1 营业中；             2 暂停营业；',
			'dealer_percap' => '人均消费（元）',
			'is_free_park' => '是否免费停车',
			'dealer_type' => '商家类型
            1 集团客户；
            2 门店客户；',
			'dealer_parent_id' => '所属商家',
			'dealer_create_date' => '创建时间',
			'dealer_link_word' => '友好连接',
			'dealer_domain' => '自定义域名',
			'dealer_express_fee' => '配送费',
			'parentDealerName' => '商家名称',
			'city_name' => '城市名称',
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

		$criteria->compare('dealer_id',$this->dealer_id,true);
		$criteria->compare('city_code',$this->city_code,true);
		$criteria->compare('dealer_name',$this->dealer_name,true);
		$criteria->compare('dealer_addr',$this->dealer_addr,true);
		$criteria->compare('dealer_postcode',$this->dealer_postcode,true);
		$criteria->compare('dealer_lon',$this->dealer_lon,true);
		$criteria->compare('dealer_lat',$this->dealer_lat,true);
		$criteria->compare('dealer_introduction',$this->dealer_introduction,true);
		$criteria->compare('dealer_tel',$this->dealer_tel,true);
		$criteria->compare('dealer_status',$this->dealer_status);
		$criteria->compare('dealer_percap',$this->dealer_percap,true);
		$criteria->compare('is_free_park',$this->is_free_park);
		$criteria->compare('dealer_type',$this->dealer_type);
		$criteria->compare('dealer_parent_id',$this->dealer_parent_id,true);
		$criteria->compare('dealer_create_date',$this->dealer_create_date,true);
		$criteria->compare('dealer_link_word',$this->dealer_link_word,true);
		$criteria->compare('dealer_domain',$this->dealer_domain,true);
		$criteria->compare('dealer_express_fee',$this->dealer_express_fee,true);
		$criteria->compare('parentDealerName',$this->parentDealerName,true);
		$criteria->compare('city_name',$this->city_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VDealerEdit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
