<?php

/**
 * This is the model class for table "{{user_project_buy}}".
 *
 * The followings are the available columns in table '{{user_project_buy}}':
 * @property integer $id
 * @property integer $uid
 * @property integer $project_id
 * @property integer $introducer_uid
 * @property integer $created_at
 * @property integer $is_effect
 * @property integer $service_uid
 * @property integer $is_cash
 */
class UserProjectBuyModel extends CActiveRecord
{
	CONST IS_DELETE = 0;//已删除
	CONST IS_EFFECT = 1;//有效
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_project_buy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('uid, project_id, introducer_uid, created_at, is_effect, service_uid,is_cash', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('id, uid, project_id, introducer_uid, created_at, is_effect, service_uid, is_cash', 'safe', 'on'=>'search'),
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
				'project'=>array(self::BELONGS_TO,'ProjectModel','project_id'),
				'service'=>array(self::BELONGS_TO,'UserProfileModel','service_uid'),
				'user'=>array(self::BELONGS_TO,'UserProfileModel','uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'uid' => 'Uid',
				'project_id' => 'Project',
				'introducer_uid' => '介绍人UID',
				'created_at' => 'Created At',
				'is_effect' => '有效性标识',
				'service_uid' => '服务商UID',
				'is_cash' => '是否变现',
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
		$criteria->compare('uid',$this->uid);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('introducer_uid',$this->introducer_uid);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('is_effect',$this->is_effect);
		$criteria->compare('service_uid',$this->service_uid);
		$criteria->compare('is_cash',$this->is_cash);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserProjectBuyModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 用户购买到的资产
	 * @param $uid
	 */
	public static function getLists($uid,$id,$is_effect,$page=0,$page_size=10)
	{
		$page = $page>1 ? $page-1:$page;
		$criteria=new CDbCriteria;
		$criteria->with=array('project','service','user');
		$criteria->addCondition("t.uid=:uid");
		$criteria->params[":uid"] = $uid;
		if($is_effect !== Null)
		{
			$criteria->addCondition("t.is_effect=:is_effect");
			$criteria->params[":is_effect"] = $is_effect;
		}
		if($id !== Null)
		{
			$criteria->addCondition("t.id=:id");
			$criteria->params[":id"] = $id;
		}
		$criteria->order = "t.created_at desc";
		$dataBuy=new CActiveDataProvider('UserProjectBuyModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageVar'=>'page',
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$result = $dataBuy->getData();
		return array("lists"=>$result,"criteria"=>$criteria,"pages"=>$dataBuy->getPagination());
	}
}
