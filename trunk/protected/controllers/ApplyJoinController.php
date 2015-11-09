<?php

class ApplyJoinController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
                'actions' => array('index', 'view', 'join', 'joinSuccess'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'create'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
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
        $model = new ApplyJoin;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ApplyJoin']))
        {
            $model->attributes = $_POST['ApplyJoin'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->apply_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionJoin()
    {
        $model = new ApplyJoin;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ApplyJoin']))
        {
            $model->attributes = $_POST['ApplyJoin'];

            if (!file_exists(Yii::getPathOfAlias('webroot') . '/upload'))
            {
                mkdir(Yii::getPathOfAlias('webroot') . '/upload');
            }
            //获取upload目录
            $upload_directory_path = Yii::getPathOfAlias('webroot') . '/upload/' . date('Y-m');
            if (!file_exists($upload_directory_path))
            {
                //如果要上传文件，且每次有次目录的话，创建新目录
                mkdir($upload_directory_path);
            }

            $image = CUploadedFile::getInstance($model, 'id_image_file_url');
            if ($image != null)
            {
                $file_ext = $image->getExtensionName();
                $file_name = 'attachment' . $this->getMSTime() . '.' . $file_ext;
                $file_fullpath = $upload_directory_path . '/' . $file_name;
                $model->id_image_file_url = '/upload/' . date('Y-m') . '/' . $file_name;
                $image->saveAs($file_fullpath);
            }
            if ($model->save())
            {
                $this->redirect(array('joinSuccess'));
            }
        }

        $this->renderPartial('join', array(
            'model' => $model,
        ));
    }

    public function actionJoinSuccess()
    {
        $this->renderPartial('joinSuccess');
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

        if (isset($_POST['ApplyJoin']))
        {
            $model->attributes = $_POST['ApplyJoin'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->apply_id));
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
        $dataProvider = new CActiveDataProvider('ApplyJoin');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new ApplyJoin('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ApplyJoin']))
            $model->attributes = $_GET['ApplyJoin'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ApplyJoin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ApplyJoin::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ApplyJoin $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'apply-join-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function getMSTime()
    {
        list($usec, $sec) = explode(" ", microtime());
        $sec = date('H_i_s', $sec);
        $usec = sprintf('%.0f', (float) $usec * 1000);
        $usec = str_pad($usec, 3, '0', STR_PAD_LEFT);
        return $sec . '_' . $usec;
    }

}
