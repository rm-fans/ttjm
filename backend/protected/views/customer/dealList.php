<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
		array('name' => '首页', 'url' => array('site/index')),
		array('name'=>'客户管理'),
		array('name' => '成交客户列表', 'url' => array('customer/dealList')),
		array('name'=>'成交客户列表')
);
$this->pageTitle = '成交客户列表';
$this->title = '成交客户列表<small>成交客户列表</small>';
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- Begin: life time stats -->
		<div class="portlet">
			<div class="portlet-title form-horizontal">
				<div class="caption">
					<i class="fa fa-paper-plane"></i>成交客户列表
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-container">
					<table class="table table-striped table-bordered table-hover" id="datatable_list">
						<thead>
						<tr role="row" class="heading">
							<th width="14%">资产ID</th>
							<th width="14%">成交时间 </th>
							<th width="14%">成交价格 </th>
							<th width="14%">客户名称</th>
							<th width="15%">客户电话</th>
							<th width="14%">项目联系人</th>
							<th width="15%">操作</th>
						</tr>
						<tr>
							<th width="14%"><input class="form-control form-filter input-sm" type="text" name="projectId" placeholder="资产ID"/> </th>
							<th width="14%"></th>
							<th width="14%"></th>
							<th width="14%"></th>
							<th width="15%"></th>
							<th width="14%"></th>
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
		var url = '<?php echo $this->createUrl("dealList",array('isAjax'=>1))?>';
		var token = $("input[name='csrf']").val();
		EcommerceList.init(url,token);
	});

</script>