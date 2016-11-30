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
                                    <?php echo $form->labelEx($model,'服务商机构名称',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'name',array('class'=>'form-control','readonly'=>'readonly')); ?>
                                    </div>
                                    <?php echo $form->error($model,'name'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'法人名字',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'identity_name',array('class'=>'form-control','readonly'=>'readonly')); ?>
                                    </div>
                                    <?php echo $form->error($model,'identity_name'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'身份证号码：',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'identity_card',array('class'=>'form-control','readonly'=>'readonly')); ?>
                                    </div>
                                    <?php echo $form->error($model,'identity_card'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'行业',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $industry_name?>
                                    </div>
                                </div>
                                <!--                                LOG-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'logo',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $logo?>
                                    </div>
                                    <?php echo $form->error($model,'logo'); ?>
                                </div>
                                <!--                                营业执照-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'business_license_src',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $business_license_src?>
                                    </div>
                                    <?php echo $form->error($model,'business_license_src'); ?>
                                </div>

                                <!--                                身份证正面-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'identity_frontend_src',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $identity_frontend_src?>
                                    </div>
                                    <?php echo $form->error($model,'identity_frontend_src'); ?>
                                </div>
                                <!--                                身份证背面-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'identity_backeend_src',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $identity_backeend_src?>
                                    </div>
                                    <?php echo $form->error($model,'identity_backeend_src'); ?>
                                </div>

                                <!--                                地域-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'address',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'address',array('class'=>'form-control','readonly'=>'readonly')); ?>
                                    </div>
                                    <?php echo $form->error($model,'address'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'机构文化：',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php
                                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                            array(
                                                'id'=>'article_content',//容器的id 唯一的[必须配置]
                                                'name'=>'content',//post到后台接收的name [必须配置]
                                                'content'=>$model->desc,//初始化内容 [可选的]
                                                'type'=>'textarea',
                                                'config'=>array(
                                                    'lang'=>'zh-cn'
                                                )
                                            )
                                        );
                                        ?>
                                    </div>
                                    <?php echo $form->error($model,'desc'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'是否通过',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->radioButtonList($model,'status',array('-1'=>'不通过','1'=>'通过'),array('template'=>'<span class="check">{input}{label}</span>','separator'=>' ')); ?>
                                    </div>
                                    <?php echo $form->error($model,'status'); ?>
                                </div>

                                <div class="actions btn-set" style="margin:20px 0px 0px 200px;">
                                    <button class="btn green" type="submit"><i class="fa fa-check"></i> 提交</button>
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
