<?php
/* @var $this ServiceController */
$this->breadcrumbs=array(
    array('name' => '首页','url'=>array('site/index') ),
    array('name'=>'认证日志')
);
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-paper-plane"></i>认证日志
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">
                                UID
                            </th>
                            <th width="10%">
                                照片
                            </th>
                            <th width="10%">
                                身份证号
                            </th>

                            <th width="10%">
                                真实姓名
                            </th>
                            <th width="10%">
                                律师资格证
                            </th>
                            <th width="10%">
                                名片(中介认证）
                            </th>
                            <th width="8%">
                                认证类型
                            </th>
                            <th width="8%">
                                认证状态
                            </th>
                            <th width="8%">
                                创建时间
                            </th>
                            <th width="8%">
                                完成时间
                            </th>
                            <th width="15%">
                                操作
                            </th>
                        </tr>
                        <tr>
                            <!--							<th width="5%"> </th>-->
                           <!-- <th width="15%"><input class="form-control form-filter input-sm" type="text" name="name" placeholder="机构名称"/> </th>
                            <th width="10%"> </th>
                            <th width="8%"> </th>
                            <th width="15%"> <input class="form-control form-filter input-sm" type="text" name="area" placeholder="地址"/> </th>
                            <th width="10%"> </th>
                            <th width="10%"></th>
                            <th width="8%"> </th>
                            <th width="20%">
                                <button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search">搜索</i></button>
                                <button class="btn btn-sm red filter-cancel"><i class="fa fa-times">重置</i></button>
                            </th>-->
                            <th width="5%">
                            </th>
                            <th width="10%">
                            </th>
                            <th width="10%">
                            </th>
                            <th width="10%">
                            </th>
                            <th width="10%">
                            </th>
                            <th width="10%">
                            </th>
                            <th width="8%">
                                <select class="form-control form-filter input-sm"   title="认证类型"  name="type">
                                    <option>--未选择</option>
                                    <option>服务商</option>
                                    <option>中介</option>
                                    <option>推荐人</option>
                                </select>
                            </th>
                            <th width="8%">
                                <select class="form-control form-filter input-sm"   title="认证状态"  name="status">
                                    <option>--未选择</option>
                                    <option>待认证</option>
                                    <option>认证成功</option>
                                    <option>认证失败</option>
                                </select>
                            </th>
                            <th width="8%">
                            </th>
                            <th width="8%">
                                </th>
                            <th width="15%">
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
        <!-- End: life time stats -->
    </div>
</div>
<input type="hidden" name="csrf" value="<?php echo Yii::app()->request->getCsrfToken() ?>">
<!-- END PAGE CONTENT-->
<script type="text/javascript"
        src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
        src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<!--style-->
<link
    href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"
    rel="stylesheet" type="text/css"/>
<script>
    jQuery(document).ready(function () {
        var url = '<?php echo $this->createUrl("oauth/oauthlog",array('isAjax'=>1))?>';
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
</script>
