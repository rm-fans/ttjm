
<?php
$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'经纪人管理')
);
?>
<div class="page-bar">

    <?php echo $this->renderPartial("_form",array('detail'=>$detail,'model'=>$model,'invite'=>$invite));?>
    <!-- END PORTLET-->

</div>