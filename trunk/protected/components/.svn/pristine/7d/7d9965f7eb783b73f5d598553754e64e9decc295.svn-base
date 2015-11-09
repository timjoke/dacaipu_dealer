<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller_DealerAdmin
 *
 * @author lts
 */
class Controller_DealerAdmin extends Controller {

    public function init() {
        Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'js/fancybox/source/jquery.fancybox.css');
        Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/fancybox/source/jquery.fancybox.js');
        Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery-ui-1.10.3.custom.min.js');
        Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/dacaipu.ct.js');
        Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/jquery-ui-1.10.3.custom.min.css');
        Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/dealermanage.css');
        Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/InformationCss.css');
        Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/WebOrderCss.css');
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerMetaTag('text/html;charset=utf-8', null, 'content-type');
        parent::init();
    }

    public function getDealerId() {
        $dealer_id = Yii::app()->session['dealer_id'];
        if (!isset($dealer_id)) {
            $customer_id = Yii::app()->user->id;
            $dealercustomer = DealerCustomer::model()->find(array('condition' => 'customer_id=' . $customer_id));
            Yii::app()->session['dealer_id'] = $dealercustomer->dealer_id;
            $dealer_id = Yii::app()->session['dealer_id'];
        }
        return $dealer_id;
    }

}
