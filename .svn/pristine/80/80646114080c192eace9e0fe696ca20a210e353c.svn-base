<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrdersTableController
 *
 * @author lts
 */
class OrdersTableController extends Controller_DealerAdmin {

    public $layout = '/layouts/dealer_menu_left';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index'),
                'roles' => array(CUSTOMER_ROLENAME_DEALERUSER),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $reserv_date = '';
        if (isset($_POST['reserv_date'])) {
            $reserv_date = $_POST['reserv_date'];
        }
        $dealer_id = $this->getDealerId();
        $date = TableReservation::model()->getOrderTable($dealer_id, $reserv_date);
        $this->render('index', array(
            'dataProvider' => $date,
            'reserv_date' => $reserv_date
        ));
    }

}
