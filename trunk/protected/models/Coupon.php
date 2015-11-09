<?php

/**/

/**
 * This is the model class for table "coupon".
 *
 * The followings are the available columns in table 'coupon':
 * @property string $coupon_id
 * @property string $dealer_id
 * @property string $coupon_no
 * @property string $coupon_value
 * @property string $coupon_start_time
 * @property string $coupon_end_time
 * @property integer $coupon_status
 * @property string $coupon_customer_id
 * @property string $coupon_create_time
 * @property string $order_id
 */
class Coupon extends CActiveRecord
{

    public $coupon_count;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'coupon';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('coupon_no, coupon_start_time', 'required'),
            array('coupon_status', 'numerical', 'integerOnly' => true),
            array('dealer_id, coupon_customer_id, order_id', 'length', 'max' => 20),
            array('coupon_no', 'length', 'max' => 50),
            array('coupon_value', 'length', 'max' => 10),
            array('coupon_end_time, coupon_create_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('coupon_id, dealer_id, coupon_no, coupon_value, coupon_start_time, coupon_end_time, coupon_status, coupon_customer_id, coupon_create_time, order_id', 'safe', 'on' => 'search'),
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
            'coupon_id' => '优惠券id',
            'dealer_id' => '商家id',
            'coupon_no' => '优惠券NO',
            'coupon_value' => '优惠券金额',
            'coupon_start_time' => '有效开始日期',
            'coupon_end_time' => '有效结束日期',
            'coupon_status' => '优惠券状态
            0 未激活；
            1 已激活；
            2 已失效；',
            'coupon_customer_id' => '使用人',
            'coupon_create_time' => '创建日期',
            'order_id' => '订单号',
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
    public function search($search)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        if (trim($search->start_time) == '')
        {
            $start_time = date('1970-1-1 0:0');
        } else
        {
            $start_time = $search->start_time;
        }
        if (trim($search->end_time) == '')
        {
            $search->end_time = date('Y-m-d 23:59');
        }
        else
        {
            $end_time = $search->end_time;
        }

        $criteria->compare('dealer_id', $search->dealer_id, true);
        $criteria->compare('coupon_no', $search->coupon_no, true);
        $criteria->addBetweenCondition('coupon_start_time', $start_time, $end_time);
        $criteria->addBetweenCondition('coupon_end_time', $start_time, $end_time);
        if ($search->coupon_status != 3)
        {
            $criteria->compare('coupon_status', $search->coupon_status);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Coupon the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 根据优惠券NO、商家ID获得优惠券
     * @param type $coupon_no
     * @param type $dealer_id
     * @return Coupon
     */
    public function getValidCouponByNO($coupon_no, $dealer_id)
    {
        $sql = 'select * from coupon where LOWER(coupon_no)=:coupon_no AND dealer_id=:dealer_id AND NOW() >= coupon_start_time AND NOW() <=coupon_end_time AND coupon_status=1 LIMIT 0,1';
        $coupon = $this->model()->findBySql($sql, array(
            ':coupon_no' => strtolower($coupon_no),
            ':dealer_id' => $dealer_id
        ));
        if (!isset($coupon))
        {
            $dealer = Dealer::model()->findByPk($dealer_id);
            if ($dealer->dealer_parent_id > 0)
            {
                $coupon = $this->model()->findBySql($sql, array(
                    ':coupon_no' => strtolower($coupon_no),
                    ':dealer_id' => $dealer->dealer_parent_id
                ));
            }
        }
        return $coupon;
    }

    /**
     * 通过订单id获取用户使用的打折码的折扣金额
     * @param type $order_id 订单id
     * @return type 打折码，如果没有使用打折码返回0
     */
    public function getCoupon_valueByorderId($order_id)
    {
        $coupon = Coupon::model()->find(array('condition' => 'order_id=' . $order_id));
        $coupon_value = 0;
        if (isset($coupon))
        {
            $coupon_value = $coupon->coupon_value;
        }
        return $coupon_value;
    }

    /**
     * 通过商家ID获取该商家所有折扣码（如果是集团用户，则获取集团折扣码和商家折扣码）
     * @param type $dealer_id
     * @return type
     */
    public function getAllCoupon_codeByDealer($dealer_id)
    {
        $sql = "select coupon_no from coupon where dealer_id=:dealer_id";
        $coupons = $this->model()->findAllBySql($sql, array(
            ":dealer_id" => $dealer_id));
        $coupon_codes = array();
        foreach ($coupons as $value)
        {
            $coupon_codes[] = $value->coupon_no;
        }
        $dealer = Dealer::model()->findByPk($dealer_id);
        if ($dealer->dealer_parent_id > 0)
        {
            $coupons = $this->model()->findAllBySql($sql, array(
                ":dealer_id" => $dealer_id));
            foreach ($coupons as $value)
            {
                $coupon_codes[] = $value->coupon_no;
            }
        }
        return $coupon_codes;
    }

    public function insertNew($dealer_id, $coupon_code, $coupon_value, $coupon_start_time, $coupon_end_time, $coupon_customer_id)
    {
        try
        {
            $db = Yii::app()->db;
            $cmd = $db->createCommand();
            $cmd->insert('coupon', array(
                'dealer_id' => $dealer_id,
                'coupon_no' => $coupon_code,
                'coupon_value' => $coupon_value,
                'coupon_start_time' => $coupon_start_time,
                'coupon_end_time' => $coupon_end_time,
                'coupon_customer_id' => $coupon_customer_id,
                'coupon_status' => 1,
                'coupon_create_time' => date('Y-m-d H:i:s', time())));

            $coupon_id = $db->getLastInsertID();
            return $coupon_id;
        } catch (Exception $ex)
        {
            Yii::log($ex->getMessage());
        }
    }
    
          /**
     * 
     * 获取当前商家的菜品列表
     * @param type $dealer_id
     * @return typ
     */
    public function getAllCoupons($dealer_id)
    {      
        $dealer_id=29;
        $sql = 'SELECT c.coupon_id,c.coupon_no,c.coupon_value,c.coupon_start_time,c.coupon_end_time,c.coupon_status,c.order_id,cu.customer_mobile,cu.customer_name '
                . 'FROM coupon as c left join customer as cu on c.coupon_customer_id=cu.customer_id '
                . 'WHERE c.order_id>0 and c.dealer_id=?';

        $attr = array($dealer_id);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();

        return busUlitity::arrayToObject($ary);
    }

}
