<?php

class DealerController extends Controller_DealerAdmin
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
                'actions' => array('index', 'view', 'create', 'update', 'fun_index',
                    'delete', 'upload_logo', 'upload_banner', 'upload_weixin_banner', 'Reset_password'),
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
        $model = new Dealer;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Dealer']))
        {
            $model->attributes = $_POST['Dealer'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->dealer_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionReset_password()
    {
        $dealerCustomer = DealerCustomer::model()->find(array('condition' => 'dealer_id=' . $this->getDealerId()));
        $customer = Customer::model()->findByPk($dealerCustomer->customer_id);
        $username = $customer->customer_name;
        $msg = '';
        if (isset($_POST['oldpassword']))
        {
            $oldpassword = $_POST['oldpassword'];
            $newpassword = $_POST['newpassword'];
            $customerModel = Customer::model()->findByPk($dealerCustomer->customer_id);
            $psd_db = $customerModel->customer_pwd;
            $isoldpsd = Customer::model()->validatePassword($username, $oldpassword, $psd_db);
            if ($isoldpsd)
            {
                //更新密码
                if (Customer::model()->changePassword($username, $newpassword))
                {
                    $msg = '修改密码成功';
                }
                else
                {
                    $msg = '修改密码失败';
                }
            }
            else
            {
                $msg = '现在的密码输入错误';
            }
        }
        $this->render('reset_password', array('msg' => $msg));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($areaid)
    {
        $id = $this->getDealerId();
        $model = $this->loadModel($id); //商家对象
        $parent_dealer = Dealer::model()->findByPk($model->dealer_parent_id);
        $parent_dealername = '';
        if (isset($parent_dealer))
        {
            $parent_dealername = $parent_dealer->dealer_name;
        }
//        $model = Dealer::model()->findByPk($id);
        $picurl_logo = $this->loadLogoPicurl($id); //商家图片
        $picurl_banner = $this->loadBannerPicurl($id); //banner图片
        $picurl_wxbanner = $this->loadWxPicurl($id); //微信banner图片
        $dealer_funlist = DealerFunction::model()->getFunidBydealerid($id); //微信前台功能列表
        $bus_dealer = new busDealer();
        $dealer_takeout = $bus_dealer->get_dealer_takeout_min_timespan($id);
        $weixin_subscribe = $bus_dealer->get_weixin_subscribe($id);
        $auto_accept_order = $bus_dealer->get_auto_accept_order($id);
        $send_message_accepted_order = $bus_dealer->get_send_message_accepted_order($id);
        $delivery = $bus_dealer->get_delivery($id);
        $dish_image_display = $bus_dealer->get_dish_image_display($id);
        //自动接收短信的管理员电话
        $cus = Customer::model()->getDealerCustomer($id);
        $contactTel = $cus->customer_mobile; //第一个管理员的手机号码
        $areaid = $_GET['areaid'];
        switch ($areaid)
        {
            case 'updatedealer':
                $model = $this->updatedealer($model);
                if (isset($_POST['dealerLogo_PicName']))
                {
                    $picurl_logo = $_POST['dealerLogo_PicName'];
                }

                break;
            case 'takeoutparam':
                $dealer_takeout = $this->takeoutparam();
                $weixin_subscribe = $this->weixin_subscribeparam();
                $auto_accept_order = $this->auto_accept_orderparam();
                $send_message_accepted_order = $this->send_message_accepted_orderparam();
                $contactTel = $this->saveContactTel();
                $delivery = $this->saveDelivery();
                $dish_image_display = $this ->saveDishImageDisplay();
                break;
            case 'funindex':
                $dealer_funlist = $this->funindex();
                break;
            default:
                break;
        }
        $picurl_logo = $this->validationLogoEmpty($picurl_logo);
        $picurl_banner = $this->validationBannerEmpty($picurl_banner);
        $picurl_wxbanner = $this->validationWxbannerEmpty($picurl_wxbanner);

        $this->render('_form', array('dealer_takeout' => $dealer_takeout,
            'weixin_subscribe' => $weixin_subscribe, 'auto_accept_order' => $auto_accept_order,
            'send_message_accepted_order' => $send_message_accepted_order,
            'model' => $model, 'picurl_logo' => $picurl_logo, 'picurl_banner' => $picurl_banner,
            'picurl_wxbanner' => $picurl_wxbanner, 'dealer_funlist' => $dealer_funlist,
            'contactTel' => $contactTel, 'parent_dealername' => $parent_dealername,
            'delivery' => $delivery,
            'dish_image_display' => $dish_image_display
        ));
    }

    /**
     * 验证商家logo图片是否为空
     * @param type $picname
     * @return type
     */
    private function validationLogoEmpty($picname)
    {
        return $this->validationPicnameEmpty($picname, 'mobile/img/dish_default.png');
    }

    /**
     * 验证banner图片是否为空
     * @param type $picname
     * @return type
     */
    private function validationBannerEmpty($picname)
    {
        return $this->validationPicnameEmpty($picname, 'mobile/img/banner_wx_default.jpg');
    }

    /**
     * 验证微信banner图片是否为空
     * @param type $picname
     * @return type
     */
    private function validationWxbannerEmpty($picname)
    {
        return $this->validationPicnameEmpty($picname, 'mobile/img/banner_default.jpg');
    }

    /**
     * 验证图片路径是否为空
     * @param type $picname 图片文件路径
     * @param type $emptyPicname 如果图片路径为空显示的图片路径
     * @return string
     */
    private function validationPicnameEmpty($picname, $emptyPicname)
    {
        if (!isset($picname) || $picname == '')
        {
            $picname = $emptyPicname;
        }
        return $picname;
    }

    private function updatedealer($model)
    {
        if (isset($_POST['Dealer']))
        {
//            $this->saveLogoPicInfo($model);

            $model->attributes = $_POST['Dealer'];
            $model->save();
        }
        return $model;
    }

    /**
     * 保存图片信息
     * @param type $filename 相对路径
     * @param type $picTypeid 类型
     */
    private function savePicInfo($filename, $picTypeid)
    {
        $dealerid = $this->getDealerId();
        //上传商家logo  dealerLogo_PicName
//        $filename = $_POST[$postName];
        $pic = Pic::model()->findByAttributes(array('entity_id' => $dealerid, 'pic_type' => $picTypeid));
        $extensionName = substr($filename, strrpos($filename, '.') + 1);

        if (!isset($pic))
        {
            $pic = new Pic;
            $pic->entity_id = $dealerid;
            $pic->pic_type = $picTypeid;
            $pic->pic_url = $filename;
            $pic->save();
        }
        else
        {
            $pic->pic_url = $filename;
            $pic->save();
        }
    }

    /**
     * 设置参数 商家起送最低间隔
     * @return type
     */
    public function takeoutparam()
    {
        $dealer_takeout_min_timespan = 30;

        if (isset($_POST['setting_key_dealer_takeout_min_timespan']))
        {
            $dealer_id = $this->getDealerId();
            $dealer_takeout_min_timespan = $_POST['setting_key_dealer_takeout_min_timespan'];
            $bus_dealer = new busDealer();
            $bus_dealer->saveSetting(SETTING_KEY_DEALER_TAKEOUT_MIN_TIMESPAN, $dealer_takeout_min_timespan, $dealer_id);
        }
        return $dealer_takeout_min_timespan;
    }

    /**
     * 设置参数 微信用户关注
     * @return type
     */
    public function weixin_subscribeparam()
    {
        $setting_key_weixin_subscribe = 0;
        if (isset($_POST['setting_key_weixin_subscribe']))
        {
            $dealer_id = $this->getDealerId();
            $setting_key_weixin_subscribe = $_POST['setting_key_weixin_subscribe'];
            $bus_dealer = new busDealer();
            $bus_dealer->saveSetting(SETTING_KEY_WEIXIN_SUBSCRIBE, $setting_key_weixin_subscribe, $dealer_id);
        }
        return $setting_key_weixin_subscribe;
    }

    /**
     * 设置参数 商家是否自动接单
     * @return type
     */
    public function auto_accept_orderparam()
    {
        $setting_key_auto_accept_order = 0;
        if (isset($_POST['auto_accept_order']))
        {
            $dealer_id = $this->getDealerId();
            $setting_key_auto_accept_order = $_POST['auto_accept_order'];
            $bus_dealer = new busDealer();
            $bus_dealer->saveSetting(SETTING_KEY_AUTO_ACCEPT_ORDER, $setting_key_auto_accept_order, $dealer_id);
        }
        return $setting_key_auto_accept_order;
    }
    
    /**
     * 设置参数 商家是否外卖
     * @return type
     */
    public function saveDelivery()
    {
        $setting_key_delivery = 0;
        if (isset($_POST['delivery']))
        {
            $dealer_id = $this->getDealerId();
            $setting_key_delivery = $_POST['delivery'];
            $bus_dealer = new busDealer();
            $bus_dealer->saveSetting(SETTING_KEY_NO_DELIVERY, $setting_key_delivery, $dealer_id);
        }
        return $setting_key_delivery;
    }
    
    /**
     * 设置参数 菜品是否显示图片
     * @return type
     */
    public function saveDishImageDisplay()
    {
        $setting_key_image_display = 0;
        if (isset($_POST['dish_image_display']))
        {
            $dealer_id = $this->getDealerId();
            $setting_key_image_display = $_POST['dish_image_display'];
            $bus_dealer = new busDealer();
            $bus_dealer->saveSetting(SETTING_KEY_DISH_IMAGE_HIDDEN, $setting_key_image_display, $dealer_id);
        }
        return $setting_key_image_display;
    }
    

    /**
     * 设置参数 是否接受订单提醒短信
     * @return type
     */
    public function send_message_accepted_orderparam()
    {
        $send_message_accepted_order = 0;
        if (isset($_POST['send_message_accepted_order']))
        {
            $dealer_id = $this->getDealerId();
            $send_message_accepted_order = $_POST['send_message_accepted_order'];
            $bus_dealer = new busDealer();
            $bus_dealer->saveSetting(SETTING_KEY_SEND_MESSAGE_ACCEPTED_ORDER, $send_message_accepted_order, $dealer_id);
        }
        return $send_message_accepted_order;
    }

    /**
     * 保存联系人手机号码
     */
    public function saveContactTel()
    {
        $contactTel = '';
        if (isset($_POST['contactTel']))
        {
            $contactTel = $_POST['contactTel'];
            $dealer_id = $this->getDealerId();
            $customer = Customer::model()->getDealerCustomer($dealer_id);

            if (isset($customer))
            {
                Customer::model()->updateByPk($customer->customer_id, array('customer_mobile' => $contactTel));
            }
            else
            {
                Yii::log('当前商家未找到联系人', CLogger::LEVEL_ERROR);
            }
        }
        return $contactTel;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Dealer the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Dealer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * 获取商家logo相对地址
     * @param type $id 商家id
     */
    public function loadLogoPicurl($id)
    {
        return $this->loadPicurl($id, PIC_TYPE_DEALER_LOGO);
    }

    /**
     * 获取banner图片
     * @param type $id 商家id
     * @return type 图片相对地址
     */
    public function loadBannerPicurl($id)
    {
        return $this->loadPicurl($id, PIC_TYPE_DEALER_BANNER);
    }

    /**
     * 获取微信banner图片
     * @param type $id 商家id
     * @return type 图片相对地址
     */
    public function loadWxPicurl($id)
    {
        return $this->loadPicurl($id, PIC_TYPE_WX_DEALER_BANNER);
    }

    /**
     * 获取商家图片
     * @param type $dealerid 商家id
     * @param type $pic_type 图片类型
     * @return string 图片相对路径
     */
    private function loadPicurl($dealerid, $pic_type)
    {
        $model = Pic::model()->findByAttributes(array('entity_id' => $dealerid, 'pic_type' => $pic_type));
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
     * Performs the AJAX validation.
     * @param Dealer $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dealer-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * 上传商家logo图片
     * @return type
     */
    public function actionUpload_logo()
    {
        $this->upload_image(PIC_TYPE_DEALER_LOGO);
    }

    /**
     * 上传banner图片
     * @return type
     */
    public function actionUpload_banner()
    {
        $this->upload_image(PIC_TYPE_DEALER_BANNER);
    }

    /**
     * 上传微信banner图片
     */
    public function actionUpload_weixin_banner()
    {
        $this->upload_image(PIC_TYPE_WX_DEALER_BANNER);
    }

    /**
     * 上传图片
     * @param type $pic_type 图片类型
     * @return type 操作结果的json字符串
     */
    private function upload_image($pic_type)
    {
        ob_clean();
        $result = new OperResult();

        if (!isset($_FILES["Filedata"]))
        {
            $result->code = 0;
            $result->msg = '请选择图片';
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
        }
        else
        {
            $path = date('Ym');
            $dir = Yii::app()->params['img_upload_dir'] . 'upload/' . $path;

            if (!file_exists($dir))
            {
                try
                {
                    Yii::log($dir, CLogger::LEVEL_INFO);
                    mkdir($dir, 0700);
                } catch (Exception $exc)
                {

                    Yii::log($exc->getMessage(), CLogger::LEVEL_ERROR);
                    echo $exc->getTraceAsString();
                }
            }

            $file_name = $pic_type . '_' . date("YmdGis") . floor(microtime() * 1000) . '.' . $extension;
            $short_name = 'upload/' . $path . '/' . $file_name;
            $full_name = $dir = Yii::app()->params['img_upload_dir'] . $short_name;

            move_uploaded_file($_FILES["Filedata"]["tmp_name"], $full_name);

            $result->code = 1;
            $result->file_path = $this->get_static_url() . $short_name;
            $result->name = $short_name;

            $this->savePicInfo($short_name, $pic_type);
        }

        echo json_encode($result);
    }

    public function funindex()
    {
        $dealer_id = $this->getDealerId();
        $dealer_funlist = DealerFunction::model()->getFunidBydealerid($dealer_id);
        if (isset($_POST['dealer_funlist']))
        {
            $funlist = $_POST['dealer_funlist'];
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                DealerFunction::model()->deleteAllByAttributes(array('dealer_id' => $dealer_id));
                foreach ($funlist as $funid)
                {
                    $temp = new DealerFunction();
                    $temp->dealer_id = $dealer_id;
                    $temp->function_id = $funid;
                    $temp->save();
                }
                $transaction->commit();
                Yii::app()->cache->flush();
                return $funlist;
            } catch (Exception $ex)
            {
                Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
                $transaction->rollback();
                return '';
            }
        }
        else
        {
            return $dealer_funlist;
        }
    }

}
