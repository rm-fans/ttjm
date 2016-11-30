<?php

/**
 * This is the model class for table "{{project_attribute_house}}".
 *
 * The followings are the available columns in table '{{project_attribute_house}}':
 * @property string $id
 * @property integer $project_id
 * @property string $plot_ratio
 * @property string $green_rate
 * @property integer $washroom
 */
class ProjectAttributeHouseModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_attribute_house}}';
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
				array('project_id, washroom', 'numerical', 'integerOnly'=>true),
				array('plot_ratio, green_rate', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('id, project_id, plot_ratio, green_rate, washroom', 'safe', 'on'=>'search'),
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
				'project_id' => 'Project',
				'plot_ratio' => '容积率',
				'green_rate' => '绿化率',
				'washroom' => '卫生间',
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
		$criteria->compare('plot_ratio',$this->plot_ratio,true);
		$criteria->compare('green_rate',$this->green_rate,true);
		$criteria->compare('washroom',$this->washroom);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectAttributeHouseModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
