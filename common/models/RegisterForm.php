<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $phone;
	public $password;
	public $code;
	public $verify_code;
	private $_identity;
	public $uid;
	/**
	 * Declares the validation rules.
	 * The rules state that phone and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// phone and password are required
			array('phone, code, password', 'required'),
			array("uid",'numerical', 'integerOnly'=>true),
			// password needs to be authenticated
			array('code', 'authenticate'),
			array('password', 'length', 'min'=>8, 'max'=>16, 'message'=>'请输入8-16位密码'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
				'phone' => '手机号码',
				'code' => '手机验证码',
				'password' => '密码',
		);
	}
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$SmsLogModel = new SmsLogModel;
			$this->_identity=$SmsLogModel->checkSmsCode($this->code,$this->phone);
			if($this->_identity['code']!=1)
				$this->addError('code',$this->_identity['message']);
		}
	}
	public function register()
	{
		if($this->_identity===null)
		{
			$SmsLogModel = new SmsLogModel;
			$this->_identity=$SmsLogModel->checkSmsCode($this->code,$this->phone);
		}
		if($this->_identity['code']==1)
		{
			$register = array(
					'phone'=>$this->phone,
					//'username'=>$this->phone,
					'password'=>$this->password,
					'email'=>'',
			);
			//$this->phone = Utils::encrypt($this->phone);
			$model = new UserProfileModel();
			$user = $model->model()->find('phone=:phone OR username=:username',array(':phone'=>Utils::encrypt($this->phone),':username'=>$this->phone));
			if($user){
				$this->addError('phone','手机号已注册');
			}
			$model->attributes = array('phone'=>Utils::encrypt($this->phone)/*,'username'=>$this->phone*/);
			$uid = User::register($register);
			if($uid['code']=='1000'){
				$model->avatar= Yii::app()->params['base_url'].'/static/images/default.png';
				$model->username=$uid['data']['username'];
				$model->uid=$uid['data']['uid'];
				if($model->save()){
					$Login=new LoginForm;
					$Login->attributes=array('phone'=>$this->phone,'password'=>$this->password);
					$Login->login();
					return true;
				}
			}else{
				$this->addError('phone',$uid['message']);
			}
		}
	}

	/**
	 * 快速注册，自主发布 一健委托用
	 */
	public function quick_register()
	{
		if($this->_identity===null)
		{
			$SmsLogModel = new SmsLogModel;
			$this->_identity = $SmsLogModel->checkSmsCode($this->code,$this->phone);
		}
		if($this->_identity['code']==1)
		{
			$register = array(
					'phone'=>$this->phone,
					//'username'=>$this->phone,
					'password'=>$this->password,
					'email'=>'',
			);
			$model = new UserProfileModel();
			$user = $model->model()->find('phone=:phone',array(':phone'=>Utils::encrypt($this->phone)));
			//手机号已注册，快速登录账户
			if($user){
				$model->uid = $user['uid'];
				LoginForm::codeLogin($this->code,$this->phone);
				return $model->uid;
			}
			$model->attributes = array('phone'=>Utils::encrypt($this->phone)/*,'username'=>$this->phone*/);
			$uid = User::register($register);
			//未注册用户或已注册用户同步数据,并快速登录
			if(in_array($uid['code'],array(1000,1002))){
				$model->avatar= Yii::app()->params['base_url'].'/static/images/default.png';
				$model->username=$uid['data']['username'];
				$model->uid=$uid['data']['uid'];
				if($model->save()){
					LoginForm::codeLogin($this->code,$this->phone);
					if($uid['code'] == '1000')//发送系统密码
					{
						SmsLogModel::sendTipSMS($this->phone, 8,array($this->phone,$this->password));
					}
					return $model->uid;
				}
			}else{
				return false;
			}
		}
	}


}
