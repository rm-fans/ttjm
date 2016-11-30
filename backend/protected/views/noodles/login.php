<script src="<?php echo Yii::app()->request->baseUrl;?>/static/js/My97DatePicker/WdatePicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-child"></i>用户登录
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <?php if(!isset($uid)): ?>
                    <form enctype="multipart/form-data" id="product-model-form" method="post">
                        <table class="table table-striped table-hover table-bordered">
                            <tbody>
                            <tr>
                                <td width='30%'>用户名</td>
                                <td width='70%'><input class="form-control" name="username" id="User_username" type="text"></td>
                            </tr>
                            <tr>
                                <td width='30%'>密码</td>
                                <td width='70%'><input class="form-control" name="password" id="User_password" type="password"></td>
                            </tr>
                            <tr>
                                <td width='30%'></td>
                                <td width='70%'>
                                    <button class="btn green" type="submit"><i class="fa fa-check"></i> 登录</button>
                                    <button class="btn default" type="reset"><i class="fa fa-reply"></i> 重置</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                    <?php else:?>
                    <table class="table table-striped table-hover table-bordered">
                        <tbody>
                        <tr>
                            <td width='30%'>用户uid</td>
                            <td width='70%'><?php echo $uid['data']['uid']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>登录access_token</td>
                            <td width='70%'><?php echo $uid['data']['access_token']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>登录refresh_token</td>
                            <td width='70%'><?php echo $uid['data']['refresh_token']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>刷新access_token</td>
                            <td width='70%'><?php echo $token['data']['access_token']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>刷新refresh_token</td>
                            <td width='70%'><?php echo $token['data']['refresh_token']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>用户uid</td>
                            <td width='70%'><?php echo $info['data']['uid']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>用户名</td>
                            <td width='70%'><?php echo $info['data']['username']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>邮箱</td>
                            <td width='70%'><?php echo $info['data']['email']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>电话</td>
                            <td width='70%'><?php echo $info['data']['phone']?></td>
                        </tr>
                        <tr>
                            <td width='30%'>冻结</td>
                            <td width='70%'><?php echo $info['data']['is_freeze']?></td>
                        </tr>
                        </tbody>
                    </table>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
