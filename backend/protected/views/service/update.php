<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '服务商管理', 'url' => array('service/index')),
    array('name'=>'修改服务商')
);
?>

<?php $this->renderPartial('_form', $result); ?>