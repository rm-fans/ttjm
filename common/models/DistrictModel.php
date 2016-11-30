<?php

/**
 * This is the model class for table "{{district}}".
 *
 * The followings are the available columns in table '{{district}}':
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property integer $usetype
 * @property integer $upid
 * @property integer $displayorder
 * @property string $code
 * @property string $short_name
 */
class DistrictModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{district}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level, usetype, upid, displayorder', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('code', 'length', 'max'=>3),
			array('short_name', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, level, usetype, upid, displayorder, code,short_name', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'level' => 'Level',
			'usetype' => 'Usetype',
			'upid' => 'Upid',
			'displayorder' => 'Displayorder',
			'code' => 'Code',
			'short_name'=>'short_name'
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('usetype',$this->usetype);
		$criteria->compare('upid',$this->upid);
		$criteria->compare('displayorder',$this->displayorder);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('short_name',$this->short_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DistrictModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 根据城市名字获取数据详情
	 * @param $name
	 * @param int $type 搜索字段1：short_name 2：name(模糊搜索)
	 * @return array|mixed|null
	 */
	public static function getNameToInfo($name,$type=1)
	{
		$criteria=new CDbCriteria;
		if($type==1){
			$criteria->addCondition("short_name=:name");
			$criteria->params = array(':name'=>$name);
		}
		else
			$criteria->addSearchCondition("name",$name);
		$info = DistrictModel::model()->find($criteria);
		if(!$info)
		{
			$info = self::getNameToInfo("成都",$type);
		}
		return $info;
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return array
	 */
	public static function getParents($id, $data = array())
	{
		$model = DistrictModel::model()->findByPk($id)->attributes;
		switch ($model['level']) {
			case 1:
				$data['province'] = $model;
				break;
			case 2:
				$data['city'] = $model;
				break;
			case 3:
				$data['district'] = $model;
				break;
		}
		if ($model['upid'])
			return DistrictModel::getParents($model['upid'], $data);
		else
			return $data;
	}
}
