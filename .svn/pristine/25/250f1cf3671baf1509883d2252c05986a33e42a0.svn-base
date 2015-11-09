<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderWaitProcessController
 *
 * @author lts
 */
class OrderWaitProcessController extends Controller_DealerAdmin
{

    public $layout = '/layouts/empty';

    //put your code here
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete',
                    'processed_order', 'agree', 'reject', 'processed_table_order',
                    'agreeTable', 'rejectTable', 'processed_hall_order', 'agreeHall', 'rejectHall'),
                #'users'=>array('*'),
                'roles' => array(CUSTOMER_ROLENAME_DEALERUSER),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * 显示外卖订单
     * @param type $id
     */
    public function actionProcessed_order($id)
    {
        $this->loadpage($id);
    }

    /**
     * 加载外卖订单
     * @param type $id
     */
    private function loadpage($id)
    {
        $dealer_id = $this->getDealerId();
        $model = Orders::model()->findByPk($id);
        //获取联系人信息
        $contactmodel = Contact::model()->findByPk($model->contact_id);
        //获取订单菜品快照信息        
        $order_dish_flash_list = OrderDishFlash::model()->getDishsByOrdersid($id);
        $busDis = new BusDiscount();

        $result = $busDis->getDiscountforDealeradmin($id);
        $coupon_value = $result->coupon_value;
        $discount_list = $result->discount_list;
        
        //菜品总金额
//        $bus_order = new busOrder();
//        $dishAmount = $bus_order->countDishAmount($order_dish_flash_list, TRUE);

        //配送费
        $dealer = Dealer::model()->findByPk($dealer_id);
        $dealer_express_fee = $dealer->dealer_express_fee;
        //用户备注
        $user_remark = OrderStatusMessage::model()->getUserRemark($id);

        $this->render('processed_order', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
            'dealer_express_fee' => $dealer_express_fee, 
//            'dishAmount' => $dishAmount,
            'user_remark' => $user_remark,
                ), false, true);
    }

    /**
     * 接受外卖订单
     * @param type $id 订单编号
     */
    public function actionagree($id)
    {
        $memo = $_POST['memo'];
        //添加备注
        $dealer_id = $this->getDealerId();
        OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_PROCESSING, $memo);
        Yii::app()->clientScript->registerScript('remove', 'window.top.agreeOrder(' . $id . ',false);');
        $this->loadpage($id);
    }

    /**
     * 接受桌台订单
     * @param type $id 订单编号
     */
    public function actionagreeTable($id)
    {
        $memo = $_POST['memo'];
        //添加备注
        $dealer_id = $this->getDealerId();
        OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_PROCESSING, $memo);
        Yii::app()->clientScript->registerScript('remove', 'window.top.agreeOrder(' . $id . ',false);');
        $this->loadtablepage($id);
    }

    /**
     * 接受堂内点餐订单
     * @param type $id 订单编号
     */
    public function actionagreeHall($id)
    {
        $memo = $_POST['memo'];
        //添加备注
        $dealer_id = $this->getDealerId();
        OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_PROCESSING, $memo);
        Yii::app()->clientScript->registerScript('remove', 'window.top.agreeOrder(' . $id . ',false);');
        $this->loadhallpage($id);
    }

    /**
     * 拒绝外卖订单
     * @param type $id
     */
    public function actionreject($id)
    {
        $memo = $_POST['memo'];
        //添加备注
        $dealer_id = $this->getDealerId();
        OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_DENIED, $memo);
        Yii::app()->clientScript->registerScript('remove', 'window.top.agreeOrder(' . $id . ',true);');
        $this->loadpage($id);
    }

    /**
     * 拒绝桌台订单
     * @param type $id
     */
    public function actionrejectTable($id)
    {
        $memo = $_POST['memo'];
        //添加备注
        $dealer_id = $this->getDealerId();
        OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_DENIED, $memo);
        $table_reser = TableReservation::model()->find(array('condition' => 'order_id=' . $id));
        $table_reser->reserv_status = TABLE_RESERVATION_STATUS_CANCEL;
        $table_reser->save();
        Yii::app()->clientScript->registerScript('remove', 'window.top.agreeOrder(' . $id . ',true);');
        $this->loadtablepage($id);
    }

    /**
     * 拒绝堂内点餐订单
     * @param type $id
     */
    public function actionrejectHall($id)
    {
        $memo = $_POST['memo'];
        //添加备注
        $dealer_id = $this->getDealerId();
        OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_DENIED, $memo);
        Yii::app()->clientScript->registerScript('remove', 'window.top.agreeOrder(' . $id . ',true);');
        $this->loadhallpage($id);
    }

    /**
     * 显示桌台订单
     * @param type $id
     */
    public function actionProcessed_table_order($id)
    {
        $this->loadtablepage($id);
    }

    /**
     * 加载桌台订单
     * @param type $id
     */
    private function loadtablepage($id)
    {
        $dealer_id = $this->getDealerId();
        $model = Orders::model()->findByPk($id);
        //获取联系人信息
        $contactmodel = Contact::model()->findByPk($model->contact_id);
        //获取桌台预定信息
        $table_resermodel = TableReservation::model()->findByAttributes(array('order_id' => $id));
        //获取桌台信息
        $dinner_tablemodel = DinnerTable::model()->findByPk($table_resermodel->table_id);
        //获取订单菜品快照信息
        $order_dish_flash_list = OrderDishFlash::model()->getDishsByOrdersid($id);
        $busDis = new BusDiscount();
        $result = $busDis->getDiscountforDealeradmin($id);
        $coupon_value = $result->coupon_value;
        $discount_list = $result->discount_list;

        //菜品总金额
//        $bus_order = new busOrder();
//        $dishAmount = $bus_order->countDishAmount($order_dish_flash_list, FALSE);
        //用户备注
//        $user_remark = OrderStatusMessage::model()->getUserRemark($id);

        $this->render('processed_table_order', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
            'table_resermodel' => $table_resermodel,
            'dinner_tablemodel' => $dinner_tablemodel,
//            'dishAmount' => $dishAmount,
                ), false, true);
    }

    /**
     * 显示堂食点餐订单
     * @param type $id 订单id
     */
    public function actionProcessed_hall_order($id)
    {
        $this->loadhallpage($id);
    }

    private function loadhallpage($id)
    {
        $dealer_id = $this->getDealerId();
        $model = Orders::model()->findByPk($id);
        //获取联系人信息
        $contactmodel = Contact::model()->findByPk($model->contact_id);
        //获取桌台信息
        $dinner_tablemodel = DinnerTable::model()->findByPk($model->table_id);
        //获取订单菜品快照信息
        $order_dish_flash_list = OrderDishFlash::model()->getDishsByOrdersid($id);
        $busDis = new BusDiscount();
        $result = $busDis->getDiscountforDealeradmin($id);
        $coupon_value = $result->coupon_value;
        $discount_list = $result->discount_list;
        //菜品总金额
//        $bus_order = new busOrder();
//        $dishAmount = $bus_order->countDishAmount($order_dish_flash_list, FALSE);

        $this->render('processed_hall_order', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
//            'table_resermodel' => $table_resermodel,
            'dinner_tablemodel' => $dinner_tablemodel
//                , 'dishAmount' => $dishAmount
                ), false, true);
    }

}
