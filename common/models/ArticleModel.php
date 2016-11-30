<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $cate_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $add_admin_id
 * @property string $rel_url
 * @property integer $update_admin_id
 * @property integer $click_count
 * @property integer $sort
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_description
 * @property string $summary
 * @property integer $is_hot
 * @property string $image
 * @property string $wap_image
 * @property integer $is_top
 * @property integer $is_effect
 */
class ArticleModel extends CActiveRecord
{
	public static $signalPage = array(1,2,3,4,16);//单页面
	public static $skills='(9,10)';//招贤纳士
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article}}';
	}

	const    ARTICLE_TYPE_HELP = 1;//帮助文章
	const    ARTICLE_TYPE_COMMON = 0;//普通文章
	const    ARTICLE_TYPE_AFFICHE = 2;//公告文章
	const    ARTICLE_TYPE_SYSTEM = 3;//系统文章
	const    ARTICLE_TYPE_DOC = 4;//文档文章
	const    TYPE_ARTICLE_TEAM = 6;//合作伙伴
	const    TYPE_ARTICLE_ABOUT = 8;//帮助文档
	const    TYPE_ARTICLE_CATE = 8;//帮助文档


//	/**
//	 * 合作伙伴列表
//	 */
//	public function teamLists(){
//       $team_list=ArticleModel::model()->findAll(array(
//		  'order'=>'sort desc',
//		   'condition'=>'is_effect=1 and cate_id=6'
//	   ));
//		return array('lists'=>$team_list);
//	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('title, content, cate_id, sort, summary, is_hot, is_effect', 'required'),
				array('cate_id, created_at, updated_at, add_admin_id, update_admin_id, click_count, sort, is_hot, is_top, is_effect', 'numerical', 'integerOnly'=>true),
				array('title, rel_url, image, wap_image', 'length', 'max'=>255),
				array('seo_title, seo_keyword, seo_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('id, title, content, cate_id, created_at, updated_at, add_admin_id, rel_url, update_admin_id, click_count, sort, seo_title, seo_keyword, seo_description, summary, is_hot, image, wap_image, is_top, is_effect', 'safe', 'on'=>'search'),
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
				'addAdmin'=>array(self::BELONGS_TO,'AdminModel','add_admin_id'),
				'upAdmin'=>array(self::BELONGS_TO,'AdminModel','update_admin_id'),
				'category'=>array(self::BELONGS_TO,'ArticleCategoryModel','cate_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'title' => 'Title',
				'content' => 'Content',
				'cate_id' => 'Cate',
				'created_at' => 'Created At',
				'updated_at' => 'Updated At',
				'add_admin_id' => 'Add Admin',
				'rel_url' => 'Rel Url',
				'update_admin_id' => 'Update Admin',
				'click_count' => 'Click Count',
				'sort' => 'Sort',
				'seo_title' => 'Seo Title',
				'seo_keyword' => 'Seo Keyword',
				'seo_description' => 'Seo Description',
				'summary' => 'Summary',
				'is_hot' => 'Is Hot',
				'image' => 'Image',
				'wap_image' => 'Wap Image',
				'is_top' => 'Is Top',
				'is_effect' => 'Is Effect',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('cate_id',$this->cate_id);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('add_admin_id',$this->add_admin_id);
		$criteria->compare('rel_url',$this->rel_url,true);
		$criteria->compare('update_admin_id',$this->update_admin_id);
		$criteria->compare('click_count',$this->click_count);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('seo_keyword',$this->seo_keyword,true);
		$criteria->compare('seo_description',$this->seo_description,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('is_hot',$this->is_hot);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('wap_image',$this->wap_image,true);
		$criteria->compare('is_top',$this->is_top);
		$criteria->compare('is_effect',$this->is_effect);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}