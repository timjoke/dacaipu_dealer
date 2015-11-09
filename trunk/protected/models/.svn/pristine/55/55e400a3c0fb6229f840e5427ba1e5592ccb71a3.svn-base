<?php

/**
 * This is the model class for table "table_reservation".
 *
 * The followings are the available columns in table 'table_reservation':
 * @property string $reserv_id
 * @property string $table_id
 * @property string $order_id
 * @property string $reserv_start_time
 * @property integer $dinner_type
 * @property integer $reserv_status
 * @property string $reserv_time
 * @property integer $from_type
 * @property string $contact_name
 * @property string $contact_tel
 *
 * The followings are the available model relations:
 * @property DinnerTable $table
 */
class TableReservation extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'table_reservation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('table_id, reserv_status, reserv_time', 'required'),
            array('dinner_type, reserv_status, from_type', 'numerical', 'integerOnly' => true),
            array('table_id, order_id', 'length', 'max' => 20),
            array('contact_name, contact_tel', 'length', 'max' => 50),
            array('reserv_start_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('reserv_id, table_id, order_id, reserv_start_time, dinner_type, reserv_status, reserv_time, from_type, contact_name, contact_tel', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'table' => array(self::BELONGS_TO, 'DinnerTable', 'table_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'reserv_id' => '预订id',
            'table_id' => '桌台id',
            'order_id' => '订单id
            如果为0,则此桌台订单为店内自行添加',
            'reserv_start_time' => '开始时间',
            'dinner_type' => '餐市类型
            1、早市
            2、午市
            3、晚市
            4、夜宵',
            'reserv_status' => '预订状态：
            0：已取消；
            1：锁定；
            2：成功；',
            'reserv_time' => '预定时间',
            'from_type' => '来源
            0、大菜谱平台
            1、餐馆自订餐',
            'contact_name' => '联系人
            餐馆自订餐使用',
            'contact_tel' => '电话
            餐馆自订餐使用',
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

        $criteria->compare('reserv_id', $this->reserv_id, true);
        $criteria->compare('table_id', $this->table_id, true);
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('reserv_start_time', $this->reserv_start_time, true);
        $criteria->compare('dinner_type', $this->dinner_type);
        $criteria->compare('reserv_status', $this->reserv_status);
        $criteria->compare('reserv_time', $this->reserv_time, true);
        $criteria->compare('from_type', $this->from_type);
        $criteria->compare('contact_name', $this->contact_name, true);
        $criteria->compare('contact_tel', $this->contact_tel, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TableReservation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getOrderTable($dealer_id, $reserv_date) {
        $sql = 'SELECT
            table_reservation.reserv_id,
orders.order_id,
customer.customer_name,
table_reservation.reserv_start_time
FROM
orders
INNER JOIN customer ON orders.order_customer_id = customer.customer_id
INNER JOIN table_reservation ON table_reservation.order_id = orders.order_id
WHERE orders.dealer_id = ' . $dealer_id;
        if (strlen($reserv_date) > 0) {
            $sql.=' AND table_reservation.reserv_start_time>\'' . $reserv_date . ' 0:00:00\' ' .
                    ' AND table_reservation.reserv_start_time<\'' . $reserv_date . ' 23:59:59\' ';
        }

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'order_id';
        return $obj;
    }

    public function getTableByOrders($tableByordersSearch) {
        $sql = 'SELECT
table_reservation.reserv_id,
table_reservation.table_id,
table_reservation.order_id,
table_reservation.reserv_start_time,
table_reservation.dinner_type,
table_reservation.reserv_status,
table_reservation.reserv_time,
table_reservation.from_type
FROM
table_reservation
INNER JOIN dinner_table ON table_reservation.table_id = dinner_table.table_id
WHERE
dinner_table.dealer_id = :dealer_id and table_reservation.reserv_status in ('
                . TABLE_RESERVATION_STATUS_LOCK . ',' . TABLE_RESERVATION_STATUS_SUCCESS . ')
 ';
        $searchArr = array(':dealer_id' => $tableByordersSearch->dealer_id);
        if (isset($tableByordersSearch->is_smoke) && $tableByordersSearch->is_smoke != -1) {
            $sql.=' and dinner_table.table_is_smoke=:is_smoke';
            $searchArr[':is_smoke'] = $tableByordersSearch->is_smoke;
        }
        if (isset($tableByordersSearch->sit_count) && $tableByordersSearch->sit_count != -1) {
            $sql.=' and dinner_table.table_sit_count=:sit_count';
            $searchArr[':sit_count'] = $tableByordersSearch->sit_count;
        }
        if (isset($tableByordersSearch->reserv_date) && strlen($tableByordersSearch->reserv_date) > 0) {
            $sql.=' and table_reservation.reserv_start_time between \''
                    . $tableByordersSearch->reserv_date . ' 00:00:00' . '\' and \'' .
                    $tableByordersSearch->reserv_date . ' 23:59:59' . '\'';
        }


        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        foreach ($searchArr as $key => $value) {
            $cmd->bindParam($key, $value);
        }
        $obj = $cmd->queryAll($searchArr);
//        $obj = new CArrayDataProvider($obj);
//        $obj->keyField = 'table_id';
        return $obj;
    }

    /**
     * 查询当天昨天的订单信息
     * @param type $table_id 桌台id
     * @param type $reserv_date 日期
     */
    public function getTableByOrdersIndex($table_id, $reserv_date) {
        $sql = 'SELECT
table_reservation.reserv_id,
table_reservation.table_id,
table_reservation.order_id,
table_reservation.reserv_start_time,
table_reservation.reserv_status,
table_reservation.reserv_time
FROM
table_reservation
WHERE table_reservation.table_id=' . $table_id;

        if (strlen($reserv_date) > 0) {
            $sql.=' AND table_reservation.reserv_start_time>\'' . $reserv_date . ' 0:00:00\' ' .
                    ' AND table_reservation.reserv_start_time<\'' . $reserv_date . ' 23:59:59\' ';
        }

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'reserv_id';
        return $obj;
    }

    /**
     * 根据订单号获取预定桌台信息
     * @param type $order_id 订单号
     * @return type
     */
    public function getTableByOrderId($order_id)
    {
        $sql = 'SELECT 
            table_id as id,
            reserv_start_time as start_time,
            reserv_time
            FROM table_reservation
            WHERE order_id = ?';


        $attr = array($order_id);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();
        
        return count($ary) > 0 ? busUlitity::arrayToObject($ary[0]) : null;
    }
}
