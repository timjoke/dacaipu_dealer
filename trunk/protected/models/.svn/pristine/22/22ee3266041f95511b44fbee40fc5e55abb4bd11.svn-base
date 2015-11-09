<?php

/**
 * This is the model class for table "partner_entity_relat".
 *
 * The followings are the available columns in table 'partner_entity_relat':
 * @property string $relat_id
 * @property string $entity_id
 * @property integer $entity_type
 * @property string $dealer_id
 * @property integer $partner_id
 * @property string $partner_entity_id
 */
class PartnerEntityRelat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'partner_entity_relat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('partner_entity_id', 'required'),
			array('entity_type, partner_id', 'numerical', 'integerOnly'=>true),
			array('entity_id, partner_entity_id', 'length', 'max'=>50),
			array('dealer_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('relat_id, entity_id, entity_type, dealer_id, partner_id, partner_entity_id', 'safe', 'on'=>'search'),
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
			'relat_id' => '关联id',
			'entity_id' => '实体id',
			'entity_type' => '实体类别：
            1 菜品类别；
            2 菜品；
            3 桌台；',
			'dealer_id' => '商家id',
			'partner_id' => '合作商id',
                    'partner_entity_id' => '合作商系统实体id',
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

		$criteria->compare('relat_id',$this->relat_id,true);
		$criteria->compare('entity_id',$this->entity_id,true);
		$criteria->compare('entity_type',$this->entity_type);
		$criteria->compare('dealer_id',$this->dealer_id,true);
		$criteria->compare('partner_id',$this->partner_id);
                $criteria->compare('partner_entity_id',$this->partner_entity_id,true);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PartnerEntityRelat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
