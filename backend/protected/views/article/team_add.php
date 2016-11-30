<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'文章管理'),
    array('name' => '伙伴列表', 'url' => array('article/team')),
    array('name'=>'添加伙伴')
);
$this->pageTitle = '添加伙伴';
$this->title = '文章管理<small>添加文章</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial("team_form",$result);?>
</div>
