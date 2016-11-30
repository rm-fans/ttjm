<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-child"></i>服务商详情
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-lg" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#tab_1" aria-expanded="true" data-id="1">
                                服务商基本信息 </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div id="tab_1" class="tab-pane active">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <tbody>
                                    <tr>
                                        <td width='30%'>形象照片</td>
                                        <td width='70%'><a href="<?= $detail->img_src?>" target="_blank"><img src="<?php echo $detail->img_src?>" style="width: 50px;height: 50px;"/></a></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>UID</td>
                                        <td width='70%'><?php echo $profile->uid?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>所属角色</td>
                                        <td width='70%'>
                                            <h4><b><?php $name=' ';
                                            if($profile->is_agent)$name.=' 中介，';
                                            if($profile->is_service)$name.=' 服务商';
                                            echo $name;
                                            ?></b></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>名称</td>
                                        <td width='70%'><?php echo $profile->username?></td>
                                    </tr>

                                    <tr>
                                        <td width='30%'>认证执照</td>
                                        <td width='70%'><a href="<?php echo $detail->service_license_src?>" target="_blank"><img src="<?php echo $detail->service_license_src?>" style="width: 50px;height: 50px;"/></a></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>地址</td>
                                        <td width='70%'> <?php echo $profile->area?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>手机号码</td>
                                        <td width='70%'> <?php echo Utils::decrypt($profile->phone)?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>真实姓名</td>
                                        <td width='70%'> <?php echo $profile->identity_name?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>身份证号码</td>
                                        <td width='70%'> <?php echo $profile->identity_card?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>开户行</td>
                                        <td width='70%'> <?= isset($bank->bank_name)?Utils::decrypt($bank->bank_name):'';?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>银行卡号</td>
                                        <td width='70%'>  <?= isset($bank->bank_card)?Utils::decrypt($bank->bank_card):'';?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>行业</td>
                                        <td width='70%'> <?php echo $industry?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>QQ</td>
                                        <td width='70%'> <?php echo $profile->qq?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>微信</td>
                                        <td width='70%'> <?php echo $profile->wechat?> </td>
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