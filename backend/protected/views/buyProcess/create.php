<?php

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '资产管理',),
    array('name' => '购买流程', 'url' => array('project/pubIndex')),
    array('name'=>'添加模板')
);
$this->pageTitle = '添加模板';
$this->title = '购买流程 <small>添加模板</small>';
?>

<?php $this->renderPartial('_form', $result);?>