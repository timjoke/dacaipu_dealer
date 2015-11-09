<?php

class DishCategoryController extends Controller_DealerAdmin
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new DishCategory;

        $model->category_status = 1;
        $model->category_parent_id = 0;

        if (isset($_POST['DishCategory']))
        {
            $model->attributes = $_POST['DishCategory'];
            $model->dealer_id = $this->getDealerId();

            if ($model->save())
                echo CLOSEDIALOGANDREFRESH;
        }

        $cate_list = $this->getDishCategorySimple($model->category_id);
        $this->layout = '/layouts/empty';
        $this->renderPartial('create', array(
            'model' => $model,
            'categories' => $cate_list,
                //'cateogry_id'
                ), false, true);
    }

    /**
     * 获取除当前菜品类别外的菜品类别简单对象
     * @param type $category_id 当前菜品的类别id
     * @return type 菜品类别id 和名称
     */
    private function getDishCategorySimple($category_id = 0)
    {
        //获取当前商家的所有菜品类别对象
        if (!isset($category_id))
        {
            $category_id = 0;
        }
        $categories = DishCategory::model()->findAll(array('select' => 'category_id,category_name',
            'condition' => 'dealer_id=:dealer_id and category_id<>:category_id',
            'params' => array(':dealer_id' => $this->getDealerId(), 'category_id' => $category_id)));
        $cate_list = array();
        $cate_list[-1] = '请选择';

        foreach ($categories as $category)
        {
            $cate_list[$category->category_id] = $category->category_name;
        }
        return $cate_list;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['DishCategory']))
        {
            $model->attributes = $_POST['DishCategory'];
            if ($model->save())
            {
                echo CLOSEDIALOGANDREFRESH; // "<script type='text/javascript'>window.top.closeDialog();</script>";
            }
        }

        $cate_list = $this->getDishCategorySimple($model->category_id);
        $this->renderPartial('update', array(
            'model' => $model,
            'categories' => $cate_list,
                ), false, true);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        //删除菜品类型，即将菜品类型职位禁用，在禁用之前需要确认隶属于此类别下的菜品都为下架
        $model = $this->loadModel($id);
        if ($model->category_status == '0')
        {//当前类别已经禁用，不需要操作
            echo '';
        } else
        {
            $count = Dish::model()->getDishCountByCatId($id);
            if ($count == 0)
            {
                $updatecount = $model->updateByPk($id, array('category_status' => 0));
                if ($updatecount == 0)
                {
                    echo '删除失败';
                } else
                {
                    echo '';
                }
            } else
            {
                echo '当前菜品类别下尚有' . $count . '个上架的菜品，当前菜品类别不能删除';
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dealer_id = $this->getDealerId();
        $date = DishCategory::model()->getDealerDishCategory($dealer_id);

        $this->render('index', array(
            'dataProvider' => $date,
        ));
    }

    /*
     * 显示菜品类别状态
     */

    public function showCategory_status($data, $row, $c)
    {
        return busDishCategory::showCategory_status($data->category_status);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DishCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = DishCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DishCategory $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dish-category-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
