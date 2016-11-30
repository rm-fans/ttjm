<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'合作伙伴'),
    array('name' => '合作列表', 'url' => array('article/team')),
    array('name'=>'合作伙伴')
);
$this->pageTitle = '合作伙伴';
$this->title = '文章管理<small>合作伙伴</small>';
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-paper-plane"></i>合作伙伴
                </div>
                <div class="actions">

                    <a class="btn default yellow-stripe" href="<?php echo Yii::app()->createUrl('article/teamadd')?>">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">添加合作伙伴 </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_list">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="15%">标题 </th>
                            <th width="15%">分类</th>
                            <th width="5%">有效 </th>
                            <th width="5%">发布人 </th>
                            <th width="5%">排序</th>
                            <th width="15%">操作</th>
                        </tr>
                        <tr>
                            <th width="15%"> <input class="form-control form-filter input-sm" type="text" name="title" placeholder="标题"/> </th>
                            <th width="15%"> </th>
                            <th width="5%"> </th>
                            <th width="5%"> </th>
                            <th width="5%"> </th>
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
        var url = '<?php echo $this->createUrl("team",array('isAjax'=>1))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);
    });

</script>