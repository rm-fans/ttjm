<?php
/* @var $this TaskController */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'派单管理'),
    array('name' => '派单列表', 'url' => array('/task/taskList')),
    array('name'=>'派单管理')
);
$this->pageTitle = '派单管理';
$this->title = '派单管理<small>派单管理</small>';
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-paper-plane"></i>派单<?=$type==1?"律师":"中介" ?>管理
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="35%"><?=$type==1?"律师":"中介" ?>名字</th>
                            <th width="35%">已接单数 </th>
                            <th width="30%">接单状态</th>
                        </tr>
                        <tr>
                            <th width="35%"> </th>
                            <th width="35%"> </th>
                            <th width="30%"> </th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>
<input type="hidden" name="csrf" value="<?php echo Yii::app()->request->getCsrfToken()?>">
<!-- END PAGE CONTENT-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<!--style-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<script>
    jQuery(document).ready(function() {
        var url = '<?php echo $this->createUrl("TaskInfo",array('isAjax'=>1,"projectid"=>$projectid,"type"=>$type))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);
    });

</script>