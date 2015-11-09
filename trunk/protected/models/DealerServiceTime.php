<?php

/**
 * This is the model class for table "dealer_service_time".
 *
 * The followings are the available columns in table 'dealer_service_time':
 * @property string $st_id
 * @property string $dealer_id
 * @property string $st_start_time
 * @property string $st_end_time
 * @property string $st_name
 */
class DealerServiceTime extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dealer_service_time';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dealer_id', 'length', 'max' => 20),
            array('st_name', 'length', 'max' => 50),
            array('st_start_time, st_end_time', 'safe'),
//            array('st_start_time', 'compare', 'compareAttribute' => 'st_end_time',
//                'operator' => '<', 'message' => '开始时间必须早于结束时间'),
//            array('st_end_time', 'compare', 'compareAttribute' => 'st_start_time',
//                'operator' => '>', 'message' => '开始时间必须早于结束时间'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('st_id, dealer_id, st_start_time, st_end_time, st_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'st_id' => '时间段id',
            'dealer_id' => '商家id',
            'st_start_time' => '开始时间',
            'st_end_time' => '结束时间',
            'st_name' => '时段名称',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('st_id', $this->st_id, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('st_start_time', $this->st_start_time, true);
        $criteria->compare('st_end_time', $this->st_end_time, true);
        $criteria->compare('st_name', $this->st_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DealerServiceTime the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * 根据商家id获得营业时间
     * @param type $dealer_id
     * @return type
     */
    public function getServiceTimes($dealer_id) 
    {
        $criteria = new CDbCriteria();
        $criteria->compare('dealer_id', $dealer_id);
        $criteria->order = "st_start_time ASC";
        
        return $this->findAll($criteria);
    }

    /**
     * 根据商家ID获取支持的餐市
     * @param type $dealer_id
     * @return type
     */
    public function getServiceTimeNames($dealer_id) {
        $names="";
        $service_time_names=$this->findAllBySql("select st_name from dealer_service_time where dealer_id=:dealer_id",array(':dealer_id'=>$dealer_id));
        if(!empty($service_time_names))
        {
            foreach ($service_time_names as $name) {                
                $names=$names." ".$name->st_name;                
            }            
        }
        return $names;
    }
    
    /**
     * 根据商家ID获取营业开始时间和结束时间
     * @param type $dealer_id
     * @return type
     */
    public function getServiceTime($dealer_id) {
        $service_time=$this->findBySql("select min(st_start_time) as st_start_time,max(st_end_time) as st_end_time "
                . "from dealer_service_time where dealer_id=:dealer_id",array(':dealer_id'=>$dealer_id));                
        if(empty($service_time))
        {
            $service_time->st_start_time="";
            $service_time->st_end_time="";
        }
        return $service_time;
    }
    
}
