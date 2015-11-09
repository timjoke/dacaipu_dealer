<?php

class OrdersController extends Controller_DealerAdmin
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
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
                'actions' => array('index', 'view', 'create', 'update', 'admin',
                    'delete', 'processed_order', 'UpdateNewOrders', 'LoadOrders',
                    'transformOrderStatus', 'testupload', 'viewTable', 'viewHall'),
                'roles' => array(CUSTOMER_ROLENAME_DEALERUSER),
            ),
            array('allow', // deny all users
                'actions' => array('printOrders','printOrdersDS'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actiontestupload()
    {
        if (isset($_POST['yt0']))
        {
            $temp = $_POST['yt0'];
            $file = CUploadedFile::getInstanceByName('asdf');
            $file->saveAs(Yii::app()->params["img_upload_dir"] . 'upload\\水电费.jpg');
        }
        $this->render('testupload');
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $dealer_id = $this->getDealerId();
        //操作事件
        if (isset($_POST['memo'], $_POST['status'], $_POST['type']))
        {
            $memo = $_POST['memo'];
            $type = $_POST['type'];
            $old_status = $_POST['status'];
            $new_status = $this->getNewStatus($old_status, $type);
            $operCode = OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, $old_status, $new_status, $memo);

            Yii::app()->clientScript->registerScript('loadOrders', 'window.top.loadOrders(); window.top.closeDialog();');
        }

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

        //配送费
        $dealer = Dealer::model()->findByPk($dealer_id);
        $dealer_express_fee = $dealer->dealer_express_fee;
        //用户备注
        $user_remark = OrderStatusMessage::model()->getUserRemark($id);

        $this->renderPartial('view', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
            'dealer_express_fee' => $dealer_express_fee,
            'user_remark' => $user_remark,
                ), false, true);
    }

    public function actionprintOrders($order_id)
    {
        //获取订单信息
        $model = $this->loadModel($order_id);
        //获取联系人信息
        $contactmodel = Contact::model()->findByPk($model->contact_id);
        //获取订单菜品快照信息       
        $order_dish_flash_list = OrderDishFlash::model()->getDishsByOrdersid($order_id);
        //
        $busDis = new BusDiscount();
        $result = $busDis->getDiscountforDealeradmin($order_id);
        $coupon_value = $result->coupon_value;
        $discount_list = $result->discount_list;
        //餐厅名称
        $dealer_id = $model->dealer_id;
        $dealer = Dealer::model()->findByPk($dealer_id);
        $dealer_express_fee = $dealer->dealer_express_fee;
        $dealer_name = $dealer->dealer_name;
        //用户备注
        $user_remark = OrderStatusMessage::model()->getUserRemark($order_id);
        Yii::app()->clientScript->reset();

        $this->renderPartial('printOrders', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list, 'dealer_name' => $dealer_name,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
            'dealer_express_fee' => $dealer_express_fee, 'user_remark' => $user_remark,
                ), false, true);
    }
    
    public function actionprintOrdersDS($order_id)
    {
        //获取订单信息
        $model = $this->loadModel($order_id);
        //获取联系人信息
        $contactmodel = Contact::model()->findByPk($model->contact_id);
        //获取订单菜品快照信息       
        $order_dish_flash_list = OrderDishFlash::model()->getDishsByOrdersid($order_id);
        //
        $busDis = new BusDiscount();
        $result = $busDis->getDiscountforDealeradmin($order_id);
        $coupon_value = $result->coupon_value;
        $discount_list = $result->discount_list;
        //餐厅名称
        $dealer_id = $model->dealer_id;
        $dealer = Dealer::model()->findByPk($dealer_id);
        $dealer_express_fee = $dealer->dealer_express_fee;
        $dealer_name = $dealer->dealer_name;
        //用户备注
        $user_remark = OrderStatusMessage::model()->getUserRemark($order_id);
        Yii::app()->clientScript->reset();

        $this->renderPartial('printOrdersDS', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list, 'dealer_name' => $dealer_name,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
            'dealer_express_fee' => $dealer_express_fee, 'user_remark' => $user_remark,
                ), false, true);
    }

    public function actionViewTable($id)
    {
        $dealer_id = $this->getDealerId();
        //操作事件
        if (isset($_POST['memo'], $_POST['status'], $_POST['type']))
        {
            $memo = $_POST['memo'];
            $type = $_POST['type'];
            $old_status = $_POST['status'];
            $new_status = $this->getNewStatus($old_status, $type);
            $operCode = OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, $old_status, $new_status, $memo);
            Yii::app()->clientScript->registerScript('loadOrders', 'window.top.loadOrders(); window.top.closeDialog();');
        }

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
        $this->renderPartial('viewTable', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'dinner_tablemodel' => $dinner_tablemodel,
            'table_resermodel' => $table_resermodel,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
                ), false, true);
    }

    public function actionViewHall($id)
    {
        $dealer_id = $this->getDealerId();
        //操作事件
        if (isset($_POST['memo'], $_POST['status'], $_POST['type']))
        {
            $memo = $_POST['memo'];
            $type = $_POST['type'];
            $old_status = $_POST['status'];
            $new_status = $this->getNewStatus($old_status, $type);
            $operCode = OrderStatusMessage::model()->transformOrderStatus($dealer_id, $id, $old_status, $new_status, $memo);
            Yii::app()->clientScript->registerScript('loadOrders', 'window.top.loadOrders(); window.top.closeDialog();');
        }
        //获取订单信息
        $model = $this->loadModel($id);
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
        $this->renderPartial('viewHall', array(
            'model' => $model, 'contactmodel' => $contactmodel,
            'order_dish_flash_list' => $order_dish_flash_list,
            'dinner_tablemodel' => $dinner_tablemodel,
            'discount_list' => $discount_list, 'coupon_value' => $coupon_value,
//            'dishAmount' => $dishAmount
                ), false, true);
    }

    /**
     * 今日订单页面中列表的操作按钮的事件
     */
    public function actiontransformOrderStatus()
    {
        $orderid = $_GET["orderid"];
        $statusid = $_GET["statusid"];
        $orders = Orders::model()->findByPk($orderid);
        if ($statusid == $orders->order_status)
        {//页面中的订单状态与数据库中的订单状态一致
            $new_status = $this->getNewStatus($statusid, $orders->order_type);
            $dealer_id = $this->getDealerId();
            $operCode = OrderStatusMessage::model()->transformOrderStatus($dealer_id, $orderid, $statusid, $new_status, '');
        } else
        {//页面中的订单与数据库中的订单状态不一致
            echo '订单已经被处理，请刷新页面';
        }
    }

    /**
     * 获取下一步操作的状态
     * @param int $status 当前状态代码
     * @param int $type 订单类型
      1 外卖送餐；
      2 外卖自取；
     */
    private function getNewStatus($status, $type)
    {
        switch ($status)
        {

            case ORDER_STATUS_PROCESSING://当前状态已完成
                switch ($type)
                {//订单类型
                    case ORDER_TYPE_TAKEOUT://外卖送餐
                        return ORDER_STATUS_EXPRESSING; //派送中
                        break;
                    case ORDER_TYPE_TAKEOUT_SELFTAKE://外卖自取
                        return ORDER_STATUS_WAIT_PAY; //待付款
                        break;
                    case ORDER_TYPE_SUB_TABLE://预订桌台
                        return ORDER_STATUS_COMPLETE; //已完成
                        break;
                    case ORDER_TYPE_SUB_TALE_DISH://预订桌台+订餐
                        return ORDER_STATUS_COMPLETE; //已完成
                        break;
                    case ORDER_TYPE_EATIN://堂食点餐
                        return ORDER_STATUS_COMPLETE;
                        break;
                    default://todo 预留给预定桌台
                        return -1;
                        break;
                }

                break;
            default://其他不需要判断类型的状态
                $new_status = Orders::model()->getNewStatus($status);
                return $new_status;
                break;
        }
        //$new_status = Orders::model()->getNewStatus($old_status);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Orders;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Orders']))
        {
            $model->attributes = $_POST['Orders'];
            $model->order_createtime = date('Y-m-d H:i:s', time());
            $model->order_dinnertime = date('Y-m-d H:i:s', time());

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->order_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Orders']))
        {
            $model->attributes = $_POST['Orders'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->order_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 处理中、派送中、待付款 状态的订单
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * 获取今日订单
     */
    public function actionLoadOrders()
    {
        $tempjson = '';
        $takeoutOrders = $this->getTodayTakeOutPendingOrders();
        $tableOrders = $this->getTodayTablePendingOrders();
        $hallOrders = $this->getTodayHallPendingOrders();
        $tempjson = busUlitity::joinjson($takeoutOrders, $tableOrders);
        $tempjson = busUlitity::joinjson($tempjson, $hallOrders);
        echo $tempjson;
    }

    /**
     * 获取当天外卖订单
     * @return type
     */
    private function getTodayTakeOutPendingOrders()
    {
        $dealer_id = $this->getDealerId();
        $dataProvider = Orders::model()->getPendingOrders($dealer_id); //外卖送餐订单列表页面
        for ($i = 0; $i < count($dataProvider); $i++)
        {
            $dataProvider[$i]['order_paid'] = busUlitity::formatMoney($dataProvider[$i]['order_paid']);
            $dataProvider[$i]['order_statusname'] = busOrder::$ORDER_STATUS_NAME[$dataProvider[$i]['order_status']];
        }
        return json_encode($dataProvider);
    }

    /**
     * 获取当天桌台订单
     * @return type
     */
    private function getTodayTablePendingOrders()
    {
        $dealer_id = $this->getDealerId();
        $dataProvider = Orders::model()->getPendingTableOrders($dealer_id);
        for ($i = 0; $i < count($dataProvider); $i++)
        {
            $dataProvider[$i]['order_paid'] = busUlitity::formatMoney($dataProvider[$i]['order_paid']);
            $dataProvider[$i]['order_statusname'] = busOrder::$ORDER_STATUS_NAME[$dataProvider[$i]['order_status']];
        }
        return json_encode($dataProvider);
    }

    private function getTodayHallPendingOrders()
    {
        $dealer_id = $this->getDealerId();
        $dataProvider = Orders::model()->getPendingHallOrders($dealer_id);
        for ($i = 0; $i < count($dataProvider); $i++)
        {
            $dataProvider[$i]['order_paid'] = busUlitity::formatMoney($dataProvider[$i]['order_paid']);
            $dataProvider[$i]['order_statusname'] = busOrder::$ORDER_STATUS_NAME[$dataProvider[$i]['order_status']];
        }
        return json_encode($dataProvider);
    }

    /**
     * 获取新的订单信息
     * @param type $lastid 上次获取的最后一个订单的id 为了能在不同平台下同步，$lastid字段无效，始终设置为0
     */
    public function actionUpdateNewOrders($lastid)
    {
        $tempjson = '';
        $lastid=0;//为了能在不同平台下同步，$lastid字段无效，始终设置为0
        $takeoutOrders = $this->getTakeoutOrders($lastid);
        $tableOrders = $this->getTableOrders($lastid);
        $hallOrders = $this->getHallOrders($lastid);
        $tempjson = busUlitity::joinjson($takeoutOrders, $tableOrders);
        $tempjson = busUlitity::joinjson($tempjson, $hallOrders);
        echo $tempjson;
    }

    /**
     * 查找外卖订单
     * @param type $lastid
     * @return type
     */
    private function getTakeoutOrders($lastid)
    {
        $dealer_id = $this->getDealerId();
        $ProcessedOrders = Orders::model()->getProcessedTakeoutOrders($dealer_id, $lastid); //右侧列表
        for ($i = 0; $i < count($ProcessedOrders); $i++)
        {
            $ProcessedOrders[$i]['order_paid'] = busUlitity::formatMoney($ProcessedOrders[$i]['order_paid']);
            $ProcessedOrders[$i]['contact_addr'] = busUlitity::hideNumber($ProcessedOrders[$i]['contact_addr']);
        }
        return json_encode($ProcessedOrders);
    }

    /**
     * 查找桌台订单
     * @param type $lastid
     * @return string
     */
    private function getTableOrders($lastid)
    {
        $dealer_id = $this->getDealerId();
        $ProcessedOrders = Orders::model()->getProcessedTableOrders($dealer_id, $lastid);
        for ($i = 0; $i < count($ProcessedOrders); $i++)
        {
            $ProcessedOrders[$i]['order_paid'] = busUlitity::formatMoney($ProcessedOrders[$i]['order_paid']);
        }
        return json_encode($ProcessedOrders);
    }

    /**
     * 查找店内点餐订单
     * @param type $lastid
     */
    private function getHallOrders($lastid)
    {
        $dealer_id = $this->getDealerId();
        $ProcessedOrders = Orders::model()->getProcessedHallOrders($dealer_id, $lastid);
        for ($i = 0; $i < count($ProcessedOrders); $i++)
        {
            $ProcessedOrders[$i]['order_paid'] = busUlitity::formatMoney($ProcessedOrders[$i]['order_paid']);
        }
        return json_encode($ProcessedOrders);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Orders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Orders']))
            $model->attributes = $_GET['Orders'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Orders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Orders $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orders-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
