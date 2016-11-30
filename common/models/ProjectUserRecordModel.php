<?php

/**
 * This is the model class for table "{{project_user_record}}".
 *
 * The followings are the available columns in table '{{project_user_record}}':
 * @property integer $id
 * @property string $projectId
 * @property integer $uid
 * @property string $username
 * @property string $project_id
 * @property string $project_title
 * @property integer $service_uid
 * @property integer $type
 * @property integer $state
 * @property integer $is_seller_interviewer
 * @property string $phone
 * @property string $name
 * @property integer $c_interviewer_count
 * @property string $c_interviewer_username
 * @property integer $c_interviewed_at
 * @property integer $s_interviewer_count
 * @property string $s_interviewer_username
 * @property integer $s_interviewed_at
 * @property string $desc
 * @property integer $created_at
 * @property integer $broker_uid
 * @property integer $is_effect
 */
class ProjectUserRecordModel extends CActiveRecord
{
	CONST TYPE_OWN_BUY = 1;//自己购买意愿
	CONST TYPE_BROKER_BUY = 2;//介绍购买(用于经纪人)
    CONST TYPE_OWN_CASH = 3;//变现
	CONST TYPE_ENTRUST_PUB = 4;//委托发布
	CONST STATE_CUSTOMER_CONTACT = 1;//客服联系中
	CONST STATE_CONTACTING = 2;//接触中
	CONST STATE_CONTACT_FAILURE = 3;//接触失败
	CONST STATE_DEAL = 4;//成交
	public  $project_lists;

	public static $project_state=array(
		'1'=>'联系中',
		'2'=>'进行中',
		'3'=>'已终止',
		'4'=>'已成交',
	);
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_user_record}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('uid, service_uid, type, state, is_seller_interviewer, c_interviewer_count, c_interviewed_at, s_interviewer_count, s_interviewed_at, created_at,broker_uid', 'numerical', 'integerOnly'=>true),
				array('projectId, username, c_interviewer_username, s_interviewer_username', 'length', 'max'=>15),
				array('project_id', 'length', 'max'=>10),
				array('project_title', 'length', 'max'=>150),
				array('phone', 'length', 'max'=>30),
				array('name', 'length', 'max'=>32),
				array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('id, projectId, uid, username, project_id, project_title, service_uid, type, state, is_seller_interviewer, phone, name, c_interviewer_count, c_interviewer_username, c_interviewed_at, broker_uid,s_interviewer_count, s_interviewer_username, s_interviewed_at, desc, created_at, is_effect', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'projectId' => '资产编号',
				'uid' => 'Uid',
				'username' => 'Username',
				'project_id' => 'Project',
				'project_title' => 'Project Title',
				'service_uid' => '服务商uid',
				'type' => '类型1：自己购买意愿2：介绍购买(用于经纪人)3:我要变现4:委托发布',
				'state' => '客户状态：1客服联系中  2接触中 3接触失败 4成交',
				'is_seller_interviewer' => '是否推送给销售1是0否',
				'phone' => 'Phone',
				'name' => '联系人',
				'c_interviewer_count' => '电话拜访次数',
				'c_interviewer_username' => '最后电话联系人',
				'c_interviewed_at' => '最后电话联系时间',
				's_interviewer_count' => '销售联系次数',
				's_interviewer_username' => '销售最后联系人',
				's_interviewed_at' => '销售最后联系时间',
				'desc' => '意向描述',
				'created_at' => 'Created At',
				'broker_uid'=>'broker Uid',
				'is_effect'=>'is Effect'
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
		$criteria->compare('projectId',$this->projectId,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('project_id',$this->project_id,true);
		$criteria->compare('project_title',$this->project_title,true);
		$criteria->compare('service_uid',$this->service_uid);
		$criteria->compare('type',$this->type);
		$criteria->compare('state',$this->state);
		$criteria->compare('is_seller_interviewer',$this->is_seller_interviewer);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('c_interviewer_count',$this->c_interviewer_count);
		$criteria->compare('c_interviewer_username',$this->c_interviewer_username,true);
		$criteria->compare('c_interviewed_at',$this->c_interviewed_at);
		$criteria->compare('s_interviewer_count',$this->s_interviewer_count);
		$criteria->compare('s_interviewer_username',$this->s_interviewer_username,true);
		$criteria->compare('s_interviewed_at',$this->s_interviewed_at);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('broker_uid',$this->broker_uid);
		$criteria->compare('is_effect',$this->is_effect);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectUserRecordModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 服务过我的律师所
	 * @param $uid
	 * @param int $page
	 * @param int $service_page_size 律师列表页显示条数
	 * @param int $project_page_size 二级资产显示条数
	 * @return mixed
	 */
	public static function userLawyerLists($uid,$page=0,$service_page_size=20,$project_page_size=4)
	{
		/*//获取project_id
		$db = Yii::app()->db;
		$sql = "select * from {{project_user_record}} as r
				left join {{user_profile}} as p on p.uid=r.service_uid
				WHERE r.uid={$uid} and  r.is_effect=1
				GROUP BY r.service_uid ";
		$sql .= " limit {$page},{$service_page_size}";
		$lists = $db->createCommand($sql)->queryAll();
		//律师列表
		foreach($lists as $key =>$obj)
		{
			//服务过我的资产
			$lists[$key]["project_lists"] = self::serviceProjectLists($uid,$obj['service_uid'],0,$project_page_size);
		}
		return $lists;*/
		$record=new CDbCriteria;
		$record->with=array('service');
		$record->addCondition("t.uid=:uid");
		$record->addCondition("t.projectId!=''");
		$record->params[":uid"] = $uid;
		$record->group = 't.service_uid';
		$recordData=new CActiveDataProvider('ProjectUserRecordModel',array(
				'criteria'=>$record,
				'pagination'=>array(
						'pageVar'=>'page',
						'pageSize'=>$service_page_size,
						'currentPage'=>$page,
				)) );
		$resultObj = $recordData->getData();
		$result = json_decode(CJSON::encode($resultObj),TRUE);
		foreach($result as $key =>$obj)
		{
			$result[$key]["service"] = json_decode(CJSON::encode($resultObj[$key]->service),TRUE);
			$result[$key]["service"]['detail'] =  json_decode(CJSON::encode(UserServiceDetailModel::model()->findByPk($obj['service_uid'])),TRUE);
			//服务过我的资产
			$result[$key]["project_lists"] = self::serviceProjectLists($uid,$obj['service_uid'],0,$project_page_size);
		}
		return array("lists"=>$result,"record"=>$record,"pages"=>$recordData->getPagination());
	}

	/**
	 * 列表 内部调用
	 * @param $criteria
	 * @param $page
	 * @param $page_size
	 * @return array
	 */
	private static function getData(&$criteria, $page, $page_size)
	{
		$dataProvider = new CActiveDataProvider('ProjectUserRecordModel', array(
				'criteria' => $criteria,
				'pagination'=>array(
				
						'pageSize'=>$page_size,//设置分页条数以确定取出数据的条数
				),
		));
		$result = $dataProvider->getData();
		return array("lists" => $result, "criteria" => $criteria,"pages"=>$dataProvider->getPagination());
	}

	/**
	 * 资产列表
	 * @param $uid
	 * @param $page
	 * @param $page_size
	 * @return array
	 */

	public static function record_page($uid, $page, $page_size){
		$criteria = new CDbCriteria;
		$criteria->addCondition("uid=:uid");
		$criteria->params[":uid"] = $uid;
		return ProjectUserRecordModel::getData($criteria, $page, $page_size);

	}

	/**
	 * 我的律师 -资产加载更多
	 * @param $uid
	 * @param $service_uid
	 * @param $page
	 * @param $page_size
	 * @return array
	 */
	public static function serviceProjectLists($uid,$service_uid,$page,$page_size=10,$state=false)
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("t.uid=:uid");
		$criteria->params[":uid"] = $uid;
		$criteria->addCondition("t.service_uid=:service_uid");
		$criteria->addCondition("t.is_effect=1");
		if($state){
			if($state==1){
				$criteria->addInCondition('t.state', array(ProjectUserRecordModel::STATE_CUSTOMER_CONTACT, ProjectUserRecordModel::STATE_CONTACTING));
				//$criteria->addBetweenCondition('t.state', ProjectUserRecordModel::STATE_CUSTOMER_CONTACT, ProjectUserRecordModel::STATE_CONTACTING);
			}else{
				$criteria->addCondition("t.state=:state");
				$criteria->params[":state"] = $state;
			}
		}

		$criteria->params[":service_uid"] = $service_uid;
		$criteria->with = array("project","service");

		$dataProvider=new CActiveDataProvider('ProjectUserRecordModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$resultObj = $dataProvider->getData();

		$result = json_decode(CJSON::encode($resultObj),TRUE);
		foreach($result as $key =>$obj)
		{
			if($resultObj[$key]->project!=null){
				$result[$key]["service"] = json_decode(CJSON::encode($resultObj[$key]->service),TRUE);
				$result[$key]["project"] =  json_decode(CJSON::encode($resultObj[$key]->project),TRUE);
				$buy_type = ProjectBuyMethodModel::model()->find('id=:id', array(':id' => $result[$key]['project']['buy_method_id']));
				$asset_attributes = AssetAttributesModel::model()->find('id=:id', array(':id' => $result[$key]['project']['attributes_id']));
				$result[$key]['tag'] =array($asset_attributes->short_name,$buy_type->short_name);
				if($result[$key]['project']['type']==0 && $result[$key]["project"]['is_grab_data']==0) {
					$result[$key]['project']['uptag']='自主';
				}
				if($result[$key]['project']['type']==1 && $result[$key]["project"]['is_grab_data']==0){
					$result[$key]['project']['uptag']= Utils::formatPriceNumber($result[$key]["project"]['discount_rate']).'折';
				}
				if($result[$key]['project']['is_grab_data'] == 1 ){
					$result[$key]['project']['uptag']= '资源';
				}
			}else{
				unset($result[$key]);
			}

		}
		return array("lists"=>$result,"criteria"=>$criteria,"pages"=>$dataProvider->getPagination());
	}

	/**
	 * 我介绍的购买人
	 * @param $uid
	 * @param $page
	 * @param $page_size
	 * @return array
	 */
	public static function introduction($uid,$page,$page_size=10,$user_page_size,$status=false)
	{
		$page = $page>1 ? $page-1:0;
		$criteria=new CDbCriteria;
		$criteria->addCondition("t.broker_uid=:broker_uid");
		$criteria->params[":broker_uid"] = $uid;
		if($status){
			if($status==2){
				$criteria->addCondition("project.status=:status");
				$criteria->params[":status"] = ProjectModel::STATUS_SUCCESS;
			}elseif($status==5){
				$criteria->addCondition("project.status=:status");
				$criteria->params[":status"] = ProjectModel::STATUS_TRADE_SUCCESS;
			}
		}
		$criteria->group = 't.project_id';
		$criteria->with = array("project","service");
		$dataProvider=new CActiveDataProvider('ProjectUserRecordModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
					    'pageVar'=>'page',
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$resultObj = $dataProvider->getData();

		$result = json_decode(CJSON::encode($resultObj),TRUE);
		foreach($result as $key =>$obj)
		{
			$result[$key]["service"] = json_decode(CJSON::encode($resultObj[$key]->service),TRUE);
			$result[$key]["project"] =  json_decode(CJSON::encode($resultObj[$key]->project),TRUE);
			//介绍的购买人
			$result[$key]["user_lists"] = self::recordUser($uid,$resultObj[$key]->project->id,0,$user_page_size);
			$buy_type = ProjectBuyMethodModel::model()->find('id=:id', array(':id' => $result[$key]['project']['buy_method_id']));
			$asset_attributes = AssetAttributesModel::model()->find('id=:id', array(':id' => $result[$key]['project']['attributes_id']));
			$result[$key]['tag'] =array($asset_attributes->short_name,$buy_type->short_name);
			$result[$key]['estimate']=Utils::formatPriceNumber($result[$key]['project']['price'] * ($result[$key]['project']['introducer_buy_rate'] / 100) * ($result[$key]['project']['min_serve_rate'] / 100))." ~ ".Utils::formatPriceNumber($result[$key]['project']['price'] * ($result[$key]['project']['introducer_buy_rate'] / 100) * ($result[$key]['project']['max_serve_rate'] / 100));
			$result[$key]['count']=ProjectUserRecordModel::model()->count(array('condition' => 'project_id='.$result[$key]['project']['id'].' and broker_uid='.$uid));
		}

		return array("lists"=>$result,"criteria"=>$criteria,"pages"=>$dataProvider->getPagination());
	}

	/**
	 * 购买意向重写model方法
	 * @param $uid
	 * @param $page
	 * @param $page_size
	 * @return array
	 */
	public static function introduction_user_info($uid,$project_id,$page,$page_size=10,$user_page_size,$status=false)
	{
		$page = $page>1 ? $page-1:0;
		$criteria=new CDbCriteria;
		$criteria->addCondition("t.broker_uid=:broker_uid");
		$criteria->params[":broker_uid"] = $uid;
		$criteria->addCondition("t.project_id=:project_id");
		$criteria->params[":project_id"] = $project_id;
		if($status){
			if($status==2){
				$criteria->addCondition("project.status=:status");
				$criteria->params[":status"] = ProjectModel::STATUS_SUCCESS;
			}elseif($status==5){
				$criteria->addCondition("project.status=:status");
				$criteria->params[":status"] = ProjectModel::STATUS_TRADE_SUCCESS;
			}
		}
		$criteria->group = 't.project_id';
		$criteria->with = array("project","service");
		$dataProvider=new CActiveDataProvider('ProjectUserRecordModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageVar'=>'page',
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$resultObj = $dataProvider->getData();

		$result = json_decode(CJSON::encode($resultObj),TRUE);
		foreach($result as $key =>$obj)
		{
			$result[$key]["service"] = json_decode(CJSON::encode($resultObj[$key]->service),TRUE);
			$result[$key]["project"] =  json_decode(CJSON::encode($resultObj[$key]->project),TRUE);
			//介绍的购买人
			$result[$key]["user_lists"] = self::recordUser($uid,$resultObj[$key]->project->id,0,$user_page_size);
			$buy_type = ProjectBuyMethodModel::model()->find('id=:id', array(':id' => $result[$key]['project']['buy_method_id']));
			$asset_attributes = AssetAttributesModel::model()->find('id=:id', array(':id' => $result[$key]['project']['attributes_id']));
			$result[$key]['tag'] =array($asset_attributes->short_name,$buy_type->short_name);
			$result[$key]['estimate']=Utils::formatPriceNumber($result[$key]['project']['price'] * ($result[$key]['project']['introducer_buy_rate'] / 100) * ($result[$key]['project']['min_serve_rate'] / 100))." ~ ".Utils::formatPriceNumber($result[$key]['project']['price'] * ($result[$key]['project']['introducer_buy_rate'] / 100) * ($result[$key]['project']['max_serve_rate'] / 100));
			$result[$key]['count']=ProjectUserRecordModel::model()->count(array('condition' => 'project_id='.$result[$key]['project']['id'].' and broker_uid='.$uid));
		}

		return array("lists"=>$result,"criteria"=>$criteria,"pages"=>$dataProvider->getPagination());
	}

	/**
	 * 我介绍的购买人加载更多
	 * @param $uid
	 * @param $page
	 * @param $page_size
	 * @return array
	 */
	public static function recordUser($uid,$project_id,$page=0,$page_size=20)
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("t.broker_uid=:broker_uid");
		$criteria->params[":broker_uid"] = $uid;
		$criteria->addCondition("t.project_id=:project_id");
		$criteria->params[":project_id"] = $project_id;
		$criteria->order = 't.state DESC' ;//排序条件
		$dataProvider=new CActiveDataProvider('ProjectUserRecordModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$result = $dataProvider->getData();
		return array("lists"=>$result,"criteria"=>$criteria,"pages"=>$dataProvider->getPagination());
	}
	/**
	 * 数据录入
	 * @param $name
	 * @param $phone
	 * @param $uid
	 * @param $project_id
	 * @param $type
	 * @return int 1成功 -1保存失败 -2 已经提交过了 -3不能推荐自己(介绍人购买) -4不能意向购买自己的资产,-5不是发布中的资产
	 */
	public static function create($name, $phone, $uid, $project_id, $type)
	{
		$broker_uid = 0;
		$phone = Utils::encrypt($phone);
		$projectModel = ProjectModel::model()->findByPk($project_id);
		if($projectModel->status != ProjectModel::STATUS_SUCCESS)
			return -5;
		switch ($type) {
			case self::TYPE_BROKER_BUY:
				$broker_uid = $uid;
				$userInfo = UserProfileModel::model()->find('phone=:phone', array(':phone' => $phone));
				if(!empty($userInfo) && $uid==$userInfo->uid)
					return -3;
				break;
			case self::TYPE_OWN_BUY:
				$userInfo = UserProfileModel::model()->find('phone=:phone', array(':phone' => $phone));
				if(!empty($projectModel) && $projectModel->uid==$uid)
					return -4;
				break;
			default:
				$userInfo = UserProfileModel::model()->findByPk($uid);
				break;
		}
		$recordInfo = $userInfo ? ProjectUserRecordModel::model()->find('uid=:uid and project_id=:project_id and type=:type and phone=:phone', array(':uid' => $userInfo->uid, ':project_id' => $project_id, ':type' => $type, ':phone' => $phone)) :
			ProjectUserRecordModel::model()->find(' project_id=:project_id and type=:type and phone=:phone', array(':project_id' => $project_id, ':type' => $type, ':phone' => $phone));
		if ($recordInfo) {
			$status = -2;
		} else {
			$model = new ProjectUserRecordModel();
			$model->name = $name;
			$model->phone = $phone;
			$model->type = $type;
			$model->created_at = time();
			$model->project_id = $projectModel->id;
			$model->project_title = $projectModel->title;
			$model->projectId = $projectModel->projectId;
			$model->service_uid = $projectModel->service_uid;
			$model->broker_uid = $broker_uid;
			if ($userInfo) {
				$model->uid = $userInfo->uid;
				$model->username = $userInfo->username;
			}
			if ($model->save())
				$status = 1;
			else
				$status = -1;
		}
		return $status;
	}
	/**
	 * 模块调用规则
	 * @param int $dealCount 完成的N条
	 * @param int $contactingCount服务中的N条
	 */
	public static function getModelLists($contactingCount=0,$dealCount=0)
	{
		$criteria=new CDbCriteria;
		$criteria->limit = $contactingCount;
		$criteria->order = "t.created_at desc";
		$criteria->with = array("project","service");
		$criteria->addCondition("t.state=".ProjectUserRecordModel::STATE_CONTACTING);
		$service = ProjectUserRecordModel::model()->findAll($criteria);

		$criteria=new CDbCriteria;
		$criteria->limit = $dealCount;
		$criteria->order = "t.created_at desc";
		$criteria->with = array("project","service");
		$criteria->addCondition("t.state=".ProjectUserRecordModel::STATE_DEAL);
		$deal = ProjectUserRecordModel::model()->findAll($criteria);
		$result = array();
		foreach($service as $obj)
		{
			$result[$obj['created_at']] = array(
					"service_name" => $obj->service['username'],
					"project_title" => $obj->project["title"],
					"project_id" => $obj->project["id"],
					'service_uid' => $obj['service_uid'],
					"state" => $obj['state'],
			);
		}
		foreach($deal as $obj)
		{
			$result[$obj['created_at']] = array(
					"service_name" => $obj->service['username'],
					"project_title" => $obj->project["title"],
					"project_id" => $obj->project["id"],
					'service_uid' => $obj['service_uid'],
					"state" => $obj['state'],
			);
		}
		/*echo "<pre>";
		print_r($result);exit;*/
		ksort($result);
		return $result;
	}
}
