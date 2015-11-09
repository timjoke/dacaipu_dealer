<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property string $news_id
 * @property integer $news_category
 * @property string $news_title
 * @property string $news_content
 * @property string $dealer_id
 * @property string $create_time
 */
class News extends CActiveRecord
{

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('create_time', 'required'),
			array('news_category', 'numerical', 'integerOnly'=>true),
			array('news_title', 'length', 'max'=>100),
			array('news_content', 'length', 'max'=>4000),
			array('dealer_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('news_id, news_category, news_title, news_content, dealer_id,create_time', 'safe', 'on'=>'search'),
		);
	}
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'news';
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
			'news_id' => '资讯id',
			'news_category' => '资讯类别',
			'news_title' => '资讯标题',
			'news_content' => '资讯内容',
			'dealer_id' => '所属商家',
                    'create_time' => '创建时间',

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

        $criteria->compare('news_id', $this->news_id, true);
        $criteria->compare('news_category', $this->news_category);
        $criteria->compare('news_title', $this->news_title, true);
        $criteria->compare('news_content', $this->news_content, true);
        $criteria->compare('dealer_id', $this->dealer_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取咨询列表
     * @param type $dealer_id
     * @return \News
     */
    public function getNews($dealer_id)
    {
        $news = $this->findAllBySql("select news_title from news where news_category=2 and "
                . " dealer_id=:dealer_id order by news_id desc limit 0,2 ", array(':dealer_id' => $dealer_id));
        if (empty($news))
        {
            $news = array();
        }
        return $news;
    }

    /**
     * 获取当前商家当前分类下的资讯数量
     * @param type $dealer_id 商家
     * @param type $news_category 资讯分类id
     * @return type
     */
    public function getCountNews($dealer_id, $news_category)
    {
        $sql = 'SELECT
	Count(news.news_id)
FROM
	news
WHERE
	news.dealer_id = :dealer_id
AND news.news_category = :news_category';
        $conn = Yii::app()->db;
        $cmd = $conn->createCommand($sql);
        $obj = $cmd->queryScalar(array(':dealer_id' => $dealer_id, ':news_category' => $news_category));
        return $obj;
    }

    public function getDealerNews($dealer_id) {
        $news= $this->findAllBySql("select news_id,news_title,news_content,create_time from news where news_category=2 and "
                . " dealer_id=:dealer_id order by news_id desc ",array(':dealer_id'=>$dealer_id)); 
//        $new=$this->findAll(array('condition'=>'dealer_id=:dealer_id',
//    'params'=>array(':dealer_id'=>$dealer_id),'order'=>'news_id DESC'));  
        if(empty($news))
        {  
            $news=array();
        }
        return $news;
    }
    
}
