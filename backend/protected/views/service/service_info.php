<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('/site/index')),
    array('name' => '服务商列表','url'=>array('service/index')),
    array('name'=>'服务商详情')
);
?>
<?php $this->renderPartial('service_info_form',array('bank'=>$bank,'profile'=>$profile,'detail'=>$detail,'industry'=>$industry_name)); ?>