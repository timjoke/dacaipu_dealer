<?php

class TableOrderTimePointController extends Controller_DealerAdmin {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/dealer_menu_left';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'create', 'update', 'view', 'delete'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new TableOrderTimePoint;
        $dinner_type = DEALER_DINNER_TYPE_LUNCH;

        if (isset($_POST['TableOrderTimePoint'])) {
            $model->attributes = $_POST['TableOrderTimePoint'];
            $dinner_type = $_POST['dinner_type'];

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $dealer_dinner_id = $this->createTimePointByCheckDinner($dinner_type);
                $model->dealer_dinner_id = $dealer_dinner_id;
                $model->save();
                $transaction->commit();
                Yii::app()->cache->flush();
                Yii::log('添加餐市时间点成功dealerid：' . $this->getDealerId() . ' time_point:' . $model->time_point);
                echo CLOSEDIALOGANDREFRESH;
                return;
            } catch (Exception $ex) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
                $transaction->rollback();
            }
        }

        $this->renderPartial('create', array(
            'model' => $model, 'dinner_type' => $dinner_type,
                ), FALSE, TRUE);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['TableOrderTimePoint'])) {
            //检查 商家餐市是否有对应的类型信息
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $dealer_dinner_id_old = $model->dealer_dinner_id;
                $dealer_dinner_model = DealerDinner::model()->findByPk($dealer_dinner_id_old);
                $dinner_type = $_POST['dinner_type'];
                $dealer_dinner_id = 0;
                if ($dealer_dinner_model->dinner_type != $dinner_type) {
                    $dealer_dinner_id = $this->createTimePointByCheckDinner($dinner_type);
                    $this->deleteTimePointByCheckDinner($dealer_dinner_id_old);
                    $model->dealer_dinner_id = $dealer_dinner_id;
                }
                
                $model->attributes = $_POST['TableOrderTimePoint'];
                $model->save(); //保存 桌台订餐时间点
                $transaction->commit();
                Yii::app()->cache->flush();
                echo CLOSEDIALOGANDREFRESH;
                return;
            } catch (Exception $ex) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
                $transaction->rollback();
            }
        }
        $dinner_type = TableOrderTimePoint::model()->getdinner_type($id);
        $this->renderPartial('update', array(
            'model' => $model, 'dinner_type' => $dinner_type,
                ), FALSE, TRUE);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $dealer_dinner_id = $model->dealer_dinner_id;

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model->delete();
            $this->deleteTimePointByCheckDinner($dealer_dinner_id);
            $transaction->commit();
            Yii::app()->cache->flush();
        } catch (Exception $ex) {
            $transaction->rollback();
        }

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * 删除时间点后检查餐市状态，如果餐市下没有隶属的时间点，就将餐市禁用
     * @param type $dealer_dinner_id 餐市id
     */
    private function deleteTimePointByCheckDinner($dealer_dinner_id) {
        $timePointCount = TableOrderTimePoint::model()->count('dealer_dinner_id=:dealer_dinner_id', array(':dealer_dinner_id' => $dealer_dinner_id));
        if ($timePointCount == 0) {
            $model_dealer_dinner = DealerDinner::model()->findByPk($dealer_dinner_id);
            $model_dealer_dinner->status = DEALER_DINNER_OFF;
            $model_dealer_dinner->update();
        }
    }

    /**
     * 添加时间点前检查餐市状态，如果没有餐市类型就添加一个，如果餐市被禁用就启用
     * @param type $dinner_type 餐市类型
     * @return type 餐市id
     */
    private function createTimePointByCheckDinner($dinner_type) {
        Yii::log('添加时间点前检查餐市状态 dealerid:' . $this->getDealerId() . ' dinner_type:' . $dinner_type, CLogger::LEVEL_INFO);
        $model_dealerdinner = DealerDinner::model()->findByAttributes(array('dealer_id' => $this->getDealerId(), 'dinner_type' => $dinner_type));

        if (isset($model_dealerdinner) == FALSE) {//没有数据，添加一个
            Yii::log('没有数据，添加一个');
            $model_dealerdinner = new DealerDinner;
            $model_dealerdinner->dealer_id = $this->getDealerId();
            $model_dealerdinner->dinner_type = $dinner_type;
            $model_dealerdinner->status = DEALER_DINNER_ON;
            $model_dealerdinner->save();
        } elseif ($model_dealerdinner->status == DEALER_DINNER_OFF) {//如果已经存在但是被禁用，那么启用
            Yii::log('已经存在但是被禁用，那么启用');
            $model_dealerdinner->status = DEALER_DINNER_ON;
            $model_dealerdinner->save();
        }
        Yii::log('获取到的餐市id：' . $model_dealerdinner->dealer_dinner_id);
        return $model_dealerdinner->dealer_dinner_id;
    }

    /**
     * Lists all models.
     */ public function actionIndex() {
        $dealer_id = $this->getDealerId();
        $dataProvider = TableOrderTimePoint::model()->getDinnerTimePoint($dealer_id);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TableOrderTimePoint('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TableOrderTimePoint']))
            $model->attributes = $_GET['TableOrderTimePoint'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TableOrderTimePoint the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = TableOrderTimePoint::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model->time_point = substr($model->time_point, 0, 5);
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TableOrderTimePoint $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'table-order-time-point-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
