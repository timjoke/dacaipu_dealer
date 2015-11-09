<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property string $city_code
 * @property string $city_name
 * @property integer $city_order
 * @property integer $city_status
 * @property string $city_postcode
 * @property string $city_phonecode
 * @property string $city_parentcode
 */
class City extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'city';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_code', 'required'),
            array('city_order, city_status', 'numerical', 'integerOnly' => true),
            array('city_code, city_parentcode', 'length', 'max' => 20),
            array('city_name', 'length', 'max' => 50),
            array('city_postcode', 'length', 'max' => 10),
            array('city_phonecode', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('city_code, city_name, city_order, city_status, city_postcode, city_phonecode, city_parentcode', 'safe', 'on' => 'search'),
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
            'city_code' => '城市代码',
            'city_name' => '城市名称',
            'city_order' => '城市排序',
            'city_status' => '城市状态',
            'city_postcode' => '城市邮编',
            'city_phonecode' => '城市区号',
            'city_parentcode' => '所属省市',
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

        $criteria->compare('city_code', $this->city_code, true);
        $criteria->compare('city_name', $this->city_name, true);
        $criteria->compare('city_order', $this->city_order);
        $criteria->compare('city_status', $this->city_status);
        $criteria->compare('city_postcode', $this->city_postcode, true);
        $criteria->compare('city_phonecode', $this->city_phonecode, true);
        $criteria->compare('city_parentcode', $this->city_parentcode, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return City the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 根据县/街道获得城市名称
     * @param type $code
     * @return City
     */
    public function getCityNameByAreaCode($code)
    {
        $area = $this->findByPk($code);
        $city = $this->findByAttributes(array('city_code' => $area->city_parentcode));
        if ($city->city_name == '市辖区' || $city->city_name == '县')
        {
            $city = $this->findByAttributes(array('city_code' => $city->city_parentcode));
        }

        return $city->city_name;
    }

    /**
     * 获取城市的全名称，省+市+区县
     * @param type $city_code 城市代码
     * @param type $name 城市名称，递归调用时使用
     * @return string
     */
    public function getFullName($city_code, $name = '')
    {
        $cache_key = CACHE_KEY_CITY_FULLNAME_PREFIX.$city_code;
        $fullname = Yii::app()->cache->get($cache_key);
        if ($name === False)
        {
            $city = $this->findByPk($city_code);
            if (isset($city))
            {
                if ($city->city_parentcode != 100000)
                {
                    if ($city->city_name != '市辖区')
                    {
                        $fullname = $this->getFullName($city->city_parentcode, $city->city_name . $name);
                    }
                    else
                    {
                        $fullname = $this->getFullName($city->city_parentcode, $name);
                    }
                }
                else
                    $fullname = $city->city_name . $name;
            }
            
            Yii::app()->cache->add($cache_key, $fullname);
        }

        return $fullname;
    }
}
