<?php

class User
{
    const app_key = 'tezisuo';
    const secret = '62cf0b3c3e6a4c9468e721683972128e';
    const redirect_url = 'https://www.fenjinshe.com';
    const Interface_url = 'http://218.89.241.79:4000/oauth/';


    public static function register($params = array()){

        $params['app_key']= self::app_key;
        //$params['secret']= self::secret;
        $params['register_ip']= Utils::getIp();
        //$a = self::app_key.$params['email'].$params['password'].$params['phone'].$params['register_ip'].$params['username'].self::secret;
        $params['sign'] = md5(self::app_key.$params['email'].$params['password'].$params['phone'].$params['register_ip'].self::secret);
        //$params['sign'] = md5(self::app_key.$params['email'].$params['password'].$params['phone'].$params['register_ip'].$params['username'].self::secret);
        $params['email'] = Utils::authcode($params['email'], $operation = 'ENCODE', self::secret);
        $params['password'] = Utils::authcode($params['password'], $operation = 'ENCODE', self::secret);
        $params['phone'] = Utils::authcode($params['phone'], $operation = 'ENCODE', self::secret);
        $params['register_ip'] = Utils::authcode($params['register_ip'], $operation = 'ENCODE', self::secret);
        //$params['username'] = Utils::authcode($params['username'], $operation = 'ENCODE', self::secret);
        $content = Utils::sendHttpRequest( self::Interface_url.'register', $params, 'POST');
        //$content = $content['content'];
        //return $content;
        return json_decode($content['content'],true);
    }

    public static function login($params = array()){
        $params['app_key']= self::app_key;
        $params['redirect_url']= self::redirect_url;
        $content = Utils::sendHttpRequest(self::Interface_url.'index', $params, 'POST');
        return json_decode($content['content'],true);
    }
    public static function autoLogin($params = array()){
        $params['app_key']= self::app_key;
        $params['redirect_url']= self::redirect_url;
        $content = Utils::sendHttpRequest(self::Interface_url.'autoLogin', $params, 'POST');
        return json_decode($content['content'],true);
    }
    public static function refreshToken($params = array()){
        $params['app_key']= self::app_key;
        $content = Utils::sendHttpRequest(self::Interface_url.'refreshToken', $params, 'POST');
        return json_decode($content['content'],true);
    }
    public static function getUserInfo($params = array()){
        $content = Utils::sendHttpRequest(self::Interface_url.'getUserInfo', $params, 'POST');
        return json_decode($content['content'],true);
    }
    public static function findPassword($params = array()){
        $params['app_key']= self::app_key;
        $params['sign'] = md5(self::app_key.$params['new_password'].$params['phone']);
        $params['new_password'] = Utils::authcode($params['new_password'], $operation = 'ENCODE', self::secret);
        $params['phone'] = Utils::authcode($params['phone'], $operation = 'ENCODE', self::secret);
        $content = Utils::sendHttpRequest( self::Interface_url.'findPassword', $params, 'POST');
        return json_decode($content['content'],true);
    }
    public static function resetPassword($params = array()){
        $content = Utils::sendHttpRequest( self::Interface_url.'resetPassword', $params, 'POST');
        return json_decode($content['content'],true);
    }
    public static function registerCount()
    {
        $content = Utils::sendHttpRequest( self::Interface_url.'registerCount', array(), 'POST');
        $data = json_decode($content['content'],true);
        return $data['data']['count'];
    }
}