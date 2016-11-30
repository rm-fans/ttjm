<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '中介管理', 'url' => array('agent/index')),
    array('name'=>'修改中介')
);
?>

<?php $this->renderPartial('addForm', $result); ?>