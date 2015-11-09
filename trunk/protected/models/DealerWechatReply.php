<?php

/**
 * This is the model class for table "dealer_wechat_reply".
 *
 * The followings are the available columns in table 'dealer_wechat_reply':
 * @property string $reply_id
 * @property string $dealer_id
 * @property integer $operat
 * @property string $keyword
 * @property string $content_id
 */
class DealerWechatReply extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dealer_wechat_reply';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('operat', 'numerical', 'integerOnly' => true),
            array('dealer_id, content_id', 'length', 'max' => 20),
            array('keyword', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('reply_id, dealer_id, operat, keyword, content_id', 'safe', 'on' => 'search'),
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
            'reply_id' => '回复id',
            'dealer_id' => '商家id',
            'operat' => '操作符：
            1 等于；
            2 包含；',
            'keyword' => '关键字',
            'content_id' => '回复内容',
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

        $criteria->compare('reply_id', $this->reply_id, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('operat', $this->operat);
        $criteria->compare('keyword', $this->keyword, true);
        $criteria->compare('content_id', $this->content_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DealerWechatReply the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取所有微信自动回复项
     * @param type $dealer_id
     * @return type
     */
    public function getDealerWechatReply($dealer_id)
    {
        $sql = 'select * from dealer_wechat_reply r '
                . 'left join dealer_wechat_reply_content c '
                . 'on r.content_id=c.content_id '
                . 'where r.dealer_id=:dealer_id';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $cmd->bindParam(':dealer_id', $dealer_id);
        $reader = $cmd->query();
        return $reader->readAll();
    }

}
