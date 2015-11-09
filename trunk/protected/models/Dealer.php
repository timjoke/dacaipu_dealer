<?php

/**
 * This is the model class for table "dealer".
 *
 * The followings are the available columns in table 'dealer':
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
 * @property string $dealer_service_distance
 * @property string $dealer_low_express_fee
 * @property integer $weixin_subscribe
 * @property string $dealer_rate
 */
class Dealer extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dealer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dealer_create_date,dealer_rate', 'required'),
            array('dealer_status, is_free_park, dealer_type, weixin_subscribe', 'numerical', 'integerOnly' => true),
            array('city_code, dealer_percap, dealer_parent_id, dealer_express_fee, dealer_service_distance, dealer_low_express_fee, dealer_rate', 'length', 'max' => 20),
            array('dealer_name', 'length', 'max' => 100),
            array('dealer_addr', 'length', 'max' => 200),
            array('dealer_postcode', 'length', 'max' => 10),
            array('dealer_lon, dealer_lat', 'length', 'max' => 11),
            array('dealer_introduction', 'length', 'max' => 8000),
            array('dealer_tel, dealer_link_word, dealer_domain', 'length', 'max' => 50),
            array('dealer_rate', 'intRangeValidator'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('dealer_id, city_code, dealer_name, dealer_addr, dealer_postcode, dealer_lon, dealer_lat, dealer_introduction, dealer_tel, dealer_status, dealer_percap, is_free_park, dealer_type, dealer_parent_id, dealer_create_date, dealer_link_word, dealer_domain, dealer_express_fee, dealer_service_distance, dealer_low_express_fee, weixin_subscribe, dealer_rate', 'safe', 'on' => 'search'),
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
            'dealer_status' => '状态
            0 已下线；
            1 营业中；
            2 暂停营业；',
            'dealer_percap' => '人均消费（元）',
            'is_free_park' => '是否免费停车',
            'dealer_type' => '商家类型
            1 集团客户；
            2 门店客户；',
            'dealer_parent_id' => '所属商家',
            'dealer_create_date' => 'Dealer Create Date',
            'dealer_link_word' => '友好连接',
            'dealer_domain' => '自定义域名',
            'dealer_express_fee' => '配送费',
            'dealer_service_distance' => '服务距离(米)',
            'dealer_low_express_fee' => 'Dealer Low Express Fee',
            'weixin_subscribe' => '微信用户订阅后触发的事件0、无事件1、发送折扣码',
            'dealer_rate' => '手续费费率',
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

        $criteria = new CDbCriteria;

        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('city_code', $this->city_code, true);
        $criteria->compare('dealer_name', $this->dealer_name, true);
        $criteria->compare('dealer_addr', $this->dealer_addr, true);
        $criteria->compare('dealer_postcode', $this->dealer_postcode, true);
        $criteria->compare('dealer_lon', $this->dealer_lon, true);
        $criteria->compare('dealer_lat', $this->dealer_lat, true);
        $criteria->compare('dealer_introduction', $this->dealer_introduction, true);
        $criteria->compare('dealer_tel', $this->dealer_tel, true);
        $criteria->compare('dealer_status', $this->dealer_status);
        $criteria->compare('dealer_percap', $this->dealer_percap, true);
        $criteria->compare('is_free_park', $this->is_free_park);
        $criteria->compare('dealer_type', $this->dealer_type);
        $criteria->compare('dealer_parent_id', $this->dealer_parent_id, true);
        $criteria->compare('dealer_create_date', $this->dealer_create_date, true);
        $criteria->compare('dealer_link_word', $this->dealer_link_word, true);
        $criteria->compare('dealer_domain', $this->dealer_domain, true);
        $criteria->compare('dealer_express_fee', $this->dealer_express_fee, true);
        $criteria->compare('dealer_service_distance', $this->dealer_service_distance, true);
        $criteria->compare('dealer_low_express_fee', $this->dealer_low_express_fee, true);
        $criteria->compare('weixin_subscribe', $this->weixin_subscribe);
        $criteria->compare('dealer_rate', $this->dealer_rate, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Dealer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * dealer_rate.0
     */
    public function intRangeValidator()
    {
        if ($this->dealer_rate > 1)
        {
            $this->addError('dealer_rate', '最大值不得大于1.0');
        }
    }

    /**
     * 获取所有商家的id和名称
     * @return type
     */
    public static function GetAllDealerName()
    {
        $sql = 'SELECT dealer_id,dealer_name FROM dealer';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $reader = $cmd->query();
        $ary = $reader->readAll();
        return $ary;
    }

    /**
     * 通过商家id查询商家名称
     * @return type 商家名称
     */
    public static function GetDealerNameByDealerId($id)
    {
        $sql = 'SELECT dealer_name FROM dealer WHERE dealer_id='.$id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $reader = $cmd->query();
        $ary = $reader->readAll();
        if(isset($ary) && count($ary)>0)
        {
            return $ary[0]['dealer_name'];
        }
        return '';
    }
    
    /**
     * 根据id获得商家(缓存)
     * @param type $dealer_id
     * @return type
     */
    public function get_by_id($dealer_id)
    {
        $cache_key = CACHE_KEY_DEALER_PREFIX.$dealer_id;
        $dealer = Yii::app()->cache->get($cache_key);
        
        if($dealer === false)
        {
            $dealer = self::model()->findByPk($dealer_id);
            Yii::app()->cache->add($cache_key, $dealer);
        }
        
        return $dealer;
    }
   
    
    /**
     * 判断商家是否京汉的账户
     * @param type $dealer_id
     * @return boolean
     */
    public function IsKindHandSubs($dealer_id) {
        $root_id=29;
        if($dealer_id == $root_id){
            return TRUE;
        }
        
        $dealer = $this->findByPk($dealer_id);
        if(empty($dealer))
            return false;
        else
        {
            return $dealer->dealer_parent_id == $root_id;
        }
    }
}
