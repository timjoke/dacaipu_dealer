<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property string $order_id
 * @property string $order_customer_id
 * @property string $order_createtime
 * @property string $order_dinnertime
 * @property string $order_amount
 * @property string $order_paid
 * @property integer $order_status
 * @property integer $order_type
 * @property integer $order_ispay
 * @property integer $order_pay_type
 * @property string $contact_id
 * @property string $dealer_id
 * @property integer $order_person_count
 *
 * The followings are the available model relations:
 * @property OrderDishFlash[] $orderDishFlashes
 * @property OrderStatusMessage[] $orderStatusMessages
 */
class Orders extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_createtime', 'required'),
            array('order_status, order_type, order_ispay, order_pay_type', 'numerical', 'integerOnly' => true),
            array('order_customer_id, contact_id, dealer_id', 'length', 'max' => 20),
            array('order_amount, order_paid', 'length', 'max' => 10),
            array('order_dinnertime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('order_id, order_customer_id, order_createtime, order_dinnertime, order_amount, order_paid, order_status, order_type, order_ispay, order_pay_type, contact_id, dealer_id,order_person_count', 'safe', 'on' => 'search'),
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
            'orderDishFlashes' => array(self::HAS_MANY, 'OrderDishFlash', 'order_id'),
            'orderStatusMessages' => array(self::HAS_MANY, 'OrderStatusMessage', 'order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'order_id' => '订单id',
            'order_customer_id' => 'Order Customer',
            'order_createtime' => '创建时间',
            'order_dinnertime' => '用餐时间',
            'order_amount' => '应收金额',
            'order_paid' => '实收金额',
            'order_status' => '订单状态
            1 待付款；
            2 待处理；
            3 处理中；
            4 已拒绝；
            5 待派送；
            6 待取餐；
            7 派送中；
            8 已完成； 
            9 已结束；',
            'order_type' => '订单类型
            1 外卖送餐；
            2 外卖自取；
            3 预订桌台；
            4 预订桌台+点菜；
            5 堂食点菜；
            ',
            'order_ispay' => '是否支付
            0 否；
            1 是；
            ',
            'order_pay_type' => '付款方式
            1 上门派送POS刷卡；
            2 上门派送现金支付；
            3 门店POS刷卡；
            4 门店现金支付；
            5 在线支付宝；
            6 在线网银；
            7 在线会员充值卡；',
            'contact_id' => '联系人id',
            'dealer_id' => '商家id',
            'order_person_count' => '就餐人数',
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

        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('order_customer_id', $this->order_customer_id, true);
        $criteria->compare('order_createtime', $this->order_createtime, true);
        $criteria->compare('order_dinnertime', $this->order_dinnertime, true);
        $criteria->compare('order_amount', $this->order_amount, true);
        $criteria->compare('order_paid', $this->order_paid, true);
        $criteria->compare('order_status', $this->order_status);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('order_ispay', $this->order_ispay);
        $criteria->compare('order_pay_type', $this->order_pay_type);
        $criteria->compare('contact_id', $this->contact_id, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('order_person_count', $this->order_person_count);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Orders the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取待处理的订单(送餐订单)
     */
    public function getPendingOrders($dealer_id)
    {
        $statuslst = array(
            ORDER_STATUS_PROCESSING,
            ORDER_STATUS_WAIT_EXPRESS,
            ORDER_STATUS_WAIT_TAKE,
            ORDER_STATUS_EXPRESSING,
            ORDER_STATUS_WAIT_PAY);
        return $this->getOrderList($dealer_id, $statuslst);
    }

    /**
     * 获取待处理的订单(桌台订单)
     */
    public function getPendingTableOrders($dealer_id)
    {
        $statuslst = array(ORDER_STATUS_PROCESSING);
        return $this->getTableOrderList($dealer_id, $statuslst, TRUE);
    }

    /**
     * 获取待处理的订单（店内点餐订单）
     * @param type $dealer_id
     * @return type
     */
    public function getPendingHallOrders($dealer_id)
    {
        $statuslst = array(ORDER_STATUS_PROCESSING);
        return $this->getHallOrderList($dealer_id, $statuslst, TRUE);
    }

    /**
     * 获取已经完成的订单
     * @return type
     */
    public function getFinishOrders($dealer_id, $search)
    {
        $status = array(ORDER_STATUS_DENIED,
            ORDER_STATUS_CLOSE,
            ORDER_STATUS_COMPLETE,
        );
        $statusStr = implode('\',\'', $status);
        $sql = 'SELECT
                orders.order_id,
                orders.order_amount,
                orders.order_paid,
                orders.order_createtime,
                orders.order_dinnertime,
                orders.order_status,
                orders.order_type,
                contact.contact_name,
                coupon.coupon_id,
                coupon.coupon_no,
                CASE
WHEN orders.order_type IN (' . ORDER_TYPE_TAKEOUT . ', ' . ORDER_TYPE_TAKEOUT_SELFTAKE . ') THEN
	contact.contact_addr
WHEN orders.order_type IN (' . ORDER_TYPE_SUB_TABLE . ', ' . ORDER_TYPE_SUB_TALE_DISH . ') THEN
	(
		SELECT
			dinner_table.table_name
		FROM
			table_reservation
		INNER JOIN dinner_table ON table_reservation.table_id = dinner_table.table_id
		WHERE
			table_reservation.order_id = orders.order_id
	)
        WHEN orders.order_type IN (' . ORDER_TYPE_EATIN . ') THEN
	(
		SELECT
			dinner_table.table_name
		FROM
			dinner_table
		WHERE
			dinner_table.table_id = orders.table_id
	)
END AS contact_addr,
                (
                        SELECT
                                SUM(order_count)
                        FROM
                                order_dish_flash
                        WHERE
                               order_dish_flash.order_id = orders.order_id
                ) AS dish_count,
                (
                        SELECT
                                GROUP_CONCAT(CONCAT(order_dish_flash.order_count,\'|\',order_dish_flash.dish_name))
                        FROM
                               order_dish_flash
                        WHERE
                                order_dish_flash.order_id = orders.order_id
                ) as dishpicurllist
        FROM
                orders
        INNER JOIN contact ON orders.contact_id = contact.contact_id 
        LEFT JOIN coupon ON orders.order_id=coupon.order_id 
        where orders.dealer_id=' . $dealer_id . '
         and orders.order_status in (\'' . $statusStr . '\') ';
        if (isset($search->start_time) && !empty($search->start_time))
        {
            $sql = $sql . ' and orders.order_createtime>\'' . $search->start_time . '\'';
        }
        if (isset($search->end_time) && !empty($search->end_time))
        {
            $sql = $sql . ' and orders.order_createtime<\'' . $search->end_time . '\'';
        }
        if (isset($search->order_id) && !empty($search->order_id))
        {
            $sql = $sql . ' and orders.order_id=\'' . $search->order_id . '\'';
        }
        if (isset($search->contact_tel) && !empty($search->contact_tel))
        {
            $sql = $sql . ' and contact.contact_tel like \'%' . $search->contact_tel . '%\'';
        }
        if(isset($search->has_coupon))
        {
            if($search->has_coupon == '1')
            {
                $sql = $sql . ' and coupon.coupon_id > 0 ';
            }
            else if($search->has_coupon == '2')
            {
                $sql = $sql . ' and coupon.coupon_id is NULL ';
            }
        }
        //echo $search->has_coupon;
        //echo $sql;
        //exit();
        $sql = $sql . 'order by  orders.order_id desc';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryAll();
        return $obj;
    }

    /**
     * 获取待处理状态的外卖订单
     * @return type
     */
    public function getProcessingOrders()
    {
        $status = array(ORDER_STATUS_WAIT_PAY, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_PROCESSING, ORDER_STATUS_WAIT_EXPRESS, ORDER_STATUS_WAIT_TAKE, ORDER_STATUS_EXPRESSING); //,ORDER_STATUS_DENIED,ORDER_STATUS_COMPLETE);
        $statusStr = implode('\',\'', $status);
        $sql = 'SELECT
                orders.order_id,
                orders.order_amount,
                orders.order_createtime,
                orders.order_dinnertime,
                orders.order_status,
                orders.order_type,
                contact.contact_name,
                (
                        SELECT 
                                customer_mobile
                        FROM 
                                customer
                        WHERE 
                                customer_id = 
                                    (
                                        SELECT customer_id FROM dealer_customer
                                        WHERE dealer_id = orders.dealer_id
                                        LIMIT 1
                                    )
                ) as dealer_tel,
                (
                        SELECT 
                                dealer_name
                        FROM 
                                dealer
                        WHERE 
                                dealer_id = orders.dealer_id
                ) as dealer_name,
                contact.contact_addr AS contact_addr,
                (
                        SELECT
                                setting_value
                        FROM
                                setting
                        WHERE
                               setting_key = CONCAT(\'' . SETTING_KEY_SEND_MESSAGE_ACCEPTED_ORDER . '\',orders.dealer_id)
                ) as has_message_func,
                (
                        SELECT
                                SUM(order_count)
                        FROM
                                order_dish_flash
                        WHERE
                               order_dish_flash.order_id = orders.order_id
                ) AS dish_count,
                (
                        SELECT
                                GROUP_CONCAT(CONCAT(order_dish_flash.order_count,\'|\',order_dish_flash.dish_name))
                        FROM
                               order_dish_flash
                        WHERE
                                order_dish_flash.order_id = orders.order_id
                ) as dishpicurllist,
                timediff(NOW(),orders.order_createtime) as timestamp
        FROM
                orders
        INNER JOIN contact ON orders.contact_id = contact.contact_id 
        WHERE dealer_id <> 1 AND orders.order_status in (\'' . $statusStr . '\')';

        $sql = $sql . ' order by orders.order_createtime DESC LIMIT 30';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryAll();
        return $obj;
    }

    /**
     * 查询外卖订单
     * @return type
     */
    public function getOrders($dealer_id, $status)
    {
        $sql = 'SELECT
                orders.order_id,
                orders.order_amount,
                orders.order_paid,
                orders.order_createtime,
                orders.order_dinnertime,
                orders.order_status,
                orders.order_type,
                contact.contact_name,
                (
                        SELECT 
                                customer_mobile
                        FROM 
                                customer
                        WHERE 
                                customer_id = 
                                    (
                                        SELECT customer_id FROM dealer_customer
                                        WHERE dealer_id = orders.dealer_id
                                        LIMIT 1
                                    )
                ) as dealer_tel,
                (
                        SELECT 
                                dealer_name
                        FROM 
                                dealer
                        WHERE 
                                dealer_id = orders.dealer_id
                ) as dealer_name,
                contact.contact_addr AS contact_addr,
                (
                        SELECT
                                setting_value
                        FROM
                                setting
                        WHERE
                               setting_key = CONCAT(\'' . SETTING_KEY_SEND_MESSAGE_ACCEPTED_ORDER . '\',orders.dealer_id)
                ) as has_message_func,
                (
                        SELECT
                                SUM(order_count)
                        FROM
                                order_dish_flash
                        WHERE
                               order_dish_flash.order_id = orders.order_id
                ) AS dish_count,
                (
                        SELECT
                                GROUP_CONCAT(CONCAT(order_dish_flash.order_count,\'|\',order_dish_flash.dish_name))
                        FROM
                               order_dish_flash
                        WHERE
                                order_dish_flash.order_id = orders.order_id
                ) as dishpicurllist,
                timediff(NOW(),orders.order_createtime) as timestamp
        FROM
                orders
        INNER JOIN contact ON orders.contact_id = contact.contact_id 
        where dealer_id <> 1 ';
        if ($dealer_id != '')
        {
            $sql .= ' AND orders.dealer_id=' . $dealer_id;
        }
        if ($status != '')
        {
            $sql .= ' AND orders.order_status=' . $status;
        }
        $sql = $sql . ' order by orders.order_createtime DESC LIMIT 50';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryAll();
        return $obj;
    }

    public function getHallOrderList($dealer_id, $status, $isToday)
    {
        $statusStr = implode('\',\'', $status);
        $sql = 'SELECT
	orders.order_id,
	orders.order_paid,
	orders.order_createtime,
	orders.order_dinnertime,
	orders.order_status,
	orders.order_type,
	contact.contact_name,
	dinner_table.table_name,
	(
		SELECT
			GROUP_CONCAT(
				CONCAT(
					order_dish_flash.order_count,
					\'|\',
					order_dish_flash.dish_name
				)
			)
		FROM
			order_dish_flash
		WHERE
			order_dish_flash.order_id = orders.order_id
	) AS dishpicurllist
FROM
	orders
INNER JOIN contact ON orders.contact_id = contact.contact_id
INNER JOIN dinner_table ON orders.table_id = dinner_table.table_id
where orders.dealer_id=' . $dealer_id . ' and
    orders.order_createtime between \'' . date("Y-m-d 0:00:00") . '\' and \'' . date("Y-m-d 23:59:59") . '\' 
        and orders.order_status in (\'' . $statusStr . '\') and orders.order_type in ('
                . ORDER_TYPE_EATIN . ') order by orders.order_id desc';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        return $obj;
    }

    /**
     * 查询桌台订单
     * @param int $status 订单状态列表
     * @param bool $isToday 是否今天订单，如果否则查询所有订单
     * @return type
     */
    public function getTableOrderList($dealer_id, $status, $isToday)
    {
        $statusStr = implode('\',\'', $status);
        $sql = 'SELECT
	orders.order_id,
	orders.order_paid,
	orders.order_createtime,
	orders.order_dinnertime,
	orders.order_status,
	orders.order_type,
	contact.contact_name,
	dinner_table.table_name,
	table_reservation.reserv_start_time,
        (
                SELECT
                        GROUP_CONCAT(CONCAT(order_dish_flash.order_count,\'|\',order_dish_flash.dish_name))
                FROM
                       order_dish_flash
                WHERE
                        order_dish_flash.order_id = orders.order_id
        ) as dishpicurllist
FROM
	orders
INNER JOIN contact ON orders.contact_id = contact.contact_id
INNER JOIN table_reservation ON table_reservation.order_id = orders.order_id
INNER JOIN dinner_table ON table_reservation.table_id = dinner_table.table_id
where orders.dealer_id=' . $dealer_id . ' and
    table_reservation.reserv_start_time between \'' . date("Y-m-d 0:00:00") . '\' and \'' . date("Y-m-d 23:59:59") . '\' 
         and orders.order_status in (\'' . $statusStr . '\') and orders.order_type in ('
                . ORDER_TYPE_SUB_TABLE . ',' . ORDER_TYPE_SUB_TALE_DISH . ') order by  orders.order_id desc';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        return $obj;
    }

    public function getOrderList($dealer_id, $status)
    {
        $statusStr = implode('\',\'', $status);

        $sql = 'SELECT
                orders.order_id,
                orders.order_paid,
                orders.order_createtime,
                orders.order_dinnertime,
                orders.order_status,
                orders.order_type,
                contact.contact_name,
                contact.contact_addr,
                (
                        SELECT
                                SUM(order_count)
                        FROM
                                order_dish_flash
                        WHERE
                               order_dish_flash.order_id = orders.order_id
                ) AS dish_count,
                (
                        SELECT
                                GROUP_CONCAT(CONCAT(order_dish_flash.order_count,\'|\',order_dish_flash.dish_name))
                        FROM
                               order_dish_flash
                        WHERE
                                order_dish_flash.order_id = orders.order_id
                ) as dishpicurllist
        FROM
                orders
        INNER JOIN contact ON orders.contact_id = contact.contact_id
        where orders.dealer_id=' . $dealer_id . '
         and orders.order_status in (\'' . $statusStr . '\') and orders.order_type in ('
                . ORDER_TYPE_TAKEOUT . ',' . ORDER_TYPE_TAKEOUT_SELFTAKE . ' ) order by  orders.order_id desc';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        return $obj;
    }

    /**
     * 获取订单状态代码
     * @param type $id 订单id
     */
    public function getOrderStatus($id)
    {
        $order = self::model()->findByPk($id);
        if (!isset($order))
        {
            return -1;
        } else
        {
            return $order->order_status;
        }
    }

    /**
     * 获取新状态 用于自动流转的流程
     * @param type $status 当前状态
     * @return string
     */
    public function getNewStatus($status)
    {
        switch ($status)
        {

            case ORDER_STATUS_EXPRESSING:
                return ORDER_STATUS_COMPLETE;
                break;
            case ORDER_STATUS_WAIT_PAY:
                return ORDER_STATUS_COMPLETE;
            default:
                return -1;
                break;
        }
    }

    /**
     * 更新订单状态
     * @param type $orderid 订单id
     * @param type $status 订单新状态
     * @return int 影响行数
     */
    public function updateStatus($orderid, $status)
    {
        $count = self::model()->updateByPk($orderid, array('order_status' => $status));
        return $count;
    }

    /**
     * 根据客户id获得历史订单
     * @param int $customer_id 客户id
     * @param int $dealer_id 商家id
     * @return type
     */
    public function getOrdersByCustomerId($customer_id, $dealer_id = 0)
    {
        $filter = array('order_customer_id' => $customer_id,);
        if ($dealer_id != 0)
        {
            $filter['dealer_id'] = $dealer_id;
        }

        return $this->findAllByAttributes($filter, array('order' => 'order_id desc'));
    }

    /**
     * 获取待处理的订单(外卖订单)
     * @return \CArrayDataProvider
     */
    public function getProcessedTakeoutOrders($dealer_id, $lastid)
    {
        $sql = 'SELECT
	orders.order_id,
	orders.order_paid,
	contact.contact_addr,
	(
		SELECT
			SUM(order_count)
		FROM
			order_dish_flash
		WHERE
			order_dish_flash.order_id = orders.order_id
	) AS dish_count,
        orders.order_type,orders.order_createtime
FROM
	orders
INNER JOIN contact ON orders.contact_id = contact.contact_id
WHERE orders.order_type in (' . ORDER_TYPE_TAKEOUT . ',' . ORDER_TYPE_TAKEOUT_SELFTAKE . ') and orders.order_status=' . ORDER_STATUS_WAIT_PROCESS
                . ' and orders.order_id>' . $lastid . ' and orders.dealer_id=' . $dealer_id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        return $obj;
    }

    /**
     * 获取待处理的订单(桌台订餐)
     * @param type $lastid
     * @return type
     */
    public function getProcessedTableOrders($dealer_id, $lastid)
    {
        $sql = 'SELECT
	orders.order_id,
	orders.order_paid,
	(
		SELECT
			if(ISNULL(SUM(order_count)),0,SUM(order_count))
		FROM
			order_dish_flash
		WHERE
			order_dish_flash.order_id = orders.order_id
	) AS dish_count,
	table_reservation.reserv_start_time,
	
	dinner_table.table_name,
        orders.order_type,orders.order_createtime
FROM
	orders
INNER JOIN table_reservation ON table_reservation.order_id = orders.order_id
INNER JOIN dinner_table ON table_reservation.table_id = dinner_table.table_id
WHERE orders.order_type in (' . ORDER_TYPE_SUB_TALE_DISH . ',' . ORDER_TYPE_SUB_TABLE . ') and orders.order_status=' . ORDER_STATUS_WAIT_PROCESS
                . ' and orders.order_id>' . $lastid . ' and orders.dealer_id=' . $dealer_id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        return $obj;
    }

    /**
     * 获取待处理的订单(店内订餐)
     * @param type $dealer_id
     * @param type $lastid
     * @return type
     */
    public function getProcessedHallOrders($dealer_id, $lastid)
    {
        $sql = sprintf('SELECT
orders.order_id,
orders.order_paid,
(
		SELECT
			SUM(order_count)
		FROM
			order_dish_flash
		WHERE
			order_dish_flash.order_id = orders.order_id
	) AS dish_count,
orders.order_type,
dinner_table.table_name,orders.order_createtime
FROM
orders
INNER JOIN dinner_table ON orders.table_id = dinner_table.table_id
WHERE
	orders.order_type = %s
AND orders.order_status = %s
AND orders.order_id > %s
AND orders.dealer_id = %s'
                , ORDER_TYPE_EATIN, ORDER_STATUS_WAIT_PROCESS, $lastid, $dealer_id
        );
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        return $obj;
    }

    /**
     * 下单数，用于报表统计
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @param type $str_orderstatus 订单类型列表，字符串类型用于in查询
     */
    private function createOrderCount($dealer_id, $beginDate_value, $endDate_value, $str_orderstatus)
    {
        $day = busUlitity::DateSubDay($beginDate_value, $endDate_value);
        $format = '';
        if ($day > 0)
        {
            $format = '%Y-%m-%d';
        } else
        {
            $format = '%H';
        }
        $sql = 'SELECT
	count(*) as value,
	
	date_format(order_createtime, \'' . $format . '\') AS name
FROM
	orders
WHERE
	order_createtime BETWEEN \'' . $beginDate_value . '\'
AND \'' . $endDate_value . '\' and dealer_id=' . $dealer_id . '
AND order_type in (' . $str_orderstatus . ')    
GROUP BY
	name
ORDER BY
	name';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        if ($day > 0)
        {
            $list = $this->reportInsertEmptyItemToJsArrayByDays($obj, $beginDate_value, $day);
        } else
        {
            $list = $this->reportInsertEmptyItemToJsArrayByHours($obj, 0, 23);
        }

        return $list;
    }

    /**
     * 接单数，用于报表统计
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @param type $str_orderstatus 订单类型列表，字符串类型用于in查询
     */
    private function effectiveOrderCount($dealer_id, $beginDate_value, $endDate_value, $str_orderstatus)
    {
        $day = busUlitity::DateSubDay($beginDate_value, $endDate_value);
        $format = '';
        if ($day > 0)
        {
            $format = '%Y-%m-%d';
        } else
        {
            $format = '%H';
        }
        $sql = 'SELECT
	count(*) as value,
	
	date_format(order_createtime, \'' . $format . '\') AS name
FROM
	orders
WHERE
	order_createtime BETWEEN \'' . $beginDate_value . '\'
AND \'' . $endDate_value . '\' and dealer_id=' . $dealer_id . ' and order_status in (1,2,3,5,6,7,8,9)
AND order_type in (' . $str_orderstatus . ')    
GROUP BY
	name
ORDER BY
	name';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        if ($day > 0)
        {
            $list = $this->reportInsertEmptyItemToJsArrayByDays($obj, $beginDate_value, $day);
        } else
        {
            $list = $this->reportInsertEmptyItemToJsArrayByHours($obj, 0, 23);
        }
        return $list;
    }

    /**
     * 
     * @param type $dealer_id
     * @param type $beginDate_value
     * @param type $endDate_value
     * @param type $str_orderstatus
     * @return type
     */
    private function turnoveSum($dealer_id, $beginDate_value, $endDate_value, $str_orderstatus)
    {
        $day = busUlitity::DateSubDay($beginDate_value, $endDate_value);
        $format = '';
        if ($day > 0)
        {
            $format = '%Y-%m-%d';
        } else
        {
            $format = '%H';
        }
        $sql = 'SELECT
	sum(order_paid) as value,
	
	date_format(order_createtime, \'' . $format . '\') AS name
FROM
	orders
WHERE
	order_createtime BETWEEN \'' . $beginDate_value . '\'
AND \'' . $endDate_value . '\' and dealer_id=' . $dealer_id . ' and order_status in (1,2,3,5,6,7,8,9)
AND order_type in (' . $str_orderstatus . ')    
GROUP BY
	name
ORDER BY
	name';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        if ($day > 0)
        {
            $list = $this->reportInsertEmptyItemToJsArrayByDays($obj, $beginDate_value, $day);
        } else
        {
            $list = $this->reportInsertEmptyItemToJsArrayByHours($obj, 0, 23);
        }
        return $list;
    }

    /**
     * 外卖下单数
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @return type
     */
    public function createOrderTakeoutCount($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->createOrderCount($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_TAKEOUT . ',' . ORDER_TYPE_TAKEOUT_SELFTAKE);
    }

    /**
     * 外卖接单数
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @return type
     */
    public function effectiveOrderTakeoutCount($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->effectiveOrderCount($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_TAKEOUT . ',' . ORDER_TYPE_TAKEOUT_SELFTAKE);
    }

    /**
     * 外卖订单成交金额
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @return type 
     */
    public function turnoveTakeoutSum($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->turnoveSum($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_TAKEOUT . ',' . ORDER_TYPE_TAKEOUT_SELFTAKE);
    }

    /**
     * 订台下单数
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     */
    public function createOrderTableCount($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->createOrderCount($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_SUB_TABLE . ',' . ORDER_TYPE_SUB_TALE_DISH);
    }

    /**
     * 订台接单数
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @return type
     */
    public function effectiveOrderTableCount($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->effectiveOrderCount($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_SUB_TABLE . ',' . ORDER_TYPE_SUB_TALE_DISH);
    }

    /**
     * 订台订单成交金额
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @return type 
     */
    public function turnoveTableSum($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->turnoveSum($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_SUB_TABLE . ',' . ORDER_TYPE_SUB_TALE_DISH);
    }

    /**
     * 堂食点菜下单数
     * @param type $dealer_id
     * @param type $beginDate_value
     * @param type $endDate_value
     * @return type
     */
    public function createOrderHallCount($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->createOrderCount($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_EATIN);
    }

    /**
     * 堂食接单数
     * @param type $dealer_id
     * @param type $beginDate_value
     * @param type $endDate_value
     */
    public function effectiveOrderHallCount($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->effectiveOrderCount($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_EATIN);
    }

    /**
     * 堂食成交金额
     * @param type $dealer_id
     * @param type $beginDate_value
     * @param type $endDate_value
     * @return type
     */
    public function turnoveHallSum($dealer_id, $beginDate_value, $endDate_value)
    {
        return $this->turnoveSum($dealer_id, $beginDate_value, $endDate_value, ORDER_TYPE_EATIN);
    }

    /**
     * 菜品热度
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @return type
     */
    public function frequencyByDealer($dealer_id, $beginDate_value, $endDate_value)
    {
        $sql = 'SELECT flash.dish_name,SUM(order_count) AS dish_count
FROM
order_dish_flash AS flash
INNER JOIN orders ON flash.order_id = orders.order_id
WHERE orders.order_createtime BETWEEN \'' . $beginDate_value . '\'
AND \'' . $endDate_value . '\' and orders.dealer_id=' . $dealer_id . '
and order_status in (1,2,3,5,6,7,8,9)
GROUP BY flash.dish_name
ORDER BY dish_count DESC';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'dish_name';
        return $obj;
    }

    /**
     * 菜品趋势
     * @param int $dealer_id 商户id
     * @param type $dish_name 菜品名称
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @return type 
     */
    public function frequencyBySingleDish($dealer_id, $dish_name, $beginDate_value, $endDate_value)
    {
        $day = busUlitity::DateSubDay($beginDate_value, $endDate_value);
        $format = '';
        if ($day > 0)
        {
            $format = '%Y-%m-%d';
        } else
        {
            $format = '%H';
        }
        $sql = 'SELECT
	sum(order_dish_flash.order_count) AS value,
	date_format(order_createtime, \'' . $format . '\') AS name
FROM
	order_dish_flash
INNER JOIN orders ON order_dish_flash.order_id = orders.order_id
WHERE   orders.order_createtime BETWEEN \'' . $beginDate_value . '\'
AND \'' . $endDate_value . '\' AND  order_dish_flash.dish_name = \'' . $dish_name . '\'
AND orders.dealer_id = ' . $dealer_id . '
AND orders.order_status IN (1, 2, 3, 5, 6, 7, 8, 9)
GROUP BY
	NAME
ORDER BY
	NAME';

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        if ($day > 0)
        {
            $list = $this->reportInsertEmptyItemToJsArrayByDays($obj, $beginDate_value, $day);
        } else
        {
            $list = $this->reportInsertEmptyItemToJsArrayByHours($obj, 0, 23);
        }
        return $list;
    }

    /**
     * 当前商户各月账单（未支付的）
     * @param type $dealer_id 商户id
     * @param type $coefficient_takeout 外卖订单系数
     * @param type $coefficient_table 桌台订单系数
     * @return \CArrayDataProvider
     */
    public function myBill($dealer_id, $coefficient_takeout, $coefficient_table)
    {
        $sql = 'SELECT
	date_format(
		orders.order_createtime,
		\'%Y-%m\'
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
	count(
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
		CASE orders.order_type
		WHEN ' . ORDER_TYPE_TAKEOUT . ' THEN
			orders.order_paid
		WHEN ' . ORDER_TYPE_TAKEOUT_SELFTAKE . ' THEN
			orders.order_paid
		ELSE
			0
		END
	) * ' . $coefficient_takeout . ' + COUNT(
		CASE orders.order_type
		WHEN ' . ORDER_TYPE_SUB_TABLE . ' THEN
			orders.order_paid
		WHEN ' . ORDER_TYPE_SUB_TALE_DISH . ' THEN
			orders.order_paid
		ELSE
			NULL
		END
	) * ' . $coefficient_table . ' AS poundage
FROM
	orders
WHERE
	dealer_id = ' . $dealer_id . ' AND orders.order_status IN (1, 2, 3, 5, 6, 7, 8, 9)
        AND date_format(
		orders.order_createtime,
		\'%Y-%m\'
	) NOT IN (
	SELECT
		bill_month
	FROM
		dealer_bill
	WHERE
		dealer_id = ' . $dealer_id . '
) 
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
     * 当前商户各月账单（已经支付的）
     * @param type $dealer_id 商户id
     * @param type $coefficient_takeout 外卖订单系数
     * @param type $coefficient_table 桌台订单系数
     * @return \CArrayDataProvider
     */
    public function myHistoryBill($dealer_id, $coefficient_takeout, $coefficient_table)
    {
        $sql = 'SELECT
	date_format(
		orders.order_createtime,
		\'%Y-%m\'
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
	count(
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
		CASE orders.order_type
		WHEN ' . ORDER_TYPE_TAKEOUT . ' THEN
			orders.order_paid
		WHEN ' . ORDER_TYPE_TAKEOUT_SELFTAKE . ' THEN
			orders.order_paid
		ELSE
			0
		END
	) * ' . $coefficient_takeout . ' + COUNT(
		CASE orders.order_type
		WHEN ' . ORDER_TYPE_SUB_TABLE . ' THEN
			orders.order_paid
		WHEN ' . ORDER_TYPE_SUB_TALE_DISH . ' THEN
			orders.order_paid
		ELSE
			NULL
		END
	) * ' . $coefficient_table . ' AS poundage
FROM
	orders
WHERE
	dealer_id = ' . $dealer_id . ' AND orders.order_status IN (1, 2, 3, 5, 6, 7, 8, 9)
        AND date_format(
		orders.order_createtime,
		\'%Y-%m\'
	) IN (
	SELECT
		bill_month
	FROM
		dealer_bill
	WHERE
		dealer_id = ' . $dealer_id . '
) 
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
     * 当前商户一个月账单
     * @param type $dealer_id 商户id
     * @param string $beginDate 起始时间 字符串格式
     * @param string $endDate 结束时间 字符串格式
     * @param type $coefficient_takeout 外卖订单系数
     * @param type $coefficient_table 桌台订单系数
     * @return \CArrayDataProvider
     */
    public function myBillMonth($dealer_id, $beginDate, $endDate, $coefficient_takeout, $coefficient_table)
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
     * @param type $coefficient_takeout
     * @return \CArrayDataProvider
     */
    public function myBillDayTakeout($dealer_id, $beginDate, $endDate, $coefficient_takeout)
    {
        $sql = 'SELECT
	date_format(
		orders.order_createtime,
		\'%Y-%m-%d %T\'
	) AS bill_date,
	orders.order_paid AS takeout_paid,
        orders.order_paid * ' . $coefficient_takeout . ' AS poundage
FROM
	orders
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
     * @param type $coefficient_table
     * @return \CArrayDataProvider
     */
    public function myBillDayTable($dealer_id, $beginDate, $endDate, $coefficient_table)
    {
        $sql = 'SELECT
	date_format(
		orders.order_createtime,
		\'%Y-%m-%d %T\'
	) AS bill_date,
        ' . $coefficient_table . ' AS poundage
FROM
	orders
WHERE
	orders.dealer_id = ' . $dealer_id . ' AND orders.order_status IN (1, 2, 3, 5, 6, 7, 8, 9)
          AND orders.order_createtime BETWEEN \'' . $beginDate . '\' AND \'' . $endDate . '\' 
          AND orders.order_type IN (' . ORDER_TYPE_SUB_TABLE . ',' . ORDER_TYPE_SUB_TALE_DISH . ')    ';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'bill_date';
        return $obj;
    }

    /**
     * 将php数组转换为js使用的数组字符串，按name属性补齐，原有数组中name不存在的数据用0补齐
     * @param type $obj php数组，必须有value 和name属性，name为一定顺序的int数据
     * @param type $beginIndex 期望结果中name的起始索引
     * @param type $endIndex 期望结果中name的结束索引
     * @return type 符合js数组的字符串
     */
    private function reportInsertEmptyItemToJsArrayByHours($obj, $beginIndex, $endIndex)
    {
        $list = array();
        for ($i = $beginIndex; $i < $endIndex + 1; $i++)
        {
//            $temp_array = array('value' => 0);
            $temp_array = 0;
            foreach ($obj as $item)
            {
                if ($item['name'] == $i)
                {
                    $temp_array = $item['value']; // $item;
                    break;
                }
            }
            array_push($list, $temp_array);
        }
        $list = implode(',', $list);
        return $list;
    }

    /**
     * 将php数组转换为js使用的数组字符串，按name属性补齐，原有数组中name不存在的数据用0补齐
     * @param type $obj php数组，必须有value 和name属性，name为一定顺序的日期类型字符串数据 形如2014-02-03
     * @param type $beginDate 起始日期
     * @param type $days_sub 天数
     */
    private function reportInsertEmptyItemToJsArrayByDays($obj, $beginDate, $days_sub)
    {
        $beginDate = substr($beginDate, 0, 10); //获得日期，不要时间
        $beginDate_time = strtotime($beginDate);
        $list = array();
        for ($i = 0; $i < $days_sub + 1; $i++)
        {
//            $temp_array = array('value' => 0);
            $time_temp = date('Y-m-d', strtotime('+' . $i . ' day', $beginDate_time));
            $temp_array = 0;
            foreach ($obj as $item)
            {
                if ($item['name'] == $time_temp)//如果当天有数据，就填充
                {
                    $temp_array = $item['value']; // $item;
                    break;
                }
            }
            array_push($list, $temp_array); //没有数据就用0补充
        }
        $list = implode(',', $list);
        return $list;
    }

    /**
     * 将php数组转换为json字符串，按name属性补齐，原有数组中name不存在的数据用0补齐
     * @param type $obj php数组，必须有value 和name属性，name为一定顺序的int数据
     * @param type $beginIndex 期望结果中name的起始索引
     * @param type $endIndex 期望结果中name的结束索引
     * @return type json字符串
     */
    private function reportInsertEmptyItemToJsonByHours($obj, $beginIndex, $endIndex)
    {
        $list = array();
        for ($i = $beginIndex; $i < $endIndex + 1; $i++)
        {
            $temp_array = array('value' => 0, 'name' => $i);
            foreach ($obj as $item)
            {
                if ($item['name'] == $i)
                {
                    $temp_array = $item;
                    break;
                }
            }
            $color = $i % 5;
            switch ($color)
            {
                case 0:
                    $temp_array['color'] = '#ff6256';
                    break;
                case 1:
                    $temp_array['color'] = '#eeb453';
                    break;
                case 2:
                    $temp_array['color'] = '#ffaca7';
                    break;
                case 3:
                    $temp_array['color'] = '#7e6861';
                    break;
                case 4:
                    $temp_array['color'] = '#7ad1d0';
                    break;
                default:
                    break;
            }
            array_push($list, $temp_array);
        }
        $list = json_encode($list);
        return $list;
    }

    /**
     * 将php数组转换为json字符串，按name属性补齐，原有数组中name不存在的数据用0补齐
     * @param type $obj php数组，必须有value 和name属性，name为一定顺序的日期类型字符串数据 形如2014-02-03
     * @param type $beginDate 起始日期
     * @param type $days_sub 天数
     * @return type
     */
    private function reportInsertEmptyItemToJsonByDays($obj, $beginDate, $days_sub)
    {
        $beginDate = substr($beginDate, 0, 10);
        $beginDate_time = strtotime($beginDate);
        $list = array();
        for ($i = 0; $i < $days_sub + 1; $i++)
        {
            $time_temp = date('Y-m-d', strtotime('+' . $i . ' day', $beginDate_time));
            $temp_array = array('value' => 0, 'name' => $time_temp);
            foreach ($obj as $item)
            {
                if ($item['name'] == $time_temp)
                {
                    $temp_array = $item;
                    break;
                }
            }
            $color = $i % 5;
            switch ($color)
            {
                case 0:
                    $temp_array['color'] = '#ff6256';
                    break;
                case 1:
                    $temp_array['color'] = '#eeb453';
                    break;
                case 2:
                    $temp_array['color'] = '#ffaca7';
                    break;
                case 3:
                    $temp_array['color'] = '#7e6861';
                    break;
                case 4:
                    $temp_array['color'] = '#7ad1d0';
                    break;
                default:
                    break;
            }
            array_push($list, $temp_array);
        }
        $list = json_encode($list);
        return $list;
    }

    /**
     * 获取待处理订单信息
     * @param type $dealer_id 商户id
     * @param type $beginDate_value 起始日期
     * @param type $endDate_value 结束日期
     * @return type
     */
    public function getProcessedOrdersByDate($dealer_id, $beginDate_value, $endDate_value)
    {
        $sql = 'SELECT 
            orders.order_id as id,
            orders.order_createtime as create_time,
            orders.order_dinnertime as dinner_time,
            orders.order_amount as order_amount,
            orders.order_paid as order_paid,
            orders.order_type as order_type,
            orders.order_ispay as order_ispay,
            orders.order_pay_type as order_pay_type,
            orders.order_person_count as order_person_count,
            orders.contact_id as contact,
            (
                SELECT
			memo
		FROM
			order_status_message
		WHERE
			order_status_message.order_id = orders.order_id
                AND
                        order_status_message.cur_order_status = orders.order_status
            ) as memo,
            (
		SELECT
			coupon_no
		FROM
			coupon
		WHERE
			coupon.order_id = orders.order_id
                AND 
                        coupon.coupon_status =' . COUPON_STATUS_INVALID .
                ') AS discount_code
            FROM orders
            WHERE orders.dealer_id = ' . $dealer_id .
                ' AND orders.order_status =' . ORDER_STATUS_WAIT_PROCESS .
                ' AND orders.order_createtime >= \'' . $beginDate_value .
                '\' AND orders.order_createtime <= \'' . $endDate_value . '\'' .
                ' ORDER BY orders.order_id DESC';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $orders = $cmd->queryAll();
        if (isset($orders))
        {
            foreach ($orders as &$order)
            {
                $order['table'] = TableReservation::model()->getTableByOrderId($order['id']);
                $order['dishes'] = OrderDishFlash::model()->getOrderDishFlashByOrderId($order['id']);
                $order['contact'] = Contact::model()->getContractByOrderId($order['contact']);
                $order['discount_plan'] = OrderDiscount::model()->getOrderDiscountByOrderId($order['id']);
            }
        }

        return $orders;
    }

    /**
     * 获取处理中订单信息
     * @param type $dealer_id 商户id
     * @return type
     */
    public function getUnfinishedOrders($dealer_id)
    {
        $sql = 'SELECT 
            orders.order_id as id,
            orders.order_createtime as create_time,
            orders.order_dinnertime as dinner_time,
            orders.order_amount as order_amount,
            orders.order_paid as order_paid,
            orders.order_type as order_type,
            orders.order_ispay as order_ispay,
            orders.order_pay_type as order_pay_type,
            orders.order_person_count as order_person_count,
            orders.contact_id as contact,
            orders.order_status,
            (
                SELECT
			memo
		FROM
			order_status_message
		WHERE
			order_status_message.order_id = orders.order_id
                AND
                        order_status_message.cur_order_status = orders.order_status
            ) as memo,
            (
		SELECT
			coupon_no
		FROM
			coupon
		WHERE
			coupon.order_id = orders.order_id
                AND 
                        coupon.coupon_status =' . COUPON_STATUS_INVALID .
                ') AS discount_code,
            (
		SELECT
			dealer_express_fee
		FROM
			dealer
		WHERE
			dealer.dealer_id = orders.dealer_id               
                ) AS express_fee
            FROM orders
            WHERE orders.dealer_id = ' . $dealer_id .
                ' AND orders.order_status NOT IN(' . ORDER_STATUS_COMPLETE . ',' . ORDER_STATUS_DENIED . ',' . ORDER_STATUS_CLOSE . ')' .
                ' ORDER BY orders.order_id DESC';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $orders = $cmd->queryAll();
        if (isset($orders))
        {
            foreach ($orders as &$order)
            {
                $order['table'] = TableReservation::model()->getTableByOrderId($order['id']);
                $order['dishes'] = OrderDishFlash::model()->getOrderDishFlashByOrderId($order['id']);
                $order['contact'] = Contact::model()->getContractByOrderId($order['contact']);
                $order['discount_plan'] = OrderDiscount::model()->getOrderDiscountByOrderId($order['id']);
            }
        }

        return $orders;
    }

    /**
     * 获取完成订单信息
     * @param type $dealer_id 商户id
     * @return type
     */
    public function getfinishedOrders($dealer_id, $lastid)
    {
        $sql = 'SELECT 
            orders.order_id as id,
            orders.order_createtime as create_time,
            orders.order_dinnertime as dinner_time,
            orders.order_amount as order_amount,
            orders.order_paid as order_paid,
            orders.order_type as order_type,
            orders.order_ispay as order_ispay,
            orders.order_pay_type as order_pay_type,
            orders.order_person_count as order_person_count,
            orders.contact_id as contact,
            orders.order_status,
                        (
                SELECT
			memo
		FROM
			order_status_message
		WHERE
			order_status_message.order_id = orders.order_id 
                AND
                        order_status_message.cur_order_status = orders.order_status
            ) as memo,
            (
		SELECT
			coupon_no
		FROM
			coupon
		WHERE
			coupon.order_id = orders.order_id
                AND 
                        coupon.coupon_status =' . COUPON_STATUS_INVALID .
                ') AS discount_code,
                (
		SELECT
			dealer_express_fee
		FROM
			dealer
		WHERE
			dealer.dealer_id = orders.dealer_id               
                ) AS express_fee
            FROM orders
            WHERE orders.dealer_id = ' . $dealer_id .
                ' AND orders.order_status IN(' . ORDER_STATUS_COMPLETE . ',' . ORDER_STATUS_DENIED . ',' . ORDER_STATUS_CLOSE . ')' .
                ' AND orders.order_id' . $lastid .
                ' ORDER BY orders.order_id DESC LIMIT 10';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $orders = $cmd->queryAll();
        if (isset($orders))
        {
            foreach ($orders as &$order)
            {
                $order['table'] = TableReservation::model()->getTableByOrderId($order['id']);
                $order['dishes'] = OrderDishFlash::model()->getOrderDishFlashByOrderId($order['id']);
                $order['contact'] = Contact::model()->getContractByOrderId($order['contact']);
                $order['discount_plan'] = OrderDiscount::model()->getOrderDiscountByOrderId($order['id']);
            }
        }

        return $orders;
    }

}
