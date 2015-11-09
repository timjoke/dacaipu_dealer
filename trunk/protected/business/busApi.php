<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of busApi
 *
 * @author jimmy
 */
class busApi
{

    /**
     * 登陆获取餐馆id
     * @return \OperResult
     */
    public function login()
    {
        //Yii::app()->request->getParam($name)
        //验证参数
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $result = new OperResult();

        Yii::log('请求参数:[$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                , CLogger::LEVEL_INFO);

        if (!isset($sign, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

        //验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

        $conn = Yii::app()->db;
        try
        {
//查询用户信息
            $dealer_user = Customer::model()->getDealerUserInfo($dealer_user);
            if (isset($dealer_user))
            {
                $result->code = 0;
                $result->message = '成功';
                $result->dealer_id = $dealer_user->dealer_id;
                $result->dealer_name = $dealer_user->dealer_name;
            } else
            {
                $result->code = -604;
                $result->message = '没有该用户';
            }

            return $result;
        } catch (Exception $ex)
        {
//$trans->rollback();
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 更新菜品种类
     * @return \OperResult
     */
    public function up_cate_list()
    {
        //验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $cate_list = json_decode(Yii::app()->request->getParam('cate_list'));
        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$cate_list]=' . Yii::app()->request->getParam('cate_list')
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $cate_list, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

        //验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

        //检查授权商家
        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
        if (!isset($partner))
        {
            Yii::log('授权无效', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "授权无效";
            return $result;
        }

        $conn = Yii::app()->db;
        $trans = $conn->beginTransaction();
        try
        {
            //修改菜品类别在线状态
            DishCategory::model()->updateAll(
                    array(
                'category_status' => DISH_CATEGORY_STATUS_OFFLINE
                    ), 'dealer_id = :dealer_id AND category_status = :category_status', array(
                ':dealer_id' => $dealer_id,
                ':category_status' => DISH_CATEGORY_STATUS_ONLINE
                    )
            );

            foreach ($cate_list as $cate)
            {
                $cate_relat = PartnerEntityRelat::model()->findByAttributes(
                        array(
                            'dealer_id' => $dealer_id,
                            'entity_type' => PARTNER_ENTITY_TYPE_DISH_CATEGORY,
                            'partner_id' => $partner->partner_id,
                            'partner_entity_id' => $cate->id,
                ));
                //如果找到商家实体的对应关系，则更新，否则先新增菜品和实体关系记录
                if (!empty($cate_relat))
                {
                    DishCategory::model()->updateAll(
                            array(
                        'category_name' => $cate->name,
                        'category_status' => DISH_CATEGORY_STATUS_ONLINE
                            ), 'dealer_id = :dealer_id AND category_id = :category_id', array(
                        ':dealer_id' => $dealer_id,
                        ':category_id' => $cate_relat->entity_id
                    ));
                } else
                {
                    //新增菜品类别
                    $model = new DishCategory();
                    $model->category_name = $cate->name;
                    $model->category_status = DISH_CATEGORY_STATUS_ONLINE;
                    $model->dealer_id = $dealer_id;
                    $model->category_parent_id = -1;
                    $model->insert();

                    //$conn->lastInsertID
                    $new_id = $model->primaryKey;

                    //新增合作商实体关联
                    $model = new PartnerEntityRelat();
                    $model->entity_id = $new_id;
                    $model->entity_type = PARTNER_ENTITY_TYPE_DISH_CATEGORY;
                    $model->dealer_id = $dealer_id;
                    $model->partner_id = $partner->partner_id;
                    $model->partner_entity_id = $cate->id;
                    $model->insert();
                }
            }

            $trans->commit();

            $result->code = 0;
            $result->message = '成功';
            return $result;
        } catch (Exception $ex)
        {
            $trans->rollback();
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 更新菜品列表
     * @return \OperResult
     */
    public function up_dish_list()
    {
        //验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $dish_list = json_decode(Yii::app()->request->getParam('dish_list'));
        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$dish_list]=' . Yii::app()->request->getParam('dish_list')
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $dish_list, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

        //验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

        //检查授权商家
        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
        //$this->responseEcho(count($result));
        if (!isset($partner))
        {
            Yii::log('授权无效', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "授权无效";
            return $result;
        }

        $conn = Yii::app()->db;
        $trans = $conn->beginTransaction();
        try
        {
            $all_dish = Dish::model()->getDishsByDealerId($dealer_id);

            //删除菜品及其关联数据
            foreach ($all_dish as $a_dish)
            {
                //删除菜品实体关系
                PartnerEntityRelat::model()->deleteAll(
                        'dealer_id = :dealer_id AND entity_type=:entity_type AND entity_id=:entity_id AND partner_id=:partner_id', array(
                    ':dealer_id' => $dealer_id,
                    ':entity_type' => PARTNER_ENTITY_TYPE_DISH,
                    ':entity_id' => $a_dish['dish_id'],
                    ':partner_id' => $partner->partner_id,
                ));

                //删除菜品类别关系
                DishCategoryRelation::model()->deleteAll(
                        'dish_id = :dish_id', array(
                    ':dish_id' => $a_dish['dish_id']
                ));
                //删除菜品图片
                Pic::model()->deleteAll(
                        'entity_id = :entity_id AND pic_type=:pic_type', array(
                    ':entity_id' => $a_dish['dish_id'],
                    ':pic_type' => PIC_TYPE_DISH_IMG
                ));

                //删除菜品
                Dish::model()->deleteAll(
                        'dealer_id = :dealer_id AND dish_id = :dish_id', array(
                    ':dealer_id' => $dealer_id,
                    ':dish_id' => $a_dish['dish_id']
                ));

                //折扣计划实体ID更新为-1
                DiscountPlan::model()->updateAll(
                        array(
                    'ar_entity_id' => -1
                        ), 'ar_entity_id = :ar_entity_id AND ar_type=:ar_type AND ar_dealer_id=:ar_dealer_id', array(
                    ':ar_entity_id' => $a_dish['dish_id'],
                    ':ar_type' => DISCOUNT_PLAN_TYPE_SINGLE,
                    ':ar_dealer_id' => $dealer_id
                ));
            }

            foreach ($dish_list as $dish)
            {
                //新增菜品
                Dish::model()->createNewDish($dish, $dealer_id, $partner);
            }

            $trans->commit();

            $result->code = 0;
            $result->message = '成功';
            return $result;
        } catch (Exception $ex)
        {
            $trans->rollback();

            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 跟新桌台列表
     * @return \OperResult
     */
    public function up_table_list()
    {
//验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $table_list = json_decode(Yii::app()->request->getParam('table_list'));
        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$table_list]=' . Yii::app()->request->getParam('table_list')
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $table_list, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

//验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

//检查授权商家
        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
        if (!isset($partner))
        {
            Yii::log('授权无效', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "授权无效";
            return $result;
        }

        $conn = Yii::app()->db;
        $trans = $conn->beginTransaction();
        try
        {
//修改桌台在线状态
            DinnerTable::model()->updateAll(
                    array(
                'table_status' => DINNERTABLE_STATUS_OFFLINE
                    ), 'dealer_id = :dealer_id AND table_status = :table_status', array(
                ':dealer_id' => $dealer_id,
                ':table_status' => DINNERTABLE_STATUS_ONLINE
                    )
            );

            foreach ($table_list as $table)
            {
                $cate_relat = PartnerEntityRelat::model()->findByAttributes(
                        array(
                            'dealer_id' => $dealer_id,
                            'entity_type' => PARTNER_ENTITY_TYPE_TABLE,
                            'partner_id' => $partner->partner_id,
                            'partner_entity_id' => $table->id,
                ));
                //如果找到商家实体的对应关系，则更新，否则先新增菜品和实体关系记录
                if (!empty($cate_relat))
                {
                    DinnerTable::model()->updateAll(
                            array(
                        'table_name' => $table->name,
                        'table_status' => DINNERTABLE_STATUS_ONLINE,
                        'table_sit_count' => $table->site_count,
                        'table_service_price' => $table->service_price,
                        'table_is_room' => $table->is_room,
                        'table_is_smoke' => $table->is_smoke,
                        'table_lower_case' => $table->lower_case
                            ), 'dealer_id = :dealer_id AND table_id = :table_id', array(
                        ':dealer_id' => $dealer_id,
                        ':table_id' => $cate_relat->entity_id
                    ));
                } else
                {
                    //新增桌台
                    $model = new DinnerTable();
                    $model->table_name = $table->name;
                    $model->table_status = DINNERTABLE_STATUS_ONLINE;
                    $model->table_sit_count = $table->site_count;
                    $model->table_service_price = $table->service_price;
                    $model->table_is_room = $table->is_room;
                    $model->table_is_smoke = $table->is_smoke;
                    $model->table_lower_case = $table->lower_case;
                    $model->dealer_id = $dealer_id;
                    $model->insert();

                    //$conn->lastInsertID
                    $new_id = $model->primaryKey;

                    //新增合作商实体关联
                    $model = new PartnerEntityRelat();
                    $model->entity_id = $new_id;
                    $model->entity_type = PARTNER_ENTITY_TYPE_TABLE;
                    $model->dealer_id = $dealer_id;
                    $model->partner_id = $partner->partner_id;
                    $model->partner_entity_id = $table->id;
                    $model->insert();
                }
            }

            $trans->commit();

            $result->code = 0;
            $result->message = '成功';
            return $result;
        } catch (Exception $ex)
        {
            $trans->rollback();

            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 接受订单DS
     * @return \OperResult
     */
    public function confirm_order_DS()
    {       
        //验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $order_id = Yii::app()->request->getParam('order_id');
        $result = new OperResult();

        Yii::log('confirm_order_DS--请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$order_id]=' . $order_id
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $order_id, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

//验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

//检查授权商家
        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
        if (!isset($partner))
        {
            Yii::log('授权无效', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "授权无效";
            return $result;
        }

        try
        {
            if (OrderStatusMessage::model()->transformOrderStatus_DS($dealer_id, $order_id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_PROCESSING, '') == 0)
            {
                $result->code = 0;
                $result->message = '成功';
            } else
            {
                $result->code = -603;
                $result->message = '服务器异常';
            }
            return $result;
        } catch (Exception $ex)
        {
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 接受订单
     * @return \OperResult
     */
    public function confirm_order()
    {
        //验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $order_id = Yii::app()->request->getParam('order_id');
        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$order_id]=' . $order_id
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $order_id, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

//验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

//检查授权商家
        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
        if (!isset($partner))
        {
            Yii::log('授权无效', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "授权无效";
            return $result;
        }

        $conn = Yii::app()->db;
        //$trans = $conn->beginTransaction();
        try
        {
            if (OrderStatusMessage::model()->transformOrderStatus($dealer_id, $order_id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_PROCESSING, '') == 0)
            {
                //$trans->commit();
                $result->code = 0;
                $result->message = '成功';
            } else
            {
                $result->code = -603;
                $result->message = '服务器异常';
            }
            return $result;
        } catch (Exception $ex)
        {
            //$trans->rollback();

            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 拒绝订单
     * @return \OperResult
     */
    public function refuse_order()
    {
//验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $order_id = Yii::app()->request->getParam('order_id');
        $reason = Yii::app()->request->getParam('reason');
        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$order_id]=' . $order_id
                . ' [$reason]=' . $reason
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $order_id, $reason, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

//验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

//检查授权商家
        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
        if (!isset($partner))
        {
            Yii::log('授权无效', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "授权无效";
            return $result;
        }

        $conn = Yii::app()->db;
        //$trans = $conn->beginTransaction();
        try
        {
//更新订单状态
//            Orders::model()->updateAll(
//                    array(
//                'order_status' => ORDER_STATUS_DENIED
//                    ), 'dealer_id = :dealer_id AND order_id = :order_id', array(
//                ':dealer_id' => $dealer_id,
//                ':order_id' => $order_id
//                    )
//            );
            if (OrderStatusMessage::model()->transformOrderStatus($dealer_id, $order_id, ORDER_STATUS_WAIT_PROCESS, ORDER_STATUS_DENIED, $reason) == 0)
            {
                $result->code = 0;
                $result->message = '成功';
            } else
            {
                $result->code = -603;
                $result->message = '服务器异常';
            }
            //$trans->commit();
            return $result;
        } catch (Exception $ex)
        {
            //$trans->rollback();

            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 请求订单
     * @return \OperResult
     */
    public function get_order()
    {
//验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $minutes = Yii::app()->request->getParam('minutes');
        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$minutes]=' . $minutes
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $minutes, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

//验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -606;
            $result->message = "用户名或密码错误";
            return $result;
        }

//检查授权商家
        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
        if (!isset($partner))
        {
            Yii::log('授权无效', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "授权无效";
            return $result;
        }

        $conn = Yii::app()->db;
//$trans = $conn->beginTransaction();
        try
        {
//查询订单详细信息
            $endTime = date('Y-m-d H:i:s', time());
            $beginTime = date('Y-m-d H:i:s', mktime(date('H'), date('i') - $minutes, date('s'), date('n'), date('j'), date('Y')));
            $ordersArray = Orders::model()->getProcessedOrdersByDate($dealer_id, $beginTime, $endTime);
            //sort($ordersArray);

            return $ordersArray;
        } catch (Exception $ex)
        {
//$trans->rollback();
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 请求未完成订单
     * @return \OperResult
     */
    public function get_unfinished_order()
    {
//验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $dealer_user, $dealer_pwd))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

//验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

//检查授权商家
        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
        if (!isset($partner))
        {
            Yii::log('授权无效', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "授权无效";
            return $result;
        }

        $conn = Yii::app()->db;
//$trans = $conn->beginTransaction();
        try
        {
//查询订单详细信息
            $ordersArray = Orders::model()->getUnfinishedOrders($dealer_id);
            //sort($ordersArray);

            return $ordersArray;
        } catch (Exception $ex)
        {
//$trans->rollback();
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 请求已完成订单
     * @return \OperResult
     */
    public function get_finished_order()
    {
//验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $lastid = Yii::app()->request->getParam('lastid');
        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$lastid]=' . $lastid
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $dealer_user, $dealer_pwd, $lastid))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

//验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

////检查授权商家
//        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
//        if (!isset($partner))
//        {
//            Yii::log('授权无效', CLogger::LEVEL_WARNING);
//            $result->code = -604;
//            $result->message = "授权无效";
//            return $result;
//        }

        $conn = Yii::app()->db;
//$trans = $conn->beginTransaction();
        try
        {
//查询订单详细信息
            $ordersArray = Orders::model()->getfinishedOrders($dealer_id, $lastid);
            //sort($ordersArray);

            return $ordersArray;
        } catch (Exception $ex)
        {
//$trans->rollback();
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 改变订单状态订单
     * @return \OperResult
     */
    public function change_order_status()
    {
        //验证参数
        $dealer_id = Yii::app()->request->getParam('dealer_id');
        $partner_key = Yii::app()->request->getParam('partner_key');
        $sign = Yii::app()->request->getParam('sign');
        $dealer_user = Yii::app()->request->getParam('dealer_user');
        $dealer_pwd = Yii::app()->request->getParam('dealer_pwd');
        $order_id = Yii::app()->request->getParam('order_id');
        $old_status = Yii::app()->request->getParam('old_status');
        $new_status = Yii::app()->request->getParam('new_status');
        $reason = Yii::app()->request->getParam('reason');

        $result = new OperResult();

        Yii::log('请求参数:[$dealer_id]=' . $dealer_id
                . ' [$partner_key]=' . $partner_key
                . ' [$sign]=' . $sign
                . ' [$dealer_user]=' . $dealer_user
                . ' [$dealer_pwd]=' . $dealer_pwd
                . ' [$order_id]=' . $order_id
                . ' [$old_status]=' . $old_status
                . ' [$new_status]=' . $new_status
                . ' [$reason]=' . $reason
                , CLogger::LEVEL_INFO);

        if (!isset($dealer_id, $partner_key, $sign, $order_id, $dealer_user, $dealer_pwd, $old_status, $new_status, $reason))
        {
            Yii::log('请求参数错误', CLogger::LEVEL_WARNING);
            $result->code = -601;
            $result->message = "请求参数错误";
            return $result;
        }

//验证签名
        if (!$this->valid_sign($sign))
        {
            Yii::log('签名错误', CLogger::LEVEL_WARNING);
            $result->code = -605;
            $result->message = "签名错误";
            return $result;
        }

        //验证用户名和密码
        if (Customer::model()->validDealerUser($dealer_user, $dealer_pwd) == 0)
        {
            Yii::log('用户名或密码错误', CLogger::LEVEL_WARNING);
            $result->code = -604;
            $result->message = "用户名或密码错误";
            return $result;
        }

////检查授权商家
//        $partner = PartnerDealer::model()->getDealerPartnerKey($dealer_id, $partner_key);
//        if (!isset($partner))
//        {
//            Yii::log('授权无效', CLogger::LEVEL_WARNING);
//            $result->code = -604;
//            $result->message = "授权无效";
//            return $result;
//        }

        $conn = Yii::app()->db;
        //$trans = $conn->beginTransaction();
        try
        {
            if (OrderStatusMessage::model()->transformOrderStatus($dealer_id, $order_id, $old_status, $new_status, $reason) == 0)
            {
                //$trans->commit();
                $result->code = 0;
                $result->message = '成功';
            } else
            {
                $result->code = -603;
                $result->message = '修改订单状态失败';
            }
            return $result;
        } catch (Exception $ex)
        {
            //$trans->rollback();

            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
            $result->code = -603;
            $result->message = $ex->getMessage();
            return $result;
        }
    }

    /**
     * 验证签名
     * @param type $my_sign
     * @return type
     */
    private function valid_sign($my_sign)
    {
        return true; //测试，跳过验证sign
        $al = array();
        foreach ($_POST as $k => $v)
        {
            $al[$k] = $v;
        }

        $md5Post = $this->getMd5($al);
        //print_r($md5Post);
        return $md5Post == $my_sign;
    }

    /**
     * 获取请求参数的Md5
     * @param type $al
     * @return type
     */
    private function getMd5($al)
    {
        $str = '';
        ksort($al);
        foreach ($al as $k => $v)
        {
            if ($k == 'sign')
            {
                continue;
            }
            $str .= sprintf('&%s=%s', $k, $v);
        }
        if ($str[0] == '&')
        {
            $str = substr($str, 1);
        }
        return md5($str);
    }

}
