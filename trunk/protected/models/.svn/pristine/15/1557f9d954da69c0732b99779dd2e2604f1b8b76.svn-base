<?php

/**
 * This is the model class for table "dealer_function".
 *
 * The followings are the available columns in table 'dealer_function':
 * @property string $df_id
 * @property string $dealer_id
 * @property string $function_id
 */
class DealerFunction extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dealer_function';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dealer_id, function_id', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('df_id, dealer_id, function_id', 'safe', 'on' => 'search'),
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
            'df_id' => '对应id',
            'dealer_id' => '商家id',
            'function_id' => '功能id',
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

        $criteria->compare('df_id', $this->df_id, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('function_id', $this->function_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DealerFunction the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getFunidBydealerid($dealer_id)
    {
        $sql = 'SELECT dealer_function.function_id  FROM dealer_function WHERE 	dealer_function.dealer_id = :dealer_id';
        $ary = $this->findAllBySql($sql, array(':dealer_id' => $dealer_id));
        $ret_ary = array();
        foreach ($ary as $value)
        {
            array_push($ret_ary, $value->function_id);
        }
        return $ret_ary;
    }

}
