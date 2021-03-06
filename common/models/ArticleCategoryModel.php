<?php

/**
 * This is the model class for table "{{role_nav_group}}".
 *
 * The followings are the available columns in table '{{role_nav_group}}':
 * @property integer $id
 * @property string $name
 * @property integer $nav_id
 * @property string $icon
 * @property integer $is_delete
 * @property integer $is_effect
 * @property integer $sort
 */
class ArticleCategoryModel extends CActiveRecord
{
	const TYPE_DEFAULT = 0;//普通文章
	const TYPE_HELP = 1;//帮助文章
	const TYPE_AFFICHE = 2;//公告文章
	const TYPE_SYSTEM = 3;//系统文章
	const TYPE_FILE = 4;//文件文章
	const TYPE_HELP_ID = 8;//文件文章

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,brief, is_effect,type_id, sort', 'required'),
			array('pid, type_id, is_effect, sort', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title,brief, pid, is_effect,type_id, sort', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'title' => 'Title',
			'brief' => '简介',
			'pid' => '父分类',
			'type_id' => '类型',
			'is_effect' => 'Is Effect',
			'sort' => 'Sort',
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
		$criteria->compare('brief',$this->brief);
		$criteria->compare('pid',$this->pid,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('is_effect',$this->is_effect);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RoleNavGroupModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function DropDownList(){
		$criteria=new CDbCriteria;
		$dataProvider=new CActiveDataProvider('ArticleCategoryModel',array('criteria'=>$criteria->addColumnCondition(array('pid' => 0))));
		$products=$dataProvider->getData();
		$DropDown = array();
		foreach($products as $key=>$p){
			$criteria=new CDbCriteria;
			$chileProvider=new CActiveDataProvider('ArticleCategoryModel',array('criteria'=>$criteria->addColumnCondition(array('pid' => $p->id))));
			$chileproducts=$chileProvider->getData();
			array_push($DropDown,$p);
			if(isset($chileproducts)){
				foreach($chileproducts as $cp){
					$cp->title = '--->'.$cp->title;
					array_push($DropDown,$cp);
				}
			}
		}
		return $DropDown;
	}
	public static function AboutDownList(){
		$criteria=new CDbCriteria;
		$dataProvider=new CActiveDataProvider('ArticleCategoryModel',array('criteria'=>$criteria->addColumnCondition(array('id' =>16))));
		$products=$dataProvider->getData();
		$DropDown = array();
		foreach($products as $key=>$p){
			$criteria=new CDbCriteria;
			$chileProvider=new CActiveDataProvider('ArticleCategoryModel',array('criteria'=>$criteria->addColumnCondition(array('pid' => $p->id))));
			$chileproducts=$chileProvider->getData();
			array_push($DropDown,$p);
			if(isset($chileproducts)){
				foreach($chileproducts as $cp){
					$cp->title = '--->'.$cp->title;
					array_push($DropDown,$cp);
				}
			}
		}
		return $DropDown;
	}
}
