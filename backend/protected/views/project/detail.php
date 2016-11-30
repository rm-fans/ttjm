<?php

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '资产管理',),
    array('name' => '非委托', 'url' => array('project/pubIndex')),
    array('name'=>'项目详情')
);
$this->pageTitle = '项目详情';
$this->title = '非委托 <small>项目详情</small>';
?>

<?php $this->renderPartial('_detail_form', $result);?>