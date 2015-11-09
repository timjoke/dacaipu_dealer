<?php

/**
 * This is the model class for table "discount_plan".
 *
 * The followings are the available columns in table 'discount_plan':
 * @property string $ar_id
 * @property string $ar_entity_id
 * @property string $discount_id
 * @property string $ar_start_time
 * @property string $ar_end_time
 * @property integer $ar_status
 * @property integer $ar_type
 * @property integer $ar_order
 * @property string $ar_dealer_id
 * @property integer $ar_orders_type
 * @property integer $ar_vip_level
 */
class DiscountPlan extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'discount_plan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ar_status, ar_type, ar_order, ar_orders_type,ar_vip_level', 'numerical', 'integerOnly' => true),
            array('ar_entity_id, discount_id, ar_dealer_id', 'length', 'max' => 20),
            array('ar_start_time, ar_end_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ar_id, ar_entity_id, discount_id, ar_start_time, ar_end_time, ar_status, ar_type, ar_order, ar_dealer_id, ar_orders_type,ar_vip_level', 'safe', 'on' => 'search'),
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
            'ar_id' => '折扣计划id',
            'ar_entity_id' => '实体id',
            'discount_id' => '折扣id',
            'ar_start_time' => '开始时间',
            'ar_end_time' => '结束时间',
            'ar_status' => '计划状态
            0 已下线;
            1 已上线;',
            'ar_type' => '1 针对全店优惠；
            2 针对单类别优惠；
            3 针对单品优惠；
            4 针对订单总额优惠（满XX元-XX元等，前3个优惠先对单品打折，这个是对总价打折）；',
            'ar_order' => 'Ar Order',
            'ar_dealer_id' => '商家id',
            'ar_orders_type' => '折扣下单类别: 0：外卖+堂食；           1：外卖；            2：堂食；',
            'ar_vip_level' => '会员级别',
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

        $criteria->compare('ar_id', $this->ar_id, true);
        $criteria->compare('ar_entity_id', $this->ar_entity_id, true);
        $criteria->compare('discount_id', $this->discount_id, true);
        $criteria->compare('ar_start_time', $this->ar_start_time, true);
        $criteria->compare('ar_end_time', $this->ar_end_time, true);
        $criteria->compare('ar_status', $this->ar_status);
        $criteria->compare('ar_type', $this->ar_type);
        $criteria->compare('ar_order', $this->ar_order);
        $criteria->compare('ar_dealer_id', $this->ar_dealer_id, true);
        $criteria->compare('ar_orders_type', $this->ar_orders_type);
        $criteria->compare('ar_vip_level',$this->ar_vip_level);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DiscountPlan the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 根据商家id获得折扣计划
     * @param type $dealer_id
     * @return type
     */
    public function getDiscountByDealerId($dealer_id)
    {
        $sql = 'select dp.* ,
            d.discount_name,d.discount_mode,d.discount_value,d.discount_condition,d.discount_compare_value 
            from discount_plan dp 
            inner join discount d on dp.discount_id=d.discount_id
            where d.discount_id=dp.discount_id 
            and now() between dp.ar_start_time and dp.ar_end_time 
            and dp.ar_status=1 
            and dp.ar_dealer_id=:dealer_id
            ORDER BY dp.ar_order ASC';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $cmd->bindParam(':dealer_id', $dealer_id);
        $ary = $cmd->queryAll();
        return busUlitity::arrayToObject($ary);
    }

    /**
     * 根据商家id,订单类型获得折扣计划
     * @param type $dealer_id
     * @return type
     */
    public function getDiscountByOrderType($dealer_id,$orders_type)
    {
        $sql = 'select dp.* ,
            d.discount_name,d.discount_mode,d.discount_value,d.discount_condition,d.discount_compare_value 
            from discount_plan dp 
            inner join discount d on dp.discount_id=d.discount_id
            where d.discount_id=dp.discount_id 
            and now() between dp.ar_start_time and dp.ar_end_time 
            and dp.ar_status=1 
            and dp.ar_orders_type= :orders_type 
            and dp.ar_dealer_id=:dealer_id
            ORDER BY dp.ar_order ASC';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $cmd->bindParam(':dealer_id', $dealer_id);
        $cmd->bindParam(':orders_type', $orders_type);
        $ary = $cmd->queryAll();
        return busUlitity::arrayToObject($ary);
    }

    /**
     * 根据商家id获得堂食折扣计划
     * @param type $dealer_id
     * @return type
     */
    public function getEatInDiscountByDealerId($dealer_id)
    {
        $sql = 'select dp.* ,
            d.discount_name,d.discount_mode,d.discount_value,d.discount_condition,d.discount_compare_value 
            from discount_plan dp 
            inner join discount d on dp.discount_id=d.discount_id
            where d.discount_id=dp.discount_id 
            and now() between dp.ar_start_time and dp.ar_end_time 
            and dp.ar_status=1 
            and dp.ar_orders_type != 1 
            and dp.ar_orders_type != 2
            and dp.ar_dealer_id=:dealer_id
            ORDER BY dp.ar_order ASC';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $cmd->bindParam(':dealer_id', $dealer_id);
        $ary = $cmd->queryAll();
        return busUlitity::arrayToObject($ary);
    }

    /**
     * 验证添加或修改的折扣计划的起始结束时间是否与已经上线的折扣计划时间重叠
     * @param type $ar_id 折扣计划id
     * @param type $dealer_id 商家id
     * @param type $startTime 起始时间
     * @param type $endTime 结束时间
     * @return array 与之重合的计划模板名称
     */
    public function validationTime($model)
    {
        $sql = 'SELECT
discount.discount_name
FROM
	discount_plan
INNER JOIN discount ON discount_plan.discount_id = discount.discount_id
WHERE
(discount_plan.ar_start_time BETWEEN :startTime
AND :endTime
OR discount_plan.ar_end_time BETWEEN :startTime
AND :endTime OR (:startTime < discount_plan.ar_start_time AND :endTime > discount_plan.ar_end_time) 
OR (:startTime > discount_plan.ar_start_time AND :endTime < discount_plan.ar_end_time))
AND discount_plan.ar_dealer_id = :dealer_id AND discount_plan.ar_id <> :ar_id
AND discount_plan.ar_status = :status AND discount_plan.discount_id = :discount_id
AND discount_plan.ar_type = :type AND discount_plan.ar_entity_id = :entity_id
AND discount_plan.ar_orders_type = :orders_type
';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $arr = $cmd->queryAll(TRUE,array(':ar_id' => $model->ar_id, ':dealer_id' => $model->ar_dealer_id,
            ':startTime' => $model->ar_start_time, ':endTime' => $model->ar_end_time, ':status' => DISCOUNT_PLAN_STATUS_ONLINE,
            ':discount_id' => $model->discount_id, ':type' => $model->ar_type, ':entity_id' => $model->ar_entity_id,
            ':orders_type'=>$model->ar_orders_type));
        $ret_ary = array();

        foreach ($arr as $value)
        {
            array_push($ret_ary, $value['discount_name']);
        }
//        $aa = $arr['discount_name'];
        return $ret_ary;
    }

}
