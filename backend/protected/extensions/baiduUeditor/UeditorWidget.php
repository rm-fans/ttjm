<?php
class UeditorWidget extends CWidget{


    private $_assetUrl;

    public $jsFiles=array(
        '/ueditor.config.js',
        //'/ueditor.all.min.js',
        '/ueditor.all.js',
        '/config.js'
    );
    public $cssFiles=array(
        '/themes/default/css/ueditor.css'
    );

    //post到后台接收的input ID
    public $inputId;
    //input textarea 类名
    public $class;
    //button 类名，只对type为file image 有效
    public $btnClass;
    //类型,textarea:富文本 file:文件 image:图片
    public $type;

    public $style;

    public $attr;

    public $titleName;//file title

    //容器的ID 具有唯一性
    public $id;
    //后台接收name名称
    public $name;
    //初始化内容
    public $content='';
    //容器宽
    public $width='100%';
    //容器高
    public $height='400px';


    public $uploadUrl;//上传路径

    public $idName;//图片服务器返回的图片id的名字

    public $idContent;//图片id默认值

    /**
     * 配置选项
     * 将ueditor.config.js的选项以数组键值的方式配置
     * @var array
     */
    public $config=array();
    //后台统一url
    public $serverUrl;

    function init(){
        $baseConfig=require('config.php');
        $imageServeHandle= new ImageServiceHandle($baseConfig['app'],$baseConfig['secret']);
        parent::init();
        $this->uploadUrl = $imageServeHandle->uploadUrl();
        if(trim($this->id)==''||trim($this->name)==''){
            throw new CException('必须设置容器id和name值');
        }

        //发布资源

        $this->_assetUrl=Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.extensions.baiduUeditor.resource'));

        $clientScript=Yii::app()->clientScript;
        //注册常量
        $jsConstant='window.UEDITOR_HOME_URL = "'.$this->_assetUrl.'/"';
        $clientScript->registerScript('ueditor_constant',$jsConstant,CClientScript::POS_BEGIN);

        //注册js文件

        foreach($this->jsFiles as $jsFile){
            $clientScript->registerScriptFile($this->_assetUrl.$jsFile,CClientScript::POS_END);

        }
        //注册css文件
        foreach($this->cssFiles as $cssFile){
            $clientScript->registerCssFile($this->_assetUrl.$cssFile);
        }
        //判断是否存在module
        if($this->owner->module!=null){
            $moduleId=$this->owner->module->id;
            $this->serverUrl=Yii::app()->createUrl($moduleId.'/ueditor');
        }else{
            $this->serverUrl=Yii::app()->createUrl('ueditor');
        }
        //config
        $this->config['serverUrl']=$this->serverUrl;
        switch($this->type){
            case 'file':
                $view = 'file';
                break;
            case 'image':
                $view = 'image';
                break;
            case 'images':
                $view = 'images';
                break;
            case 'textarea':
            default:
                $view = 'ueditor';
                break;
        }
        $this->render($view);


    }


}