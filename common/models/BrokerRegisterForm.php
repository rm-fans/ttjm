<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class BrokerRegisterForm extends CFormModel
{
	public $phone;
	public $password;
	public $code;
	public $verify_code;
	private $_identity;
	public $industry_id;
	public $identity_name;
	public $identity_card;
	public $isNew;//是否已登录


	/**
	 * Declares the validation rules.
	 * The rules state that phone and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
				array('identity_name,industry_id,identity_card,', 'required'),
				array('identity_card', 'match', 'message'=>'身份证号格式不对', 'pattern'=>'/([a-z]|[A-Z]|[0-9]){15,18}/i'),
				array('phone,password,code,verify_code', 'required', 'on' => 'login'),
				array('phone', 'isphone', 'on' => 'login'),
				array('password','length', 'message'=>'密码格式有误' , 'min'=>8,'max'=>16, 'on' => 'login'),
				array('code',"authenticate", 'on' => 'login'),
				array('verify_code','length',  'max'=>4, 'on' => 'login'),
				array('isNew', 'length', 'max'=>1),
		);
		/*return array(
			// phone and password are required
//			array('identity_name', 'match', 'message'=>'姓名必须为中文', 'pattern'=>'/[x{4e00}-x{9fa5}]+/u'),
			array('identity_card', 'match', 'message'=>'身份证号格式不对', 'pattern'=>'/([a-z]|[A-Z]|[0-9]){15,18}/i'),
//			array('phone', 'match', 'message'=>'手机号码错误', 'pattern'=>'/^(13|14|15|17|18)\d{9}$/i'),
			array('identity_name,industry_id,identity_card,code,phone', 'required'),
			// password needs to be authenticated
			array('code', 'authenticate'),
			array('password', 'checkPassword'),
		);*/
	}
	public function isphone()
	{
		$isPhone = Utils::isPhone($this->phone);
		if(!$isPhone)
		{
			$this->addError("手机号码错误");
		}
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
				'phone' => '手机号码',
				'code' => '短信验证码',
			    'identity_name'=>'个人姓名',
			    'identity_card'=>'身份证号',
			    'verify_code'=>'图片验证码',
			    'password'=>'密码',
				//'nickname' => '称呼',
				'identity_name' => '个人名字',
		);
	}

	public function checkPassword($attribute,$params)
	{
		if ($this->isNew && !$this->hasErrors()) {
			$length = strlen($this->password);
			if ($length < 8 && $length > 16) {
				$this->addError('password', '密码格式有误');
			}
		}
	}
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors() && !$this->isNew)
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
					'username'=>$this->phone,
					'password'=>$this->password,
					'email'=>'',
			);
			//$this->phone = Utils::encrypt($this->phone);
			$model = new UserProfileModel();
			$user = $model->model()->find('phone=:phone OR username=:username',array(':phone'=>Utils::encrypt($this->phone),':username'=>$this->phone));
			if($user){
				$this->addError('phone','手机号已注册');
			}
			//'nickname'=>$this->nickname,,'sex'=>$this->sex
			$model->attributes = array('phone'=>Utils::encrypt($this->phone),'username'=>$this->phone);
			$uid = User::register($register);
			if($uid['code']=='1000'){
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
}
