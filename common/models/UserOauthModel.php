<?php

/**
 * This is the model class for table "{{user_oauth}}".
 *
 * The followings are the available columns in table '{{user_oauth}}':
 * @property integer $id
 * @property integer $uid
 * @property string $picture
 * @property string $identity_card
 * @property string $identity_name
 * @property string $identity_frontend_src
 * @property string $identity_backend_src
 * @property string $certificate_src
 * @property string $business_card_src
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $completed_at
 */
class UserOauthModel extends CActiveRecord
{
	CONST STATUS_PENDING = 0;//待认证
	CONST STATUS_SUCCESS = 1;//认证成功
	CONST STATUS_FAILED = -1;//认证失败

	CONST TYPE_SERVICE = 1;//服务商
	CONST TYPE_BROKER = 2;//经纪人
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_oauth}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'required'),
			array('uid, type, status, created_at, updated_at, completed_at', 'numerical', 'integerOnly'=>true),
			array('picture, identity_frontend_src, identity_backend_src, certificate_src, business_card_src', 'length', 'max'=>150),
			array('identity_card', 'length', 'max'=>50),
			array('identity_name', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, picture, identity_card, identity_name, identity_frontend_src, identity_backend_src, certificate_src, business_card_src, type, status, created_at, updated_at, completed_at', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'picture' => '照片',
			'identity_card' => '身份证号码',
			'identity_name' => '实名',
			'identity_frontend_src' => '身份证正面照',
			'identity_backend_src' => 'Identity Backend Src',
			'certificate_src' => '从业资格证书',
			'business_card_src' => '名片',
			'type' => '认证类型1：服务商2：经纪人',
			'status' => '认证状态0:待认证1:认证成功-1:认证失败',
			'created_at' => '创建时间',
			'updated_at' => '更新时间',
			'completed_at' => '完成时间',
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
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('identity_card',$this->identity_card,true);
		$criteria->compare('identity_name',$this->identity_name,true);
		$criteria->compare('identity_frontend_src',$this->identity_frontend_src,true);
		$criteria->compare('identity_backend_src',$this->identity_backend_src,true);
		$criteria->compare('certificate_src',$this->certificate_src,true);
		$criteria->compare('business_card_src',$this->business_card_src,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('completed_at',$this->completed_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserOauthModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
