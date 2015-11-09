<?php

class DinnerTableController extends Controller_DealerAdmin {

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
//            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
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
        $model = new DinnerTable;
        $model->table_status = 1;
        $model->table_is_room = 0;
        $model->table_is_smoke = 0;

        if (isset($_POST['DinnerTable'], $_POST['hallTableNum'])) {
            $model->attributes = $_POST['DinnerTable'];
            $model->table_service_price = 0;
            $model->table_lower_case = 0;
            $model->dealer_id = $this->getDealerId();

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->save();
                $this->createTableParterRelat($model->table_id, $_POST['hallTableNum']);
                $transaction->commit();
                Yii::app()->cache->flush();
                echo CLOSEDIALOGANDREFRESH;
            } catch (Exception $ex) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
                $transaction->rollback();
            }
        }

        $this->renderPartial('create', array(
            'model' => $model, 'hallTableNum' => ''
                ), false, true);
    }

    /**
     * 创建
     * @param type $entity_id
     * @param type $hallTableNum
     */
    private function createTableParterRelat($entity_id, $hallTableNum) {
        $per = new PartnerEntityRelat();
        $per->entity_type = 3; //todo:此处需要朱坤配合找到枚举
        $per->dealer_id = $this->getDealerId();
        $per->partner_id = 3;
        $per->partner_entity_id = $hallTableNum;
        $per->entity_id = $entity_id;
        $per->save();
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $hallTableNum = '';
        $per = PartnerEntityRelat::model()->findByAttributes(
                array('entity_type' => 3, 'dealer_id' => $this->getDealerId(),
                    'partner_id' => 3, 'entity_id' => $model->table_id));
        if (isset($per)) {
            $hallTableNum = $per->partner_entity_id;
        }
        if (isset($_POST['DinnerTable'], $_POST['hallTableNum'])) {
            $model->attributes = $_POST['DinnerTable'];

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->save();
                //检查管理是否存在
                if (isset($per)) {
                    $per->partner_entity_id = $_POST['hallTableNum'];
                    $per->save();
                } else {
                    $this->createTableParterRelat($model->table_id, $_POST['hallTableNum']);
                }

                $transaction->commit();
                Yii::app()->cache->flush();
                echo CLOSEDIALOGANDREFRESH;
            } catch (Exception $ex) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
                $transaction->rollback();
            }
        }
        $this->renderPartial('update', array(
            'model' => $model, 'hallTableNum' => $hallTableNum
                ), false, true);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);

        if ($model->table_status == '-1') {//当前类别已经禁用，不需要操作
            echo '';
        } else {
            $updatecount = $model->updateByPk($id, array('table_status' => -1));
            if ($updatecount == 0) {
                echo '删除失败';
            } else {
                echo '';
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('DinnerTable', array(
            'criteria' => array(
                'condition' => 'dealer_id=' . $this->getDealerId(),
                'order' => 'table_status desc',
            )
        ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new DinnerTable('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DinnerTable']))
            $model->attributes = $_GET['DinnerTable'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DinnerTable the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DinnerTable::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DinnerTable $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dinner-table-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
