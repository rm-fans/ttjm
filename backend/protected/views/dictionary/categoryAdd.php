<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '分类列表', 'url' => array('dictionary/CategoryList')),
    array('name'=>'添加分类')
);
$this->pageTitle = '添加分类';
$this->title = '分类管理<small>添加分类</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial("categoryForm",array('model'=>$model));?>
</div>
