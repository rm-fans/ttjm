<?php
$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '短信日志','url'=>array('sms/index')),
    array('name' => '短信列表')
);


?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="portlet">

            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-building"></i>短信列表
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">ID</th>
                            <th width="10%">手机号码 </th>
                            <th width="10%">发送时间</th>
                            <th width="40%">短信内容</th>
                            <th width="10%">短信类型</th>
                            <th width="5%">状态</th>
                            <th width="10%">操作</th>
                        </tr>
                        <tr>
                            <th width="5%"></th>
                            <th width="10%"><input type="text" name="phone" class="form-control form-filter input-sm" placeholder="手机号码"></th>
                            <th width="10%">
                                <div class="input-group date date-picker margin-bottom-5"  data-date="" data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
                                    <input type="text" class="form-control form-filter input-sm" readonly="" name="order_date_from" placeholder="从">
											<span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
                                </div>
                                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
                                    <input type="text" class="form-control form-filter input-sm" readonly="" name="order_date_to" placeholder="到">
											<span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
                                </div>
                            </th>
                            <th width="40%"></th>
                            <th width="10%">
                                <select class="form-control form-filter input-sm"   title="短信分类"  name="type">
                                    <option></option>
                                    <option>登录异常</option>
                                    <option>注册</option>
                                    <option>重设密码</option>
                                    <option>其他</option>
                                </select>
                            <th width="5%"></th>
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
        var url = '<?php echo $this->createUrl("information/sms",array('isAjax'=>1))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);
    });
</script>