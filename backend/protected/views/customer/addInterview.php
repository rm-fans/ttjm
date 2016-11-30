<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'客户管理'),
    array('name' => '客户管理', 'url' => array('customer/lineList')),
    array('name'=>'添加联系记录')
);
$this->pageTitle = '添加联系记录';
$this->title = '添加联系记录<small>添加联系记录</small>';
?>
<div class="page-bar">
    <div class="row">
        <div class="col-md-12" style="background: white;">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'enableAjaxValidation'=>false,
                'enableClientValidation' => true,
                'htmlOptions'=>array('class'=>'form-horizontal form-row-seperated',"enctype" => "multipart/form-data"),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                )
            )); ?>
            <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
            <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
            <link href="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>

            <div class="portlet-body">
                <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','',
                    array('class' => 'alert alert-danger'));?>
                <div class="tabbable">
                    <div class="tab-content no-space">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'联系时间',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'interviewed_at',array('class' => 'form-control form_datetime', 'readonly' => "readonly")); ?>
                                    </div>
                                    <?php echo $form->error($model,'联系时间'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'沟通内容',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textArea($model,'desc',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'沟通内容'); ?>
                                </div>
                                <input class="form-control" name="ProjectUserRecordModel[state]" id="ProjectUserRecordModel_state" type="hidden" value="1">
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
    <script type="text/javascript">
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
    </script>

</div>
