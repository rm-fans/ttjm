<?php

/**
 *
 */
class FindForm extends CFormModel
{
	public $phone;
	public $code;
	public $password;
	public $verify_code;
	private $_identity;
	public function rules()
	{
		return array(
			array('phone, code, password,, verify_code', 'required'),
			array('phone', 'match', 'pattern'=>'/^(13|14|15|17|18)\d{9}$/', 'message'=>'请输入正确的手机号'),
			//array('phone', 'checkPhone'),
			array('code', 'checkCode'),
			array('password', 'length', 'min'=>8, 'max'=>16, 'message'=>'请输入8-16位密码'),
		);
	}
	

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'phone' => '手机号', 
			'code' => '手机验证码',
			'password' => '密码',
			'verify_code'=>'验证码'
		);
	}

	/**
	 * check phone exits or not
	 */
/*	public function checkPhone($attribute,$params)
	{
		if(!$this->hasErrors()){
			$model = new UserProfileModel();
			$user = UserProfileModel::model()->find('phone=:phone',array(':phone'=>Utils::encrypt($this->phone)));
			if (!$user) {
				$this->addError('phone','手机号未注册');
			}
		}
	}*/
	
	/**
	 * check phone code
	 */
	public function checkCode($attribute,$params)
	{
		if(!$this->hasErrors()){
			$SmsLogModel = new SmsLogModel;
			$this->_identity=$SmsLogModel->checkSmsCode($this->code,$this->phone);
			if($this->_identity['code']!=1)
				$this->addError('code',$this->_identity['message']);
		}
	}
	
	/**
	 * register user
	 */
	public function resetPassword()
	{
		if($this->_identity===null)
		{
			$SmsLogModel = new SmsLogModel;
			$this->_identity=$SmsLogModel->checkSmsCode($this->code,$this->phone);
		}
		if($this->_identity['code']==1) {
			$uid = User::findPassword(array('phone'=>$this->phone,'new_password'=>$this->password));
			if($uid['code']=='1000'){
				return true;
			}else{
				$this->addError('phone',$uid['message']);
			}
		}
	}

}