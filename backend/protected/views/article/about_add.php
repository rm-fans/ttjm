<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'文章管理'),
    array('name' => '关于我们', 'url' => array('article/about')),
    array('name'=>'添加信息')
);
$this->pageTitle = '添加信息';
$this->title = '文章管理<small>添加信息</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial("about_form",$result);?>
</div>
