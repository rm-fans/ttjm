<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '友情链接管理', 'url' => array('FriendLink/index')),
    array('name'=>'友情链接添加')
);
$this->pageTitle = '友情链接';
$this->title = '表单 <small>友情链接添加</small>';
?>
<div class="page-bar">
          <?php echo $this->renderPartial("_form",array('model'=>$model));?>
        <!-- END PORTLET-->

</div>
