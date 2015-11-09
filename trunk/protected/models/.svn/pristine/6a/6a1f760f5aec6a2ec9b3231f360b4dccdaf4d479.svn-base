<?php

/**
 * This is the model class for table "dealer_bill_orders".
 *
 * The followings are the available columns in table 'dealer_bill_orders':
 * @property string $dealer_bill_ordersl_id
 * @property integer $order_id
 * @property integer $bill_mode
 * @property string $bill_value
 * @property string $bill_money_value
 */
class DealerBillOrders extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dealer_bill_orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, bill_mode', 'numerical', 'integerOnly' => true),
            array('bill_value, bill_money_value', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('dealer_bill_ordersl_id, order_id, bill_mode, bill_value, bill_money_value', 'safe', 'on' => 'search'),
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
            'dealer_bill_ordersl_id' => '账单id',
            'order_id' => '订单id',
            'bill_mode' => '计算模式
            1、百分比
            2、固定值',
            'bill_value' => '计算值',
            'bill_money_value' => '抽成金额',
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

        $criteria->compare('dealer_bill_ordersl_id', $this->dealer_bill_ordersl_id, true);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('bill_mode', $this->bill_mode);
        $criteria->compare('bill_value', $this->bill_value, true);
        $criteria->compare('bill_money_value', $this->bill_money_value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DealerBillOrders the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getMonthDealerBill($dealer_id, $beginDate, $endDate)
    {
        $sql = 'SELECT
	date_format(
		orders.order_createtime,
		\'%Y-%m-%d\'
	) AS bill_date,
	sum(
		CASE orders.order_type
		WHEN ' . ORDER_TYPE_TAKEOUT . ' THEN
			orders.order_paid
		WHEN ' . ORDER_TYPE_TAKEOUT_SELFTAKE . ' THEN
			orders.order_paid
		ELSE
			0
		END
	) AS takeout_paid,
	COUNT(
		CASE orders.order_type
		WHEN ' . ORDER_TYPE_SUB_TABLE . ' THEN
			orders.order_paid
		WHEN ' . ORDER_TYPE_SUB_TALE_DISH . ' THEN
			orders.order_paid
		ELSE
			NULL
		END
	) AS table_paid,
	sum(
		dealer_bill_orders.bill_money_value
	) AS poundage
FROM
	orders
INNER JOIN dealer_bill_orders ON orders.order_id = dealer_bill_orders.order_id
WHERE
	dealer_id = ' . $dealer_id . ' AND orders.order_status IN (1, 2, 3, 5, 6, 7, 8, 9) AND
        orders.order_createtime BETWEEN \'' . $beginDate . '\' AND \'' . $endDate . '\'
GROUP BY
	bill_date
ORDER BY
	bill_date';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'bill_date';
        return $obj;
    }

    /**
     * 
     * @param type $dealer_id
     * @param type $beginDate
     * @param type $endDate
     * @return \CArrayDataProvider
     */
    public function myBillDayTakeout($dealer_id, $beginDate, $endDate)
    {
        $sql = 'SELECT
	date_format(
		orders.order_createtime,
		\'%Y-%m-%d %T\'
	) AS bill_date,
	orders.order_paid AS takeout_paid,
        dealer_bill_orders.bill_money_value AS poundage
FROM
	orders
INNER JOIN dealer_bill_orders ON orders.order_id = dealer_bill_orders.order_id
WHERE
	orders.dealer_id = ' . $dealer_id . ' AND orders.order_status IN (1, 2, 3, 5, 6, 7, 8, 9)
          AND orders.order_createtime BETWEEN \'' . $beginDate . '\' AND \'' . $endDate . '\' 
          AND orders.order_type IN (' . ORDER_TYPE_TAKEOUT . ',' . ORDER_TYPE_TAKEOUT_SELFTAKE . ')    ';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'bill_date';
        return $obj;
    }

    /**
     * 
     * @param type $dealer_id
     * @param type $beginDate
     * @param type $endDate
     * @return \CArrayDataProvider
     */
    public function myBillDayTable($dealer_id, $beginDate, $endDate)
    {
        $sql = 'SELECT
	date_format(
		orders.order_createtime,
		\'%Y-%m-%d %T\'
	) AS bill_date,
        dealer_bill_orders.bill_money_value AS poundage
FROM
	orders
INNER JOIN dealer_bill_orders ON orders.order_id = dealer_bill_orders.order_id
WHERE
	orders.dealer_id = ' . $dealer_id . ' AND orders.order_status IN (1, 2, 3, 5, 6, 7, 8, 9)
          AND orders.order_createtime BETWEEN \'' . $beginDate . '\' AND \'' . $endDate . '\' 
          AND orders.order_type IN (' . ORDER_TYPE_SUB_TABLE .
                ',' . ORDER_TYPE_SUB_TALE_DISH . ',' . ORDER_TYPE_EATIN . ')    ';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'bill_date';
        return $obj;
    }

}
