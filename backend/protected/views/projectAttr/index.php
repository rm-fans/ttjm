<?php
$this->breadcrumbs=array(
    array('name' => '资产属性管理'),
    array('name'=>'资产类别'),
);
$this->title = '资产属性管理';
?>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-child"></i>资产类别
                </div>
                <div class="actions">
                    <a href="<?php echo Yii::app()->createUrl('projectAttr/add')?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i><span class="hidden-480">资产类别添加 </span>
                    </a>
                </div>
            </div>
            
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="20%">资产类别ID</th>
                            <th width="20%">资产类别名称</th>
                            <th width="20%">是否有效</th>
                            <th width="40%">操作</th>
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
        var url = '<?php echo $this->createUrl("index",array('isAjax'=>1))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token,'','',15);
    });
        
</script>