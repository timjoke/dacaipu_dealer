<?php

class DiscountCodeController extends Controller_DealerAdmin {

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
                'actions' => array('index', 'used'),
                #'users'=>array('*'),
                'roles' => array(CUSTOMER_ROLENAME_DEALERUSER),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionUsed($id) {
        $model = $this->loadModel($id);
        $model->status = 1;
        $model->used_time = date('Y-m-d H:i:s', time());
        if ($model->save() == true) {
            echo '';
        } else {
            echo '设置打折码状态使用失败';
        }
    }

     public function loadModel($id) {
        $model = DiscountCode::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    /**
     * Lists all models.
     */
    public function actionIndex() {
        $search = new DiscountCodeSearch;
        $search->discountCodeStatus = 0;
        $search->dealer_id =$this->getDealerId();
        if (isset($_POST['DiscountCodeSearch'])) {
            $search->attributes = $_POST['DiscountCodeSearch'];
        }
        $dataProvider = DiscountCode::model()->search($search);

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'search' => $search
        ));
    }

}
