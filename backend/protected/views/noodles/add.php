<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('/site/index')),
    array('name' => '菜品列表','url'=>array('noodles/index')),
    array('name'=>'添加菜品')
);
?>
<?php $this->renderPartial('_form', $result); ?>