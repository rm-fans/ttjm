<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-child"></i>用户详情
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-lg" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#tab_1" aria-expanded="true" data-id="1">
                                用户基本信息 </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#tab_2" aria-expanded="false" data-id="2">
                                我要购买
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1" class="tab-pane active">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <tbody>
                                    <tr>
                                        <td width='30%'>用户名</td>
                                        <td width='70%'><?php echo $model->username?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>手机号码</td>
                                        <td width='70%'><?php echo $model->phone?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>昵称</td>
                                        <td width='70%'><?php echo $model->nickname?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>性别</td>
                                        <td width='70%'> <?php echo $model->sex?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>生日</td>
                                        <td width='70%'>  <?php echo $model->birthday?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>真实姓名</td>
                                        <td width='70%'> <?php echo $model->identity_name?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>身份证号码</td>
                                        <td width='70%'> <?php echo $model->identity_card?> </td>
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
                                        <td width='70%'> <?php echo $model->industry_id?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>地址</td>
                                        <td width='70%'> <?php echo $model->address?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>微信号</td>
                                        <td width='70%'> <?php echo $model->wechat?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>QQ</td>
                                        <td width='70%'> <?php echo $model->qq?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>头像</td>
                                        <td width='70%'> <img src="<?php echo $model->avatar?>" height="200" width="200" alt=""/></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tab_2" class="tab-pane">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="datatable_list">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th width="15%">项目名称</th>
                                        <th width="15%">类型</th>
                                        <th width="15%">电话</th>
                                        <th width="15%">名字</th>
                                        <th width="25%">简介</th>
                                        <th width="15%">操作时间</th>
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
        var url = '<?php echo $this->createUrl("info",array('id'=>$model->uid))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);
    });

</script>