<?php

/**
 * This is the model class for table "{{user_service_organization}}".
 *
 * The followings are the available columns in table '{{user_service_organization}}':
 * @property integer $id
 * @property integer $admin_uid
 * @property integer $industry_id
 * @property string $logo
 * @property string $address
 * @property string $name
 * @property string $area
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $business_license_src
 * @property string $identity_name
 * @property string $identity_frontend_src
 * @property string $identity_backeend_src
 * @property integer $views_number
 * @property string $desc
 * @property integer $status
 */
class UserServiceOrganizationModel extends CActiveRecord
{
	CONST STATUS_PENDING = 0;//审核中
	CONST STATUS_SUCCESS = 1;//审核成功
	CONST STATUS_FAILED = -1;//审核失败
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_service_organization}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,admin_uid,province_id, city_id, district_id,industry_id', 'required'),
			array('admin_uid, industry_id, province_id, city_id, district_id, views_number, status', 'numerical', 'integerOnly'=>true),
			array('logo, address, business_license_src, identity_frontend_src, identity_backeend_src', 'length', 'max'=>150),
			array('area, identity_name', 'length', 'max'=>25),
			array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admin_uid, industry_id, logo, address, area, province_id, city_id, district_id, business_license_src, identity_name, identity_frontend_src, identity_backeend_src, views_number, desc, status', 'safe', 'on'=>'search'),
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
				'image'=> array(self::HAS_MANY,'UserServiceOrganizationImageModel','project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '服务商机构名称',
			'admin_uid' => '管理员ID',
			'industry_id' => '行业',
			'logo' => 'Logo',
			'address' => '地址',
			'area' => '地域名：省 市 区',
			'province_id' => 'Province',
			'city_id' => 'City',
			'district_id' => '地域地址',
			'business_license_src' => '营业执照',
			'identity_name' => '法人姓名',
			'identity_card' => '法人身份证号',
			'identity_frontend_src' => '法人身份证正面',
			'identity_backeend_src' => '法人身份证背面',
			'views_number' => '访问量',
			'desc' => '机构描述',
			'status' => '状态',
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
	 * @return UserServiceModel the static model class
	 */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


	/**
	 * 服务商列表
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
        $criteria->addCondition("status=:status");
        $criteria->params[":status"] = self::STATUS_SUCCESS;
		$dataProvider=new CActiveDataProvider('UserServiceOrganizationModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$result = $dataProvider->getData();

		return array("lists"=>$result,"criteria"=>$criteria);
	}

	/**
	 * 某服务商信息
	 * @param $id
	 */
	public static function getInfo($id)
	{
		UserServiceOrganizationModel::model()->findByPk($id);
	}
	/**
	 * 服务商机构成员
	 * @param $organization_id
	 * @param $page
	 * @param $page_size
	 */
	public static function teamLists($organization_id,$page=null,$page_size=null)
	{
		$criteria=new CDbCriteria;
		$criteria->with = "user_service_detail";
		$criteria->addCondition("t.service_organization_id = :organization_id");
		$criteria->params[":organization_id"] = $organization_id;
		$criteria->addCondition("t.is_service =1");

		$dataProvider=new CActiveDataProvider('UserProfileModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)) );
		$result = $dataProvider->getData();
		return array("lists"=>$result,"criteria"=>$criteria,"pages"=>$dataProvider->getPagination());
	}
}
