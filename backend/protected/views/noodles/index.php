<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
		array('name' => '首页', 'url' => array('site/index')),
		array('name'=>'菜品管理'),
		array('name' => '菜品列表', 'url' => array('noodles/index')),
);
$this->pageTitle = '菜品管理';
$this->title = '菜品管理';
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- Begin: life time stats -->
		<div class="portlet">
			<div class="portlet-title form-horizontal">
				<div class="caption">
					<i class="fa fa-paper-plane"></i>菜品管理
				</div>
				<div class="actions">
					<a class="btn default yellow-stripe" href="<?php echo Yii::app()->createUrl('noodles/add')?>">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">菜品添加 </span>
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-container">
					<table class="table table-striped table-bordered table-hover" id="datatable_list">
						<thead>
						<tr role="row" class="heading">
							<th width="5%">ID </th>
							<th width="10%">面条名称</th>
							<th width="10%">菜品类型</th>
							<th width="10%">单价</th>
							<th width="20%">简介</th>
							<th width="15%">操作</th>
						</tr>
						<tr>
							<th width="5%"> </th>
							<th width="10%"> <input class="form-control form-filter input-sm" type="text" name="name" placeholder="名称"/> </th>
							<th width="15%">
								<select class="form-control form-filter input-sm"   title="菜品类型"  name="noodtype">
									<option>--未选择</option>
									<option>干馏系列</option>
									<option>汤面系列</option>
									<option>抄手系列</option>
									<option>精品小吃</option>
								</select>

							</th>
							<th width="10%"><input class="form-control form-filter input-sm" type="text" name="noodtype" placeholder="单价"/>  </th>
							<th width="20%"><input class="form-control form-filter input-sm" type="text" name="nooddetail" placeholder="简介"/>  </th>
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