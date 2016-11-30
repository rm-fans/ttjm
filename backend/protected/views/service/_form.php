<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */
/* @var $form CActiveForm */
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/My97DatePicker/WdatePicker.js"
        type="text/javascript"></script>
<script type="text/javascript"
        src="<?php echo Yii::app()->request->baseUrl ?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript"
        src="<?php echo Yii::app()->request->baseUrl ?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12" style="background: white;">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-model-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal form-row-seperated', "enctype" => "multipart/form-data"),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form, data, hasError) {
                  if(hasError) {
                      for(var i in data) $("#"+i).parents(".form-group").addClass("has-error");
                      return false;
                  }
                  else {
                      form.children().removeClass("has-error");
                      return true;
                  }
              }',
                'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                  if(hasError) $("#"+attribute.id).parents(".form-group").addClass("has-error");
                      else $("#"+attribute.id).parents(".form-group").removeClass("has-error");
              }'
            )
        )); ?>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cubes"><?php echo $this->title ?></i>
                </div>
            </div>
            <div class="portlet-body">
                <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>', '', array('class' => 'alert alert-danger')); ?>
                <div class="tabbable">
                    <div class="tab-content no-space">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body">
                                <?php if($display=='success'):?>
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, "服务商名称<span class='required'>*</span>", array('class' => 'col-md-2 control-label')); ?>
                                        <div class="col-md-8">
                                            <?php echo $form->textField($model, 'username', array('class' => 'form-control','readonly'=>'readonly')); ?>
                                        </div>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div>
                                <?php endif;?>
                                <?php if ($display=='create'): ?>
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, '手机号码', array('class' => 'col-md-2 control-label')); ?>
                                        <div class="col-md-8">
                                            <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
                                        </div>
                                        <?php echo $form->error($model, 'phone'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($display=='success' || $display=='update'):?>
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, '手机号码', array('class' => 'col-md-2 control-label')); ?>
                                        <div class="col-md-8">
                                            <?php echo $form->textField($model, 'phone', array('class' => 'form-control','readonly'=>'readonly')); ?>
                                        </div>
                                        <?php echo $form->error($model, 'phone'); ?>
                                    </div>
                                <?php endif;?>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '密码', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control"  name="UserProfileModel[password]" id="UserProfileModel_password"/>
<!--                                        --><?php //echo $form->textField($password, 'password', array('class' => 'form-control','readonly'=>'readonly')); ?>
                                    </div>
                                    <?php echo $form->error($model, '密码'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '性别', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->dropDownList($model, 'sex', array('1' => '男', '0' => '女', '-1' => '不限'), array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, 'sex'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '真实姓名', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model, 'identity_name', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, 'identity_name'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '身份证号码：', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model, 'identity_card', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, 'identity_card'); ?>
                                </div>
                                <?php  if($display!='create'):?>
                                <div class="form-group">
                                     <label class='col-md-2 control-label'>开户行：</label>
                                    <div class="col-md-8">
                                        <input type="text" readonly="readonly" class ='form-control' value="<?= isset($bank['bank_name'])?Utils::decrypt($bank['bank_name']):'';?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class='col-md-2 control-label'>银行卡号：</label>
                                    <div class="col-md-8">
                                        <input type="text" readonly="readonly" class ='form-control' value="<?= isset($bank['bank_card'])?Utils::decrypt($bank['bank_card']):'';?>"/>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, "行业<span class='required'>*</span>", array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->radioButtonList($model, 'industry_id', $industry, array('template' => '<span class="check">{input}{label}</span>', 'separator' => ' ')); ?>
                                    </div>
                                    <?php echo $form->error($model, 'industry_id'); ?>
                                </div>
                                <!--                                形象照片-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($detail, 'img_src', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php
                                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                            array(
                                                'id' => 'img_src',//容器的id 唯一的[必须配置]
                                                'name' => 'image[img_src]',//post到后台接收的name [必须配置]
                                                'inputId' => 'src',//post到后台接收的input ID [file image 时必须配置]
                                                'content' => $detail->img_src,//初始化内容 [可选的]
                                                'class' => 'form-control',
                                                'btnClass' => 'btn blue',
                                                'type' => 'image',
                                                //配置选项，[可选的]
                                                //将ueditor的配置项以数组键值对的方式传入,具体查看ueditor.config.js
                                                //不要配置serverUrl(即使配置也会被覆盖)程序会自动处理后端url
                                                'config' => array(
                                                    // 'toolbars'=>array(array('fullscreen', 'source', '|')),//toolbars注意是嵌套两个数组
                                                    'lang' => 'zh-cn'
                                                )
                                            )
                                        );
                                        ?>
                                        <span><i>宽高478*307</i></span>
                                    </div>
                                    <?php echo $form->error($detail, 'img_src'); ?>
                                </div>
                               <!--                                从业资格证-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($detail, 'service_license_src', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php
                                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                            array(
                                                'id' => 'img_license',//容器的id 唯一的[必须配置]
                                                'name' => 'image[license]',//post到后台接收的name [必须配置]
                                                'inputId' => 'license',//post到后台接收的input ID [file image 时必须配置]
                                                'content' => $detail->service_license_src,//初始化内容 [可选的]
                                                'class' => 'form-control',
                                                'btnClass' => 'btn blue',
                                                'type' => 'image',
                                                //配置选项，[可选的]
                                                //将ueditor的配置项以数组键值对的方式传入,具体查看ueditor.config.js
                                                //不要配置serverUrl(即使配置也会被覆盖)程序会自动处理后端url
                                                'config' => array(
                                                    // 'toolbars'=>array(array('fullscreen', 'source', '|')),//toolbars注意是嵌套两个数组
                                                    'lang' => 'zh-cn'
                                                )
                                            )
                                        );
                                        ?>
                                        <span><i>宽高478*307</i></span>
                                    </div>
                                    <?php echo $form->error($detail, 'service_license_src'); ?>
                                </div>
                                <!--                                地域-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">选择地址 <span class="required">*</span></label>

                                    <div class="col-md-8">
                                        <?php echo $form->dropDownList($model, 'province_id', CHtml::listData(DistrictModel::model()->findAll('level=1'), 'id', 'name'),
                                            array(
                                                'prompt' => '选择省份',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => $this->createUrl('ajax/district'),
                                                    'dataType' => 'json',
                                                    'data' => array('id' => 'js:this.value', 'csrf' => 'js:$("input[name=\'csrf\']").val()', 'type' => 'province'),
                                                    'success' => 'function(data) {
                                                 $("#UserProfileModel_city_id").html(data.cities);
                                                 $("#UserProfileModel_district_id").html(data.districts);
                                           }',
                                                )));
                                        ?>
                                        <?php echo $form->dropDownList($model, 'city_id', $model->province_id ? CHtml::listData(DistrictModel::model()->findAll('upid=' . $model->province_id), 'id', 'name') : array(),
                                            array(
                                                'prompt' => '选择城市',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => $this->createUrl('ajax/district'),
                                                    'update' => '#UserProfileModel_district_id',
                                                    'data' => array('id' => 'js:this.value', 'csrf' => 'js:$("input[name=\'csrf\']").val()', 'type' => 'city'),
                                                )), array('class' => 'form-control')
                                        ); ?>
                                        <?php echo $form->dropDownList($model, 'district_id', $model->city_id ? CHtml::ListData(DistrictModel::model()->findAll('upid=' . $model->city_id), 'id', 'name') : array(), array('prompt' => '选择区域')); ?>
                                        <?php echo $form->textField($model, 'address', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, 'district_id'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '微信号', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model, 'wechat', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, 'wechat'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'QQ', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model, 'qq', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, 'qq'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($detail, '描述：', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php
                                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                            array(
                                                'id' => 'article_content',//容器的id 唯一的[必须配置]
                                                'name' => 'desc',//post到后台接收的name [必须配置]
                                                'content' => $detail->desc,//初始化内容 [可选的]
                                                'type' => 'textarea',
                                                'config' => array(
                                                    'lang' => 'zh-cn'
                                                )
                                            )
                                        );
                                        ?>
                                    </div>
                                    <?php echo $form->error($detail, 'desc'); ?>
                                </div>
                                <div class="actions btn-set" style="margin:20px 0px 0px 200px;">
                                    <?php if($display=='update' || $display=='create'):?>
                                        <button class="btn green" type="submit"><i class="fa fa-check"></i> 提交</button>
                                        <button class="btn default" type="reset"><i class="fa fa-check"></i> 重置</button>
                                    <?php else:?>
                                    <button class="btn green" type="submit"><i class="fa fa-check"></i> 确认认证</button>
                                    <button class="btn default" type="button"><a href="<?php echo $this->createUrl('service/loser',array('uid'=>$model->uid));?>"><i class="fa fa-reply"> 不通过认证</i></a> </button>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- END PAGE CONTENT-->
<script>
    $(document).ready(function () {

    })
    $('.green').click(function check() {
        var values = $('input[class="node_item"]'.checked).val();
        if (values == '') {
            alert("请选择相关列表！");
        }
    });
</script>
