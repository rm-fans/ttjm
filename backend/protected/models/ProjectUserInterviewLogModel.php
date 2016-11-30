<?php

/**
 * This is the model class for table "{{project_user_interview_log}}".
 *
 * The followings are the available columns in table '{{project_user_interview_log}}':
 * @property integer $id
 * @property integer $project_user_record_id
 * @property integer $admin_uid
 * @property string $admin_username
 * @property integer $type
 * @property integer $interviewed_at
 * @property string $desc
 * @property integer $created_at
 */
class ProjectUserInterviewLogModel extends CActiveRecord
{
	CONST TYPE_CUSTOMER = 1;//客服联系
	CONST TYPE_SALESPERSON = 2;//销售联系
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_user_interview_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_user_record_id, admin_uid,interviewed_at,desc', 'required'),
			array('project_user_record_id, admin_uid, type, interviewed_at, created_at', 'numerical', 'integerOnly'=>true),
			array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_user_record_id, admin_uid,, type, interviewed_at, desc, created_at', 'safe', 'on'=>'search'),
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
				'admin'=>array(self::BELONGS_TO,'AdminModel','admin_uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'project_user_record_id' => 'Project User Record',
			'admin_uid' => 'Admin Uid',
			'type' => '联系类型1：客服联系 2：销售联系',
			'interviewed_at' => '联系时间',
			'desc' => '沟通内容',
			'created_at' => 'Created At',
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
		$criteria->compare('project_user_record_id',$this->project_user_record_id);
		$criteria->compare('admin_uid',$this->admin_uid);
		$criteria->compare('type',$this->type);
		$criteria->compare('interviewed_at',$this->interviewed_at);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectUserInterviewLogModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
