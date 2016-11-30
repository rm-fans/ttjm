<?php
/* @var $this ProjectController */
/* @var $model ProjectModel */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '资产管理',),
    array('name' => '待审核', 'url' => array('auditProject/index')),
    array('name'=>'项目管理')
);
$this->pageTitle = '编辑资产';
$this->title = '资产管理 <small>编辑资产</small>';
?>

<?php echo $this->renderPartial('/entrustProject/_create_form', $result); ?>
