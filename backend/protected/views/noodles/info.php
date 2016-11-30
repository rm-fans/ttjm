<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-child"></i>产品详情
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-lg" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#tab_1" aria-expanded="true" data-id="1">
                                产品基本信息 </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1" class="tab-pane active">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <tbody>
                                    <tr>
                                        <td width='30%'>名称</td>
                                        <td width='70%'><?php echo $model->name?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>类型</td>
                                        <td width='70%'><?php echo NoodlesModel::noodlesname($model->noodtype);?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>平均单价</td>
                                        <td width='70%'><?php echo $model->noodprice?> 元/碗</td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>详情</td>
                                        <td width='70%'> <?php echo $model->nooddetail?> </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        var url = '<?php echo $this->createUrl("info",array('id'=>$model->id))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);
    });

</script>