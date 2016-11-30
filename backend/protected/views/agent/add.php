<?php
$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'中介管理', 'url' => array('agent/index')),
    array('name'=>'添加中介')
);
?>
<div class="page-bar">
    <?php echo $this->renderPartial("addForm",$result);?>
    <!-- END PORTLET-->

</div>