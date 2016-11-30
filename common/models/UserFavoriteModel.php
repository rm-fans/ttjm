<?php

/**
 * This is the model class for table "{{user_favorite}}".
 *
 * The followings are the available columns in table '{{user_favorite}}':
 * @property integer $id
 * @property integer $uid
 * @property string $username
 * @property string $keep_type
 * @property integer $origin_id
 * @property string $origin_name
 * @property integer $created_at
 */
class UserFavoriteModel extends CActiveRecord
{
	const  KEEP_TYPE_PROJECT = "project";
	const  KEEP_TYPE_BROKER = "broker";
	const  KEEP_TYPE_SERVICE = "service";
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_favorite}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, username', 'required'),
			array('uid, origin_id, created_at', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>15),
			array('keep_type', 'length', 'max'=>7),
			array('origin_name', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, username, keep_type, origin_id, origin_name, created_at', 'safe', 'on'=>'search'),
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
				'project'=> array(self::BELONGS_TO,'ProjectModel','origin_id'),
				'broker'=> array(self::BELONGS_TO,'UserBrokerOrganizationModel','origin_id'),
				'service'=> array(self::BELONGS_TO,'UserServiceOrganizationModel','origin_id'),
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
			'username' => 'Username',
			'keep_type' => 'Keep Type',
			'origin_id' => '源对象ID',
			'origin_name' => '源对象名',
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
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('keep_type',$this->keep_type,true);
		$criteria->compare('origin_id',$this->origin_id);
		$criteria->compare('origin_name',$this->origin_name,true);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserFavoriteModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 用户收藏的资产
	 * type 是否委托资产
	 */
	public static function getProjectLists($uid,$type=null,$page,$page_size,$order='')
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("t.uid=:uid");
		$criteria->params[":uid"] = $uid;
		if ($order) {
			$criteria->order = $order;
		} else {
			$criteria->order = "t.created_at desc";
		}
		if($type !== null)
		{
			$criteria->addCondition("project.type=:type");
			$criteria->params[":type"] = $type;
		}
		$criteria->addCondition("t.keep_type='".self::KEEP_TYPE_PROJECT."'");
		$criteria->with = array("project");
		$dataProvider=new CActiveDataProvider('UserFavoriteModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageVar'=>'page',
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$result = $dataProvider->getData();
		if($result)
		{
			foreach($result as $obj)
			{
				$obj['project']['diff_day'] = 0;
				if($obj['project']['disposition_end_at']>0 && $obj['project']['status'] == ProjectModel::STATUS_SUCCESS)
				{
					$day = Utils::timediff(time(),$obj['project']['disposition_end_at'],false,true);
					$obj['project']['diff_day'] = (int)$day['day'];
				}
				if(empty($obj['project']['image']))
				{
					$obj['project']['image'] = Yii::app()->params['pub_default_img'];
				}
				$area = explode(" ",$obj['project']['area']);
				$area = array_filter($area);
				$obj['project']['last_area'] = end($area);
			}
		}
		return array("lists"=>$result,"criteria"=>$criteria,"pages"=>$dataProvider->getPagination());
	}

	/**
	 * 添加收藏
	 * @param $uid
	 * @param $origin_id
	 * @param $keep_type
	 * @return UserFavoriteModel|static
	 */
	public static function create($uid,$origin_id,$keep_type)
	{
		$userInfo = UserProfileModel::model()->findByPk($uid);
		$criteria=new CDbCriteria;
		$criteria->addCondition("uid = :uid");
		$criteria->params[":uid"] = $uid;
		$criteria->addCondition("origin_id = :origin_id");
		$criteria->params[":origin_id"] = $origin_id;
		$criteria->addCondition("keep_type = :keep_type");
		$criteria->params[":keep_type"] = $keep_type;
		$f = UserFavoriteModel::model()->find($criteria);
		if(!$f)
		{
			$name = '';
			if(self::KEEP_TYPE_PROJECT == $keep_type){
				$info = ProjectModel::model()->findByPk($origin_id);
				$name = $info['title'];
			}elseif(self::KEEP_TYPE_BROKER == $keep_type){
				$info = UserBrokerOrganizationModel::model()->findByPk($origin_id);
				$name = $info['name'];
			}elseif(self::KEEP_TYPE_SERVICE == $keep_type){
				$info = UserServiceOrganizationModel::model()->findByPk($origin_id);
				$name = $info['name'];
			}
			if($name){
				$f = new UserFavoriteModel();
				$f->uid = $uid;
				$f->username = $userInfo->username;
				$f->keep_type = $keep_type;
				$f->origin_id = $origin_id;
				$f->origin_name = $name;
				$f->created_at = time();
				$f->save();
			}
		}
		return $f ? true : false;
	}

	/**
	 * 取消收藏
	 * @param $uid
	 * @param $origin_id
	 * @param $keep_type
	 * @return bool
	 */
	public static function cancel($uid, $origin_id, $keep_type)
	{
		$info = UserFavoriteModel::model()->find('uid=:uid and origin_id=:origin_id and keep_type=:keep_type',
			array(':uid' => $uid, ':origin_id' => $origin_id, ':keep_type' => $keep_type));
		if ($info) {
			$info->delete();
			return true;
		}
		return false;
	}

	/**
	 * 当前源是否收藏
	 * @param $uid
	 * @param $origin_id
	 * @param $keep_type
	 * @return bool
	 */
	public static function hasFavorite($uid, $origin_id, $keep_type)
	{
		$model = $uid ? UserFavoriteModel::model()->find('uid=:uid and origin_id=:origin_id and keep_type=:keep_type',
			array(':uid' => $uid, ':origin_id' => $origin_id, ':keep_type' => $keep_type)) : '';
		return $model ? true : false;
	}

	/**
	 * 列表页判断哪些是被用户收藏了的源
	 * @param $uid
	 * @param array $origin_ids
	 * @param $keep_type
	 * @return array
	 */
	public static function userFavoriteIds($uid,$origin_ids=array(),$keep_type)
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("uid = :uid");
		$criteria->params[":uid"] = $uid;
		$criteria->addInCondition("origin_id",$origin_ids);
		$criteria->addCondition("keep_type = :keep_type");
		$criteria->params[":keep_type"] = $keep_type;
		$lists = UserFavoriteModel::model()->findAll($criteria);
		$result = array();
		if($lists)
		{
			foreach($lists as $obj)
			{
				$result[] = $obj['origin_id'];
			}
		}
		return $result;
	}
}
