<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'伙伴管理'),
    array('name' => '伙伴列表', 'url' => array('article/team')),
    array('name'=>'修改伙伴')
);
$this->pageTitle = '修改伙伴';
$this->title = '伙伴管理<small>修改伙伴</small>';
?>
<div class="page-bar">
    <?php echo $this->renderPartial("team_form",$result);?>
</div>
