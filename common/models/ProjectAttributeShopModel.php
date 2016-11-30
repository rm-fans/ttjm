<?php

/**
 * This is the model class for table "{{project_attribute_shop}}".
 *
 * The followings are the available columns in table '{{project_attribute_shop}}':
 * @property integer $project_id
 * @property string $shop_num
 * @property string $floor_height
 * @property integer $user_from
 * @property integer $features_type
 */
class ProjectAttributeShopModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_attribute_shop}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id', 'required'),
			array('project_id, user_from, features_type', 'numerical', 'integerOnly'=>true),
			array('shop_num, floor_height', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('project_id, shop_num, floor_height, user_from, features_type', 'safe', 'on'=>'search'),
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
			'project_id' => 'Project',
			'shop_num' => '总户数',
			'floor_height' => '层高',
			'user_from' => '客流人群:1学生2旅游3居民',
			'features_type' => '商铺特征1:不可餐饮2不可分割3可餐饮4可分割',
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

		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('shop_num',$this->shop_num,true);
		$criteria->compare('floor_height',$this->floor_height,true);
		$criteria->compare('user_from',$this->user_from);
		$criteria->compare('features_type',$this->features_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectAttributeShopModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
