<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
		array('name' => '首页', 'url' => array('site/index')),
		array('name'=>'用户管理'),
		array('name' => '用户列表', 'url' => array('article/index')),
		array('name'=>'用户管理')
);
$this->pageTitle = '用户管理';
$this->title = '用户管理<small>用户管理</small>';
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- Begin: life time stats -->
		<div class="portlet">
			<div class="portlet-title form-horizontal">
				<div class="caption">
					<i class="fa fa-paper-plane"></i>用户管理
				</div>
				<div class="actions">
					<a class="btn default yellow-stripe" href="<?php echo Yii::app()->createUrl('users/add')?>">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">用户添加 </span>
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-container">
					<table class="table table-striped table-bordered table-hover" id="datatable_list">
						<thead>
						<tr role="row" class="heading">
							<th width="5%">ID </th>
							<th width="8%">UID </th>
							<th width="10%">手机号</th>
							<th width="10%">用户名</th>
							<th width="10%">角色</th>
							<th width="10%">姓名</th>
							<th width="10%">用户状态</th>
							<th width="15%">操作</th>
						</tr>
						<tr>
							<th width="5%"> </th>
							<th width="8%"> <input class="form-control form-filter input-sm" type="text" name="uid" placeholder="用户编号"/> </th>
							<th width="10%"> <input class="form-control form-filter input-sm" type="text" name="phone" placeholder="手机号"/> </th>
							<th width="10%"><input class="form-control form-filter input-sm" type="text" name="username" placeholder="用户名"/>  </th>
							<th width="15%">
								<select class="form-control form-filter input-sm"   title="角色"  name="roles">
									<option>--未选择</option>
									<option>律师</option>
									<option>经纪人</option>
									<option>推荐人</option>
								</select>

							</th>
							<th width="15%"><input class="form-control form-filter input-sm" type="text" name="identity_name" placeholder="姓名"/>  </th>
							<th width="10%"><select class="form-control form-filter input-sm"   title="状态"  name="status">
									<option>--未选择</option>
									<option>正常</option>
									<option>冻结</option>
								</select>
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
		EcommerceList.init(url,token);
	});

</script>