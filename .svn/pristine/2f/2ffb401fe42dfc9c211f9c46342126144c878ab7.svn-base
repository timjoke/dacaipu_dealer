<?php

class DealerServiceTimeController extends Controller_DealerAdmin {

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
        $model = new DealerServiceTime;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DealerServiceTime'])) {
            $model->attributes = $_POST['DealerServiceTime'];
            $model->dealer_id =$this->getDealerId();
            if ($model->save())
                //$this->redirect(array('view', 'id' => $model->st_id));
                echo CLOSEDIALOGANDREFRESH;
        }

        $this->renderPartial('create', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DealerServiceTime'])) {
            $model->attributes = $_POST['DealerServiceTime'];
            $model->dealer_id =$this->getDealerId();
            if ($model->save())
                echo CLOSEDIALOGANDREFRESH;
            //$this->redirect(array('view', 'id' => $model->st_id));
        }

        $this->renderPartial('update', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('DealerServiceTime', array(
            'criteria' => array(
                'condition' => 'dealer_id=' .$this->getDealerId(),
                'order' => 'st_start_time',
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
        $model = new DealerServiceTime('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DealerServiceTime']))
            $model->attributes = $_GET['DealerServiceTime'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DealerServiceTime the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DealerServiceTime::model()->findByPk($id);


        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $model->st_start_time = substr($model->st_start_time, 0, 5);
        $model->st_end_time = substr($model->st_end_time, 0,5);
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DealerServiceTime $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dealer-service-time-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
//    protected function processAdminCommand()
//{
//if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
//{
//	 echo '########';
//	 exit;
//$this->loadModel($_POST['id'])->delete();
// reload the current page to avoid duplicated delete actions
//$this->refresh();
//}
//}

}
