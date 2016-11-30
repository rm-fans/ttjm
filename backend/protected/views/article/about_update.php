<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'关于我们'),
    array('name' => '关于我们', 'url' => array('article/about')),
    array('name'=>'修改信息')
);
$this->pageTitle = '修改信息';
$this->title = '关于我们<small>修改信息</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial("about_form",$result);?>
</div>
