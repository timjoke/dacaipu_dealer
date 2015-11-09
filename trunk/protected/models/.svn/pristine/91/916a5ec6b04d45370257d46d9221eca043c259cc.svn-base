<?php

/**
 * This is the model class for table "dealer_bill".
 *
 * The followings are the available columns in table 'dealer_bill':
 * @property string $dealer_bill_id
 * @property string $dealer_id
 * @property string $begin_date
 * @property string $end_date
 * @property integer $is_pay
 * @property string $takeout_paid
 * @property integer $table_count
 * @property string $fee
 *
 * The followings are the available model relations:
 * @property Dealer $dealer
 */
class DealerBill extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dealer_bill';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('is_pay, table_count', 'numerical', 'integerOnly' => true),
            array('dealer_id', 'length', 'max' => 20),
            array('takeout_paid, fee', 'length', 'max' => 10),
            array('begin_date, end_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('dealer_bill_id, dealer_id, begin_date, end_date, is_pay, takeout_paid, table_count, fee', 'safe', 'on' => 'search'),
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
            'dealer' => array(self::BELONGS_TO, 'Dealer', 'dealer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'dealer_bill_id' => '账单id',
            'dealer_id' => '商家id',
            'begin_date' => '起始日期',
            'end_date' => '结束日期',
            'is_pay' => '是否支付',
            'takeout_paid' => '外卖总金额',
            'table_count' => '订台下单量',
            'fee' => '手续费',
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

        $criteria->compare('dealer_bill_id', $this->dealer_bill_id, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('begin_date', $this->begin_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('is_pay', $this->is_pay);
        $criteria->compare('takeout_paid', $this->takeout_paid, true);
        $criteria->compare('table_count', $this->table_count);
        $criteria->compare('fee', $this->fee, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DealerBill the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 通过商家id获取账单
     * @param type $dealerid 商家id
     * @param type $is_pay 是否支付 0未支付 1已支付
     * @return \CArrayDataProvider
     */
    public function getDealerBillByDealerId($dealerid, $is_pay)
    {
        $sql = 'SELECT
	dealer_bill.dealer_bill_id,
	dealer_bill.dealer_id,
	dealer_bill.begin_date,
	dealer_bill.end_date,
	dealer_bill.is_pay,
	dealer_bill.takeout_paid,
	dealer_bill.table_count,
	dealer_bill.fee
FROM
	dealer_bill
WHERE
	dealer_bill.dealer_id = %s
AND dealer_bill.is_pay = %s
ORDER BY
	dealer_bill.begin_date ASC';
        $sql = sprintf($sql, $dealerid, $is_pay);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'dealer_bill_id';
        return $obj;
    }

    /**
     * 获取不重复的账单日期
     * @return type
     */
    public function getDealerBillDate()
    {
        $sql = 'SELECT distinct begin_date FROM dealer_bill';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryAll();
        return $obj;
    }
}
