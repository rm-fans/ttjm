<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13
 * Time: 16:20
 */
class UploaderWidget extends CWidget{
    private $_assetUrl;
    public $uploadUrl;//上传路径
    public $form_name;
    public $form_ids;
    public $images;
    public $file_count;//最多上传几张
    public $cover;
    public $jsFiles=array(
        '/dist/webuploader.js',
    );
    public $cssFiles=array(
        '/css/webuploader.css',
    );
    function init(){
        parent::init();
        $img_service = new ImageServiceHandle(Yii::app()->params['frontend_app'],Yii::app()->params['frontend_secret']);
        $this->uploadUrl = $img_service->uploadUrl();
        //注册常量

        $clientScript=Yii::app()->clientScript;
        $this->_assetUrl=Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.extensions.webuploader'));
        $swf = $this->_assetUrl.'/dist/Uploader.swf';
        foreach($this->jsFiles as $jsFile){
            $clientScript->registerScriptFile($this->_assetUrl.$jsFile);
        }
        //注册css文件
        /*foreach($this->cssFiles as $cssFile){
            $clientScript->registerCssFile($this->_assetUrl.$cssFile);
        }*/
        $this->render("uploader",array(
            "uploadUrl"=>$this->uploadUrl,
            "swf"=>$swf,
            "form_name" => $this->form_name,
            "form_ids" => $this->form_ids,
            "images" => $this->images,
            "cover" => $this->cover,
            "file_count" => $this->file_count>0 ? $this->file_count:1
            ));
    }
}