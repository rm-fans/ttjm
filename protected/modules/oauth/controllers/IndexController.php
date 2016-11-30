<?php

class IndexController extends OauthController
{
    /**
     * GetAccessCode
     */
    public function actionIndex()
    {
        $now = time();
        $status = 5000;
        $message = '';
        $data = array();
        $appKey = Yii::app()->request->getParam('app_key');
        $redirectUrl = urldecode(Yii::app()->request->getParam('redirect_url'));
        $appInfo = OauthAppsModel::model()->find('app_key=:app_key', array(':app_key' => $appKey));
        if ($appInfo && $redirectUrl) {
            $appId = $appInfo->id;
            $uri = parse_url($appInfo->callback_url);
            $urlParse = parse_url($redirectUrl);
            if (
                is_array($urlParse) &&
                $uri['host'] == $urlParse['host'] &&
                ((isset($uri['port']) && isset($urlParse['port']) && $uri['port'] == $urlParse['port'])
                    || (!isset($uri['port']) && !isset($urlParse['port'])))
            ) {
                // collect user input data
                if (Yii::app()->request->isPostRequest) {
                    $username = Yii::app()->request->getParam('username');
                    $password = Yii::app()->request->getParam('password');
                    $identity = new  UserIdentity($username, $password);
                    if ($identity->authenticate() == UserIdentity::ERROR_NONE) {
                        $uid = $identity->getId();
                        $userInfo = UserModel::model()->findByPk($uid);
                        if($userInfo->is_effect==1){
                            $tokenModel = OauthTokenModel::model()->find('app_id=:app_id and uid=:uid', array(':app_id' => $appId, ':uid' => $uid));
                            if (!$tokenModel) {
                                $tokenModel = new OauthTokenModel();
                                $tokenModel->app_id = $appId;
                                $tokenModel->uid = $uid;
                            }
                            $token = md5($appInfo->app_secret . $now . rand(1, 1000));
                            $refreshToken = md5($appKey . $appId . $now . rand(1, 1000));
                            $express = Yii::app()->params['expiresToken'];
                            $tokenModel->access_token = $token;
                            $tokenModel->refresh_token = $refreshToken;
                            $tokenModel->expires = time() + $express;
                            if ($tokenModel->save()) {
                                $status = 1000;
                                $data = array('uid'=>$uid,'access_token' => $token, 'refresh_token' => $refreshToken, 'express_in' => $express);
                            }
                        }else{
                            $status = 1001;
                            $message = '账户已冻结';
                        }


                    } else {
                        $status = 2001;
                        $message = '用户不存在或密码不正确';
                    }
                }
            }
        } else {
            $status = 5001;
            $message = '应用不存在';
        }
        die(Utils::jsonResult($status, $message, $data));
    }


    /**
     * 获取token
     */
    public function actionGetToken()
    {
        $now = time();
        $accessCode = Yii::app()->request->getParam('access_code');
        $appSecret = Yii::app()->request->getParam('app_secret');
        $appKey = Yii::app()->request->getParam('app_key');
        if (empty($accessCode) || empty($appSecret) || empty($appKey)) {
            die(Utils::jsonResult(4001, 'Miss Params [access_code|app_secret|app_key]'));
        }
        $accessModel = OauthCodeModel::model()->find('code=:code', array(':code' => $accessCode));
        if (!$accessModel || ($accessModel && $accessModel->expires < $now)) {
            die(Utils::jsonResult(4002, 'Access Code expired'));
        }
        //校验app secret
        $appModel = OauthAppsModel::model()->find('app_key=:app_key', array(':app_key' => $appKey));
        if (!$appKey || ($appKey && !$appModel->status)) {
            die(Utils::jsonResult(4003, 'App error'));
        }
        if ($appModel->app_secret !== $appSecret) {
            die(Utils::jsonResult(4004, 'App secret error'));
        }
        //生成或更新token
        $uid = $accessModel->uid;
        $appId = $accessModel->app_id;
        $tokenModel = OauthTokenModel::model()->find('app_id=:app_id and uid=:uid', array(':app_id' => $appId, ':uid' => $uid));
        if (!$tokenModel) {
            $tokenModel = new OauthTokenModel();
            $tokenModel->app_id = $appId;
            $tokenModel->uid = $uid;
        }
        $token = md5($appSecret . $now . rand(1, 1000));
        $refreshToken = md5($appKey . $appId . $now . rand(1, 1000));
        $express = Yii::app()->params['expiresToken'];
        $tokenModel->access_token = $token;
        $tokenModel->refresh_token = $refreshToken;
        $tokenModel->expires = time()+$express;
        if ($tokenModel->save())
            echo Utils::jsonResult(1000, '', array('access_token' => $token, 'refresh_token' => $refreshToken, 'express_in' => $express));
        else
            echo Utils::jsonResult(5001, 'Server Error');

    }



    /**
     * autoLogin
     */
    public function actionAutoLogin()
    {
        $now = time();
        $status = 5000;
        $message = '';
        $data = array();
        $appKey = Yii::app()->request->getParam('app_key');
        $redirectUrl = urldecode(Yii::app()->request->getParam('redirect_url'));
        $appInfo = OauthAppsModel::model()->find('app_key=:app_key', array(':app_key' => $appKey));
        if ($appInfo && $redirectUrl) {
            $appId = $appInfo->id;
            $uri = parse_url($appInfo->callback_url);
            $urlParse = parse_url($redirectUrl);
            if (
                is_array($urlParse) &&
                $uri['host'] == $urlParse['host'] &&
                ((isset($uri['port']) && isset($urlParse['port']) && $uri['port'] == $urlParse['port'])
                    || (!isset($uri['port']) && !isset($urlParse['port'])))
            ) {
                // collect user input data
                if (Yii::app()->request->isPostRequest) {
                    $username = Yii::app()->request->getParam('username');
                    $identity = new  UserIdentity($username, '');
                    if ($identity->autoAuthenticate() == UserIdentity::ERROR_NONE) {
                        $uid = $identity->getId();
                        $userInfo = UserModel::model()->findByPk($uid);
                        if($userInfo->is_effect==1){
                            $tokenModel = OauthTokenModel::model()->find('app_id=:app_id and uid=:uid', array(':app_id' => $appId, ':uid' => $uid));
                            if (!$tokenModel) {
                                $tokenModel = new OauthTokenModel();
                                $tokenModel->app_id = $appId;
                                $tokenModel->uid = $uid;
                            }
                            $token = md5($appInfo->app_secret . $now . rand(1, 1000));
                            $refreshToken = md5($appKey . $appId . $now . rand(1, 1000));
                            $express = Yii::app()->params['expiresToken'];
                            $tokenModel->access_token = $token;
                            $tokenModel->refresh_token = $refreshToken;
                            $tokenModel->expires = time() + $express;
                            if ($tokenModel->save()) {
                                $status = 1000;
                                $data = array('uid'=>$uid,'access_token' => $token, 'refresh_token' => $refreshToken, 'express_in' => $express);
                            }
                        }else{
                            $status = 1001;
                            $message = '账户已冻结';
                        }


                    } else {
                        $status = 2001;
                        $message = '用户不存在';
                    }
                }
            }
        } else {
            $status = 5001;
            $message = '应用不存在';
        }
        die(Utils::jsonResult($status, $message, $data));
    }

    /**
     * 刷新token
     */
    public function actionRefreshToken()
    {
        $now = time();
        $expiresIn = Yii::app()->params['expiresToken'];
        $refreshToken = Yii::app()->request->getParam('refresh_token');
        $appKey = Yii::app()->request->getParam('app_key');
        $appModel = OauthAppsModel::model()->find('app_key=:app_key', array(':app_key' => $appKey));
        if (empty($refreshToken) || empty($appKey)) {
            die(Utils::jsonResult(4001, 'Miss Params [refresh_token|app_key]'));
        }
        if (!$appModel || ($appModel && !$appModel->status)) {
            die(Utils::jsonResult(4003, 'App error'));
        }
        $tokenInfo = OauthTokenModel::model()->find('app_id=:app_id and refresh_token=:refresh_token',
            array(':app_id' => $appModel->id, ':refresh_token' => $refreshToken));
        if (!$tokenInfo) {
            die(Utils::jsonResult(4008, 'refresh_token expressed'));
        }
        $userInfo = UserModel::model()->findByPk($tokenInfo->uid);
        $appSecret = $appModel->app_secret;
        $appId = $appModel->id;
        $accessToken = md5($appSecret . $now . rand(1, 1000));
        $refreshToken = md5($appKey . $appId . $now . rand(1, 1000));
        $express = $now + $expiresIn;
        $username = $userInfo->username;
        $tokenInfo->access_token = $accessToken;
        $tokenInfo->refresh_token = $refreshToken;
        $tokenInfo->expires = $express;
        if ($tokenInfo->save())
            echo Utils::jsonResult(1000, '', array('access_token' => $accessToken, 'refresh_token' => $refreshToken, 'uid' => $userInfo->uid, 'expires_in' => $expiresIn));
        else
            echo Utils::jsonResult(5001, 'Server Error');
    }


}