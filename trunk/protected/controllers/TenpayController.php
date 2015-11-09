<?php

class TenpayController extends Controller_DealerAdmin
{

    public $layout = '/layouts/report_menu_left';

    public function actionIndex()
    {

        $bank_type_value = Yii::app()->request->getPost("bank_type_value", -1);
        if ($bank_type_value != -1)
        {
            $btp = new busTenpay();
            $req = $btp->get_request_handler();
            $req->setParameter('bank_type', $bank_type_value);

            $this->redirect($req->getRequestURL());
        }
        else
        {
            $id = Yii::app()->request->getParam('id', -1);
            if ($id == -1)
            {
                $this->redirect('../report/myBill');
                return;
            }

            $dealerBill = DealerBill::model()->findByPk($id);
            if ((!isset($dealerBill)) ||
                    $dealerBill->is_pay == 1 ||
                    $dealerBill->dealer_id != $this->getDealerId())
            {
                $this->redirect('../report/myBill');
                return;
            }
            $dealerBill->fee = busUlitity::formatMoney($dealerBill->fee);
            $this->render('index', array('dealerBill' => $dealerBill));
        }
    }

    public function actionNotifyUrl()
    {
        $btp = new busTenpay();
        $btp->dealer_bill_notice();
    }

    public function actionReturnUrl()
    {
        $btp = new busTenpay();
        $result = $btp->dealer_bill_return();
        $this->render('returnUrl', array('result' => $result));
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('notifyurl', 'captcha'),
                'users' => array('*'),
            ),
        );
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
