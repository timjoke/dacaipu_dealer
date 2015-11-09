<?php

/**
 * This is the model class for table "table_order_time_point".
 *
 * The followings are the available columns in table 'table_order_time_point':
 * @property string $table_order_time_point_id
 * @property string $dealer_dinner_id
 * @property string $time_point
 *
 * The followings are the available model relations:
 * @property DealerDinner $dealerDinner
 */
class TableOrderTimePoint extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'table_order_time_point';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dealer_dinner_id', 'length', 'max' => 20),
            array('time_point', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('table_order_time_point_id, dealer_dinner_id, time_point', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dealerDinner' => array(self::BELONGS_TO, 'DealerDinner', 'dealer_dinner_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'table_order_time_point_id' => 'Table Order Time Point',
            'dealer_dinner_id' => 'Dealer Dinner',
            'time_point' => 'Time Point',
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

        $criteria->compare('table_order_time_point_id', $this->table_order_time_point_id, true);
        $criteria->compare('dealer_dinner_id', $this->dealer_dinner_id, true);
        $criteria->compare('time_point', $this->time_point, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TableOrderTimePoint the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 查询订餐时间点
     * @param type $dealer_id
     * @return \CArrayDataProvider
     */
    public function getDinnerTimePoint($dealer_id) {
        $sql = 'SELECT
table_order_time_point.table_order_time_point_id,
table_order_time_point.time_point,
dealer_dinner.dinner_type
FROM
table_order_time_point
INNER JOIN dealer_dinner ON table_order_time_point.dealer_dinner_id = dealer_dinner.dealer_dinner_id
WHERE
dealer_dinner.`status` = 1 AND
dealer_dinner.dealer_id = ' . $dealer_id . ' order by dealer_dinner.dinner_type ,table_order_time_point.time_point';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'table_order_time_point_id';
        return $obj;
    }

    /**
     * 获取 桌台订餐时间点 对应的 餐市类型
     * @param type $table_order_time_point_id
     * @return type
     */
    public function getdinner_type($table_order_time_point_id) {
        $sql = 'SELECT
	dealer_dinner.dinner_type
FROM
	dealer_dinner
INNER JOIN table_order_time_point ON table_order_time_point.dealer_dinner_id = dealer_dinner.dealer_dinner_id
WHERE
	table_order_time_point.table_order_time_point_id = ' . $table_order_time_point_id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryScalar();
        return $obj;
    }

    /**
     * 获取时间点列表
     * @param type $dealer_id 商户id
     * @param type $dinner_type 餐市类型
     */
    public function gettime_pointlist($dealer_id, $dinner_type) {
        $sql = 'SELECT
	
	table_order_time_point.time_point
FROM
	dealer_dinner
INNER JOIN table_order_time_point ON table_order_time_point.dealer_dinner_id = dealer_dinner.dealer_dinner_id
WHERE
	dealer_dinner.dealer_id = :dealer_id
AND dealer_dinner.dinner_type = :dinner_type';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $cmd->bindParam(':dealer_id', $dealer_id);
        $cmd->bindParam(':dinner_type', $dinner_type);

        $obj = $cmd->queryAll();
        $timepoint_list = array();
        foreach ($obj as $timepoint) {
            $timepoint_list[$timepoint['time_point']] = substr($timepoint['time_point'], 0, 5);
        }
        return $timepoint_list;
    }

}
