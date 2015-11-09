<?php

/**
 * This is the model class for table "dinner_table".
 *
 * The followings are the available columns in table 'dinner_table':
 * @property string $table_id
 * @property string $table_name
 * @property string $dealer_id
 * @property integer $table_status
 * @property integer $table_sit_count
 * @property string $table_service_price
 * @property integer $table_is_room
 * @property string $table_lower_case
 * @property integer $table_is_smoke
 *
 * The followings are the available model relations:
 * @property TableReservation[] $tableReservations
 */
class DinnerTable extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dinner_table';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('table_status, table_sit_count, table_is_room, table_is_smoke', 'numerical', 'integerOnly' => true),
            array('table_name', 'length', 'max' => 50),
            array('dealer_id, table_service_price, table_lower_case', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('table_id, table_name, dealer_id, table_status, table_sit_count, table_service_price, table_is_room, table_lower_case, table_is_smoke', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tableReservations' => array(self::HAS_MANY, 'TableReservation', 'table_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'table_id' => 'Table',
            'table_name' => '桌台名称',
            'dealer_id' => '所属商家',
            'table_status' => '桌台状态；
            -1：已删除；
            0：已下线；
            1：已上线；',
            'table_sit_count' => '标准人数',
            'table_service_price' => '服务费',
            'table_is_room' => '是否包间：
            0：否；
            1：是；',
            'table_lower_case' => 'Table Lower Case',
            'table_is_smoke' => '是否抽烟：            0：否；            1：是;',
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

        $criteria->compare('table_id', $this->table_id, true);
        $criteria->compare('table_name', $this->table_name, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('table_status', $this->table_status);
        $criteria->compare('table_sit_count', $this->table_sit_count);
        $criteria->compare('table_service_price', $this->table_service_price, true);
        $criteria->compare('table_is_room', $this->table_is_room);
        $criteria->compare('table_lower_case', $this->table_lower_case, true);
        $criteria->compare('table_is_smoke', $this->table_is_smoke);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DinnerTable the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTableType($dealer_id) {
        $sql = 'SELECT table_sit_count FROM dinner_table where dealer_id=' . $dealer_id . ' group by table_sit_count';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryColumn();
        return $obj;
    }

    /**
     * 获取餐厅桌台简单列表
     * @return type
     */
    public function getDinnerTableSimple($tableByOrdersSearch) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('dealer_id = :dealer_id');
        $criteria->params[':dealer_id'] = $tableByOrdersSearch->dealer_id;
        $criteria->addCondition('table_status = :table_status');
        $criteria->params[':table_status'] = 1;
        if ($tableByOrdersSearch->is_smoke != -1) {
            $criteria->addCondition('table_is_smoke=:table_is_smoke');
            $criteria->params[':table_is_smoke'] = $tableByOrdersSearch->is_smoke;
        }
        if ($tableByOrdersSearch->sit_count != -1) {
            $criteria->addCondition('table_sit_count=:table_sit_count');
            $criteria->params[':table_sit_count'] = $tableByOrdersSearch->sit_count;
        }
        $criteria->select = 'table_id,table_name';
        $criteria->order = 'table_name ASC'; //排序条件     

        $dinnertables = DinnerTable::model()->findAll($criteria);
        return $dinnertables;
//        $dinnertable_list = array();
//        foreach ($dinnertables as $dinnertable) {
//            $dinnertable_list[$dinnertable->table_id] = $dinnertable->table_name;
//        }
//        return $dinnertable_list;
    }

    public function getDinnerTablesByDealer($dealer_id) {
        $sql = "select dinner_table.table_id,dinner_table.table_name,partner_entity_relat.partner_entity_id "
                . "from dinner_table left join partner_entity_relat "
                . "on dinner_table.table_id=partner_entity_relat.entity_id "
                . "where partner_entity_relat.entity_type=3 and dinner_table.dealer_id=".$dealer_id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryAll();
        $tables=array();
        if (empty($obj)) {
            return array();
        } else {
            foreach ($obj as $item) {
                $obj = new stdClass();
                $obj->sys_table_id = $item['table_id'];
                $obj->table_name = $item['table_name'];
                $obj->table_id = $item['partner_entity_id'];
                $tables[]=$obj;
            } 
            return $tables;
        }
    }

}
