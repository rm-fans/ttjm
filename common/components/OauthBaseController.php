<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/21
 * Time: 15:22
 */
class OauthBaseController extends Controller
{

    public $model, $loginUrl, $redirectUrl, $appInfo;

    public function beforeAction($action)
    {
        if ($action->id == 'index') {

            $isPass = 0; //数据校验
            $appKey = Yii::app()->request->getParam('app_key');
            $redirectUrl = urldecode(Yii::app()->request->getParam('redirect_url'));
            $appInfo = OauthAppsModel::model()->find('app_key=:app_key', array(':app_key' => $appKey));
            if ($appInfo && $redirectUrl) {
                $uri = parse_url($appInfo->callback_url);
                $urlParse = parse_url($redirectUrl);

                if (
                    is_array($urlParse) &&
                    $uri['host'] == $urlParse['host'] &&
                    ((isset($uri['port']) && isset($urlParse['port']) && $uri['port'] == $urlParse['port'])
                        || (!isset($uri['port']) && !isset($urlParse['port'])))
                ) {
                    $model = new LoginForm;
                    $isPass = 1;
                }
            }
            if ($isPass) {
                $loginUrl = $this->createUrl('oauth/index', array('app_key' => $appKey, 'redirect_url' => $redirectUrl));
                $this->model = $model;
                $this->loginUrl = $loginUrl;
                $this->redirectUrl = $redirectUrl;
                $this->appInfo = $appInfo;
                return parent::beforeAction($action);
            } else {
                throw new CHttpException(404);
            }
        }
        return parent::beforeAction($action);
    }
}