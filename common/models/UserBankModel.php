<?php

/**
 * This is the model class for table "{{user_bank}}".
 *
 * The followings are the available columns in table '{{user_bank}}':
 * @property integer $id
 * @property integer $uid
 * @property string $bank_name
 * @property string $bank_card
 * @property string $real_name
 * @property string $bankzone
 * @property integer $created_at
 */
class UserBankModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_bank}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, bank_name, bank_card,real_name,bankzone', 'required'),
			array('uid, created_at', 'numerical', 'integerOnly'=>true),
			array('bank_name', 'length', 'max'=>150),
            array('bank_name','match','pattern'=>'/^[\x{4e00}-\x{9fa5}]+$/u','message'=>'银行名只能为汉字'),
            array('bank_card', 'length', 'max'=>20,'min'=>16,'message'=>'请输入有效长度的卡号'),
			array('bank_card', 'match', 'pattern'=>'/^\d{16,19}|\d{4}\*{8,11}\d{4}$/i','message'=>'请输入正确的卡号'),
			array('real_name', 'length', 'min'=>2,'max'=>20),
            array('real_name','match','pattern'=>'/^[\x{4e00}-\x{9fa5}]+$/u','message'=>'真实姓名只能为汉字'),
			array('bankzone', 'length', 'max'=>255),
            array('bankzone','match','pattern'=>'/^[\x{4e00}-\x{9fa5}]+$/u','message'=>'支行信息只能为汉字'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, bank_name, bank_card, real_name, bankzone, created_at', 'safe', 'on'=>'search'),
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
			'uid' => '体现人（标识ID）',
			'bank_name' => '银行名称',
			'bank_card' => '卡号',
			'real_name' => '姓名',
			'bankzone' => '开户网点',
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
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('bank_card',$this->bank_card,true);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('bankzone',$this->bankzone,true);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserBankModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
