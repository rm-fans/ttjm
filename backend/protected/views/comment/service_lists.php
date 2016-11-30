<?php
/* @var $this ServiceController */
$this->breadcrumbs=array(
    array('name' => '首页','url'=>array('site/index') ),
    array('name'=>'评论管理'),
    array('name'=>'律师评论汇总')
);
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-paper-plane"></i>律师评论管理
                </div>
            </div>
            <div class="portlet-body">
                <span style="font-size: 22px">开启审核机制：<b style="color: red"><?php echo $audit['value']?'已开启':'关闭';?></b></span>
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="10%">
                                发布时间
                            </th>
                            <th width="10%">
                                律师名称
                            </th>
<!--                            <th width="10%">-->
<!--                                用户名-->
<!--                            </th>-->
                            <th width="20%">
                                内容
                            </th>
                            <th width="10%">
                                是否置顶
                            </th>
                            <th width="10%">
                                是否通过审核
                            </th>
                            <th width="5%">
                                删除
                            </th>
                        </tr>
                        <th width="10%">
                        </th>
                        <th width="10%">
                            <input class="form-control form-filter input-sm" type="text" name="username" placeholder="律师名称"/>
                        </th>
<!--                        <th width="10%">-->
<!--                            <input class="form-control form-filter input-sm" type="text" name="username" placeholder="用户名"/>-->
<!--                        </th>-->
                        <th width="20%">
                            <input class="form-control form-filter input-sm" type="text" name="content" placeholder="内容"/>
                        </th>
                        <th width="5%">
                            <select  name="is_top" class="form-control form-filter input-sm">
                                <option value="" selected="selected">请选择</option>
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </th>
                        <th width="5%">
                            <select  name="status" class="form-control form-filter input-sm">
                                <option value="" selected="selected">请选择</option>
                                <option value="1">通过</option>
                                <option value="-1">不通过</option>
                            </select>
                        </th>
                        <th width="25%">
                            <button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search">搜索</i></button>
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
<input type="hidden" name="csrf" value="<?php echo Yii::app()->request->getCsrfToken() ?>">
<!-- END PAGE CONTENT-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<!--style-->
<link
    href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"
    rel="stylesheet" type="text/css"/>
<script>
    jQuery(document).ready(function () {
        var url = '<?php echo $this->createUrl("ServiceComment",array('isAjax'=>1))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url, token);
    });
    $(document).on('click', '.bootbox-confirm', function () {
        var button = $(this);
        bootbox.confirm("确认删除？", function (result) {
            if (result) {
                var url = button.attr('rel');
                $.getJSON(url, function (backdata) {
                    if (backdata.success == 1) {
                        bootbox.alert("删除成功", function () {
                            window.location.href = '';
                        });
                    } else {
                        bootbox.alert("删除失败");
                    }
                });
            }
        });
    });
    function status(id,$this){
        var status=$this.val();
        var url="<?php echo $this->createUrl('comment/serviceajax');?>";
        $.ajax({
            type:"POST",
            url:url,
            data:{id:id,s:status},
            success:function(e){
            }
        });
    }
    function is_top(id,$this){
        var top=$this.val();
        var url="<?php echo $this->createUrl('comment/serviceajax');?>";
        $.ajax({
            type:"POST",
            url:url,
            data:{id:id,c:top},
            success:function(e){
            }
        });
    }
</script>