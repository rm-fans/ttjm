<?php

/**
 * This is the model class for table "{{project_check_log}}".
 *
 * The followings are the available columns in table '{{project_check_log}}':
 * @property string $id
 * @property string $project_id
 * @property string $reason
 * @property integer $status
 * @property string $admin_id
 * @property string $admin_name
 * @property string $created_at
 */
class ProjectCheckLogModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_check_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('project_id, admin_id, created_at', 'length', 'max'=>10),
			array('reason', 'length', 'max'=>50),
			array('admin_name', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_id, reason, status, admin_id, admin_name, created_at', 'safe', 'on'=>'search'),
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
			'reason' => '原因',
			'status' => 'Status',
			'admin_id' => 'Admin',
			'admin_name' => '操作用户',
			'created_at' => '操作时间',
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
		$criteria->compare('project_id',$this->project_id,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('admin_id',$this->admin_id,true);
		$criteria->compare('admin_name',$this->admin_name,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectCheckLogModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function add($project_id,$reason,$status)
	{
		$obj = new ProjectCheckLogModel();
		$obj->project_id = $project_id;
		$obj->admin_id = Yii::app()->user->id;
		$obj->admin_name = Yii::app()->user->name;
		$obj->status = $status;
		$obj->reason = $reason;
		$obj->created_at = time();
		$obj->save();
	}
}
