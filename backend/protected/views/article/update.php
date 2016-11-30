<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'文章管理'),
    array('name' => '文章列表', 'url' => array('article/CategoryList')),
    array('name'=>'更新文章')
);
$this->pageTitle = '更新文章';
$this->title = '文章管理<small>文章管理</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial('form',array('model'=>$model,'category'=>$category));?>
</div>
