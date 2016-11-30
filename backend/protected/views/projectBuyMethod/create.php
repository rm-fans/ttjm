<?php

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '资产购买方式', 'url' => array('project/pubIndex')),
    array('name'=>'添加')
);
$this->pageTitle = '添加项目';
$this->title = '<small>添加项目</small>';
?>

<?php
/* @var $this ProjectController */
/* @var $model ProjectModel */
/* @var $form CActiveForm */
?>
<script src="<?php echo Yii::app()->request->baseUrl;?>/static/js/My97DatePicker/WdatePicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>

<div class="row">
    <div class="col-md-12">
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
                <div class="actions btn-set">
                    <button type="button" name="back" class="btn default"><i class="fa fa-angle-left"></i> 返回</button>
                    <button class="btn default" type="reset"><i class="fa fa-reply"></i> 重置</button>

                </div>
            </div>
            <div class="portlet-body">
                <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','', array('class' => 'alert alert-danger'));?>
                <div class="tabbable">
                    <div class="tab-content no-space">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body">
                                <!--标题-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'name',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'name'); ?>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"></label>
                                    <div class="col-md-8">
                                            <button class="btn green" type="submit"><i class="fa fa-check"></i>添加</button>
                                    </div>
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


<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>




