<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'客户管理'),
    array('name' => '客户管理', 'url' => array('customer/lineList')),
    array('name'=>'提交成交信息')
);
$this->pageTitle = '提交成交信息';
$this->title = '提交成交信息<small>提交成交信息</small>';
?>
<div class="page-bar">
    <div class="row">
        <div class="col-md-12" style="background: white;">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'enableAjaxValidation'=>false,
                'enableClientValidation' => true,
                'htmlOptions'=>array('class'=>'form-horizontal form-row-seperated',"enctype" => "multipart/form-data"),
                'clientOptions' => array(
                   // 'validateOnSubmit' => true,
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
                                    <?php echo $form->labelEx($model,'成交时间',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'selled_at',array('class'=>'form-control form_datetime','readonly'=>'readonly')); ?>
                                    </div>
                                    <?php echo $form->error($model,'selled_at'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'成交金额',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'sell_price',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'sell_price'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'经纪人佣金',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'serve_price',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'serve_price'); ?>
                                </div>
                                <input class="form-control" name="ProjectUserRecordModel[state]" id="ProjectUserRecordModel_state" type="hidden" value="1">
                                <div class="actions btn-set" style="margin:20px 0px 0px 200px;">
                                    <button class="btn green" type="submit"><i class="fa fa-check"></i> 提交</button>
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
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii:00'});
    </script>
</div>
