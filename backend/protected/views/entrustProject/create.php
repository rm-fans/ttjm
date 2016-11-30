<?php

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '资产管理',),
    array('name' => '待审核', 'url' => array('project/pubIndex')),
    array('name'=>'添加项目')
);
$this->pageTitle = '添加项目';
$this->title = '待审核 <small>添加项目</small>';
?>

<?php $this->renderPartial('_create_form', $result);?>
