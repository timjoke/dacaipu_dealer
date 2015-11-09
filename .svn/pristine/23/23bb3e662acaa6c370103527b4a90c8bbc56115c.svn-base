<?php

class ReportController extends Controller_DealerAdmin
{

    public $layout = '/layouts/report_menu_left';

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
                'actions' => array('orderReport', 'frequencyReport', 'frequencySingleDishReport',
                    'myBill', 'myBillMonth', 'myBillDay', 'dealer_bill', 'myhistoryBill'),
                #'users'=>array('*'),
                'roles' => array(CUSTOMER_ROLENAME_DEALERUSER),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * 订单统计
     */
    public function actionOrderReport()
    {
        $dealer_id = $this->getDealerId();
        $beginDate = date('Y-m-d');
        $endDate = date('Y-m-d');

        if (isset($_POST['beginDate'], $_POST['endDate']))
        {
            $beginDate = $_POST['beginDate'];
            $endDate = $_POST['endDate'];
        } elseif (isset($_GET['sort']))
        {
            switch ($_GET['sort'])
            {
                case 'today':
                    $beginDate = date('Y-m-d');
                    $endDate = date('Y-m-d');
                    break;
                case 'yesterday':
                    $beginDate = date('Y-m-d', strtotime('-1 day'));
                    $endDate = date('Y-m-d', strtotime('-1 day'));

                    break;
                case 'week':
                    $beginDate = date('Y-m-d', strtotime('-7 day'));
                    $endDate = date('Y-m-d');

                    break;
                case 'month':
                    $beginDate = date('Y-m-d', strtotime('-30 day'));
                    $endDate = date('Y-m-d');

                    break;
                default:
                    break;
            }
        }

        $beginDate_value = $beginDate . ' 00:00:00';
        $endDate_value = $endDate . ' 23:59:59';
        //外卖下单数
        $create_order_takeout_count = Orders::model()->createOrderTakeoutCount($dealer_id, $beginDate_value, $endDate_value);
        //外卖接单数
        $effective_order_takeout_count = Orders::model()->effectiveOrderTakeoutCount($dealer_id, $beginDate_value, $endDate_value);
        //外卖成交金额
        $turnove_takeout_sum = Orders::model()->turnoveTakeoutSum($dealer_id, $beginDate_value, $endDate_value);
        //x轴时间数据
        $x_report_takeout = busUlitity::X_reportjsArray($beginDate_value, $endDate_value);

        //订台下单数
        $create_order_table_count = Orders::model()->createOrderTableCount($dealer_id, $beginDate_value, $endDate_value);
        //订台接单数
        $effective_order_table_count = Orders::model()->effectiveOrderTableCount($dealer_id, $beginDate_value, $endDate_value);
        //订台成交金额
        $turnove_table_sum = Orders::model()->turnoveTableSum($dealer_id, $beginDate_value, $endDate_value);

        //堂食点菜下单数
        $create_order_hall_count = Orders::model()->createOrderHallCount($dealer_id, $beginDate_value, $endDate_value);
        //堂食接单数
        $effective_order_hall_count = Orders::model()->effectiveOrderHallCount($dealer_id, $beginDate_value, $endDate_value);
        //堂食成交金额
        $turnove_hall_sum = Orders::model()->turnoveHallSum($dealer_id, $beginDate_value, $endDate_value);

        $this->render('orderReport', array('create_order_takeout_count' => $create_order_takeout_count,
            'effective_order_takeout_count' => $effective_order_takeout_count, 'turnove_takeout_sum' => $turnove_takeout_sum,
            'x_report_takeout' => $x_report_takeout,
            'create_order_table_count' => $create_order_table_count,
            'effective_order_table_count' => $effective_order_table_count, 'turnove_table_sum' => $turnove_table_sum,
            'create_order_hall_count' => $create_order_hall_count,
            'effective_order_hall_count' => $effective_order_hall_count, 'turnove_hall_sum' => $turnove_hall_sum,
            'beginDate' => $beginDate, 'endDate' => $endDate));
    }

    /**
     * 菜品热度
     */
    public function actionFrequencyReport()
    {
        $dealer_id = $this->getDealerId();
        $beginDate = date('Y-m-d');
        $endDate = date('Y-m-d');

        if (isset($_POST['beginDate'], $_POST['endDate']))
        {
            $beginDate = $_POST['beginDate'];
            $endDate = $_POST['endDate'];
        } elseif (isset($_GET['sort']))
        {
            switch ($_GET['sort'])
            {
                case 'today':
                    $beginDate = date('Y-m-d');
                    $endDate = date('Y-m-d');
                    break;
                case 'yesterday':
                    $beginDate = date('Y-m-d', strtotime('-1 day'));
                    $endDate = date('Y-m-d', strtotime('-1 day'));

                    break;
                case 'week':
                    $beginDate = date('Y-m-d', strtotime('-7 day'));
                    $endDate = date('Y-m-d');

                    break;
                case 'month':
                    $beginDate = date('Y-m-d', strtotime('-30 day'));
                    $endDate = date('Y-m-d');

                    break;
                default:
                    break;
            }
        }
        $beginDate_value = $beginDate . ' 00:00:00';
        $endDate_value = $endDate . ' 23:59:59';

        $dataProvider = Orders::model()->frequencyByDealer($dealer_id, $beginDate_value, $endDate_value);
        $this->render('frequencyReport', array('beginDate' => $beginDate, 'endDate' => $endDate, 'dataProvider' => $dataProvider,));
    }

    public function actionFrequencySingleDishReport()
    {
        $dealer_id = $this->getDealerId();
        $beginDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        $dish_name = '';
        if (isset($_GET['dishName']))
        {
            $dish_name = $_GET['dishName'];
            if (isset($_POST['beginDate'], $_POST['endDate']))
            {
                $beginDate = $_POST['beginDate'];
                $endDate = $_POST['endDate'];
            } elseif (isset($_GET['sort']))
            {
                switch ($_GET['sort'])
                {
                    case 'today':
                        $beginDate = date('Y-m-d');
                        $endDate = date('Y-m-d');
                        break;
                    case 'yesterday':
                        $beginDate = date('Y-m-d', strtotime('-1 day'));
                        $endDate = date('Y-m-d', strtotime('-1 day'));

                        break;
                    case 'week':
                        $beginDate = date('Y-m-d', strtotime('-7 day'));
                        $endDate = date('Y-m-d');

                        break;
                    case 'month':
                        $beginDate = date('Y-m-d', strtotime('-30 day'));
                        $endDate = date('Y-m-d');

                        break;
                    default:
                        break;
                }
            }
        } else
        {
            throw new CHttpException(404, '未找到参数dishname');
            return;
        }

        $beginDate_value = $beginDate . ' 00:00:00';
        $endDate_value = $endDate . ' 23:59:59';
        $x_report = busUlitity::X_reportjsArray($beginDate_value, $endDate_value);
        $data = Orders::model()->frequencyBySingleDish($dealer_id, $dish_name, $beginDate_value, $endDate_value);
        $this->render('frequencySingleDishReport', array('data' => $data, 'x_report' => $x_report, 'beginDate' => $beginDate,
            'endDate' => $endDate, 'dish_name' => $dish_name));
    }

    public function actionmyBill()
    {
        $dealer_id = $this->getDealerId();
        $data = DealerBill::model()->getDealerBillByDealerId($dealer_id, DEALERBILL_ISPAY_NO);
        $this->render('myBill', array('dataProvider' => $data));
    }

    public function actionmyhistoryBill()
    {
        $dealer_id = $this->getDealerId();
        $data = DealerBill::model()->getDealerBillByDealerId($dealer_id, DEALERBILL_ISPAY_YES);
        $this->render('myHistoryBill', array('dataProvider' => $data));
    }

    public function actionmyBillMonth($dealer_bill_id)
    {
        $dealer_id = $this->getDealerId();
        $dealerbill = DealerBill::model()->findByPk($dealer_bill_id);
        $data = DealerBillOrders::model()->getMonthDealerBill($dealer_id, $dealerbill->begin_date . ' 0:00:00', $dealerbill->end_date . ' 23:59:59');

        $year_month = busUlitity::getDatestr($dealerbill->begin_date,0,10) . '->' . busUlitity::getDatestr($dealerbill->end_date,0,10);
//        $date_fristDayOfMonth = $year_month . '-01';
//        $time_thismonth = strtotime($date_fristDayOfMonth);
//        $time_nextmonth = strtotime('+1 months', $time_thismonth);
//        $time_thismonth_str = date('Y-m-d', $time_thismonth);
//        $time_nextmonth_str = date('Y-m-d', $time_nextmonth);
//        $data = Orders::model()->myBillMonth($dealer_id, $time_thismonth_str, $time_nextmonth_str, 0.06, 2);
        $this->render('myBillMonth', array('dataProvider' => $data, 'year_month' => $year_month));
    }

    public function actionmyBillDay($year_month_day)
    {
        $dealer_id = $this->getDealerId();
        $time_today = strtotime($year_month_day);
        $time_nextday = strtotime('+1 day', $time_today);
        $time_today_str = date('Y-m-d', $time_today);
        $time_nextday_str = date('Y-m-d', $time_nextday);
        $data_takeout = DealerBillOrders::model()->myBillDayTakeout($dealer_id, $time_today_str, $time_nextday_str);
        $data_table = DealerBillOrders::model()->myBillDayTable($dealer_id, $time_today_str, $time_nextday_str);

        $this->render('myBillDay', array('data_takeout' => $data_takeout, 'data_table' => $data_table,
            'year_month_day' => $year_month_day));
    }

    public function actiondealer_bill($id)
    {
        $message = '';
        $dealer_id = $this->getDealerId();
        $model = DealerBill::model()->findByPk($id);
        if (isset($_POST['dealer_bill_id']))
        {
            $model->is_pay = 1;
            $model->save();
            echo CLOSEDIALOGANDREFRESH;
        }

        $this->renderPartial('dealer_bill', array('message' => $message, 'model' => $model)
                , false, true);
    }

}
