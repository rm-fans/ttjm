<?php

/**
 * This is the model class for table "{{project_attribute}}".
 *
 * The followings are the available columns in table '{{project_attribute}}':
 * @property string $id
 * @property integer $project_id
 * @property integer $attr_id
 * @property string $attr_value
 */
class ProjectAttributeModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attr_value', 'required'),
			array('project_id, attr_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_id, attr_id, attr_value', 'safe', 'on'=>'search'),
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
				'project'=> array(self::BELONGS_TO,'ProjectModel','id'),
				'attribute'=>array(self::BELONGS_TO,'AttributeModel','attr_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'project_id' => 'Project',
			'attr_id' => 'Attr',
			'attr_value' => 'Attr Value',
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
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('attr_id',$this->attr_id);
		$criteria->compare('attr_value',$this->attr_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function objArrayToArray($objArr)
	{
		$arrs = array();

		if(is_array($objArr)){
			foreach ($objArr as $val){
				if(isset($val->attr_id) && $val->attr_id && isset($val->attr_value) && $val->attr_value){
					$arrs[$val->attr_id] = $val->attr_value;
				}
			}
		}

		return $arrs;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectAttributeModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);

	}

	/**
	 * 获取某资产扩展属性
	 * @param $project_id
	 */
	public static function getProjectInfo($project_id)
	{
		$lists = ProjectAttributeModel::model()->with('attribute')->findAll("project_id = :project_id",array(":project_id"=>$project_id));
		$result = array();
		foreach($lists as $obj)
		{
			$attr = $obj->attribute;
			$arr = array(
					"value" => $obj['attr_value'],
					"input_type"  => $attr['input_type'],
					'checked' => array(),
					'lists' => array(),
			);
			//多列文本显示
			if(in_array($attr['input_type'],AttributeModel::$need_values))
			{
				$arr['lists'] = AttributeModel::parseValue($attr['values']);
				$arr['checked'] =explode(',',$obj['attr_value']);
			}

			$result[$attr['group_id']][$attr['name']]=$arr;

		}
		return $result;
	}
}
