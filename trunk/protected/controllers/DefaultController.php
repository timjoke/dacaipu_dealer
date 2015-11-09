<?php

class DefaultController extends Controller_DealerAdmin
{

    function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'width' => 62,
                'padding' => 2,
                'offset' => -2,
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x0F0FF0, //字体颜色
                'transparent' => false, //显示为透明,默认中可以看到为false
                'height' => 26,
                'maxLength' => '4', // 最多生成几个字符
                'minLength' => '4',
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'captcha'),
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        if (Yii::app()->user->isLogin())
        {
            $this->redirect('/orders/');
        } else
        {
            $this->loginfun();
        }
    }

    public function actionLogin()
    {
        if (Yii::app()->user->isLogin())
        {
            $this->redirect(Yii::app()->user->returnUrl);
        } else
        {
            $this->loginfun();
        }
    }

    private function loginfun()
    {
        $model = new DealerLoginForm;
        $model->rememberMe = TRUE;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['DealerLoginForm']))
        {
            $model->attributes = $_POST['DealerLoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
            {
                $this->redirect('/orders/');
            }
        }
        // display the login form
        $this->renderPartial('login', array('model' => $model), false, true);
    }

    public function actionLogout()
    {
        Yii::log('用户退出，dealerid:' . $this->getDealerId(), CLogger::LEVEL_INFO);
        Yii::app()->user->logout();
        Yii::app()->session->clear(); //移去所有session变量，然后，调用
        Yii::app()->session->destroy(); //移去存储在服务器端的数据。
        Yii::app()->cache->flush(); //清除缓存
        $this->redirect('login');
    }

}
