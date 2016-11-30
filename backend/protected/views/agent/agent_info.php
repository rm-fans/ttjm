<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('/site/index')),
    array('name' => '中介列表','url'=>array('agent/index')),
    array('name'=>'中介详情')
);
?>
<?php $this->renderPartial('agent_info_form',array('bank'=>$bank,'profile'=>$profile,'detail'=>$detail,'industry'=>$industry_name)); ?>