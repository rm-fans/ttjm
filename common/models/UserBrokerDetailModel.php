<?php

/**
 * This is the model class for table "{{user_broker_detail}}".
 *
 * The followings are the available columns in table '{{user_broker_detail}}':
 * @property integer $uid
 * @property integer $industry_id
 * @property string $business_card_src
 * @property string $certificate_src
 * @property string $desc
 * @property integer $pub_count
 * @property integer $pub_success_count
 * @property integer $introduction_count
 */
class UserBrokerDetailModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_broker_detail}}';
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
			array('uid, industry_id, pub_count, pub_success_count, introduction_count', 'numerical', 'integerOnly'=>true),
			array('business_card_src, certificate_src', 'length', 'max'=>150),
			array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, industry_id, business_card_src, certificate_src, desc, pub_count, pub_success_count, introduction_count', 'safe', 'on'=>'search'),
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
				'user_profile' => array(self::BELONGS_TO, 'UserProfileModel', 'uid'),
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
			'business_card_src' => 'Business Card Src',
			'certificate_src' => 'Certificate Src',
			'desc' => 'Desc',
			'pub_count' => 'Pub Count',
			'pub_success_count' => 'Pub Success Count',
			'introduction_count' => 'Introduction Count',
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
		$criteria->compare('business_card_src',$this->business_card_src,true);
		$criteria->compare('certificate_src',$this->certificate_src,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('pub_count',$this->pub_count);
		$criteria->compare('pub_success_count',$this->pub_success_count);
		$criteria->compare('introduction_count',$this->introduction_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserBrokerDetailModel the static model class
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
		$info = UserBrokerDetailModel::model()->with("user_profile")->find("uid=:uid",array(":uid"=>$uid));
		return $info;
	}
}
