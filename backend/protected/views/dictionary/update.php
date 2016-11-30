<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'词典管理'),
    array('name' => '词典列表', 'url' => array('dictionary/index')),
    array('name'=>'更新词典')
);
$this->pageTitle = '更新词典';
$this->title = '词典列表<small>更新词典</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial('form',array('model'=>$model,'category'=>$category));?>
</div>
