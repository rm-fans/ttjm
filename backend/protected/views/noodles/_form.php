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
                                    <?php echo $form->labelEx($model,'name',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'name',array('class'=>'form-control',)); ?>
                                    </div>
                                    <?php echo $form->error($model,'name'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'noodtype',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->dropDownList($model,'noodtype',array('1'=>'干馏系列','2'=>'汤面系列','3'=>'抄手系列','4'=>'精品小吃','5'=>'其他'),array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'noodtype'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'noodprice',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'noodprice',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'noodprice'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'nooddetail',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textArea($model,'nooddetail',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'nooddetail'); ?>
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
