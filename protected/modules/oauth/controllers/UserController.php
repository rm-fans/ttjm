<?php

/**
 * Created by PhpStorm.
 * User: thinkpad
 * Date: 2015/12/1
 * Time: 19:45
 */
class UserController extends Controller
{
    /**
     * 获取用户信息
     */
    public function actionGetUserInfo()
    {
        $now = time();
        $token = Yii::app()->request->getParam('access_token');
        $uid = urldecode(Yii::app()->request->getParam('uid'));
        //缺少参数
        if (empty($token) || empty($uid)) {
            die(Utils::jsonResult(4005, 'Params lost'));
        }
        $tokenModel = OauthTokenModel::model()->find('access_token=:access_token', array(':access_token' => $token));
        //token 是否存在和过期
        if (!$tokenModel || ($tokenModel && $tokenModel->expires < $now)) {
            die(Utils::jsonResult(4006, 'access_token expressed'));
        }
        $userInfo = UserProfileModel::model()->findByPk($uid);

        if (!$userInfo || ($tokenModel->uid != $userInfo->uid)) {
            die(Utils::jsonResult(4007, 'User not exist'));
        }

        $data = array(
            'uid' => $userInfo->uid,
            'username' => $userInfo->username,
            'email' => $userInfo->email,
            'phone' => Utils::decrypt($userInfo->phone),
            'avatar' => $userInfo->avatar ? $userInfo->avatar : Yii::app()->params['base_url'] . '/static/images/defaultAvatar.jpg',
            'is_freeze' => 0
        );
        die(Utils::jsonResult(1000, '', $data));
    }


}
