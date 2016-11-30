<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'文章管理'),
    array('name' => '分类列表', 'url' => array('dictionary/CategoryList')),
    array('name'=>'更新分类')
);
$this->pageTitle = '更新分类';
$this->title = '分类管理<small>分类管理</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial('categoryForm',array('model'=>$model));?>
</div>
