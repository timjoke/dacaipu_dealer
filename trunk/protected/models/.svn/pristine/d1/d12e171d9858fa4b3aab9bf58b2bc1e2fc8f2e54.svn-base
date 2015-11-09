<?php

/**
 * This is the model class for table "partner_dealer".
 *
 * The followings are the available columns in table 'partner_dealer':
 * @property string $pd_id
 * @property string $dealer_id
 * @property integer $partner_id
 */
class PartnerDealer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'partner_dealer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partner_id', 'numerical', 'integerOnly'=>true),
			array('dealer_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pd_id, dealer_id, partner_id', 'safe', 'on'=>'search'),
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
			'pd_id' => '授权id',
			'dealer_id' => '商家id',
			'partner_id' => '合作商id',
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

		$criteria=new CDbCriteria;

		$criteria->compare('pd_id',$this->pd_id,true);
		$criteria->compare('dealer_id',$this->dealer_id,true);
		$criteria->compare('partner_id',$this->partner_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PartnerDealer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取商家授权key
     * @param type $dealer_id
     * @param type $partner_key
     * @return type
     */
    public function getDealerPartnerKey($dealer_id, $partner_key)
    {
        $sql = 'SELECT pd.*,p.* FROM partner_dealer AS pd 
                LEFT JOIN partner as p 
                ON pd.partner_id = p.partner_id
                WHERE pd.dealer_id = ?
                AND p.partner_key = ?';


        $attr = array($dealer_id, $partner_key);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();
        
        //$obj = busUlitity::arrayToObject($ary);
        
        //$obj2 = busUlitity::arrayToObject($ary[0]);
        return count($ary) > 0 ? busUlitity::arrayToObject($ary[0]) : null;
    }

    /**
     * 获取授权id所授权给的所有商家
     * @param type $partner_id
     * @return type
     */
    public function GetPartnerDealerByPartnerId($partner_id)
    {
        $sql = 'SELECT * FROM partner_dealer WHERE partner_id=?';
        $attr = array($partner_id);
        $conn = Yii::app()->db;
        $cmd = $conn ->createCommand($sql);
        $reader = $cmd -> query($attr);
        $ary = $reader->readAll(); 
        return $ary;   
    }
}
