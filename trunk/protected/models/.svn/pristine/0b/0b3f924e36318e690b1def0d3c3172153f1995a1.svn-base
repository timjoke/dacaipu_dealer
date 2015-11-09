<?php

/**
 * This is the model class for table "member_card_change".
 *
 * The followings are the available columns in table 'member_card_change':
 * @property string $change_id
 * @property integer $change_type
 * @property string $card_id
 * @property string $operator_id
 * @property string $change_time
 * @property string $change_val
 * @property string $order_id
 * @property string $memo
 * @property integer $change_sys
 * @property string $change_origin_val
 * @property string $change_new_val
 */
class MemberCardChange extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'member_card_change';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('change_type, card_id, operator_id, change_time, change_val, order_id, memo, change_sys, change_origin_val, change_new_val', 'required'),
            array('change_type, change_sys', 'numerical', 'integerOnly' => true),
            array('card_id, operator_id, change_val, order_id, change_origin_val, change_new_val', 'length', 'max' => 20),
            array('memo', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('change_id, change_type, card_id, operator_id, change_time, change_val, order_id, memo, change_sys, change_origin_val, change_new_val', 'safe', 'on' => 'search'),
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
            'change_id' => '变更id',
            'change_type' => '变更类别：
            1  开卡；
            2  充值；
            3  消费；
            4  兑换；
            5  销卡；',
            'card_id' => 'Card',
            'operator_id' => '操作人',
            'change_time' => '操作时间',
            'change_val' => '变更值',
            'order_id' => '订单号',
            'memo' => '备注',
            'change_sys' => '请求系统：
            1  大菜谱微餐厅',
            'change_origin_val' => 'Change Origin Val',
            'change_new_val' => 'Change New Val',
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

        $criteria->compare('change_id', $this->change_id, true);
        $criteria->compare('change_type', $this->change_type);
        $criteria->compare('card_id', $this->card_id, true);
        $criteria->compare('operator_id', $this->operator_id, true);
        $criteria->compare('change_time', $this->change_time, true);
        $criteria->compare('change_val', $this->change_val, true);
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('change_sys', $this->change_sys);
        $criteria->compare('change_origin_val', $this->change_origin_val, true);
        $criteria->compare('change_new_val', $this->change_new_val, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MemberCardChange the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 
     * @param type $card_no 卡号    
     * @param type $currentPage 当前页
     * @param type $pageSize    每页现实数目
     * @return type
     */   
    public function GetList($card_no, $currentPage, $pageSize = 10)
    {
        $sql = "select change_id,change_type,mcc.card_id,operator_id,change_time,change_val,order_id,memo,change_origin_val,change_new_val,dealer_name "
                . "from member_card_change as mcc left join member_card as mc on mcc.card_id=mc.card_id left join dealer on mc.`dealer_id`=dealer.dealer_id"
                . " where mc.card_no=".$card_no;        
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
            'itemCount' =>$pages->itemCount ,
            'currentPage' => $pages->currentPage,
            'pageSize' => $pages->pageSize,
            'model' => $model,
        );
    }

}
