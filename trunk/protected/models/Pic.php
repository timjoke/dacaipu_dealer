<?php

/**
 * This is the model class for table "pic".
 *
 * The followings are the available columns in table 'pic':
 * @property string $pic_id
 * @property string $entity_id
 * @property integer $pic_type
 * @property string $pic_url
 */
class Pic extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pic_type', 'numerical', 'integerOnly'=>true),
			array('entity_id', 'length', 'max'=>20),
			array('pic_url', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pic_id, entity_id, pic_type, pic_url', 'safe', 'on'=>'search'),
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
			'pic_id' => '图片id',
			'entity_id' => '实体id',
			'pic_type' => '图片类型：
            1 商家logo；
            2 菜品图片；',
			'pic_url' => '图片路径',
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

		$criteria->compare('pic_id',$this->pic_id,true);
		$criteria->compare('entity_id',$this->entity_id,true);
		$criteria->compare('pic_type',$this->pic_type);
		$criteria->compare('pic_url',$this->pic_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    
    /**
     * 获得商家logo路径
     * @param int 商家id
     * @return string
     */
    public function getDealerLogo($dealer_id)
    {
        return $this->getByType(PIC_TYPE_DEALER_LOGO,$dealer_id);
    }
    
    /**
     * 获得商家logo路径
     * @param int 商家id
     * @return string
     */
    public function getByType($pic_type,$entity_id)
    {
        $cache_key = CACHE_KEY_PIC_TYPE_PREFIX.$pic_type.'__'.$entity_id;
        $pic = Yii::app()->cache->get($cache_key);
        if($pic === false)
        {
            $pic = $this->findByAttributes(array('pic_type'=>$pic_type,'entity_id'=>$entity_id));
            Yii::app()->cache->add($cache_key, $pic);
        }
        
        return isset($pic) ? $pic->pic_url : '';
    }
    
    /**
     * 获得菜品logo路径
     * @param int 商家id
     * @return string
     */
    public function getDishLogo($dish_id)
    {
        return $this->getByType(PIC_TYPE_DISH_IMG,$dish_id);
    }
    
    /**
     * 获得商家banner图片
     * @param type $dealer_id
     * @return type
     */
    public function getDealerBanner($dealer_id)
    {
        return $this->getByType(PIC_TYPE_DEALER_BANNER, $dealer_id);
    }
    
    /**
     * 获得商家微信页banner图片
     * @param type $dealer_id
     * @return type
     */
    public function getWXPic($dealer_id)
    {
        return $this->getByType(PIC_TYPE_WX_DEALER_BANNER, $dealer_id);
    }
    
    
}
