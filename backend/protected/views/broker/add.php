<?php
$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'经纪人管理', 'url' => array('broker/index')),
    array('name'=>'添加经纪人')
);
?>
<div class="page-bar">
    <?php echo $this->renderPartial("addForm",$result);?>
    <!-- END PORTLET-->

</div>