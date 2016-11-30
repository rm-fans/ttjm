<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $uid;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user= array(
				'username'=>$this->username,
				'password'=>$this->password,
		);
		$uid = User::login($user);
		if($uid['code']==1000){
			$data = $uid['data'];
			$info = User::getUserInfo(array('access_token'=>$data['access_token'],'uid'=>$data['uid']));
			$this->errorCode=self::ERROR_NONE;
			$model = UserProfileModel::model()->find(array(
					'condition' => 'uid=:uid',
					'params' => array(':uid' => $info['data']['uid']),
			));
			if ($model == null ||$model =="") {
				$model = new UserProfileModel();
				$model->attributes = array('email'=>$info['data']['email'],'avatar'=>Yii::app()->params['base_url'].'/static/images/default.png','uid'=>$data['uid'],'phone'=>Utils::encrypt($this->username),'username'=>$info['data']['username']);
				$model->save();
			}
			$this->username = $info['data']['username'];
			$this->uid = $info['data']['uid'];
			$model = json_decode(CJSON::encode($model),TRUE);
			$model['access_token'] = $uid['data']['access_token'];
			$model['refresh_token'] = $uid['data']['refresh_token'];
			$this->setPersistentStates($model);
			return true;
		}else{
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		return !$this->errorCode;
	}

	public function codeLogin()
	{
		$user= array(
				'username'=>$this->username,
		);
		$uid = User::autoLogin($user);
		if($uid['code']==1000){
			$data = $uid['data'];
			$info = User::getUserInfo(array('access_token'=>$data['access_token'],'uid'=>$data['uid']));
			$this->errorCode=self::ERROR_NONE;
			$model = UserProfileModel::model()->find(array(
					'condition' => 'uid=:uid',
					'params' => array(':uid' => $info['data']['uid']),
			));
			if ($model === null) {
				$model = new UserProfileModel();
				$model->attributes = array('phone'=>Utils::encrypt($this->username),'username'=>$this->username);
				$model->save();
			}
			$this->username = $info['data']['username'];
			$this->uid = $info['data']['uid'];
			$model = json_decode(CJSON::encode($model),TRUE);
			$model['uid'] = $uid['data']['uid'];
			$model['access_token'] = $uid['data']['access_token'];
			$model['refresh_token'] = $uid['data']['refresh_token'];
			$this->setPersistentStates($model);
			return true;
		}else{
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		return !$this->errorCode;
	}
	public function getId()
	{
		return $this->uid;
	}
}