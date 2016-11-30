<?php

/**
 * This is the model class for table "{{data_statistics}}".
 *
 * The followings are the available columns in table '{{data_statistics}}':
 * @property integer $id
 * @property double $entrust_price_all
 * @property double $transaction_price_all
 * @property integer $service_num_count
 * @property integer $can_sell_num
 * @property integer $registered_users
 * @property integer $registered_user_all
 * @property double $confirm_price_all
 * @property integer $registered_service
 * @property integer $registered_broker
 * @property integer $registered_referee
 * @property integer $registered_service_all
 * @property integer $registered_noservice
 */
class DataStatisticsModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{data_statistics}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, service_num_count, can_sell_num, registered_users, registered_user_all, registered_service, registered_broker, registered_referee, registered_service_all, registered_noservice', 'numerical', 'integerOnly'=>true),
			array('entrust_price_all, transaction_price_all, confirm_price_all', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, entrust_price_all, transaction_price_all, service_num_count, can_sell_num, registered_users, registered_user_all, confirm_price_all, registered_service, registered_broker, registered_referee, registered_service_all, registered_noservice', 'safe', 'on'=>'search'),
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
			'entrust_price_all' => '累计发布资产总金额',
			'transaction_price_all' => '当前可交易资产总额',
			'service_num_count' => '已服务资产数量（旧的）',
			'can_sell_num' => '可交易资产数',
			'registered_users' => '已注册用户（所有角色）',
			'registered_user_all' => '平台所有角色（含机构） 旧的',
			'confirm_price_all' => '已服务的成交总额',
			'registered_service' => '已注册买家（含机构）',
			'registered_broker' => '注册的经纪人数',
			'registered_referee' => '已注册资产推荐人（推荐人角色数量)',
			'registered_service_all' => '已入驻服务机构数（个人＋机构）',
			'registered_noservice' => '已注册卖家（除服务商之外的所有用户数（含机构））',
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
		$criteria->compare('entrust_price_all',$this->entrust_price_all);
		$criteria->compare('transaction_price_all',$this->transaction_price_all);
		$criteria->compare('service_num_count',$this->service_num_count);
		$criteria->compare('can_sell_num',$this->can_sell_num);
		$criteria->compare('registered_users',$this->registered_users);
		$criteria->compare('registered_user_all',$this->registered_user_all);
		$criteria->compare('confirm_price_all',$this->confirm_price_all);
		$criteria->compare('registered_service',$this->registered_service);
		$criteria->compare('registered_broker',$this->registered_broker);
		$criteria->compare('registered_referee',$this->registered_referee);
		$criteria->compare('registered_service_all',$this->registered_service_all);
		$criteria->compare('registered_noservice',$this->registered_noservice);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DataStatisticsModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
