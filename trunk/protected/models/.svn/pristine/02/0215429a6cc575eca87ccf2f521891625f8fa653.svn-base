<?php

/**
 * This is the model class for table "dish_category_relation".
 *
 * The followings are the available columns in table 'dish_category_relation':
 * @property string $dr_id
 * @property string $dish_id
 * @property string $category_id
 */
class DishCategoryRelation extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dish_category_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dish_id, category_id', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('dr_id, dish_id, category_id', 'safe', 'on' => 'search'),
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
            'dr_id' => '关联id',
            'dish_id' => '菜品id',
            'category_id' => '类别id',
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

        $criteria->compare('dr_id', $this->dr_id, true);
        $criteria->compare('dish_id', $this->dish_id, true);
        $criteria->compare('category_id', $this->category_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DishCategoryRelation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 
     * @param type $dealer_id
     * @param type $dish_id
     * @param type $disn_category_name
     */
    public static function AddOrUpdateDishCategory($dealer_id, $dish_id, $disn_category_name)
    {
        $dish_category = DishCategory::model()->find('category_name=:category_name AND dealer_id=:dealer_id', array(':category_name' => $disn_category_name, ':dealer_id' => $dealer_id));
        $db = Yii::app()->db;
        if (isset($dish_category))
        {
            $is_exist = False;
            $relas = DishCategoryRelation::model()->findAll('dish_id=:dish_id', array(':dish_id' => $dish_id));
            foreach ($relas as $rel)
            {
                if ($rel->category_id == $dish_category->category_id)
                {
                    $is_exist = True;
                    continue;
                }
                else
                {
                    $rel->delete();
                }
            }

            //insert
            if ($is_exist === False)
            {
                $category_relation = new DishCategoryRelation();
                $category_relation->category_id = $dish_category->category_id;
                $category_relation->dish_id = $dish_id;
                $category_relation->save();
            }

//            $category_relation = DishCategoryRelation::model()->find('dish_id=:dish_id AND category_id=:category_id', 
//                    array(':dish_id' => $dish_id,
//                ':category_id' => $dish_category->category_id));
//            if (!isset($category_relation))
//            {
//                $category_relation = new DishCategoryRelation();
//                $category_relation->category_id = $dish_category->category_id;
//                $category_relation->dish_id = $dish_id;
//                $category_relation->save();
//                
//            }
        }
        else
        {
            $db->createCommand()->insert('dish_category', array(
                'category_name' => $disn_category_name,
                'category_status' => DISH_CATEGORY_STATUS_ONLINE,
                'dealer_id' => $dealer_id,
                'category_parent_id' => '-1',
            ));

            $dish_category_id = $db->lastInsertID;

            $category_relation = new DishCategoryRelation();
            $category_relation->category_id = $dish_category_id;
            $category_relation->dish_id = $dish_id;
            $category_relation->save();
        }
    }

    /**
     * 获取菜品类别
     * @param type $dish_id
     * @return type
     */
    public function getDishCategoryBydishid($dish_id)
    {
        $sql = 'SELECT dcr.category_id,dc.category_name FROM dish_category_relation as dcr'
                . ' LEFT JOIN dish_category as dc'
                . ' ON dcr.category_id=dc.category_id'
                . ' WHERE dcr.dish_id=:dish_id';

        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam(':dish_id', $dish_id);
        $reader = $cmd->query();
        $ary = $reader->readAll();

        return $ary;
    }

}
