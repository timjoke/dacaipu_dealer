<?php

/**
 * This is the model class for table "dish_category".
 *
 * The followings are the available columns in table 'dish_category':
 * @property string $category_id
 * @property string $category_name
 * @property integer $category_status
 * @property string $dealer_id
 * @property string $category_parent_id
 * @property integer $dish_category_order
 *
 * The followings are the available model relations:
 * @property Dealer $dealer
 */
class DishCategory extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dish_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_status,dish_category_order', 'numerical', 'integerOnly' => true),
            array('category_name', 'length', 'max' => 50),
            array('dealer_id, category_parent_id', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('category_id, category_name, category_status, dealer_id, category_parent_id,dish_category_order', 'safe', 'on' => 'search'),
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
            'dealer' => array(self::BELONGS_TO, 'Dealer', 'dealer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'category_id' => '类别id',
            'category_name' => '类别名称',
            'category_status' => '状态',
            'dealer_id' => '所属商家',
            'category_parent_id' => '隶属类别',
            'dish_category_order'=>'排序'
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

        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('category_name', $this->category_name, true);
        $criteria->compare('category_status', $this->category_status);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('category_parent_id', $this->category_parent_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DishCategory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /*
     * 获取当前餐厅的所有菜品类别
     * @param $dealerid 当前餐厅id
     */

    public function getAllDishCategoryByDealer($dealerid)
    {
        $paras = array();
        $paras['dealer_id'] = $dealerid;
        $dishCat = DishCategory::model()->findAllByAttributes(array('dealer_id' => $dealerid),array('order'=>'dish_category_order DESC'));
        return $dishCat;
    }

    /**
     * 获取单个菜品类别对象，用于单个菜品类别的展示
     * @param type $id 
     * @return type
     */
    public function getSingleDishCategory($id)
    {
        $sql = 'SELECT c.`category_id`,c.`category_name`, c.`category_status`, p.`category_name` as pcategory_name,'
                . ' d.dealer_name FROM `dish_category` as c left join dealer as d on c.dealer_id = d.dealer_id '
                . ' left outer join dish_category as p on p.category_id=c.category_parent_id WHERE c.category_id=' . $id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $objarr = $cmd->queryRow();
        $obj = busUlitity::arrayToObject($objarr);
        return $obj;
    }

    public function getDealerDishCategory($dealer_id)
    {
        $sql = 'SELECT
dish_category.category_id,
dish_category.category_name,
dish_category.category_status,
dish_cat_parent.category_name AS categ_parent_name
FROM
dish_category
Left outer join dish_category AS dish_cat_parent ON dish_category.category_parent_id = dish_cat_parent.category_id
WHERE dish_category.dealer_id=' . $dealer_id . ' order by dish_category.dish_category_order DESC,dish_category.category_status desc';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'category_id';
        return $obj;
    }

    /**
     * 获得商家在线并有菜品的菜品类别
     * @param type $dealer_id
     */
    public function getOnlineDishCategory($dealer_id)
    {
        //$cache_key = CACHE_KEY_Online_DishCategories_list_prefix . $dealer_id;
        //$list = Yii::app()->cache->get($cache_key);
        $list =false;
        if ($list === false)
        {
            $sql = "select dc.* from dish_category dc 
            inner join (
                    select count(1) as dish_count,category_id 
                    from dish_category_relation group by category_id) dcr 
            ON dc.category_id=dcr.category_id and dcr.dish_count > 0
            left join (
                            select dcr.category_id from dish_category_relation dcr 
                            inner join dish d on dcr.dish_id=d.dish_id and d.dish_status = 1 
                            group by dcr.category_id) tmp
            on dc.category_id = tmp.category_id
            where  dc.category_status=:category_status and dealer_id=:dealer_id order by dc.dish_category_order DESC,dc.category_id asc";
            $p = array(':category_status' => DISH_CATEGORY_STATUS_ONLINE,
                ':dealer_id' => $dealer_id);

            $cmd = $this->dbConnection->createCommand($sql);
            $list = $cmd->query($p)->readAll();
            if (isset($list))
            {
                $list = busUlitity::arrayToObject($list);
            }
            //Yii::app()->cache->add($cache_key, $list);
        }
        return $list;
    }

    /**
     * 获得商家在线并有菜品的菜品类别
     * @param type $dealer_id
     */
    public function getOnlineDishCategoryFromDB($dealer_id)
    {
        $cache_key = CACHE_KEY_Online_DishCategories_list_prefix . $dealer_id;
            $sql = "select dc.* from dish_category dc 
            inner join (
                    select count(1) as dish_count,category_id 
                    from dish_category_relation group by category_id) dcr 
            ON dc.category_id=dcr.category_id and dcr.dish_count > 0
            left join (
                            select dcr.category_id from dish_category_relation dcr 
                            inner join dish d on dcr.dish_id=d.dish_id and d.dish_status = 1 
                            group by dcr.category_id) tmp
            on dc.category_id = tmp.category_id
            where  dc.category_status=:category_status and dealer_id=:dealer_id order by dc.dish_category_order DESC,dc.category_id asc";
            $p = array(':category_status' => DISH_CATEGORY_STATUS_ONLINE,
                ':dealer_id' => $dealer_id);

            $cmd = $this->dbConnection->createCommand($sql);
            $list = $cmd->query($p)->readAll();
            if (isset($list))
            {
                $list = busUlitity::arrayToObject($list);
            }

        return $list;
    }
    
    /**
     * 获得商家在线并有菜品的非外带菜品类别
     * @param type $dealer_id
     * @return type
     */
    public function getOnlineEatinDishCategory($dealer_id)
    {
        $sql = "select dc.* from dish_category dc 
            inner join (
                    select count(1) as dish_count,category_id 
                    from dish_category_relation group by category_id) dcr 
            ON dc.category_id=dcr.category_id and dcr.dish_count > 0
            left join (
                            select dcr.category_id from dish_category_relation dcr 
                            inner join dish d on dcr.dish_id=d.dish_id and d.dish_status = 1 and d.dish_display_type!=1
                            group by dcr.category_id) tmp
            on dc.category_id = tmp.category_id
            where  dc.category_status=:category_status and dealer_id=:dealer_id order by dc.dish_category_order DESC,dc.category_id asc";
        $p = array(':category_status' => DISH_CATEGORY_STATUS_ONLINE,
            ':dealer_id' => $dealer_id);
        $cmd = $this->dbConnection->createCommand($sql);
        return $cmd->query($p)->readAll();
    }

    public function saveOrUpdateNameByPk($id, $name, $dealer_id)
    {
        $model = null;
        if (!empty($id))
        {
            //$this->category_id = $id;
            $model = $this->findByPk($id);
        }
        else
        {
            $model = new DishCategory();
        }
        $model->category_name = $name;
        $model->category_status = 1;
        $model->dealer_id = $dealer_id;
        $model->category_parent_id = -1;
        $model->save();
    }

}
