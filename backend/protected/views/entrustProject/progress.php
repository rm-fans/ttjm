<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */
/* 委托审核列表*/

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

                    <div style="padding: 5px;">中介：<?php echo $agent;?></div>
                    <div style="padding: 5px;">服务商：<?php echo $service;?></div>
                    <div style="padding: 5px;"><a href="#responsive" class="btn green"  data-toggle="modal">重新派单</a></div>
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
                            <th width="10%" class="sorting_disabled"> 用户名 </th>
                            <th width="10%" class="sorting_disabled"> 提交时间 </th>
                            <th width="10%" class="sorting_disabled">律师id</th>
                            <th width="10%" class="sorting_disabled">律师</th>
                            <th width="10%" class="sorting_disabled">中介id</th>
                            <th width="10%" class="sorting_disabled">中介</th>
                            <th width="10%" class="sorting_disabled"> 律师服务费用</th>
                            <th width="10%" class="sorting_disabled"> 中介服务费用</th>
                            <th width="10%" class="sorting_disabled"> 当前状态</th>
                            <th width="10%" class="sorting_disabled"> 下一项工作</th>
                            <th width="15%" class="sorting_disabled"> 操作</th>
                            <th width="10%" class="sorting_disabled"> 备注</th>
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

<!--弹框-->
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">重新派单</h4>
            </div>
            <form action="#" id="form-username" class="form-horizontal form-bordered">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">手机号码：</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="tel" class="form-control task_tel">
                            </div>
                        </div>
                    </div>
                </div>
             </form>
            <div class="modal-footer" style="text-align: center">
                <button type="button" data-dismiss="modal" class="btn default">取消</button>
                <button type="button" id="task_button" class="btn green"  name="" value="" >确认</button>
            </div>
        </div>
    </div>
</div>
<div id="progress_detail" class="modal fade" tabindex="-1" aria-hidden="true">
</div>
<!-- END PAGE CONTENT-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<!--style-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/jquery.min.js" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
    function updateFlowStatus(order_id,to_status,type) {
        var url = "<?= $this->createUrl('updateFlowStatus')?>";
        //showDialog('提示', '确定本次操作?',true,true,false, function () {
            $.ajax({
                type:'POST',
                async : false,
                dataType: 'json',
                data:{order_id:order_id,to_status:to_status,type:type,csrf: $('input[name="csrf"]').val()},
                url:url,
                success:function(data){
                    if(data.result)
                    {
                        alert('操作成功');
                        location.reload();
                    }else{
                        alert('操作失败');
                    }
                }
            });
        //},'否','是');
    }
</script>
<script>
    jQuery(document).ready(function() {
        var url = '<?php echo $this->createUrl("/entrustProject/progress",array('id'=>$id))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);

    });
    $("#task_button").click(function(){
        var id = "<?php echo $id;?>";
        var phone = $('.task_tel').val();
        $.ajax({
            url:'<?php echo $this->createUrl('entrustProject/orderTask')?>',
            dataType:'json',
            type:'post',
            data:{id:id,phone:phone,csrf:$('input[name="csrf"]').val()},
            success:function(data){
                alert(data.message);
                $('#responsive').modal('hide')
            }
        });
    })
    function progress_detail(order_id,service_uid,agent_uid)
    {
        $.ajax({
            url:'<?php echo $this->createUrl('entrustProject/progressDetail')?>',
            dataType:'json',
            type:'post',
            data:{order_id:order_id,service_uid:service_uid,agent_uid:agent_uid,csrf:$('input[name="csrf"]').val()},
            success:function(data){
                $('#progress_detail').html(data.data.html);
                $('#progress_detail').modal('show')
            }
        });
    }

    function order_contract(order_id)
    {
        $.ajax({
            url:'<?php echo $this->createUrl('entrustProject/orderContract')?>',
            dataType:'json',
            type:'post',
            data:{order_id:order_id,csrf:$('input[name="csrf"]').val()},
            success:function(data){
                $('#progress_detail').html(data.data.html);
                $('#progress_detail').modal('show')
            }
        });
    }
    function pay_button(order_id,project_id)
    {
        $.ajax({
            url:'<?php echo $this->createUrl('entrustProject/orderLogUpdate')?>',
            dataType:'json',
            type:'post',
            data:{order_id:order_id,project_id:project_id,csrf:$('input[name="csrf"]').val()},
            success:function(data){
               window.location.reload(true);
            }
        });
    }

</script>