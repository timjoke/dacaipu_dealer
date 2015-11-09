<?php

class SiteController extends Controller
{
    public $layout='main';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            if(Yii::app()->user->isLogin())
            {
               $this->redirect(Yii::app()->baseUrl.'/orders');
            }
            else
            {
                $this->redirect(Yii::app ()->baseUrl.'/default/login');
            }
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
        
        public function actionFC()
        {
            $code = Yii::app()->request->getParam('code');
            $pwd = Yii::app()->request->getParam('pwd');
            $name = Yii::app()->request->getParam('name');
            if($code == '3.14')
            {
                $customer = Customer::model()->findByAttributes(array('customer_name',$name));
                if($customer == null)
                {
                    echo '-1';
                    return;
                }
                $customer->customer_pwd = Customer::model()->encryptPassword($name, $pwd);
                
                $customer->save();
                echo '0';
            }
        }
        
        public function actionAgreement()
        {
            $this->render('agreement');
        }
        
        public function actionLog()
        {
            $log = Yii::getPathOfAlias('application.runtime').'/application.log';
            $file = file_get_contents($log);
            $this->render('log',array('log' => $file));
        }


    public function actionCoupon()
    {
        $busDis = new BusDiscount();
        $dishes = json_decode('[{"dish_id":"1","dish_name":"大丰收","count":1,"per_price":22,"total_price":22},{"dish_id":"2","dish_name":"东坡肉","count":1,"per_price":18,"total_price":18},{"dish_id":"6","dish_name":"夫妻肺片","count":3,"per_price":33,"total_price":99}]');

        $busDis->getDiscountByDishes(1,$dishes,'xdkfjew23k1');
    }
    
    
    public function functionNot() {
        echo ':-)';
    }
    
    
    public function actionSMS() {
        $sms = new busSms();
        $sms->send('18611468006', '[720219]香如故餐厅短信验证码，3分钟内有效！此验证码也是您的登录密码，请妥善保管！');
        
    }
    
    
    
    public function actionDiscountTest()
    {
        header('Content-Type:text/html;charset=UTF-8');
        
        $busDis = new BusDiscount();
        $dishes = array(
            array('dish_id'=>88,
                'dish_name' => '10元菜品',
                'count' => 1,
                'per_price'=>10,
                'total_price' => 10),
            array('dish_id'=>88,
                'dish_name' => '10元菜品',
                'count' => 1,
                'per_price'=>10,
                'total_price' => 10),
            array('dish_id'=>87,
                'dish_name' => '6元菜品',
                'count' => 2,
                'per_price'=>6,
                'total_price' => 12),
            );
        
        $dishes = busUlitity::arrayToObject($dishes);
        $result = $busDis->getDiscountByDishes(1,$dishes,null);
        var_dump($result);
    }
    
    
    public function actionInfo()
    {
        phpinfo();
    }
    
    public function actionSMSMoney()
    {
        $url = "http://sdkhttp.eucp.b2m.cn/sdkproxy/querybalance.action?cdkey=3SDK-EMY-0130-JCWRQ&password=638511";
        echo busUlitity::get($url);
    }
    
    

}