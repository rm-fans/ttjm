<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $phone;
	public $password;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that phone and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// phone and password are required
			array('phone, password', 'required'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
				'phone' => '手机号码',
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
			$this->_identity=new UserIdentity($this->phone,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','手机号或密码错误.');
		}
	}
	public static function codeLogin($code,$phone)
	{
		$SmsLogModel = new SmsLogModel;
		$_identity = $SmsLogModel->checkSmsCode($code,$phone);
		if($_identity['code']!=1)
			return $_identity;
		$_identity=new UserIdentity($phone,$code);
		$_identity->codeLogin();
		if($_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($_identity,0);
			return true;
		}
		else
			return false;

	}
	/**
	 * Logs in the user using the given phone and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->phone,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($this->_identity,0);
			return true;
		}
		else
			return false;
	}
}
