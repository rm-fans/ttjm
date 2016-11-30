<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '资产管理',),
    array('name' => '待审核', 'url' => array('auditProject/index')),
    array('name'=>'项目列表')
);
$this->pageTitle = '项目列表';
$this->title = '待审核 <small>项目列表</small>';
?>
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-paper-plane"></i>项目列表
                </div>
                <div class="actions">
                    <a class="btn default yellow-stripe" href="<?php echo Yii::app()->createUrl('entrustProject/create')?>">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">项目添加 </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th > 资产ID </th>
                            <th >资产标题</th>
                            <th > 合同金额 </th>
                            <th > 卖方 </th>
                            <th > 买方uid </th>
                            <th > 律师uid </th>
                            <th > 律师服务费 </th>
                            <th > 中介uid </th>
                            <th > 中介服务费 </th>
                            <th > 完成时间 </th>
                            <th > 操作</th>
                        </tr>
                        <tr role="row">
                            <th ><input class="form-control form-filter input-sm" type="text" name="projectId" placeholder="资产ID"></th>
                            <th ><input class="form-control form-filter input-sm" type="text" name="title" placeholder="资产标题"></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ><button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search">搜索</i></button><button class="btn btn-sm red filter-cancel"><i class="fa fa-times">重置</i></button></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
<link href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/jquery.min.js" rel="stylesheet" type="text/css"/>
<script>
    jQuery(document).ready(function() {

        var url = '<?php echo $this->createUrl("entrustProject/".$action,array('isAjax'=>1))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);


    });
</script>