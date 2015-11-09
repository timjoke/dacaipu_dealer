<?php

class DealerWechatReplyController extends Controller_DealerAdmin
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
                'actions' => array('index', 'create', 'update', 'delete'),
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
        $model = new DealerWechatReply;
        $model_content = new DealerWechatReplyContent();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DealerWechatReply'], $_POST['DealerWechatReplyContent']))
        {
            try
            {
                $trans = Yii::app()->db->beginTransaction();

                $model->attributes = $_POST['DealerWechatReply'];
                $model_content->attributes = $_POST['DealerWechatReplyContent'];
                $model->dealer_id = $this->getDealerId();
                $model_content->dealer_id = $model->dealer_id;
                if ($model_content->save())
                {
                    $model->content_id = $model_content->primaryKey;
                    $model->save();
                }
                $trans->commit();
                echo CLOSEDIALOGANDREFRESH;
            } catch (Exception $e)
            {
                $trans->rollback();
                Yii::log($e->getMessage(), 'error');
            }
        }

        $this->renderPartial('create', array(
            'model' => $model,
            'model_content' => $model_content,
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
        $model_content = DealerWechatReplyContent::model()->findByPk($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DealerWechatReply'], $_POST['DealerWechatReplyContent']))
        {
            try
            {
                $trans = Yii::app()->db->beginTransaction();

                $model->attributes = $_POST['DealerWechatReply'];
                $model_content->attributes = $_POST['DealerWechatReplyContent'];
                $model->dealer_id = $this->getDealerId();
                $model_content->dealer_id = $model->dealer_id;
                if ($model_content->save())
                {
                    $model->content_id = $model_content->primaryKey;
                    $model->save();
                }
                $trans->commit();
                echo CLOSEDIALOGANDREFRESH;
            } catch (Exception $e)
            {
                $trans->rollback();
                Yii::log($e->getMessage(), 'error');
            }
        }

        $this->renderPartial('update', array(
            'model' => $model,
            'model_content' => $model_content,
        ),false,true);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        try
        {
            $trans = Yii::app()->db->beginTransaction();
            $this->loadModel($id)->delete();
            DealerWechatReplyContent::model()->deleteByPk($id);
            $trans->commit();
            echo '';
        } catch (Exception $e)
        {
            $trans->rollback();
            Yii::log($e->getMessage(), 'error');
            echo '删除失败!';
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dealer_id = $this->getDealerId();
        $dataProvider = new CActiveDataProvider('DealerWechatReply', array(
            'criteria' => array(
                'condition' => 'dealer_id=' . $dealer_id,
            )
        ));
        $dataProvider = DealerWechatReply::model()->getDealerWechatReply($dealer_id);
        $dataProvider = new CArrayDataProvider($dataProvider);
        $dataProvider->keyField = 'reply_id';
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new DealerWechatReply('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DealerWechatReply']))
            $model->attributes = $_GET['DealerWechatReply'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DealerWechatReply the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = DealerWechatReply::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DealerWechatReply $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dealer-wechat-reply-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
