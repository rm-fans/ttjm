<?php
/* @var $this ServiceController */
$this->breadcrumbs=array(
	array('name' => '首页','url'=>array('site/index') ),
	array('name'=>'服务商管理')
);
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- Begin: life time stats -->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-paper-plane"></i>服务商列表
				</div>
			<div class="actions">

					<a class="btn default yellow-stripe" href="<?php echo Yii::app()->createUrl('service/create') ?>">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">服务商添加 </span>
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-container">
					<table class="table table-striped table-bordered table-hover" id="datatable_list">
						<thead>
						<tr role="row" class="heading">
							<th width="10%">
								ID
							</th>
							<th width="10%">
								名称
							</th>
							<th width="10%">
								手机号码
							</th>
							<th width="8%">
								形象照片
							</th>
							<th width="8%">
								律师资格证
							</th>
							<th width="10%">
								所属行业
							</th>
							<th width="10%">
								认证状态
							</th>
							<th width="5%">
								进行中
							</th>
							<th width="5%">
								已成交
							</th>
							<th width="5%">
								已结束
							</th>
							<th width="30%">
								操作
							</th>
						</tr>
						<th width="10%">
						</th>
						<th width="10%">
							<input class="form-control form-filter input-sm" type="text" name="identity_name" placeholder="名称"/>
						</th>
						<th width="10%">
							<input class="form-control form-filter input-sm" type="text" name="phone" placeholder="手机号码"/>
						</th>
						<th width="8%">
						</th>
						<th width="8%">
						</th>
						<th width="10%">
							<select class="form-control form-filter input-sm"   title="行业"  name="industry_id">
								<option>--未选择</option>
								<option>律师</option>
								<option>银行行业</option>
								<option>金融行业</option>
								<option>房产行业</option>
								<option>拍卖行业</option>
								<option>其它</option>
							</select>
						</th>
						<th width="10%">
							<select class="form-control form-filter input-sm"   title="认证状态"  name="status">
								<option>--未选择</option>
								<option>待认证</option>
								<option>认证成功</option>
								<option>认证失败</option>
							</select>
						</th>
						<th width="10%">
						</th>
						<th width="10%">
						</th>
						<th width="5%">
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
<link href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/jquery.min.js" rel="stylesheet" type="text/css"/>
<script>
	jQuery(document).ready(function () {
		var url = '<?php echo $this->createUrl("service/index",array('isAjax'=>1))?>';
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
