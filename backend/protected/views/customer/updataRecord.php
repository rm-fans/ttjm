<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'客户管理'),
    array('name' => '客服客户管理', 'url' => array('customer/lineList')),
    array('name'=>'更新客户')
);
$this->pageTitle = '更新客户';
$this->title = '更新客户<small>更新客户</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial("recordForm",array('model'=>$model,'state'=>$state,'type'=>'updata'));?>
</div>
