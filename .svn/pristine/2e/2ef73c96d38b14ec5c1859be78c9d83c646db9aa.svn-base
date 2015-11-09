<?php

class NewsController extends Controller_DealerAdmin
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
//            'postOnly + delete', // we only allow deletion via POST request
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
        $dealer_id = $this->getDealerId();
        $model = new News();
        $model->news_category = NEWS_CATEGORY_DESCRIPTION;
        //验证当前商家下只能有一个简介
        $news_count = News::model()->getCountNews($dealer_id, NEWS_CATEGORY_DESCRIPTION);
        $msg = '';
        if ($news_count > 0)
        {
            $model->news_category = NEWS_CATEGORY_FAVORABLE;
            Yii::app()->clientScript->registerScript('news_category', '$("#News_news_category>input").attr("disabled","disabled");');
            $msg = '&nbsp;<span style="color:green">只允许有一个简介资讯</span>';
        } else
        {
            Yii::app()->clientScript->registerScript('news_category', '$("#News_news_category>input").click(function(){$("#hd_news_category").val(this.value);});');
        }

        if (isset($_POST['News']))
        {
            $model->attributes = $_POST['News'];
            $model->news_category = $_POST['hd_news_category'];
            $model->dealer_id = $dealer_id;
            $model->create_time = date('Y-m-d H:i:s', time());
            if ($model->news_title == '')
            {
                Yii::app()->clientScript->registerScript('msg', 'alert("请输入标题");');
            } else
            {
                if ($model->save())
                {
                    //echo CLOSEDIALOGANDREFRESH;
                    $this->actionIndex();
                }
            }
        }


        $this->renderPartial('create', array(
            'model' => $model, 'msg' => $msg
                ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $dealer_id = $this->getDealerId();
        $model = $this->loadModel($id);
//验证当前商家下只能有一个简介
        $news_count = News::model()->getCountNews($dealer_id, NEWS_CATEGORY_DESCRIPTION);
        $msg = '';
        if ($news_count > 0)
        {
            Yii::app()->clientScript->registerScript('news_category', '$("#News_news_category>input").attr("disabled","disabled");');
            $msg = '&nbsp;<span style="color:green">只允许有一个简介资讯</span>';
        } else
        {
            Yii::app()->clientScript->registerScript('news_category', '$("#News_news_category>input").click(function(){$("#hd_news_category").val(this.value);});');
        }
        if (isset($_POST['News']))
        {
            $model->attributes = $_POST['News'];
            $model->news_category = $_POST['hd_news_category'];
            if ($model->news_title == '')
            {
                Yii::app()->clientScript->registerScript('msg', 'alert("请输入标题");');
            } else
            {
                if ($model->save())
                {
                    //echo CLOSEDIALOGANDREFRESH;
                    $this->actionIndex();
                }
            }
        }

        $this->renderPartial('update', array(
            'model' => $model, 'msg' => $msg
                ), false, true);
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
        $dealer_id = $this->getDealerId();
        $dataProvider = new CActiveDataProvider('News', array(
            'criteria' => array(
                'condition' => 'dealer_id=' . $dealer_id,
            )
        ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new News('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['News']))
            $model->attributes = $_GET['News'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = News::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param News $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
