<?php

define('Max_Sequence_Code', 1000000000);
define('Default_Sequence_Code', 10001);

/**
 * This is the model class for table "member_card".
 *
 * The followings are the available columns in table 'member_card':
 * @property string $card_id
 * @property string $card_no
 * @property integer $card_type
 * @property string $card_sdate
 * @property string $card_edate
 * @property string $dealer_id
 * @property integer $card_status
 * @property string $card_val
 * @property string $card_createtime
 */
class MemberCard extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'member_card';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'card_no, card_type, card_sdate, card_edate, dealer_id, card_status, card_val, card_createtime',
                'required'),
            array(
                'card_type, card_status',
                'numerical',
                'integerOnly' => true),
            array(
                'card_no',
                'length',
                'max' => 30),
            array(
                'dealer_id, card_val',
                'length',
                'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'card_id, card_no, card_type, card_sdate, card_edate, dealer_id, card_status, card_val, card_createtime',
                'safe',
                'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'card_id' => '会员卡id',
            'card_no' => '卡号',
            'card_type' => '类型：
            1 储值卡；
            2 积分卡；
            3 打折卡；',
            'card_sdate' => '有效期开始时间',
            'card_edate' => '有效期结束时间',
            'dealer_id' => '商家id',
            'card_status' => '状态
            0  无效；
            1  有效；
            ',
            'card_val' => '卡值',
            'card_createtime' => '创建时间',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('card_id', $this->card_id, true);
        $criteria->compare('card_no', $this->card_no, true);
        $criteria->compare('card_type', $this->card_type);
        $criteria->compare('card_sdate', $this->card_sdate, true);
        $criteria->compare('card_edate', $this->card_edate, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('card_status', $this->card_status);
        $criteria->compare('card_val', $this->card_val, true);
        $criteria->compare('card_createtime', $this->card_createtime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MemberCard the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获得当前时间
     * @return type
     */
    public function now()
    {
        return date('Y-m-d H:i:s', time());
    }

    public function GetCardNoByDealer($dealer_id)
    {
        $db = Yii::app()->db;
        $sql = "select max(card_no) as max_no from member_card where dealer_id=?";
        $arr = array(
            $dealer_id);
        $cmd = $db->createCommand($sql);
        $reader = $cmd->query($arr);
        $rows = $reader->readAll();
        $sequence_code = Default_Sequence_Code;
        $max_no = $rows[0]['max_no'];
        if (isset($max_no))
        {
            try
            {
                $split_arr = explode('' . $dealer_id . '', $max_no, 2);
                $sequence_code = intval($split_arr[1]);
                if ($sequence_code < Max_Sequence_Code)
                {
                    $sequence_code+=1;
                }
            } catch (Exception $exc)
            {
                Yii::log('max_no is not a valible,msg is:' . $exc->getTraceAsString(), CLogger::LEVEL_ERROR);
            }
        }
        $card_o = sprintf("%s%09d", $dealer_id, $sequence_code);
        return $card_o;
    }

    /**
     * 生成新卡
     * @param type $dealer_id
     * @return null
     */
    public function GetNewCardByDealer($dealer_id, $card_type)
    {
        $card = new MemberCard();
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try
        {
            $now = $this->now();
            $card->card_createtime = $now;
            $card->dealer_id = $dealer_id;
            $card->card_no = $this->GetCardNoByDealer($dealer_id);
            $card->card_type = $card_type;
            $card->card_sdate = $now;
            $card->card_edate = $now;
            $card->card_status = 0; //无效卡
            $card->card_val = 0;
            if (!$card->save())
            {
                $trans->rollback();
                Yii::log("插入会员卡失败", CLogger::LEVEL_ERROR);
                $card = NULL;
            }
            $trans->commit();
        } catch (Exception $ex)
        {
            $trans->rollback();
            Yii::log("新建会员卡失败,错误为" . $ex->getMessage(), CLogger::LEVEL_ERROR);
            $card = NULL;
        }
        return $card;
    }

    /**
     * 开通卡（储值卡、折扣卡，同时新建对应的积分卡）
     * @param type $c_name 客户姓名
     * @param type $c_sex 客户性别
     * @param type $c_mobile 客户手机号
     * @param type $c_addr 客户地址
     * @return boolean 是否开通成功
     */
    public function OpenCard($c_name, $c_sex, $c_mobile, $c_addr, $old_card_val)
    {
        $now = $this->now();
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try
        {
            if (!$this->save())
            {
                $trans->rollback();
                Yii::log("更新主卡失败", CLogger::LEVEL_ERROR);
                return FALSE;
            }
//            $old_card = $this->findByAttributes(array('card_id' => $this->card_id));
            $change = new MemberCardChange();
            $change->card_id = $this->card_id;
            $change->change_origin_val = $old_card_val;
            $change->change_new_val = $this->card_val;
            $change->change_type = Action_Open;
            $change->operator_id = Yii::app()->user->id;
            $change->change_time = $now;
            $change->change_val = '';
            $change->order_id = '';
            $change->change_sys = 1; //大菜谱微餐厅
            $change->memo = "储值卡或打折卡开卡";
            if (!$change->insert())
            {
                $trans->rollback();
                Yii::log('插入会员卡变更记录失败', CLogger::LEVEL_ERROR);
                return FALSE;
            }

            //新建积分卡
            $card = new MemberCard();
            $card->card_createtime = $now;
            $card->dealer_id = $this->dealer_id;
            $card->card_no = $this->GetCardNoByDealer($this->dealer_id);
            $card->card_type = Integral_Card;
            $card->card_sdate = $now;
            $card->card_edate = $now;
            $card->card_status = 1; //有效卡
            $card->card_val = 0;
            if (!$card->insert())
            {
                $trans->rollback();
                Yii::log("插入积分卡失败", CLogger::LEVEL_ERROR);
                return FALSE;
            }
            $change = new MemberCardChange();
            $change->card_id = $card->card_id;
            $change->change_origin_val = 0;
            $change->change_new_val = 0;
            $change->change_type = Action_Open;
            $change->operator_id = Yii::app()->user->id;
            $change->change_time = $now;
            $change->change_val = '';
            $change->order_id = '';
            $change->change_sys = 1; //大菜谱微餐厅
            $change->memo = "积分卡开卡";
            if (!$change->insert())
            {
                $trans->rollback();
                Yii::log('插入积分卡变更记录失败', CLogger::LEVEL_ERROR);
                return FALSE;
            }

            //如果存在微信id则用微信id，否则用手机号            
            $customer_name = $c_mobile;
            //检查账户
            $customer = Customer::model()->findByAttributes(array(
                'customer_name' => $customer_name,
            ));

            $customer_id = 0;
            if (!isset($customer))
            {
                $customer_data = array(
                    'customer_name' => $c_name,
                    'customer_mobile' => $c_mobile,
                    'customer_pwd' => Customer::model()->encryptPassword($c_mobile, $c_mobile),
                    'customer_status' => CUSTOMER_STATUS_ENABLE,
                    'customer_wechat_id' => '',
                    'customer_reg_time' => $now,
                );

                if (!$db->createCommand()->insert('customer', $customer_data))
                {
                    $trans->rollback();
                    Yii::log("保存用户失败", CLogger::LEVEL_ERROR);
                    return false;
                }
                $customer_id = $db->getLastInsertID();
                //为用户指定角色
                Yii::app()->authManager->assign(CUSTOMER_ROLENAME_CUSTOMER, $customer_id);
            } else
            {
                $customer_id = $customer->customer_id;
            }

            //检查联系人地址
            $contact_data = array(
                'customer_id' => $customer_id,
                'contact_name' => $c_name,
                'contact_tel' => $c_mobile,
                'contact_city_code' => '',
                'contact_addr' => $c_addr
            );
            $contact = Contact::model()->findByAttributes($contact_data);
            $contact_id = 0;
            if (isset($contact))
            {
                $contact_id = $contact->contact_id;
            } else
            {
                if (!$db->createCommand()->insert('contact', $contact_data))
                {
                    $trans->rollback();
                    Yii::log('保存联系人失败！', CLogger::LEVEL_ERROR);
                    return FALSE;
                }
                $contact_id = $db->lastInsertID;
            }
            //主卡
            $m_relation = new CustomerCard();
            $m_relation->card_id = $this->card_id;
            $m_relation->cc_date = $now;
            $m_relation->customer_id = $customer_id;
            $m_relation->operator_id = Yii::app()->user->id;
            if (!$m_relation->insert())
            {
                $trans->rollback();
                Yii::log('插入用户－会员卡关联主卡信息失败', CLogger::LEVEL_ERROR);
                return FALSE;
            }
            //积分卡
            $v_relation = new CustomerCard();
            $v_relation->card_id = $card->card_id;
            $v_relation->cc_date = $now;
            $v_relation->customer_id = $customer_id;
            $v_relation->operator_id = Yii::app()->user->id;
            if (!$v_relation->insert())
            {
                $trans->rollback();
                Yii::log('插入用户－会员卡关联积分卡信息失败', CLogger::LEVEL_ERROR);
                return FALSE;
            }
            $trans->commit();
            return TRUE;
        } catch (Exception $ex)
        {
            $trans->rollback();
            Yii::log('开通会员卡失败，错误为' . $ex->getMessage(), CLogger::LEVEL_ERROR);
            return FALSE;
        }
    }

    /**
     * 更新会员卡
     * @param type $type变更类型
     * @param type $order_id 订单ID     
     * @param type $charge 变更值
     * @param type $memo 备注
     * @return boolean
     */
    public function UpdateCard($type, $charge = '0', $memo = '', $order_id = '')
    {
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try
        {
            $old_card = $this->findByAttributes(array('card_id' => $this->card_id));
            $change = new MemberCardChange();
            $change->card_id = $this->card_id;
            $change->change_origin_val = $old_card->card_val;
            $change->change_new_val = $this->card_val;
            $change->change_type = $type;
            $change->operator_id = Yii::app()->user->id;
            $change->change_time = $this->now();
            $change->change_val = $charge;
            $change->order_id = $order_id;
            $change->change_sys = 1; //大菜谱微餐厅
            $change->memo = $memo;
            if (!$change->insert())
            {
                Yii::log('插入会员卡变更记录失败', CLogger::LEVEL_ERROR);
                $trans->rollback();
                return FALSE;
            }
            if (!$this->save())
            {
                Yii::log('更新会员卡失败', CLogger::LEVEL_ERROR);
                $trans->rollback();
                return FALSE;
            }
            $trans->commit();
            return TRUE;
        } catch (Exception $exc)
        {
            $trans->rollback();
            Yii::log($exc->getTraceAsString(), CLogger::LEVEL_ERROR);
            return FALSE;
        }
    }

    /**
     * 
     * @param type $card_no卡号
     * @param type $c_mobile联系人手机号
     * @param type $card_type卡类型
     * @param type $currentPage当前页
     * @param type $pageSize默认10
     * @return type
     */
    public function GetList($card_no, $c_mobile, $card_type, $dealer_id, $currentPage, $pageSize = 10)
    {
        $sql = "select mc.card_id,mc.card_no,mc.card_type,mc.card_sdate,mc.card_edate,mc.dealer_id,mc.card_status,mc.card_val,mc.card_createtime,c.customer_id,c.customer_name as c_name,c.customer_mobile as c_mobile "
                . "from `member_card` as mc inner join `customer_card` as cc on mc.`card_id`=cc.`card_id`  inner join customer as c on c.`customer_id`=cc.`customer_id` "
                . "and (c.`customer_wechat_id`='' or c.`customer_wechat_id`=null) "
        ;
        $sql = $sql . ' and card_type=' . $card_type;
        $sql = $sql . ' and mc.dealer_id=' . $dealer_id;
        if ($card_no != NULL && $card_no != '')
        {
            $sql = $sql . " and card_no like '%" . $card_no . "%'";
        }
        if ($c_mobile != NULL && $c_mobile != '')
        {
            $sql = $sql . " and customer_mobile like '%" . $c_mobile . "%'";
        }
        $criteria = new CDbCriteria;

        $model = Yii::app()->db->createCommand($sql)->queryAll();
        $pages = new CPagination(count($model));
        $pages->pageSize = $pageSize;
        $pages->currentPage = $currentPage;
        $pages->applylimit($criteria);

        $model = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $model->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $model->bindValue(':limit', $pages->pageSize);
        $model = $model->queryAll();
        return array(
            'itemCount' =>$pages->itemCount,
            'currentPage' => $pages->currentPage,
            'pageSize' => $pages->pageSize,
            'model' => $model,
        );
    }

    public function GetValueCardNobyIntegralNo($card_no)
    {
        try
        {
            $sql = "select card_no from member_card as mc left join customer_card as cc on mc.card_id=cc.card_id  where customer_id in(select `customer_id` from member_card as mc left join customer_card as cc on mc.card_id=cc.card_id "
                    . " where card_no=:card_no) and card_type=1";
            $result = yii::app()->db->createCommand($sql);
            $result->bindParam(':card_no', $card_no);
            $query = $result->queryAll();
            return array(
                $query [0] ['card_no'],
            );
        } catch (Exception $exc)
        {
            echo $exc->getTraceAsString();
            return '';
        }
    }

}
