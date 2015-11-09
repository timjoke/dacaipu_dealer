<?php

/**
 * This is the model class for table "dish".
 *
 * The followings are the available columns in table 'dish':
 * @property string $dish_id
 * @property string $dish_name
 * @property string $dish_price
 * @property integer $dish_recommend
 * @property string $dish_package_fee
 * @property integer $dish_is_vaget
 * @property integer $dish_spicy_level
 * @property string $dish_introduction
 * @property string $dealer_id
 * @property integer $dish_status
 * @property string $dish_createtime
 * @property integer $dish_mode
 * @property string $dish_child_count
 * @property integer $dish_display_type
 * @property string $dish_modifytime
 * @property string $dish_quanpin
 * @property string $dish_jianpin
 * @property integer $dish_count
 * @property integer $alert_count
 * @property string $dish_unit
 * @property integer $is_presell
 * @property integer $dish_order
 */
class Dish extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dish';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dish_createtime, dish_modifytime', 'required'),
            array('dish_recommend, dish_is_vaget, dish_spicy_level, dish_status, dish_mode, dish_display_type, dish_count, alert_count, is_presell,dish_order', 'numerical', 'integerOnly' => true),
            array('dish_name, dish_jianpin', 'length', 'max' => 50),
            array('dish_price, dish_package_fee', 'length', 'max' => 10),
            array('dish_introduction', 'length', 'max' => 8000),
            array('dealer_id, dish_child_count, dish_unit', 'length', 'max' => 20),
            array('dish_quanpin', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('dish_id, dish_name, dish_price, dish_recommend, dish_package_fee, dish_is_vaget, dish_spicy_level, dish_introduction, dealer_id, dish_status, dish_createtime, dish_mode, dish_child_count, dish_display_type, dish_modifytime, dish_quanpin, dish_jianpin, dish_count, alert_count, dish_unit, is_presell,dish_order', 'safe', 'on' => 'search'),
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
            'dish_id' => '菜品id',
            'dish_name' => '菜品名称',
            'dish_price' => '菜品价格',
            'dish_recommend' => '是否推荐',
            'dish_package_fee' => '打包费',
            'dish_is_vaget' => '是否素菜
            0 否；
            1 是；',
            'dish_spicy_level' => '辣度
            0 不辣；
            1 微辣；
            2 麻辣；
            3 辣；
            4 很辣；
            5 最辣',
            'dish_introduction' => '简介',
            'dealer_id' => '所属商家',
            'dish_status' => '状态
            0 已下架
            1 已上架',
            'dish_createtime' => 'Dish Createtime',
            'dish_mode' => '菜品模式
            1 单菜售卖；
            2 套餐组合售卖；
            3 单菜或分组都可售卖；',
            'dish_child_count' => '所属套餐菜品id',
            'dish_display_type' => '菜品显示类别：
            0：外卖+堂食；
            1：外卖；
            2：堂食；',
            'dish_modifytime' => 'Dish Modifytime',
            'dish_quanpin' => '名称全拼',
            'dish_jianpin' => '名称简拼',
            'dish_count' => '菜品数量',
            'alert_count' => '提醒数量',
            'dish_unit' => '菜品单位',
            'is_presell' => '是否预售',
            'dish_order'=>'排序'
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

        $criteria->compare('dish_id', $this->dish_id, true);
        $criteria->compare('dish_name', $this->dish_name, true);
        $criteria->compare('dish_price', $this->dish_price, true);
        $criteria->compare('dish_recommend', $this->dish_recommend);
        $criteria->compare('dish_package_fee', $this->dish_package_fee, true);
        $criteria->compare('dish_is_vaget', $this->dish_is_vaget);
        $criteria->compare('dish_spicy_level', $this->dish_spicy_level);
        $criteria->compare('dish_introduction', $this->dish_introduction, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);
        $criteria->compare('dish_status', $this->dish_status);
        $criteria->compare('dish_createtime', $this->dish_createtime, true);
        $criteria->compare('dish_mode', $this->dish_mode);
        $criteria->compare('dish_child_count', $this->dish_child_count, true);
        $criteria->compare('dish_display_type', $this->dish_display_type);
        $criteria->compare('dish_modifytime', $this->dish_modifytime, true);
        $criteria->compare('dish_quanpin', $this->dish_quanpin, true);
        $criteria->compare('dish_jianpin', $this->dish_jianpin, true);
        $criteria->compare('dish_count', $this->dish_count);
        $criteria->compare('alert_count', $this->alert_count);
        $criteria->compare('dish_unit', $this->dish_unit, true);
        $criteria->compare('is_presell', $this->is_presell);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Dish the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 
     * 获取当前商家的菜品列表
     * @param type $dealer_id
     * @return typ
     */
    public function getOnlineDishes($dealer_id, $no_display_type)
    {
        $sql = 'select d.*,
            dc.category_id,dc.category_name,dc.category_parent_id,
            p.pic_url,
            dov.over_id,dov.over_date
            from dish d 
            left join dish_category_relation dcr on d.dish_id=dcr.dish_id 
            left join dish_category dc on dcr.category_id=dc.category_id
            left join dealer dr on d.dealer_id=dr.dealer_id
            left join (select pic.* from pic inner join(
            select max(pic_id) pic_id,entity_id from pic  where pic_type=2 group by entity_id) pictmp on pic.pic_id=pictmp.pic_id) p on d.dish_id=p.entity_id and p.pic_type=2 
            left join dish_over dov on d.dish_id=dov.dish_id and dov.over_date = curdate()
            /* inner join (select max(dr_id) dr_id,dish_id from dish_category_relation group by dish_id) dcr_dst on dcr.dr_id=dcr_dst.dr_id */
            WHERE d.dealer_id=? AND dr.dealer_status=? AND dc.category_status=?
            AND d.dish_status=? AND dish_display_type!=? ORDER BY d.dish_order DESC,dc.category_id ASC,d.dish_quanpin ASC';


        $attr = array($dealer_id, DEALER_STATUS_ONLINE, DISH_CATEGORY_STATUS_ONLINE, DISH_STATUS_ONLINE, $no_display_type);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();

        return busUlitity::arrayToObject($ary);
    }

    /**
     * 
     * 获取当前商家的菜品列表
     * @param type $dealer_id
     * @return typ
     */
    public function getAllDishes($dealer_id)
    {
        $sql = 'select d.dish_name,
            d.dish_price,
            d.dish_package_fee,
            dc.category_name,
            d.dish_introduction 
            from dish d 
            left join dish_category_relation dcr on d.dish_id=dcr.dish_id 
            left join dish_category dc on dcr.category_id=dc.category_id
            WHERE d.dealer_id=?
            ORDER BY d.dish_order DESC,d.dish_name ASC';

        $attr = array($dealer_id);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();

        return busUlitity::arrayToObject($ary);
    }

    /**
     * 获得外卖上架的菜品
     * @param type $dealer_id
     * @return type
     */
    public function getTakeoutOnlineDishes($dealer_id)
    {
        //Yii::app()->cache->flush();
        //$dishes_cache_key = CACHE_KEY_Takeout_Online_Dish_list_prefix . $dealer_id;
        //$list = Yii::app()->cache->get($dishes_cache_key);
        //if ($list === false)
        //{
            //取非堂食类菜品
            $list = $this->getOnlineDishes($dealer_id, DISH_DISPLAY_TYPE_EATIN);
            //Yii::app()->cache->add($dishes_cache_key, $list);
        //}

        return $list;
    }

    /**
     * 获得堂食上架的菜品
     * @param type $dealer_id
     * @return type
     */
    public function getEatinOnlineDishes($dealer_id)
    {
        $dishes_cache_key = CACHE_KEY_Eatin_Online_Dish_list_prefix . $dealer_id;
        $list = Yii::app()->cache->get($dishes_cache_key);
        if ($list === false)
        {
            //取非堂食类菜品
            $list = $this->getOnlineDishes($dealer_id, DISH_DISPLAY_TYPE_TAKOUT);
            Yii::app()->cache->add($dishes_cache_key, $list);
        }

        return $list;
    }

    /**
     * 获取当前餐厅的所有菜品，不包含当前菜品（$dishId），用于选择“所属套餐菜品”
     * @param type $dealerId 当前商家id
     * @param int $dishId 不包含的菜品id
     */
    public static function getAllDishByDealer($dealerId, $dishId)
    {
        if (!isset($dishId))
        {
            $dishId = 0;
        }
        $dealerId = intval($dealerId);
        $dishId = intval($dishId);

        $dishlst = Dish::model()->findAll(array('select' => 'dish_id,dish_name',
            'condition' => 'dealer_id=:dealer_id and dish_id<>:dish_id',
            'params' => array(':dealer_id' => $dealerId, ':dish_id' => $dishId),
            'order'=>'dish_order DESC'));
        $result = array(0 => '请选择');
        foreach ($dishlst as &$value)
        {
            $result[$value->dish_id] = $value->dish_name;
        }
        return $result;
    }

    /**
     * 获取当前餐厅的所有套餐菜品
     * @param type $dealerId 当前商家id
     */
    public function getAllPackageDishByDealer($dealerId)
    {
        $dealerId = intval($dealerId);

        $dishlst = Dish::model()->findAll(array('select' => 'dish_id,dish_name,dish_child_count',
            'condition' => 'dealer_id=:dealer_id and (dish_mode=2 or dish_mode=3)',
            'params' => array(':dealer_id' => $dealerId),
            'order'=>'dish_order DESC'));
        $result = array(0 => '-请选择-');
        foreach ($dishlst as &$value)
        {
            $result[$value->dish_id] = $value->dish_name . "-" . $value->dish_child_count;
        }
        return $result;
    }

    /**
     * 获取当前餐厅的所有非套餐菜品
     * @param type $dealerId 当前商家id
     */
    public function getAllSingleDishByDealer($dealerId)
    {
        $dealerId = intval($dealerId);

        $dishlst = Dish::model()->findAll(array('select' => 'dish_id,dish_name',
            'condition' => 'dealer_id=:dealer_id and (dish_mode=1 or dish_mode=3)',
            'params' => array(':dealer_id' => $dealerId)));
        //$result = array(0 => '请选择');
        foreach ($dishlst as &$value)
        {
            $result[$value->dish_id] = $value->dish_name;
        }
        return $result;
    }

    /**
     * 获取菜品信息
     * @param type $id
     */
    public function getSingleDish($id)
    {
        $sql = 'SELECT
	dish.dish_id,
	dish.dish_name,
	dish.dish_price,
	dish.dish_recommend,
	dish.dish_package_fee,
	dish.dish_is_vaget,
	dish.dish_spicy_level,
	dish.dish_introduction,
	dish.dish_status,
	dish.dish_createtime,
	dish.dish_mode,
	dealer.dealer_name,
	dishParent.dish_name AS dish_name_parent
FROM
	dish
INNER JOIN dealer ON dish.dealer_id = dealer.dealer_id
LEFT OUTER JOIN dish AS dishParent ON dish.dish_child_count = dishParent.dish_id
INNER JOIN dish_category_relation ON dish.dish_id = dish_category_relation.dish_id
INNER JOIN dish_category ON dish_category_relation.category_id = dish_category.category_id WHERE dish.dish_id=' . $id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);

        $objarr = $cmd->queryRow();
        $obj = busUlitity::arrayToObject($objarr);
        return $obj;
    }

    /**
     * 获取一个类别下的已上架的菜品的个数
     * @param type $category_id 类别id
     * @return int
     */
    public function getDishCountByCatId($category_id)
    {
        $sql = 'SELECT
	Count(dish.dish_id)
FROM
	dish
INNER JOIN dish_category_relation ON dish.dish_id = dish_category_relation.dish_id
WHERE
	dish.dish_status = 1
AND dish_category_relation.category_id = ' . $category_id;
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        return $cmd->queryScalar();
    }

    /**
     * 获取菜品列表信息，包含菜品图片
     * @return type
     */
    public function getDish($dealer_id, $category_id = 0, $dish_name)
    {
        $sql = 'SELECT
        DISTINCT dish.dish_id,
	pic.pic_url,
	dish.dish_name,
	dish.dish_price,
	dish.dish_recommend,
	dish.dish_package_fee,
	dish.dish_is_vaget,
	dish.dish_spicy_level,
	dish.dish_introduction,
	dish.dealer_id,
	dish.dish_status,
	dish.dish_createtime,
	dish.dish_mode,
	dish.dish_child_count,
	dish.dish_modifytime,
        dish_over.over_id
        FROM  dish 
        LEFT OUTER JOIN pic ON dish.dish_id = pic.entity_id and pic.pic_type = ' . PIC_TYPE_DISH_IMG .
                ' LEFT JOIN dish_category_relation dcr ON dish.dish_id=dcr.dish_id
                  LEFT OUTER JOIN dish_over ON dish.dish_id = dish_over.dish_id and dish_over.over_date=\'' . date("Y-m-d") . '\'
        WHERE
	 dish.dealer_id= :dealer_id';
        if (isset($dish_name) && strlen($dish_name) > 0)
        {
            $sql.=' AND dish.dish_name like \'%' . $dish_name . '%\'';
        }
        if ($category_id != 0)
        {
            $sql .= ' AND dcr.category_id = :category_id';
        }
        $sql .= ' order by dish.dish_order DESC,dish.dish_status desc';

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $cmd->bindParam(':dealer_id', $dealer_id);

        if ($category_id != 0)
        {
            $cmd->bindParam(':category_id', $category_id);
        }

        $obj = $cmd->queryAll();
        $obj = new CArrayDataProvider($obj);
        $obj->keyField = 'dish_id';
        return $obj;
    }

    /**
     * 新增菜品
     * @param type $dish 菜品
     * @param type $dealer_id 商家id
     * @param type $partner 合作商
     */
    public function createNewDish($dish, $dealer_id, $partner)
    {
        $model = new Dish();
        $model->dish_name = $dish->name;
        $model->dish_price = $dish->price;
        $model->dish_introduction = $dish->description;
        $model->dish_package_fee = $dish->package_price;
        $model->dish_spicy_level = $dish->cap_level;
        $model->dish_is_vaget = $dish->is_veget;
        $model->dish_recommend = $dish->is_recommend;
        $model->dish_display_type = $dish->dish_type;
        $model->dish_status = DISH_STATUS_ONLINE;
        $model->dealer_id = $dealer_id;
        $model->dish_createtime = date('Y-m-d H:i:s', time());
        $model->dish_modifytime = date('Y-m-d H:i:s', time());

        $model->insert();

        //$conn->lastInsertID
        $new_id = $model->primaryKey;

        //先通过参数中商家的菜品类别id找到对应的实体关系
        $cate_relat = PartnerEntityRelat::model()->findByAttributes(
                array(
                    'dealer_id' => $dealer_id,
                    'entity_type' => PARTNER_ENTITY_TYPE_DISH_CATEGORY,
                    'partner_id' => $partner->partner_id,
                    'partner_entity_id' => $dish->category_id,
        ));
        if (!empty($cate_relat))
        {
            //如果找到商家实体的对应关系
            //新增菜品类别关系
            $model = new DishCategoryRelation();
            $model->dish_id = $new_id;
            $model->category_id = $cate_relat->entity_id;
            $model->insert();
        }

        //新增菜品图片
        $model = new Pic();
        $model->entity_id = $new_id;
        $model->pic_type = PIC_TYPE_DISH_IMG;
        if (!empty($dish->pic_url))
        {
            $model->pic_url = $dish->pic_url;
        }
        else
        {
            $model->pic_url = base64_decode($dish->pic . $dish->pic_ext);
        }
        $model->insert();

        //新增合作商实体关联
        $model = new PartnerEntityRelat();
        $model->entity_id = $new_id;
        $model->entity_type = PARTNER_ENTITY_TYPE_DISH;
        $model->dealer_id = $dealer_id;
        $model->partner_id = $partner->partner_id;
        $model->partner_entity_id = $dish->dish_id;
        $model->insert();
    }

    /**
     * 根据订单号获取预定桌台信息
     * @param type $order_id 订单号
     * @return type
     */
    public function getDishsByDealerId($dealer_id)
    {
        $sql = 'SELECT *
            FROM dish
            WHERE dealer_id = ?';


        $attr = array($dealer_id);

        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();

        return $ary;
    }

    /**
     *  获取套餐下的所有菜品
     * @param type $id
     * @return type
     */
    public function GetPackageChildByid($id)
    {
        $sql = 'SELECT * FROM dish_relation WHERE dish_parent_id=?';
        $attr = array($id);
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $reader = $cmd->query($attr);
        $ary = $reader->readAll();
        return $ary;
    }

}
