<?php

/**
 * This is the model class for table "{{asset_attributes}}".
 *
 * The followings are the available columns in table '{{asset_attributes}}':
 * @property string $id
 * @property string $name
 * @property string $short_name
 * @property integer $is_effect
 */
class AssetAttributesModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{asset_attributes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('is_effect', 'numerical', 'integerOnly'=>true),
				array('name', 'length', 'max'=>25),
				array('short_name', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, is_effect', 'safe', 'on'=>'search'),
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
				'short_name'=>'short_name',
				'is_effect' => '是否显示',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->name,true);
		$criteria->compare('is_effect',$this->is_effect);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssetAttributesModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * id对应名称所有
	 * @return array
	 */
	public static function getIdToName($is_hidden=array())
	{
		$lists = AssetAttributesModel::model()->findAll("is_effect=1");
		$result = array();
		foreach($lists as $obj)
		{
			if(!in_array($obj['id'],$is_hidden))
			{
				$result[$obj['id']] = $obj['name'];
			}
		}
		return $result;
	}
}