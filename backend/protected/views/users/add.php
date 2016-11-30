<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('/site/index')),
    array('name' => '用户列表','url'=>array('users/index')),
    array('name'=>'添加用户')
);
?>
<?php $this->renderPartial('_form', $result); ?>