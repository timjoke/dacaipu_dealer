<?php

/**
 * This is the model class for table "order_status_message".
 *
 * The followings are the available columns in table 'order_status_message':
 * @property string $message_id
 * @property string $order_id
 * @property string $create_time
 * @property string $memo
 * @property integer $cur_order_status
 * @property string $modifier_id
 *
 * The followings are the available model relations:
 * @property Orders $order
 */
class OrderStatusMessage extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'order_status_message';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('create_time', 'required'),
            array('cur_order_status', 'numerical', 'integerOnly' => true),
            array('order_id, modifier_id', 'length', 'max' => 20),
            array('memo', 'length', 'max' => 2000),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('message_id, order_id, create_time, memo, cur_order_status, modifier_id', 'safe', 'on' => 'search'),
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
            'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'message_id' => '维护信息id',
            'order_id' => '订单id',
            'create_time' => '创建时间',
            'memo' => '备注',
            'cur_order_status' => '当前状态',
            'modifier_id' => '维护人id
            -1 系统；
            > 0 customer',
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

        $criteria->compare('message_id', $this->message_id, true);
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('cur_order_status', $this->cur_order_status);
        $criteria->compare('modifier_id', $this->modifier_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderStatusMessage the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取订单状态维护信息列表，用于订单页面
     * @param type $order_id 订单id
     * @return type
     */
    public function getOrderStatusMessageList($order_id)
    {
        $sql = 'SELECT
            order_status_message.message_id,
	order_status_message.create_time,
	order_status_message.memo,
	order_status_message.cur_order_status,
	order_status_message.modifier_id,
	CASE
WHEN order_status_message.modifier_id =- 1 THEN
	\'系统\'
WHEN order_status_message.modifier_id > 0 THEN
	(
		SELECT
			customer_name
		FROM
			customer
		WHERE
			customer_id = order_status_message.modifier_id
	)
END AS modifierName
FROM
	order_status_message
WHERE
	order_status_message.order_id = ' . $order_id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'message_id';
        return $obj;
    }

    /**
     * 订单状态流转DS
     * @param type $orderid 订单id
     * @param type $old_status 旧状态
     * @param type $new_status 新状态
     * @param type $memo 备注
     * @return int
     */
    public function transformOrderStatus_DS($dealer_id, $orderid, $old_status, $new_status, $memo)
    {
//检查页面上传来的订单状态是否与数据库中的一致
        $order = Orders::model()->findByPk($orderid);
        if (!isset($order))
        {
            Yii::log('订单状态流转失败：未找到订单', CLogger::LEVEL_ERROR);
            return -1;
        } else
        {
            if ($order->order_status != $old_status)
            {
                Yii::log('订单状态流转失败：订单状态已经改变。数据库状态： '
                        . $order->order_status . '  页面传入的状态:' . $old_status, CLogger::LEVEL_ERROR);
                return -2;
            }
        }

        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            //更新订单状态
            $count = Orders::model()->updateStatus($orderid, $new_status);
            if ($count == 0)
            {//更新失败，回滚
                Yii::log('更新失败,订单id：' . $orderid, CLogger::LEVEL_ERROR);
                $transaction->rollback();
                return -3;
            }
            //记录备注
            $bo = new busOrderDS();
            $dealerCustomer = DealerCustomer::model()->find(array('condition' => 'dealer_id=' . $dealer_id));
            $customer_id = $dealerCustomer->customer_id;
            $bo->insert_order_status($orderid, $new_status, $customer_id, $memo);

            //通知
            $busOrder = new busOrderDS();
            $res = new OperResult();
            $res->order_id = $orderid;
            $res->reason = $memo;
            $busOrder->order_status_notice($res);

            $transaction->commit();
            //Yii::app()->cache->flush();
            Yii::log('订单状态更新成功，订单id：' . $orderid, CLogger::LEVEL_INFO);
            return 0;
        } catch (Exception $ex)
        {//未知错误，回滚
            Yii::log('订单状态流转未知错误：' . $ex->getMessage(), CLogger::LEVEL_ERROR);
            $transaction->rollback();
            return -4;
        }
    }

    /**
     * 订单状态流转
     * @param type $orderid 订单id
     * @param type $old_status 旧状态
     * @param type $new_status 新状态
     * @param type $memo 备注
     * @return int
     */
    public function transformOrderStatus($dealer_id, $orderid, $old_status, $new_status, $memo)
    {
//检查页面上传来的订单状态是否与数据库中的一致
        $order = Orders::model()->findByPk($orderid);
        if (!isset($order))
        {
            Yii::log('订单状态流转失败：未找到订单', CLogger::LEVEL_ERROR);
            return -1;
        } else
        {
            if ($order->order_status != $old_status)
            {
                Yii::log('订单状态流转失败：订单状态已经改变。数据库状态： '
                        . $order->order_status . '  页面传入的状态:' . $old_status, CLogger::LEVEL_ERROR);
                return -2;
            }
        }

        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            //更新订单状态
            $count = Orders::model()->updateStatus($orderid, $new_status);
            if ($count == 0)
            {//更新失败，回滚
                Yii::log('更新失败,订单id：' . $orderid, CLogger::LEVEL_ERROR);
                $transaction->rollback();
                return -3;
            }
            //记录备注
            $bo = new busOrder();
            $dealerCustomer = DealerCustomer::model()->find(array('condition' => 'dealer_id=' . $dealer_id));
            $customer_id = $dealerCustomer->customer_id;
            $bo->insert_order_status($orderid, $new_status, $customer_id, $memo);

            //通知
            $busOrder = new busOrder();
            $res = new OperResult();
            $res->order_id = $orderid;
            $res->reason = $memo;
            $busOrder->order_status_notice($res);

            $transaction->commit();
            //Yii::app()->cache->flush();
            Yii::log('订单状态更新成功，订单id：' . $orderid, CLogger::LEVEL_INFO);
            return 0;
        } catch (Exception $ex)
        {//未知错误，回滚
            Yii::log('订单状态流转未知错误：' . $ex->getMessage(), CLogger::LEVEL_ERROR);
            $transaction->rollback();
            return -4;
        }
    }

    /**
     * 获取订单用户提交的备注
     * @param type $orderid 订单编号
     * @return type
     */
    public function getUserRemark($orderid)
    {
        $cri = new CDbCriteria();
        $cri->addCondition('order_id = :order_id');
        $cri->addCondition('cur_order_status = :cur_order_status');
        $cri->params[':order_id'] = $orderid;
        $cri->params[':cur_order_status'] = ORDER_STATUS_WAIT_PROCESS;

        $cri->select = 'memo';
        $orderStatus = OrderStatusMessage::model()->find($cri);
        if (isset($orderStatus))
        {
            return $orderStatus->memo;
        } else
        {
            return '';
        }
    }

    /**
     * 获取已拒绝订单商家的备注信息
     * @param type $orderid
     */
    public function getRejectMemo($orderid)
    {
        $cri = new CDbCriteria();
        $cri->addCondition('order_id = :order_id');
        $cri->addCondition('cur_order_status = :cur_order_status');
        $cri->params[':order_id'] = $orderid;
        $cri->params[':cur_order_status'] = ORDER_STATUS_DENIED;

        $cri->select = 'memo';
        $orderStatus = OrderStatusMessage::model()->find($cri);
        if (isset($orderStatus))
        {
            return $orderStatus->memo;
        } else
        {
            return '';
        }
    }

}
