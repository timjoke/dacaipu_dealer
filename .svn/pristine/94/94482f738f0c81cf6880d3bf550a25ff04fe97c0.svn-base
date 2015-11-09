<?php

class DiscountPlanController extends Controller_DealerAdmin
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
                'actions' => array('index', 'view', 'create', 'update', 'admin',
                    'delete', 'cancelDelete', 'dynamicEntity', 'batchOfflineDiscountPlan','batchOnlineDiscountPlan'),
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
        $model = new DiscountPlan;
        $model->ar_status = 1;
        $model->ar_orders_type = 1;
        $stencils = $this->getAllDiscountStencil();
        $msg = '';

        if (isset($_POST['DiscountPlan']))
        {
            $ordersTypeList = $_POST['orders_type_list'];
            $model_list = array();
            $dealer_id = $this->getDealerId();
            foreach ($ordersTypeList as $orders_type)
            {
                $model = new DiscountPlan;
                $model->ar_status = 1;
                $model->ar_orders_type = 1;
                $model->attributes = $_POST['DiscountPlan'];
                $model->ar_dealer_id = $dealer_id;
                $model->ar_orders_type = $orders_type;
                $overlap_displan = array();
                if ($model->ar_status == DISCOUNT_PLAN_STATUS_ONLINE)
                {
                    $overlap_displan = DiscountPlan::model()->validationTime($model);
                }

                if (count($overlap_displan) > 0)
                {
                    $msg = '当前折扣模板的时间与以下折扣模板的时间有重合:' . join(',', $overlap_displan);
                    break;
                } else
                {
                    array_push($model_list, $model);
                }
            }
            if ($msg == '')
            {
                foreach ($model_list as $model_item)
                {
                    $model_item->save();
                }
                echo CLOSEDIALOGANDREFRESH;
            }
        }
        $this->layout = '/layouts/empty';
        $this->renderPartial('create', array(
            'model' => $model, 'msg' => $msg,
            'stencils' => $stencils
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
        $stencils = $this->getAllDiscountStencil();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $type = $model->ar_type;
        $entities = $this->dynamicEntity($type);
        $msg = '';
        if (isset($_POST['DiscountPlan']))
        {
            $model->attributes = $_POST['DiscountPlan'];
            $dealer_id = $this->getDealerId();
            $overlap_displan = array();
            if ($model->ar_status == DISCOUNT_PLAN_STATUS_ONLINE)
            {
                $overlap_displan = DiscountPlan::model()->validationTime($model);
            }
            if (count($overlap_displan) > 0)
            {
                $msg = '当前折扣模板的时间与以下折扣模板的时间有重合:' . join(',', $overlap_displan);
//                Yii::app()->clientScript->registerScript('msg', 'alert(' . $msg . ');');
            } else
            {
                if ($model->save())
                {
                    echo CLOSEDIALOGANDREFRESH;
                }
            }
        }
        $this->layout = '/layouts/empty';
        $this->render('update', array(
            'model' => $model, 'stencils' => $stencils, 'entities' => $entities, 'msg' => $msg,
        ));
    }

    /**
     * 折扣计划下线
     * @param type $id
     */
    public function actionDelete($id)
    {
        $this->updateStatus($id, DISCOUNT_PLAN_STATUS_OFFLINE, '下线失败');
    }

    /**
     * 折扣计划上线
     * @param type $id
     */
    public function actionCancelDelete($id)
    {
        $model = $this->loadModel($id);
        $overlap_displan = DiscountPlan::model()->validationTime($model);
        if (count($overlap_displan) > 0)
        {
            $msg = '当前折扣模板的时间与以下折扣模板的时间有重合:' . join(',', $overlap_displan);
            echo $msg;
        } else
        {
            $this->updateStatus($id, DISCOUNT_PLAN_STATUS_ONLINE, '上线失败');
        }
    }

    private function updateStatus($id, $status, $errormsg)
    {
        $model = $this->loadModel($id);
        $updatecount = $model->updateByPk($id, array('ar_status' => $status));
        if ($updatecount == 0)
        {
            echo $errormsg;
        } else
        {
            echo '';
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('DiscountPlan', array(
            'criteria' => array(
                'condition' => 'ar_dealer_id=' . $this->getDealerId(),
                'order' => 'ar_status DESC, ar_start_time ',
            ),
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
        $model = new DiscountPlan('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DiscountPlan']))
            $model->attributes = $_GET['DiscountPlan'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DiscountPlan the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = DiscountPlan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model->ar_start_time = substr($model->ar_start_time, 0, strlen($model->ar_start_time) - 3);
        $model->ar_end_time = substr($model->ar_end_time, 0, strlen($model->ar_end_time) - 3);

        return $model;
    }

    private function getAllDiscountStencil()
    {
        $discountStencils = Discount::model()->findAll(array('select' => 'discount_id,discount_name',
            'condition' => 'dealer_id=:dealer_id',
            'params' => array(':dealer_id' => $this->getDealerId())));
        $stencilList = array();
        $stencilList[-1] = '请选择';

        foreach ($discountStencils as $tmp)
        {
            $stencilList[$tmp->discount_id] = $tmp->discount_name;
        }
        return $stencilList;
    }

    public function actionDynamicEntity()
    {
        $type = $_POST['policy_id'];
        $entities = $this->dynamicEntity($type);
        foreach ($entities as $k => $v)
        {
            echo CHtml::tag('option', array(
                'value' => $k), CHtml::encode($v), true);
        }
    }

    private function dynamicEntity($_type)
    {
        $entities = array();
        $type = (int) $_type;
        if ($type == DISCOUNT_PLAN_TYPE_DISH)
        {
            $dishs = Dish::model()->findAll(array(
                'select' => 'dish_name,dish_id',
                'condition' => 'dealer_id=:dealer_id',
                'params' => array(
                    ':dealer_id' => $this->getDealerId())));
            $entities[-1] = '请选择';
            foreach ($dishs as $tmp)
            {
                $entities[$tmp->dish_id] = $tmp->dish_name;
            }
        } elseif ($type == DISCOUNT_PLAN_TYPE_CATEGORY)
        {
            $categories = DishCategory::model()->findAll(array(
                'select' => 'category_name,category_id',
                'condition' => 'dealer_id=:dealer_id',
                'params' => array(
                    ':dealer_id' => $this->getDealerId())));
            $entities[-1] = '请选择';
            foreach ($categories as $tmp)
            {
                $entities[$tmp->category_id] = $tmp->category_name;
            }
        } elseif ($type == DISCOUNT_PLAN_TYPE_VENDOR)
        {
            $entities[0] = '全店';
        }
        return $entities;
    }

    public static function showDiscountName($discount_id)
    {
        $model = Discount::model()->findByPk($discount_id);
        if (isset($model))
        {
            return $model->discount_name;
        } else
            return '无此折扣模板';
    }

    public static function showStatus($status)
    {
        $showstatus = $status == 1 ? '已上线' : '已下线';
        return $showstatus;
    }

    public static function showType($type)
    {
        $showType = '无优惠';
        switch ($type)
        {
            case 1:
                $showType = '针对全店优惠';
                break;
            case 2:
                $showType = '针对单品类别优惠';
                break;
            case 3:
                $showType = '针对单品优惠';
                break;
            default:
                break;
        }
        return $showType;
    }

    public static function showEntity($entity_id, $type)
    {
        $showEntity = '全店';
        if ($type == 3)
        {
            $model = Dish::model()->findByPk($entity_id);
            if (isset($model))
            {
                $showEntity = $model->dish_name;
            } else
                $showEntity = '无此菜品';
        } elseif ($type == 2)
        {
            $model = DishCategory::model()->findByPk($entity_id);
            if (isset($model))
            {
                $showEntity = $model->category_name;
            } else
                $showEntity = '无此菜品类别';
        }
        return $showEntity;
    }

    /**
     * Performs the AJAX validation.
     * @param DiscountPlan $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'discount-plan-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * 批量下线折扣计划
     * @param type $discountids
     * @return type
     */
    public function actionBatchOfflineDiscountPlan($discountids)
    {
        $discountarr = explode(',', $discountids);
        $count = 0;
        try
        {
            $trans = Yii::app()->db->beginTransaction();

            for ($i = 0; $i < count($discountarr); $i++)
            {
                DiscountPlan::model()->updateByPk($discountarr[$i], array('ar_status' => 0));
                $count++;
            }
            echo $count;
            $trans->commit();
        } catch (Exception $e)
        {
            $trans->rollback();
            echo 'error下线折扣计划失败' + $e->getMessage();
        }
    }
    
    /**
     * 批量上线折扣计划
     * @param type $discountids
     * @return type
     */
    public function actionBatchOnlineDiscountPlan($discountids)
    {
        $discountarr = explode(',', $discountids);
        $count = 0;
        try
        {
            $trans = Yii::app()->db->beginTransaction();

            for ($i = 0; $i < count($discountarr); $i++)
            {
                DiscountPlan::model()->updateByPk($discountarr[$i], array('ar_status' => 1));
                $count++;
            }
            echo $count;
            $trans->commit();
        } catch (Exception $e)
        {
            $trans->rollback();
            echo 'error上线折扣计划失败' + $e->getMessage();
        }
    }

}
