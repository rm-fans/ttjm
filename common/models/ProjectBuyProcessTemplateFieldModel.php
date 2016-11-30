<?php

/**
 * This is the model class for table "{{project_buy_process_template_field}}".
 *
 * The followings are the available columns in table '{{project_buy_process_template_field}}':
 * @property integer $id
 * @property integer $buy_process_template_id
 * @property string $name
 * @property integer $type
 * @property string $content
 * @property integer $sort
 */
class ProjectBuyProcessTemplateFieldModel extends CActiveRecord
{
	const TYPE_TEXTAREA = 1;
	const TYPE_IMAGE = 2;
	const TYPE_FILE = 3;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_buy_process_template_field}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('buy_process_template_id, type, sort', 'numerical', 'integerOnly'=>true),
				array('name', 'length', 'max'=>150),
				array('pc_content, wap_content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('id, buy_process_template_id, name, type, pc_content, wap_content, sort', 'safe', 'on'=>'search'),
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
			'buy_process_template'=>array(self::BELONGS_TO,'ProjectBuyProcessTemplateModel','buy_process_template_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'buy_process_template_id' => 'Buy Process Template',
				'name' => '标题',
				'type' => '字段类型1:富文本2:图片3:文件',
				'pc_content' => '内容',
				'wap_content' => 'Wap Content',
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
		$criteria->compare('buy_process_template_id',$this->buy_process_template_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('pc_content',$this->pc_content,true);
		$criteria->compare('wap_content',$this->wap_content,true);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectBuyProcessTemplateFieldModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
