<?php

/**
 * This is the model class for table "{{user_service_detail}}".
 *
 * The followings are the available columns in table '{{user_service_detail}}':
 * @property integer $uid
 * @property integer $industry_id
 * @property integer $good_num
 * @property integer $good_stars
 * @property integer $service_times
 * @property integer $level
 * @property string $img_src
 * @property string $desc
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 */
class UserServiceDetailModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_service_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid', 'required'),
			array('uid, industry_id, good_num, good_stars, service_times, level', 'numerical', 'integerOnly'=>true),
			array('img_src', 'length', 'max'=>150),
			array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, industry_id, good_num, good_stars, service_times, level, img_src, desc, province_id, city_id, district_id', 'safe', 'on'=>'search'),
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
				'user_profile'=>array(self::BELONGS_TO,'UserProfileModel','uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'industry_id' => 'Industry',
			'good_num' => 'Good Num',
			'good_stars' => 'Good Stars',
			'service_times' => 'Service Times',
			'level' => 'Level',
			'img_src' => '上传头像',
			'desc' => 'Desc',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('industry_id',$this->industry_id);
		$criteria->compare('good_num',$this->good_num);
		$criteria->compare('good_stars',$this->good_stars);
		$criteria->compare('service_times',$this->service_times);
		$criteria->compare('level',$this->level);
		$criteria->compare('img_src',$this->img_src,true);
		$criteria->compare('desc',$this->desc,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserServiceDetailModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * 经纪人信息
	 * @param $uid
	 */
	public static function getInfo($uid)
	{
		$info = UserServiceDetailModel::model()->with("user_profile")->find("uid=:uid",array(":uid"=>$uid));
		return $info;
	}

	public static function serverUsers()
	{
		$server_obj = UserServiceDetailModel::model()->with('user_profile')->findAll();
		$server_users = array();
		foreach($server_obj as $obj)
		{
			$server_users[$obj['uid']] = $obj->user_profile['username'];
		}
		return $server_users;
	}

	/**
	 * 获取推荐服务商，不够条数取成都
	 * @param $city_id
	 * @param int $count
	 * @return array
	 */
	public static function recommend($city_id,$count=4){
		$data = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition("t.is_service=1 and t.city_id=:city_id");
		$criteria->params[":city_id"] = $city_id;
		$num = UserProfileModel::model()->count($criteria);
		if($num <$count )
		{	//默认成都服务商
			$criteria->params[":city_id"] = 385;
			$criteria->limit = $count-$num;
			$data = UserProfileModel::model()->with(array('user_service_detail','service_organization'))->findAll($criteria);
		}
		$criteria->params[":city_id"] = $city_id;
		$criteria->limit = $count;
		$list = UserProfileModel::model()->with(array('user_service_detail','service_organization'))->findAll($criteria);
		$s = array_merge($list,$data);
		$result = array();

		foreach(array_merge($list,$data) as $d){
			$d = array_merge($d->attributes,$d->user_service_detail->attributes,array('organization'=>$d->service_organization['attributes']));
			$d['identity_name'] = Utils::decrypt($d['identity_name']);
			$d['identity_card'] = Utils::decrypt($d['identity_card']);
			$result[]=$d;
		};
		return $result;
	}
	/**
	 * 刷新服务商星级
	 * @param $uid
	 */
	public static function updatastars($uid){
		$criteria = new CDbCriteria;
		$criteria->addCondition("t.uid=:uid");
		$criteria->params[":uid"] = $uid;
		$criteria->select = 'stars';
		$stars = MarkModel::model()->findAll($criteria);
		$star=0;
		foreach ($stars as $val) {
			$star += $val->stars;
		}
		$count = MarkModel::model()->count($criteria);
		$stars = round($star/$count);

		$UserServiceDetailModel = UserServiceDetailModel::model()->findByPk($uid);
		$UserServiceDetailModel->good_num=$count;
		$UserServiceDetailModel->good_stars=$stars;
		$UserServiceDetailModel->save();
		/*$UserServiceDetailModel = UserServiceDetailModel::model()->findByPk($uid);
		if($type=='stars'){
			$UserServiceDetailModel->good_stars=round((($UserServiceDetailModel->good_num*$UserServiceDetailModel->good_stars)+$stars)/($UserServiceDetailModel->good_num+1));
			$UserServiceDetailModel->good_num=$UserServiceDetailModel->good_num+1;
		}
		if($type=='times'){
			$UserServiceDetailModel->service_times=$UserServiceDetailModel->service_times+1;
		}
		$UserServiceDetailModel->save();*/
	}
	/**
	 * 增加服务商服务次数
	 * @param $uid
	 */
	public static function updatatimes($uid){
		$UserServiceDetailModel = UserServiceDetailModel::model()->findByPk($uid);
		$UserServiceDetailModel->service_times=$UserServiceDetailModel->service_times+1;
		$UserServiceDetailModel->save();
	}
}
