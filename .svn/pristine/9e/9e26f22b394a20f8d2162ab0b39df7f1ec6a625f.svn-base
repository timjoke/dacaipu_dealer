<?php

class CouponController extends Controller_DealerAdmin
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/dealer_menu_left';

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
                'actions' => array('index', 'create', 'update', 'delete','outputExcel'),
                #'users'=>array('*'),
                'roles' => array(CUSTOMER_ROLENAME_DEALERUSER),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Coupon;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Coupon']))
        {
            $model->attributes = $_POST['Coupon'];
            $coupon_count = intval($_POST['Coupon']['coupon_count']);
            $bus_king_hand = new busKingHand();
            $coupon_nos = $bus_king_hand->generate_promotion_code($coupon_count);

            try
            {
                $trans = Yii::app()->db->beginTransaction();

                foreach ($coupon_nos as $value)
                {
                    $coupon = new Coupon();
                    $coupon->dealer_id = $this->getDealerId();
                    $coupon->coupon_no = $value;
                    $coupon->coupon_value = $model->coupon_value;
                    $coupon->coupon_start_time = $model->coupon_start_time;
                    $coupon->coupon_end_time = $model->coupon_end_time;
                    $coupon->coupon_status = COUPON_STATUS_ACTIVE;
                    $coupon->coupon_create_time = date('Y-m-d H:i:s');
                    $coupon->save();
                }
                $trans->commit();
                echo CLOSEDIALOGANDREFRESH;
            } catch (Exception $e)
            {
                $trans->rollback();
                Yii::log($e->getMessage(), 'error');
            }
        }

        //generate_promotion_code
        //makeDiscountCode 纯数字的
        $this->renderPartial('create', array(
            'model' => $model,
                ), false, true);
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

        if (isset($_POST['Coupon']))
        {
            $model->attributes = $_POST['Coupon'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->coupon_id));
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
     * Lists all models.
     */
    public function actionIndex()
    {
        $search = new CouponSearch();
        $search->coupon_status=3;
        $search->end_time = date('Y-m-d 23:59:59');
        if (isset($_POST['CouponSearch']))
        {
            $search->attributes = $_POST['CouponSearch'];
        }
        $search->dealer_id = $this->getDealerId();
        $dataProvider = Coupon::model()->search($search);

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'search' => $search
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Coupon('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Coupon']))
            $model->attributes = $_GET['Coupon'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Coupon the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Coupon::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Coupon $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'coupon-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

        /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionOutputExcel()
    {
        $all_coupons = Coupon::model()->getAllCoupons($this->getDealerId());
        Yii::app()->yexcel->writeActiveSheet_coupon($all_coupons);
    }
}
