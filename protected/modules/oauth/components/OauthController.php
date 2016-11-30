<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class OauthController extends CController
{
    public $config;//配置信息

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->config = CHtml::listData(ConfModel::model()->findAll(), 'name', 'value');
        }
        return true;
    }
    
    public function throwError()
    {
    	throw new CHttpException(404);
    }
    
}