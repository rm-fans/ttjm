<?php
$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '通知消息日志','url'=>array('notify/index')),
    array('name' => '消息列表')
);


?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="portlet">

            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-building"></i>消息列表
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">ID</th>
                            <th width="10%">标题</th>
                            <th width="5%">发送至</th>
                            <th width="10%">消息类型</th>
                            <th width="8%">是否查看</th>
                            <th width="10%">发送者</th>
                            <th width="20%">内容</th>
                            <th width="10%">发送时间</th>
                            <th width="10%">阅读时间</th>
                            <th width="10%">操作</th>
                        </tr>
                        <tr>
                            <th width="5%"></th>
                            <th width="10%"><input type="text" name="title" class="form-control form-filter input-sm" placeholder="标题"></th>
                            <th width="5%"></th>
                            <th width="10%">
                                <select class="form-control form-filter input-sm"   title="是否查看"  name="type">
                                    <option>--未选择</option>
                                    <option>系统消息</option>
                                </select>
                            </th>
                            <th width="5%">
                                <select class="form-control form-filter input-sm"   title="是否查看"  name="is_read">
                                    <option>--未选择</option>
                                    <option>已查看</option>
                                    <option>未查看</option>
                                </select></th>
                            <th width="10%"></th>
                            <th width="20%"><input type="text" name="content" class="form-control form-filter input-sm" placeholder="内容"></th>
                            <th width="10%"></th>
                            <th width="10%"></th>
                            <th width="10%" rowspan="1" colspan="1">
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

<input type="hidden" name="csrf" value="<?php echo Yii::app()->request->getCsrfToken()?>">

<link href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<script>
    $(document).ready(function() {
        var url = '<?php echo $this->createUrl("information/notify",array('isAjax'=>1))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);
    });
</script>