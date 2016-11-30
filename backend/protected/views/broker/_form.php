<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-child"></i>经纪人详情
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-lg" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#tab_1" aria-expanded="true" data-id="1">
                                经纪人基本信息 </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div id="tab_1" class="tab-pane active">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <tbody>
                                    <tr>
                                        <td width='30%'>头像</td>
                                        <td width='70%'><img src="<?php echo isset($model->avatar)?$model->avatar:'';?>" style="width: 50px;height: 50px;"/></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>用户名</td>
                                        <td width='70%'><?php echo $model->username?$model->username:'';?></td>
                                    </tr>

                                    <tr>
                                        <td width='30%'>手机号码</td>
                                        <td width='70%'><?php echo $model->phone?$model->phone:'';?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>邀请人</td>
                                        <td width='70%'><?php echo isset($invite->username)?$invite->username:'';?> </td>
                                    </tr>


                                    <tr>
                                        <td width='30%'>真实姓名</td>
                                        <td width='70%'> <?php echo isset($model->identity_name)?$model->identity_name:'';?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>身份证号码</td>
                                        <td width='70%'> <?php echo isset($model->identity_card)?$model->identity_card:'';?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>行业</td>
                                        <td width='70%'> <?php echo isset($model->industry_id)?$model->industry_id:'';?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>地址</td>
                                        <td width='70%'> <?php echo isset($model->address)?$model->address:'';?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>描述</td>
                                        <td width='70%'> <?php echo $detail->desc?$detail->desc:'';?> </td>
                                    </tr>

                                    <tr>
                                        <td width='30%'>从业资格证</td>
                                        <td width='70%'> <img src="<?php echo isset($detail->certificate_src)?$detail->certificate_src:'';?>" height="200" width="200" alt=""/></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>名片</td>
                                        <td width='70%'> <img src="<?php echo isset($detail->business_card_src)?$detail->business_card_src:'';?>" height="200" width="200" alt=""/></td>
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
<!--<script>-->
<!--    jQuery(document).ready(function() {-->
<!--        var url = '--><?php //echo $this->createUrl("detail",array('id'=>$model->uid))?><!--';-->
<!--        var token = $("input[name='csrf']").val();-->
<!--        EcommerceList.init(url,token);-->
<!--    });-->
<!---->
<!--</script>-->