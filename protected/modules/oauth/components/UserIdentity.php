<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

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
        $inputType = Utils::getInputType($this->username);
        switch ($inputType) {
            case 1://手机
                $user = UserModel::model()->with('user_profile')->find('phone=:phone', array(':phone' => Utils::encrypt($this->username)));
                break;
            case 2://email
                $user = UserModel::model()->with('user_profile')->find('email=:email', array(':email' => $this->username));
                break;
            default:
                $user = UserModel::model()->with('user_profile')->find('username=:username', array(':username' => $this->username));
                break;
        }
        if ($user) {
            if ($user->password == md5(md5($this->password) . $user->salt)) {
                $this->username = $user->username;
                $this->_id = $user->uid;
                $tempLoginIp = Utils::getIp();
                $user->lastlogin_at = time();
                $user->lastlogin_ip = $tempLoginIp;
                $user->save();
                $this->errorCode = self::ERROR_NONE;
            } else {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }

        return $this->errorCode;
    }

    /**
     * 自动登录方法
     */
    public function autoAuthenticate()
    {
        $inputType = Utils::getInputType($this->username);
        switch ($inputType) {
            case 1://手机
                $user = UserModel::model()->with('user_profile')->find('phone=:phone', array(':phone' => Utils::encrypt($this->username)));
                break;
            case 2://email
                $user = UserModel::model()->with('user_profile')->find('email=:email', array(':email' => $this->username));
                break;
            default:
                $user = UserModel::model()->with('user_profile')->find('username=:username', array(':username' => $this->username));
                break;
        }
        if ($user) {
            $this->_id = $user->uid;
            $this->errorCode = self::ERROR_NONE;
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        return $this->errorCode;

    }

    public function getId()
    {
        return $this->_id;
    }

}