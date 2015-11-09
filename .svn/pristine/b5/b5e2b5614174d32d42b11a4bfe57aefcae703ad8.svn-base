<?php

class DishController extends Controller_DealerAdmin
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
            array('allow',
                'actions' => array('upload'),
                'users' => array('*'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'cancelDelete'
                    , 'cancelOverDish', 'overDish', 'batchOverDish', 'batchCancelOverDish'
                    , 'batchDeleteDish', 'batchOnboardDish', 'del', 'batchDelDish', 'importExcel',
                    'uploadExcel', 'outputExcel', 'dishPackage', 'getPackageDish', 'updatePackageDish'),
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
            'model' => $this->loadViewModel($id),
        ));
    }

//    public function showdish_is_vaget($data, $row, $c) {
//        return busDish::showIsVaget($data->dish_is_vaget);
//    }

    public function loadViewModel($id)
    {
        $model = Dish::model()->getSingleDish($id);


        if ($model === null)
        {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $model->dish_recommend = busDish::$RECOMMEND[$model->dish_recommend];
        $model->dish_is_vaget = busDish::$ISVAGET[$model->dish_is_vaget]; //showIsVaget($model->dish_is_vaget);
        $model->dish_spicy_level = busDish::$SPICY_LEVEL[$model->dish_spicy_level];
        $model->dish_status = busDish::$DISH_STATUS[$model->dish_status];
        $model->dish_mode = busDish::$DISH_MODE[$model->dish_mode]; //busDish::showMode($model->dish_mode);
        if (!isset($model->dish_name_parent))
        {
            $model->dish_name_parent = '未制定';
        }
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Dish;
        $model->dish_recommend = 0;
        $model->dish_is_vaget = 1;
        $model->dish_status = 1;
        $model->dish_price = '0';
        $model->dish_package_fee = '0';
        $dish_display_type_select = array(1, 2);

        if (isset($_POST['Dish'], $_POST['dish_category'], $_POST['dish_display_type']))
        {
            $model->attributes = $_POST['Dish'];
            $model->dish_createtime = date("Y-m-d H:i:s");
            $model->dish_modifytime = date("Y-m-d H:i:s");
            $model->dealer_id = $this->getDealerId();
            $pin = new busPinyin();
            $model->dish_quanpin = $pin->getAllPY($model->dish_name);
            $model->dish_jianpin = $pin->getFirstPY($model->dish_name);
            $dish_category_id = $_POST['dish_category'];
            $dish_display_type_select = $_POST['dish_display_type'];
            if ($dish_display_type_select == array(1, 2))
            {
                $model->dish_display_type = DISH_DISPLAY_TYPE_TAKEOUT_EATIN;
            }
            elseif ($dish_display_type_select == array(1))
            {
                $model->dish_display_type == DISH_DISPLAY_TYPE_TAKOUT;
            }
            elseif ($dish_display_type_select == array(2))
            {
                $model->dish_display_type == DISH_DISPLAY_TYPE_EATIN;
            }

            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $model->save(); //保存菜品对象

                $relation_id_arr = explode(',',$dish_category_id);
                if (isset($relation_id_arr) && count($relation_id_arr) > 0)
                {
                    foreach ($relation_id_arr as $categoryid)
                    {
                        if ($categoryid == "")
                        {
                            continue;
                        }
                        $dishcatmodel = new DishCategoryRelation;
                        $dishcatmodel->category_id = $categoryid;
                        $dishcatmodel->dish_id = $model->dish_id;
                        $dishcatmodel->save(); //保存菜品与类别关系
                    }
                }

//                $dishcatmodel = new DishCategoryRelation;
//                $dishcatmodel->category_id = $dish_category_id;
//                $dishcatmodel->dish_id = $model->dish_id;
//                $dishcatmodel->save(); //保存菜品与类别关系

                $filename = $_POST['newPicName'];
                $pic = Pic::model()->findByAttributes(array('entity_id' => $model->dish_id, 'pic_type' => 2));
                $extensionName = substr($filename, strrpos($filename, '.') + 1);

                if (!isset($pic))
                {//图片信息在数据库中不存在
                    $pic = new Pic;
                    $pic->entity_id = $model->dish_id;
                    $pic->pic_type = 2;
                    $pic->pic_url = $filename;
                    $pic->save();
                }

                $transaction->commit();
                Yii::app()->cache->flush();

                echo CLOSEDIALOGANDREFRESH;
            }
            catch (Exception $ex)
            {
                Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
                $transaction->rollback();
            }
        }

        $cate_list = $this->getDishCategorySimple();
        $dishparent = $this->getAllDishByDealer();
        $dish_mode_isable = true;
        if (isset($_GET["id"]) && $_GET["id"] == "2")
        {
            $model->dish_mode = 2;
            $dish_mode_isable = false;
        }
        $model->dish_child_count = null;
        $this->renderPartial('create', array(
            'model' => $model,
            'categories' => $cate_list,
            'dishparent' => $dishparent, 'picurl_dish' => '',
            'dish_mode_isable' => $dish_mode_isable,
            'cateogry_id_arr' => array(), 'dish_display_type_select' => $dish_display_type_select
                ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        if ($id == "")
        {
            return;
        }
        $model = $this->loadModel($id);
        $picurl_dish = $this->loadDishPicurl($id);
        $dish_display_type_select = array(1, 2);
        if ($model->dish_display_type == DISH_DISPLAY_TYPE_TAKEOUT_EATIN)
        {
            $dish_display_type_select = array(1, 2);
        }
        elseif ($model->dish_display_type == DISH_DISPLAY_TYPE_TAKOUT)
        {
            $dish_display_type_select = array(1);
        }
        elseif ($model->dish_display_type == DISH_DISPLAY_TYPE_EATIN)
        {
            $dish_display_type_select = array(2);
        }

        if (isset($_POST['Dish'], $_POST['dish_category'], $_POST['dish_display_type']))
        {
            $model->attributes = $_POST['Dish'];
            $model->dish_modifytime = date("Y-m-d H:i:s");
            $pin = new busPinyin();
            $model->dish_quanpin = $pin->getAllPY($model->dish_name);
            $model->dish_jianpin = $pin->getFirstPY($model->dish_name);
            $dish_categoryid = $_POST['dish_category'];

            $dish_display_type_select = $_POST['dish_display_type'];
            if ($dish_display_type_select == array(1, 2))
            {
                $model->dish_display_type = DISH_DISPLAY_TYPE_TAKEOUT_EATIN;
            }
            elseif ($dish_display_type_select == array(1))
            {
                $model->dish_display_type = DISH_DISPLAY_TYPE_TAKOUT;
            }
            elseif ($dish_display_type_select == array(2))
            {
                $model->dish_display_type = DISH_DISPLAY_TYPE_EATIN;
            }
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $model->save(); //保存菜品对象
//删除当前菜品对应的菜品类别关系
//                $criteria = new CDbCriteria;
//                $criteria->addCondition("dish_id=" . $model->dish_id);
                DishCategoryRelation:: model()->deleteAll('dish_id=:dish_id', array(':dish_id' => $model->dish_id));

                $relation_id_arr = explode(',', $dish_categoryid);
                if (isset($relation_id_arr) && count($relation_id_arr) > 0)
                {
                    foreach ($relation_id_arr as $categoryid)
                    {
                        if ($categoryid == "")
                        {
                            continue;
                        }
                        $dishcatmodel = new DishCategoryRelation;
                        $dishcatmodel->category_id = $categoryid;
                        $dishcatmodel->dish_id = $model->dish_id;
                        $dishcatmodel->save(); //保存菜品与类别关系
                    }
                }
//                $dishPicFile = CUploadedFile::getInstanceByName('dishPicFile');
//                $msg = busUlitity::UploadImg($dishPicFile, 2, $model->dish_id, 1);

                $filename = $_POST['newPicName'];
                $pic = pic::model()->findByAttributes(array('entity_id' => $model->dish_id, 'pic_type' => 2));
                $extensionName = substr($filename, strrpos($filename, '.') + 1);

                if (!isset($pic))
                {
                    $pic = new Pic;
                    $pic->entity_id = $model->dish_id;
                    $pic->pic_type = 2;
                    $pic->pic_url = $filename;
                    $pic->save();
                }
                else
                {
                    $pic->pic_url = $filename;
                    $pic->save();
                }

//保存图片与菜品的关系
                $transaction->commit();
                Yii::app()->cache->flush();
                echo CLOSEDIALOGANDREFRESH;
//                $this->redirect(array('view', 'id' => $model->dish_id));
            }
            catch (Exception $ex)
            {
                $transaction->rollback();
            }
        }
        $cate_list = $this->getDishCategorySimple(); //菜品分类列表
        $cate_id_arr = $this->getCateid($model->dish_id); //菜品分类id
        $dishparent = $this->getAllDishByDealer($model->dish_id);
        //$model->dish_child_count = null;
        $dish_mode_isable = true;
        $this->renderPartial('update', array(
            'model' => $model,
            'categories' => $cate_list,
            'dishparent' => $dishparent,
            'picurl_dish' => $picurl_dish,
            'dish_mode_isable' => $dish_mode_isable,
            'cateogry_id_arr' => $cate_id_arr, 'dish_display_type_select' => $dish_display_type_select
                ), false, true);
    }

    /**
     * 获取菜品类别id
     * @param type $dishid 菜品id
     * @return int 菜品类别id
     */
    public function getCateid($dishid)
    {
//        $dishcateRel = DishCategoryRelation::model()->find('dish_id=' . $dishid);
//        if (!isset($dishcateRel))
//        {
//            return -1;
//        }
//        else
//        {
//            return $dishcateRel->category_id;
//        }

        $categories = DishCategoryRelation::model()->getDishCategoryBydishid($dishid);
        //$categories = DishCategoryRelation::model()->findAll('dish_id=' . $dishid);
        $cate_list = array();
        //$cate_list[-1] = '请选择';

        foreach ($categories as $category)
        {
            $cate_list[$category["category_id"]] = $category["category_name"];
        }
        return $cate_list;
    }

    /**
     * 获取菜品图片相对地址
     * @param type $id 商家id
     */
    private function loadDishPicurl($id)
    {
        $model = Pic::model()->findByAttributes(array('entity_id' => $id, 'pic_type' => 2));
        if (!isset($model))
        {
            return '';
        }
        else
        {
            return $model->pic_url;
        }
    }

    /**
     * 获取除当前菜品类别外的菜品类别简单对象
     * @param type $category_id 当前菜品的类别id
     * @return type 菜品类别id 和名称
     */
    private function getDishCategorySimple($category_id = 0)
    {
        if (!isset($category_id))
        {
            $category_id = 0;
        }
//获取当前商家的所有菜品类别对象
        $categories = DishCategory::model()->findAll(array('select' => 'category_id,category_name',
            'condition' => 'dealer_id=:dealer_id and category_id<>:category_id',
            'params' => array(':dealer_id' => $this->getDealerId(), 'category_id' => $category_id)));
        $cate_list = array();
        //$cate_list[-1] = '请选择';

        foreach ($categories as $category)
        {
            $cate_list[$category->category_id] = $category->category_name;
        }
        return $cate_list;
    }

    /**
     * 获取除当前菜品外的菜品简单对象
     * @param type $dishId 当前菜品
     * @return type
     */
    private function getAllDishByDealer($dishId = 0)
    {
        $dishs = Dish::model()->findAll(array('select' => 'dish_id,dish_name',
            'condition' => 'dealer_id=:dealer_id and dish_id<>:dish_id',
            'params' => array(':dealer_id' => $this->getDealerId(), ':dish_id' => $dishId)));
        $dish_list = array();
        $dish_list[-1] = '请选择';
        foreach ($dishs as $dish)
        {
            $dish_list[$dish->dish_id] = $dish->dish_name;
        }
        return $dish_list;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->dish_status == DISH_STATUS_OFFLINE)
        {
            echo '';
        }
        else
        {
            $updatecount = $model->updateByPk($id, array('dish_status' => DISH_STATUS_OFFLINE));
            if ($updatecount == 0)
            {
                echo '删除失败';
            }
            else
            {
                echo '';
            }
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDel($id)
    {
        $model = $this->loadModel($id);

        $updatecount = $model->delete();
        if ($updatecount == 0)
        {
            echo '删除失败';
        }
        else
        {
            echo '';
        }
    }

    /**
     * 上架菜品
     * @param type $id
     */
    public function actioncancelDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->dish_status == DISH_STATUS_ONLINE)
        {
            echo '';
        }
        else
        {
            $updatecount = $model->updateByPk($id, array('dish_status' => DISH_STATUS_ONLINE));
            if ($updatecount == 0)
            {
                echo '上架失败';
            }
            else
            {
                echo '';
            }
        }
    }

    /**
     * 批量下架菜品
     * @param type $dishids
     * @return type
     */
    public function actionbatchDeleteDish($dishids)
    {
        return $this->updishstatus($dishids, DISH_STATUS_OFFLINE);
    }

    /**
     * 批量删除菜品
     * @param type $dishids
     * @return type
     */
    public function actionbatchDelDish($dishids)
    {
        $disharr = explode(',', $dishids);
        $count = 0;
        try
        {
            $trans = Yii::app()->db->beginTransaction();

            for ($i = 0; $i < count($disharr); $i++)
            {
                Dish::model()->deleteByPk($disharr[$i]);
                $count++;
            }
            echo $count;
            $trans->commit();
        }
        catch (Exception $e)
        {
            $trans->rollback();
            echo 'error删除菜品失败' + $e->getMessage();
        }
    }

    /**
     * 批量上架菜品
     * @param type $dishids
     * @return type
     */
    public function actionbatchOnboardDish($dishids)
    {
        return $this->updishstatus($dishids, DISH_STATUS_ONLINE);
    }

    /**
     * 
     * @param type $dishids
     * @param type $status
     * @return string
     */
    private function updishstatus($dishids, $status)
    {
        $disharr = explode(',', $dishids);
        $count = 0;
        try
        {
            for ($i = 0; $i < count($disharr); $i++)
            {
                $model = Dish::model()->findByPk($disharr[$i]);
                if ($model->dish_status != $status)
                {
                    $model->updateByPk($disharr[$i], array('dish_status' => $status));
                    $count++;
                }
            }
            echo $count;
        }
        catch (Exception $e)
        {
            echo 'error设置菜品状态更新失败' + $e->getMessage();
        }
    }

    /**
     * 取消估清 
     * @param type $overid
     */
    public function actioncancelOverDish($overid)
    {
        $model = DishOver::model()->findByPk($overid);
        if ($model->delete() == TRUE)
        {
            echo '';
        }
        else
        {
            echo '取消菜品估清失败';
        }
    }

    /**
     * 批量取消估清
     * @param type $dishids 估清菜品id列表，以逗号分隔
     * @return string
     */
    public function actionbatchCancelOverDish($dishids)
    {
        $disharr = explode(',', $dishids);
        $count = 0;
        try
        {
            for ($i = 0; $i < count($disharr); $i++)
            {
                $model = DishOver::model()->findByAttributes(array('dish_id' => $disharr[$i],
                    'over_date' => date('Y-m-d')));
                if (isset($model))
                {
                    $model->delete();
                    $count++;
                }
            }
            echo $count;
        }
        catch (Exception $e)
        {
            echo 'error:设置菜品估清失败' + $e->getMessage();
        }
    }

    /**
     * 设置菜品估清
     * @param type $dishid
     */
    public function actionoverDish($dishid)
    {
        $model = new DishOver();
        $model->dish_id = $dishid;
        $model->over_date = date('Y-m-d');
        $model->over_createtime = date("Y-m-d H:i:s");
        if ($model->save() == true)
        {
            echo '';
        }
        else
        {
            echo '设置菜品估清失败';
        }
    }

    /**
     * 批量估清菜品
     * @param type $dishids 估清菜品id列表，id以逗号分隔
     * @return string
     */
    public function actionbatchOverDish($dishids)
    {
        $disharr = explode(',', $dishids);
        $count = 0;
        try
        {
            for ($i = 0; $i < count($disharr); $i++)
            {
//查看当前菜品是否估清
                $tempcount = DishOver::model()->countByAttributes(array('dish_id' => $disharr[$i],
                    'over_date' => date('Y-m-d')));
                if ($tempcount == 0)
                {
//估清当前菜品
                    $model = new DishOver();
                    $model->dish_id = $disharr[$i];
                    $model->over_date = date('Y-m-d');
                    $model->over_createtime = date("Y-m-d H:i:s");
                    $model->save();
                    $count++;
                }
            }
            echo $count;
        }
        catch (Exception $e)
        {
            echo 'error:设置菜品估清失败' + $e->getMessage();
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {

//        $dataProvider = new CActiveDataProvider('Dish', array(
//            'criteria' => array(
//                'condition' => 'dealer_id=' .$this->getDealerId(),
//                'order' => 'dish_status DESC',
//            ),
//        ));
        $c = Yii::app()->request->getParam('c', 0);
        $dealer_id = $this->getDealerId();

        $dish_name = '';
        if (isset($_POST['dish_name']))
        {
            $dish_name = $_POST['dish_name'];
        }

        $dish_cates = DishCategory::model()->findAllByAttributes(
                array('dealer_id' => $dealer_id,
            'category_status' => DISH_CATEGORY_STATUS_ONLINE), array('order' => 'dish_category_order DESC'));

        $cate_all = new DishCategory();
        $cate_all->category_id = 0;
        $cate_all->category_name = '全部';
        $dish_cates = busUlitity::array_insert($dish_cates, $cate_all, 0);

        $dataProvider = Dish::model()->getDish($dealer_id, $c, $dish_name);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'categories' => $dish_cates,
            'c' => $c,
        ));
    }

    /**
     * Lists all package Dish.
     */
    public function actionDishPackage()
    {
        $all_dish_package = Dish::model()->getAllPackageDishByDealer($this->getDealerId());
        $all_dish = Dish::model()->getAllSingleDishByDealer($this->getDealerId());
        $this->render('dishPackage', array(
            'all_dish_package' => $all_dish_package,
            'all_dish' => $all_dish
        ));
    }

    /**
     * 获取套餐下的所有菜品
     * @param type $id
     */
    public function actionGetPackageDish($id)
    {
        try
        {
            $partner_dealer_list = Dish::model()->GetPackageChildByid($id);
            echo json_encode($partner_dealer_list);
        }
        catch (Exception $ex)
        {
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            echo '-1';
        }
    }

    /**
     * 更新套餐下的菜品
     * @param type $id
     */
    public function actionUpdatePackageDish()
    {
        try
        {
            if (isset($_POST['dish_id'], $_POST['dish_id_select']))
            {
                $dish_id = $_POST['dish_id'];
                $dish_id_select = $_POST['dish_id_select'];

                $conn = Yii::app()->db;
                $trans = $conn->beginTransaction();

                DishRelation::model()->deleteAll('dish_parent_id=:dish_parent_id', array(':dish_parent_id' => $dish_id));

                $arr = explode(',', $dish_id_select);
                foreach ($arr as $value)
                {
                    $dish_relation_model = new DishRelation();
                    $dish_relation_model->dish_parent_id = $dish_id;
                    $dish_relation_model->dish_id = $value;
                    $dish_relation_model->save();
                }

                $trans->commit();
                echo '1';
            }
        }
        catch (Exception $ex)
        {
            $trans->rollback();
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            echo '-1';
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Dish('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Dish']))
            $model->attributes = $_GET['Dish'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Dish the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Dish::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Dish $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dish-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpload()
    {
        ob_clean();
        $result = new OperResult();

        if (!isset($_FILES["Filedata"]))
        {
            $result->code = 0;
            $result->msg = 'no image to upload';
            echo json_encode($result);
            return;
        }

        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["Filedata"]["name"]);
        $extension = end($temp);
        if ($_FILES["Filedata"]["error"] > 0)
        {
            $result->code = 0;
            $result->msg = $_FILES["Filedata"]["error"];
            Yii::log($_FILES["Filedata"]["error"], CLogger::LEVEL_ERROR);
        }
        else
        {
            $path = date('Ym');
            $dir = Yii::app()->params['img_upload_dir'] . 'upload/' . $path;

            if (!file_exists($dir))
            {
                try
                {
                    mkdir($dir, 0700);
                }
                catch (Exception $exc)
                {
                    Yii::log($exc->getMessage(), CLogger::LEVEL_ERROR);
                    echo $exc->getTraceAsString();
                }
            }

            $file_name = '2_' . date("YmdGis") . floor(microtime() * 1000) . '_1.' . $extension;
            $short_name = 'upload/' . $path . '/' . $file_name;
            $full_name = $dir = Yii::app()->params['img_upload_dir'] . $short_name;

            move_uploaded_file($_FILES["Filedata"]["tmp_name"], $full_name);

            $result->code = 1;
            $result->file_path = $this->get_static_url() . '120_120/' . $short_name;
            $result->name = $short_name;
        }

        echo json_encode($result);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionImportExcel()
    {
//$sheet_array = Yii::app()->yexcel->readActiveSheet("");
        $this->render('importExcel');
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionOutputExcel()
    {
        $all_dishs = Dish::model()->getAllDishes($this->getDealerId());
        Yii::app()->yexcel->writeActiveSheet($all_dishs);
    }

    /**
     * 上传Excel文件，并读取
     * 根据菜品名称更新或新增菜品
     * @return type
     */
    public function actionUploadExcel()
    {
        if (!isset($_FILES["file"]))
        {
            $error_mes = "-2";
            $this->render('importExcel', array('error_mes' => $error_mes));
        }
        if ($_FILES["file"]["error"] > 0)
        {
            $error_mes = $_FILES["file"]["error"];
            $this->render('importExcel', array('error_mes' => $error_mes));
        }

        if ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
        {
            $error_mes = "0";

            $file_name = 'data' . $this->getMSTime();
            move_uploaded_file($_FILES["file"]["tmp_name"], $file_name);

            $sheet_array = Yii::app()->yexcel->readActiveSheet($file_name);

            $i = 0;
            $conn = Yii::app()->db;
            $trans = $conn->beginTransaction();
            try
            {
                foreach ($sheet_array as $row)
                {
                    if ($row['A'] == null || $row['A'] == "")
                    {
                        continue;
                    }
                    $dish_type = '';
//跳过第一行
                    if ($i == 0)
                    {
                        $i++;
                        continue;
                    }
//取出Excel中的数据
                    $dish_excel = new Dish();
                    $dish_excel->dish_name = $row['A'];
                    $dish_excel->dish_price = $row['B'];
                    $dish_excel->dish_package_fee = $row['C'];
                    $dish_type_name = $row['D'];
                    $dish_excel->dish_recommend = DISH_RECOMMEND_NO;
                    $dish_excel->dish_is_vaget = '0';
                    $dish_excel->dish_spicy_level = '0';
                    $dish_excel->dish_introduction = $row['E'];
                    $dish_excel->dealer_id = $this->getDealerId();
                    $dish_excel->dish_status = DISH_STATUS_ONLINE;
                    $dish_excel->dish_createtime = date('Y-m-d H:i:s', time());
                    $dish_excel->dish_mode = '1';
                    $dish_excel->dish_child_count = '-1';
                    $dish_excel->dish_display_type = '0';
                    $dish_excel->dish_modifytime = date('Y-m-d H:i:s', time());
                    $pin = new busPinyin();
                    $dish_excel->dish_quanpin = $pin->getAllPY($dish_excel->dish_name);
                    $dish_excel->dish_jianpin = $pin->getFirstPY($dish_excel->dish_name);

                    $dish = Dish::model()->find('dish_name=:dish_name AND dealer_id=:dealer_id', array(':dish_name' => $dish_excel->dish_name, ':dealer_id' => $this->getDealerId()));

                    $dish_id = '';
                    if (isset($dish))
                    {
//数据库有相同菜品的名称
//更新
//$dish->dish_name = $dish_excel->dish_name;
                        $dish->dish_price = $dish_excel->dish_price;
//$dish->dish_recommend = $dish_excel->dish_recommend;
                        $dish->dish_package_fee = $dish_excel->dish_package_fee;
//                    $dish->dish_is_vaget = $dish_excel->dish_is_vaget;
//                    $dish->dish_spicy_level = $dish_excel->dish_spicy_level;
                        $dish->dish_introduction = $dish_excel->dish_introduction;
//                    $dish->dealer_id = $dish_excel->dealer_id;
//                    $dish->dish_status = $dish_excel->dish_status;
//                    $dish->dish_createtime = $dish_excel->dish_createtime;
//                    $dish->dish_mode = $dish_excel->dish_mode;
//                    $dish->dish_child_count = $dish_excel->dish_child_count;
//                    $dish->dish_display_type = $dish_excel->dish_display_type;
//                    $dish->dish_modifytime = $dish_excel->dish_modifytime;
//                    $dish->dish_quanpin = $dish_excel->dish_quanpin;
//                    $dish->dish_jianpin = $dish_excel->dish_jianpin;
                        $dish->update();
                        $dish_id = $dish->dish_id;
                    }
                    else
                    {
//添加菜品
                        $dish_excel->save();
                        $dish_id = $dish_excel->dish_id;
                    }
                    if ($dish_type_name == '')
                    {
                        throw new Exception('导入失败：菜品类别不可为空!');
                    }
                    else
                    {
                        DishCategoryRelation::AddOrUpdateDishCategory($this->getDealerId(), $dish_id, $dish_type_name);
                    }
                }
                $trans->commit();
                Yii::app()->cache->flush();
            }
            catch (Exception $ex)
            {
                $trans->rollback();
                Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
                $error_mes = $ex->getMessage();
            }
            unlink($file_name);
        }
        else
        {
            $error_mes = "-1";
        }
        $this->render('importExcel', array('error_mes' => $error_mes));
    }

    /**
     * 获取系统当前时间的时_分_秒_毫秒
     * @return type
     */
    protected function getMSTime()
    {
        list($usec, $sec) = explode(" ", microtime());
        $sec = date('H_i_s', $sec);
        $usec = sprintf('%.0f', (float) $usec * 1000);
        $usec = str_pad($usec, 3, '0', STR_PAD_LEFT);
        return $sec . '_' . $usec;
    }

}
