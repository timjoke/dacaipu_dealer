<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TableByOrdersController
 *
 * @author lts
 */
class TableByOrdersController extends Controller_DealerAdmin
{

    public $layout = '/layouts/order_menu_left';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'viewTableByOrdersIndex', 'createDealerTableOrder', 'updateDealerTableOrder'),
                'roles' => array(CUSTOMER_ROLENAME_DEALERUSER),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $tableByOrdersSearch = new TableByOrdersSearch();
        $dealer_id = $this->getDealerId();
        $tableByOrdersSearch->dealer_id = $dealer_id;
        $tableByOrdersSearch->reserv_date = date('Y-m-d', time());
        if (isset($_POST['TableByOrdersSearch']))
        {
            $tableByOrdersSearch->attributes = $_POST['TableByOrdersSearch'];
        }

        $date = TableReservation::model()->getTableByOrders($tableByOrdersSearch);
        $sit_countlist = DinnerTable::model()->getTableType($dealer_id); //餐桌座位数列表
        //餐市类型列表
        $dinnertypelist = DealerDinner::model()->getDinner_typeByDealerid($dealer_id);
        //餐桌列表
        $dinner_tablelist = DinnerTable::model()->getDinnerTableSimple($tableByOrdersSearch);
        $this->render('index', array(
            'dataProvider' => $date,
            'TableByOrdersSearch' => $tableByOrdersSearch, 'sit_countlist' => $sit_countlist,
            'dinnertypelist' => $dinnertypelist, 'dinner_tablelist' => $dinner_tablelist
        ));
    }

    /**
     * 通过桌台查找订单
     */
    public function actionViewTableByOrdersIndex()
    {
        $table_id = $_GET['table_id']; //桌台id
        $reserv_date = $_GET['reserv_date']; //订餐日期
        $table_name = $_GET['tablename'];
        $reserv_date = $_GET['reserv_date'];

        $date = TableReservation::model()->getTableByOrdersIndex($table_id, $reserv_date);
        $this->renderPartial('viewTableByOrdersIndex', array(
            'dataProvider' => $date, 'tablename' => $table_name, 'reserv_date' => $reserv_date,
            'table_id' => $table_id), false, true);
    }

    public function actioncreateDealerTableOrder()
    {
        if (isset($_GET['dinnertype'], $_GET['tableid'], $_GET['reserv_date']))
        {
            $dinnertype = $_GET['dinnertype']; //餐市类型
            $tableid = $_GET['tableid']; //桌台id
            $modeltable = DinnerTable::model()->findByPk($tableid); //桌台对象
            $dinner_table_name = $modeltable->table_name; //桌台名称
            $reserv_date = $_GET['reserv_date']; //就餐日期
            $dealer_id = $this->getDealerId(); //商家id
            $contact_name = '';
            $contact_tel = '';
            //当前餐厅的餐市的时间点列表
            $timepointlist = TableOrderTimePoint::model()->gettime_pointlist($dealer_id, $dinnertype);
            if (isset($_POST['reserv_start_time'], $_POST['contact_name'], $_POST['contact_tel']))
            {
                $model = new TableReservation();
                $model->table_id = $_GET['tableid'];
                $model->order_id = 0;
                $model->reserv_start_time = $_GET['reserv_date'] . ' ' . $_POST['reserv_start_time'];
                $model->dinner_type = $_GET['dinnertype'];
                $model->reserv_status = TABLE_RESERVATION_STATUS_SUCCESS;
                $model->reserv_time = date('Y-m-d H:i:s', time());
                $model->from_type = TABLE_RESERVATION_FROMTYPE_DEALERSELF;
                $model->contact_name = $_POST['contact_name'];
                $model->contact_tel = $_POST['contact_tel'];
                if ($model->save())
                {
                    echo CLOSEDIALOGANDREFRESH;
                }
            }
            $this->renderPartial('createDealerTableOrder', array('dinner_table_name' => $dinner_table_name, 'reserv_date' => $reserv_date,
                'timepointlist' => $timepointlist, 'time_point' => '',
                'contact_name' => $contact_name, 'contact_tel' => $contact_tel, 'isNewRecord' => TRUE,
                    ), FALSE, TRUE);
        }
    }

    public function actionupdateDealerTableOrder()
    {
        if (isset($_GET['reserv_id'], $_GET['table_id']))
        {
            $tableid = $_GET['table_id']; //桌台id
            $modeltable = DinnerTable::model()->findByPk($tableid); //桌台对象
            $dinner_table_name = $modeltable->table_name; //桌台名称

            $reserv_id = $_GET['reserv_id'];
            $model = TableReservation::model()->findByPk($reserv_id);
            if (isset($_POST['reserv_id']))
            {
                //删除当前预定
                if (TableReservation::model()->deleteByPk($_POST['reserv_id']))
                {
                    echo CLOSEDIALOGANDREFRESH;
                }
            }
            $this->renderPartial('updateDealerTableOrder', array('dinner_table_name' => $dinner_table_name,
                'reserv_date' => substr($model->reserv_start_time, 0, 10),
                'timepointlist' => '', 'time_point' => substr($model->reserv_start_time, 10),
                'contact_name' => $model->contact_name,
                'contact_tel' => $model->contact_tel, 'isNewRecord' => FALSE,
                    ), FALSE, TRUE);
        }
    }

}
