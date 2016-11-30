<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('/site/index')),
    array('name' => '服务商机构列表','url'=>array('service/org_index')),
    array('name'=>'添加服务商机构')
);
?>
<?php $this->renderPartial('org_form', $result); ?>