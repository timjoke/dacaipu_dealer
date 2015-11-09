<?php

class OrdersHistoryController extends Controller_DealerAdmin
{

    public $layout = '/layouts/order_menu_left';

    /**
     * @return array action filters
     */
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
                'actions' => array('index', 'LoadHistoryOrders', 'view', 'viewTable', 'viewHall'),
                'roles' => array(CUSTOMER_ROLENAME_DEALERUSER),
            ),
        );
    }

    public function actionIndex()
    {
        $search = new OrdersHistorySearch();
        $search->end_time = date('Y-m-d 23:59');
        $search->has_coupon = '3';

        if (isset($_POST['OrdersHistorySearch']))
        {
            $search->attributes = $_POST['OrdersHistorySearch'];
        }

        $dealer_id = $this->getDealerId();
        //echo $search->has_coupon;
        $dataProvider = Orders::model()->getFinishOrders($dealer_id, $search); //列表页面
        for ($i = 0; $i < count($dataProvider); $i++)
        {
            $dataProvider[$i]['order_statusname'] = busOrder::$ORDER_STATUS_NAME[$dataProvider[$i]['order_status']];
        }
        $dataProvider = new CArrayDataProvider($dataProvider);
        $dataProvider->keyField = 'order_id';
        $this->render('index', array('search' => $search,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionLoadHistoryOrders()
    {
        $dataProvider = Orders::model()->getFinishOrders(); //列表页面
        for ($i = 0; $i < count($dataProvider); $i++)
        {
            $dataProvider[$i]['order_statusname'] = busOrder::$ORDER_STATUS_NAME[$dataProvider[$i]['order_status']];
        }
        echo json_encode($dataProvider);
    }

    public function actionView($id)
    {
        $dealer_id = $this->getDealerId();
        //获取订单信息
        $model = $this->loadModel($id);
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
        //拒绝订单的商家备注
        $rejectMemo = OrderStatusMessage::model()->getRejectMemo($id);
        $this->renderPartial('view', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
            'dealer_express_fee' => $dealer_express_fee,
            'user_remark' => $user_remark, 'rejectMemo' => $rejectMemo
                ), false, true);
    }

    public function actionViewTable($id)
    {
        $dealer_id = $this->getDealerId();
        //获取订单信息
        $model = $this->loadModel($id);
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
        //拒绝订单的商家备注
        $rejectMemo = OrderStatusMessage::model()->getRejectMemo($id);
        $this->renderPartial('viewTable', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
            'dinner_tablemodel' => $dinner_tablemodel,
            'table_resermodel' => $table_resermodel, 'rejectMemo' => $rejectMemo
                ), false, true);
    }

    public function actionviewHall($id)
    {
        $dealer_id = $this->getDealerId();
        //获取订单信息
        $model = $this->loadModel($id);
        //获取联系人信息
        $contactmodel = Contact::model()->findByPk($model->contact_id);
        //获取桌台预定信息
//        $table_resermodel = TableReservation::model()->findByAttributes(array('order_id' => $id));
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
        
        //拒绝订单的商家备注
        $rejectMemo = OrderStatusMessage::model()->getRejectMemo($id);
        $this->renderPartial('viewHall', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
            'dinner_tablemodel' => $dinner_tablemodel, 'rejectMemo' => $rejectMemo
                ), false, true);
    }

    public function loadModel($id)
    {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
