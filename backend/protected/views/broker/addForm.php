<div class="row">
    <div class="col-md-12" style="background: white;">

        <?php $form = $this->beginWidget('CActiveForm', array(
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
        <div class="portlet-body">

            <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>', '',
                array('class' => 'alert alert-danger')); ?>
            <div class="tabbable">
                <div class="tab-content no-space">
                    <div class="tab-pane active" id="tab_general">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '昵称', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model, 'nickname', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, '昵称'); ?>
                                </div>
                                <?php if ($display == 'update'): ?>
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, '经纪人账号', array('class' => 'col-md-2 control-label')); ?>
                                        <div class="col-md-8">
                                            <?php echo $form->textField($model, 'username', array('class' => 'form-control','readonly'=>'readonly')); ?>
                                        </div>
                                        <?php echo $form->error($model, '经纪人账号'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, '手机号码', array('class' => 'col-md-2 control-label')); ?>
                                        <div class="col-md-8">
                                            <?php echo $form->textField($model, 'phone', array('class' => 'form-control','readonly'=>'readonly')); ?>
                                        </div>
                                        <?php echo $form->error($model, '手机号码'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '手机号码', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, '手机号码'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '真实姓名', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model, 'identity_name', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, '真实姓名'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, '身份证', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model, 'identity_card', array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model, '身份证'); ?>
                                </div>

<!--                                <div class="form-group">-->
<!--                                    --><?php //echo $form->labelEx($model, '所属机构', array('class' => 'col-md-2 control-label')); ?>
<!--                                    <div class="col-md-8">-->
<!--                                        --><?php //echo $form->dropDownList($model, 'broker_organization_id', $org, array('class' => 'form-control')); ?>
<!--                                    </div>-->
<!--                                    --><?php //echo $form->error($model, 'broker_organization_id'); ?>
<!--                                </div>-->
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
                                    <?php echo $form->labelEx($model, '行业', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->radioButtonList($model, 'industry_id', $industry, array('template' => '<span class="check">{input}{label}</span>', 'separator' => ' ')); ?>
                                    </div>
                                    <?php echo $form->error($model, 'industry_id'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php
                                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                            array(
                                                'id' => 'img_avatar',//容器的id 唯一的[必须配置]
                                                'name' => 'image[avatar]',//post到后台接收的name [必须配置]
                                                'inputId' => 'avatar',//post到后台接收的input ID [file image 时必须配置]
                                                'content' => $model->avatar,//初始化内容 [可选的]
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
                                    </div>
                                    <?php echo $form->error($model, '头像'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($detail, '从业资格证（正面）', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php
                                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                            array(
                                                'id' => 'img_certificate',//容器的id 唯一的[必须配置]
                                                'name' => 'image[certificate_src]',//post到后台接收的name [必须配置]
                                                'inputId' => 'certificate_src',//post到后台接收的input ID [file image 时必须配置]
                                                'content' => $detail->certificate_src,//初始化内容 [可选的]
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
                                    </div>
                                    <?php echo $form->error($detail, '从业资格证（正面）'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($detail, '名片（正面）', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php
                                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                            array(
                                                'id' => 'img_business_card',//容器的id 唯一的[必须配置]
                                                'name' => 'image[business_card_src]',//post到后台接收的name [必须配置]
                                                'inputId' => 'business_card_src',//post到后台接收的input ID [file image 时必须配置]
                                                'content' => $detail->business_card_src,//初始化内容 [可选的]
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
                                    </div>
                                    <?php echo $form->error($detail, '名片（正面）'); ?>
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
                                    <button class="btn green" type="submit"><i class="fa fa-check"></i> 保存</button>
                                    <button class="btn default" type="reset"><i class="fa fa-reply"></i> 重置</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>

    </div>
