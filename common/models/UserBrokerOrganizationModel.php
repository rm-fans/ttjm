<?php

/**
 * This is the model class for table "{{user_broker_organization}}".
 *
 * The followings are the available columns in table '{{user_broker_organization}}':
 * @property integer $id
 * @property string $name
 * @property integer $admin_uid
 * @property integer $industry_id
 * @property string $logo
 * @property string $address
 * @property string $area
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $business_license_src
 * @property string $identity_name
 * @property string $identity_card
 * @property string $identity_frontend_src
 * @property string $identity_backeend_src
 * @property integer $views_number
 * @property string $desc
 * @property integer $status
 */
class UserBrokerOrganizationModel extends CActiveRecord
{
	CONST STATUS_PENDING = 0;//审核中
	CONST STATUS_SUCCESS = 1;//审核成功
	CONST STATUS_FAILED = -1;//审核失败
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_broker_organization}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admin_uid, industry_id, province_id, city_id, district_id, views_number, status', 'numerical', 'integerOnly'=>true),
			array('name, identity_card', 'length', 'max'=>255),
			array('logo, address, business_license_src, identity_frontend_src, identity_backeend_src', 'length', 'max'=>150),
			array('area, identity_name', 'length', 'max'=>25),
			array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, admin_uid, industry_id, logo, address, area, province_id, city_id, district_id, business_license_src, identity_name, identity_card, identity_frontend_src, identity_backeend_src, views_number, desc, status', 'safe', 'on'=>'search'),
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
				'image'=> array(self::HAS_MANY,'UserBrokerOrganizationImageModel','project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'admin_uid' => 'Admin Uid',
			'industry_id' => 'Industry',
			'logo' => 'Logo',
			'address' => 'Address',
			'area' => 'Area',
			'province_id' => 'Province',
			'city_id' => 'City',
			'district_id' => 'District',
			'business_license_src' => 'Business License Src',
			'identity_name' => 'Identity Name',
			'identity_card' => 'Identity Card',
			'identity_frontend_src' => 'Identity Frontend Src',
			'identity_backeend_src' => 'Identity Backeend Src',
			'views_number' => 'Views Number',
			'desc' => 'Desc',
			'status' => 'Status',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('admin_uid',$this->admin_uid);
		$criteria->compare('industry_id',$this->industry_id);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('business_license_src',$this->business_license_src,true);
		$criteria->compare('identity_name',$this->identity_name,true);
		$criteria->compare('identity_card',$this->identity_card,true);
		$criteria->compare('identity_frontend_src',$this->identity_frontend_src,true);
		$criteria->compare('identity_backeend_src',$this->identity_backeend_src,true);
		$criteria->compare('views_number',$this->views_number);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserBrokerOrganizationModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 机构详情
	 * @param $id
	 */
	public static function getInfo($id)
	{
		UserBrokerOrganizationModel::model()->findByPk($id);
	}
	/**
	 * 经纪人机构列表
	 * @param $where
	 * 			province_id	省id
	 * 			city_id	市id
	 * @param $page_size
	 * @param $page
	 * @return array
	 */
	public static function getLists($where=array(),$page_size,$page)
	{
		$criteria=new CDbCriteria;
		if(isset($where['province_id']) && !empty($where['province_id']))
		{
			$criteria->addCondition("province_id=:province_id");
			$criteria->params[":province_id"] = $where["province_id"];
		}
		if(isset($where['city_id']) && !empty($where['city_id']))
		{
			$criteria->addCondition("city_id=:city_id");
			$criteria->params[":city_id"] = $where["city_id"];
		}

		$dataProvider=new CActiveDataProvider('UserBrokerOrganizationModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$result = $dataProvider->getData();
		return array("lists"=>$result,"criteria"=>$criteria);
	}

	/**
	 * 经纪人机构成员
	 * @param $organization_id
	 * @param $page
	 * @param $page_size
	 */
	public static function teamLists($organization_id,$page,$page_size)
	{
		$criteria=new CDbCriteria;
		$criteria->with = "user_broker_detail";
		$criteria->addCondition("t.broker_organization_id = :organization_id");
		$criteria->params[":organization_id"] = $organization_id;

		$dataProvider=new CActiveDataProvider('UserProfileModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$result = $dataProvider->getData();
		return array("lists"=>$result,"criteria"=>$criteria);
	}
}
