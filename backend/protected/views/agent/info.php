
<?php
$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'中介管理')
);
?>
<div class="page-bar">
    <?php echo $this->renderPartial("_form",array('detail'=>$detail,'model'=>$model));?>
    <!-- END PORTLET-->
</div>