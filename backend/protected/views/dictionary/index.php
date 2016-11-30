<?php
/* @var $this BrokerController */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'协议词典管理')
);
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-paper-plane"></i>协议词典管理
                </div>
                <div class="actions">

                    <a class="btn default yellow-stripe" href="<?php echo Yii::app()->createUrl('dictionary/add') ?>">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">词典添加 </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%"> id </th>
                            <th width="10%">问题标题</th>
                            <th width="10%">分类名</th>
                            <th width="12%">解决方案</th>
                            <th width="8%"> 周期计划(日) </th>
                            <th width="10%" >所需价格</th>
                            <th width="11%">状态</th>
                            <th width="10%">创建时间</th>
                            <th width="8%">更新时间</th>
                            <th width="15%">操作</th>
                        </tr>
                        <tr><th width="5%">  </th>
                            <th width="10%"> <input class="form-control form-filter input-sm" type="text"  name="title" placeholder="标题"/> </th>
                            <th width="10%">  </th>
                            <th width="12%"> <input class="form-control form-filter input-sm" type="text"  name="content" placeholder="解决方案"/> </th>
                            <th width="8%">  </th>
                            <th width="10%">  </th>
                            <th width="11%">
                                <select class="form-control form-filter input-sm"   title="是否查看"  name="status">
                                    <option>--未选择</option>
                                    <option>未发布</option>
                                    <option>已发布</option>
                                </select></th>
                            <th width="10%">  </th>
                            <th width="8%">  </th>
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