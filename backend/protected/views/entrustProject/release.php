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

                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="2%" class="sorting_disabled"> id </th>
                            <th width="5%"> 资产ID </th>
                            <th width="5%"> 发布用户 </th>
                            <th width="5%"> 推荐 </th>
                            <th width="15%">资产标题</th>
                            <th width="10%" class="sorting_disabled">资产上线时间</th>
                            <th width="10%" class="sorting_disabled">状态</th>
                            <!--<th width="5%" class="sorting_disabled">是否派单</th>
                            <th width="5%" class="sorting_disabled">意向客户</th>-->
                            <th width="15%"> 操作</th>
                        </tr>
                        <tr role="row">
                            <th width="15%">
                                <input class="form-control form-filter input-sm" type="text" name="id" placeholder="id">
                            </th>
                            <th width="15%">
                                <input class="form-control form-filter input-sm" type="text" name="projectId" placeholder="资产ID">
                            </th>
                            <th width="15%">
                            </th>
                            <th width="5%">
                                <select class="form-control form-filter input-sm" name="is_recommend">
                                    <option value="" selected="selected">推荐</option>
                                    <option value="1">是</option>
                                    <option value="0" >否</option>
                                </select>
                            </th>
                            <th width="5%">
                                <input class="form-control form-filter input-sm" type="text" name="title" placeholder="资产标题">
                            </th>

                            <th width="10%">

                            </th>
                            <th width="10%">
                            </th>
                            <!--<th width="5%">
                            </th>
                            <th width="5%">
                            </th>-->
                            <th width="15%">
                                <button class="btn btn-sm yellow filter-submit margin-bottom">
                                    <i class="fa fa-search">搜索</i>
                                </button>
                                <button class="btn btn-sm red filter-cancel"><i class="fa fa-times">重置</i></button>
                            </th>
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
<!--弹框-->
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">平台下架</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer" style="text-align: center">
                <button type="button" data-dismiss="modal" class="btn default">取消</button>
                <button type="button" id="shelf_value" class="btn green"  name="" value="" >确认</button>
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
        var url = '<?php echo $this->createUrl("entrustProject/release",array('isAjax'=>1))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);
    });
    function proShelf(project_id){
        $("#shelf_value").val('');
        $("#shelf_value").val(project_id);
        $("#responsive").modal('show');
    }
    $('#shelf_value').click(function(){
        var id = $(this).val();
        $.ajax({
            url:'<?php echo $this->createUrl('project/updateStatus')?>',
            dataType:'json',
            type:'post',
            data:{"id":id,status:<?php echo ProjectModel::STATUS_SHELF;?>,"csrf":$('input[name="csrf"]').val()},
            success:function(_data){
                location.reload();
            }

        });
    })
</script>
