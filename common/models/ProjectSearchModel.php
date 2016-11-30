<?php

/**
 * This is the model class for table "{{project_search}}".
 *
 * The followings are the available columns in table '{{project_search}}':
 * @property string $id
 * @property integer $type
 * @property string $project_field
 * @property string $url_param
 * @property string $name
 * @property string $eq
 * @property string $gte
 * @property string $lte
 * @property integer $order
 * @property integer $is_effect
 */
class ProjectSearchModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_search}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('project_field, url_param, name', 'required'),
				array('type, order, is_effect', 'numerical', 'integerOnly'=>true),
				array('project_field, url_param, name', 'length', 'max'=>25),
				array('eq, gte, lte', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('id, type, project_field, url_param, name, eq, gte, lte, order, is_effect', 'safe', 'on'=>'search'),
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
				'type' => '1委托，0非委托',
				'project_field' => 'Project Field',
				'url_param' => 'Url Param',
				'name' => 'Name',
				'eq' => 'Eq',
				'gte' => 'Gte',
				'lte' => 'Lte',
				'order' => '排序',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('project_field',$this->project_field,true);
		$criteria->compare('url_param',$this->url_param,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('eq',$this->eq,true);
		$criteria->compare('gte',$this->gte,true);
		$criteria->compare('lte',$this->lte,true);
		$criteria->compare('order',$this->order);
		$criteria->compare('is_effect',$this->is_effect);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectSearchModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getSearchLists($type=1)
	{
		$lists = ProjectSearchModel::model()->findAll(array(
						'order'=>'`order` asc',
						'condition'=>'is_effect=1',
				));
		$field = $param = array();
		foreach($lists as $obj)
		{
			$project_field = $obj['project_field'];
			$url_param = $obj['url_param'];
			if(!isset($field[$project_field]))$field[$project_field] = array();
			$field[$project_field][] = $obj;

			if(!isset($param[$url_param]))$param[$url_param] = array();
			$param[$url_param] = $obj;
		}
		return array("project_field"=>$field,"url_param"=>$param);
	}

	public static function getWhere($type,$lists_param,$url_params,$price_from,$price_to,$area_from,$area_to)
	{
		$where = array();
		$where['type'] = $type;

		if(array_filter($lists_param))
		{
			foreach($lists_param as $k=>$name)
			{
				if(isset($url_params[$name]))
				{
					$info = $url_params[$name];
					if($info['project_field'] == 'attributes_id')
					{
						$where[$info['project_field']][] = $info['eq'];
					}elseif($info['eq'])
					{
						$where[$info['project_field']] = $info['eq'];
					}else{
						$where[$info['project_field']] = array(
								"gte" => $info['gte'],
								"lte" => $info['lte'],
								"eq" => $info['eq']
						);
					}
					if($info['project_field'] == "type")
					{
						$where['type'] = $info['eq'];
					}

				}else{
					unset($lists_param[$k]);
				}
			}
		}

		if($price_from>0 || $price_to>0)
		{
			$where['price']['gte'] = $price_from;
			$where['price']['lte'] = $price_to;
			$where['price']['eq'] = 0;
		}
		if($area_from>0 || $area_to>0)
		{
			$where['floor_area']['gte'] = $area_from;
			$where['floor_area']['lte'] = $area_to;
			$where['floor_area']['eq'] = 0;
		}
		if(!isset($where['status']))
		{
			$where['status'] = ProjectModel::STATUS_SUCCESS;
		}


		return $where;
	}
}
