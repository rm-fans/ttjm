<?php
/* @var $this RoleModelController */
/* @var $model RoleModel */
/* @var $form CActiveForm */
?>
<script src="<?php echo Yii::app()->request->baseUrl;?>/static/js/My97DatePicker/WdatePicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12" style="background: white;">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'product-model-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation' => true,
            'htmlOptions'=>array('class'=>'form-horizontal form-row-seperated',"enctype" => "multipart/form-data"),
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
                    <i class="fa fa-cubes"><?php echo $this->title?></i>
                </div>
            </div>
            <div class="portlet-body">
                <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','', array('class' => 'alert alert-danger'));?>
                <div class="tabbable">
                    <div class="tab-content no-space">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'用户名',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $model->username?>
                                    </div>
                                    <?php echo $form->error($model,'用户名'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'手机号码',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $model->phone?>
                                    </div>
                                    <?php echo $form->error($model,'手机号码'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($bank, '开户行：', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($bank, 'bank_name', array('class' => 'form-control','readonly'=>'readonly')); ?>
                                    </div>
                                    <?php echo $form->error($bank, 'bank_name'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($bank, '银行卡号：', array('class' => 'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($bank, 'bank_card', array('class' => 'form-control','readonly'=>'readonly')); ?>
                                    </div>
                                    <?php echo $form->error($bank, 'bank_card'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'昵称',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'nickname',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'昵称'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'性别',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->dropDownList($model,'sex',array('1'=>'男','2'=>'女','0'=>'不限'),array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'性别'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'生日',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->dateField($model,'birthday',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'生日'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'真实姓名',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'identity_name',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'真实姓名'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'身份证号码：',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'identity_card',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'身份证号码'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'行业',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->radioButtonList($model,'industry_id',$industry,array('template'=>'<span class="check">{input}{label}</span>','separator'=>' ')); ?>
                                    </div>
                                    <?php echo $form->error($model,'行业'); ?>
                                </div>


<!--                                地域-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">选择地址</label>
                                    <div class="col-md-8">
                                        <?php echo $form->dropDownList($model, 'province_id', CHtml::listData(DistrictModel::model()->findAll('level=1'), 'id', 'name'),
                                            array(
                                                'prompt' => '选择省份',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => $this->createUrl('ajax/district'),
                                                    'dataType' => 'json',
                                                    'data' => array('id'=>'js:this.value','csrf'=>'js:$("input[name=\'csrf\']").val()','type'=>'province'),
                                                    'success' => 'function(data) {
                                                 $("#UserProfileModel_city_id").html(data.cities);
                                                 $("#UserProfileModel_district_id").html(data.districts);
                                           }',
                                                )));
                                        ?>
                                        <?php echo $form->dropDownList($model,'city_id',$model->province_id ? CHtml::listData(DistrictModel::model()->findAll('upid='.$model->province_id), 'id', 'name') : array(),
                                            array(
                                                'prompt' => '选择城市',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => $this->createUrl('ajax/district'),
                                                    'update' => '#UserProfileModel_district_id',
                                                    'data' => array('id'=>'js:this.value','csrf'=>'js:$("input[name=\'csrf\']").val()','type'=>'city'),
                                                )),array('class'=>'form-control')
                                        ) ; ?>
                                        <?php echo $form->dropDownList($model, 'district_id', $model->city_id ? CHtml::ListData(DistrictModel::model()->findAll('upid=' . $model->city_id), 'id', 'name') : array(), array('prompt' => '选择区域')); ?>

                                    </div>
                                    <?php echo $form->error($model,'district_id'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'详细地址',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'address',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'详细地址'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'微信号',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'wechat',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'wechat'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'QQ',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'qq',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'qq'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'头像',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php
                                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                            array(
                                                'id'=>'imageId',//容器的id 唯一的[必须配置]
                                                'name'=>'image[avatar]',//post到后台接收的name [必须配置]
                                                'inputId'=>'imageAvatar',//post到后台接收的input ID [file image 时必须配置]
                                                'content'=>$model->avatar,//初始化内容 [可选的]
                                                'class'=>'form-control',
                                                'btnClass'=>'btn blue',
                                                'type'=>'image',
                                                //配置选项，[可选的]
                                                //将ueditor的配置项以数组键值对的方式传入,具体查看ueditor.config.js
                                                //不要配置serverUrl(即使配置也会被覆盖)程序会自动处理后端url
                                                'config'=>array(
                                                    // 'toolbars'=>array(array('fullscreen', 'source', '|')),//toolbars注意是嵌套两个数组
                                                    'lang'=>'zh-cn'
                                                )
                                            )
                                        );
                                        ?>
                                    </div>
                                    <?php echo $form->error($model,'头像'); ?>
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
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- END PAGE CONTENT-->
<script>
    $(document).ready(function(){

    })
    $('.green').click(function check(){
        var values=$('input[class="node_item"]'.checked).val();
        if(values==''){
            alert("请选择相关列表！");
        }
    })
</script>
