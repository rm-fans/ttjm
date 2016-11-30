<?php

/**
 * This is the model class for table "{{user_profile}}".
 *
 * The followings are the available columns in table '{{user_profile}}':
 * @property string $uid
 * @property string $phone
 * @property integer $broker_organization_id
 * @property integer $service_organization_id
 * @property string $username
 * @property string $nickname
 * @property string $email
 * @property string $avatar
 * @property integer $sex
 * @property integer $is_service
 * @property integer $is_broker
 * @property integer $industry_id
 * @property string $area
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $identity_name
 * @property string $identity_card
 * @property string $address
 * @property string $wechat
 * @property string $qq
 * @property string $birthday
 * @property string $token
 * @property integer $is_pub_project
 */
class UserProfileModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_profile}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
				array('uid,province_id, city_id, district_id,industry_id,username', 'required'),
				array('broker_organization_id, service_organization_id, sex, is_service, is_broker, industry_id, province_id, city_id, district_id', 'numerical', 'integerOnly'=>true),
				array('uid', 'length', 'max'=>10),
				array('phone, wechat', 'length', 'max'=>30),
				array('username, nickname, avatar, address', 'length', 'max'=>150),
				array('area, identity_name', 'length', 'max'=>25),
				array('identity_card', 'length', 'max'=>50),
				array('qq', 'length', 'max'=>15),
				array('birthday', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('uid, phone, broker_organization_id, service_organization_id, username, nickname, avatar, sex, is_service, is_broker, industry_id, area, province_id, city_id, district_id, identity_name, identity_card, address, wechat, qq, birthday,token', 'safe', 'on'=>'search'),
		);*/
		return array(
				array('uid', 'required'),
				array('broker_organization_id, service_organization_id, sex, is_service, is_broker, industry_id, province_id, city_id, district_id, is_pub_project', 'numerical', 'integerOnly'=>true),
				array('uid', 'length', 'max'=>10),
				array('phone, wechat', 'length', 'max'=>30),
				array('username, nickname, email,avatar, address', 'length', 'max'=>150),
				array('area, identity_name', 'length', 'max'=>25),
				array('identity_card', 'length', 'max'=>50),
				array('qq', 'length', 'max'=>15),
				array('token', 'length', 'max'=>255),
				array('birthday', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('uid, phone, broker_organization_id, service_organization_id, username, nickname,email, avatar, sex, is_service, is_broker, industry_id, area, province_id, city_id, district_id, identity_name, identity_card, address, wechat, qq, birthday, token, is_pub_project', 'safe', 'on'=>'search'),
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
				'user_broker_detail'=> array(self::HAS_ONE,'UserBrokerDetailModel','uid'),
				'user_service_detail'=> array(self::HAS_ONE,'UserServiceDetailModel','uid'),
				'service_organization'=>array(self::BELONGS_TO,'UserServiceOrganizationModel','service_organization_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'uid' => 'Uid',
				'phone' => '手机号码',
				'broker_organization_id' => 'Broker Organization',
				'service_organization_id' => 'Service Organization',
				'username' => '用户名',
				'nickname' => '昵称',
				'email' => 'Email',
				'avatar' => '头像',
				'sex' => '性别',
				'is_service' => 'Is Service',
				'is_broker' => 'Is Broker',
				'industry_id' => '行业',
				'area' => 'Area',
				'province_id' => 'Province',
				'city_id' => 'City',
				'district_id' => '地域地址',
				'identity_name' => '名字',
				'identity_card' => '身份证号码',
				'address' => '详细地址',
				'wechat' => 'Wechat',
				'qq' => 'Qq',
				'birthday' => '',
				'token' => 'token',
				'is_pub_project' => '是否发布过资产:1是，0否',
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

		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('broker_organization_id',$this->broker_organization_id);
		$criteria->compare('service_organization_id',$this->service_organization_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('is_service',$this->is_service);
		$criteria->compare('is_broker',$this->is_broker);
		$criteria->compare('industry_id',$this->industry_id);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('identity_name',$this->identity_name,true);
		$criteria->compare('identity_card',$this->identity_card,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('wechat',$this->wechat,true);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('is_pub_project',$this->is_pub_project);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserProfileModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	//发布资产默认加上服务商
	public static function getProjectServiceUser($city_id = 0)
	{
		$criteria = new CDbCriteria;
		$num = UserProfileModel::model()->count("is_service=1 and city_id=:city_id",array(":city_id"=>$city_id));
		$criteria->addCondition("is_service=1");
		if($num == 0 )
		{	//默认成都服务商
			$criteria->addCondition("city_id=385");
			$num = UserProfileModel::model()->count("is_service=1");
		}else{
			$criteria->addCondition("city_id=:city_id");
			$criteria->params[":city_id"] = $city_id;
		}
		$limit = round(1,$num);
		$criteria->limit = array($limit,1);
		$info = UserProfileModel::model()->find($criteria);
		return $info;

	}
	/**
	 * 更新数据
	 */
	public static function updataSession()
	{
		if (Yii::app()->user->isGuest){
			return array('state'=>'-1','message'=>'未登录');
		}
		$user = UserProfileModel::model()->findByPk(Yii::app()->user->id);
		$user = json_decode(CJSON::encode($user),TRUE);
		foreach($user as $key=>$var){
			Yii::app()->user->setState($key,$var);
		}
		return array('state'=>'1','message'=>'更新成功');
	}
	/**
	 * 确认用户已发布资产
	 * @param $uid
	 */
	public static function setPubProject($uid,$project_status)
	{
		if($project_status == ProjectModel::STATUS_SUCCESS && !empty($uid))
		{
			$user = UserProfileModel::model()->findByPk($uid);
			if($user->is_pub_project==0)
			{
				$user->is_pub_project = 1;
				$user->save();
			}
		}
	}
}
