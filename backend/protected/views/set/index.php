<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name' => '系统管理',),
    array('name' => '资产设置', 'url' => array('set/index')),
    array('name'=>'项目列表')
);
$this->pageTitle = '项目列表';
$this->title = '表单 <small>项目列表</small>';
?>
<div class="row" xmlns="http://www.w3.org/1999/html">
<div class="col-md-12">
<!-- Begin: life time stats -->
<div class="portlet">
<div class="portlet-title form-horizontal">
    <div class="caption">
        <i class="fa fa-sun-o"></i>项目列表
    </div>
</div>
<div class="portlet">
<div class="portlet-body">
<div class="tabbable">
<ul class="nav nav-tabs nav-tabs-lg">
    <li class="active">
        <a href="#tab_1" data-toggle="tab">
            基础设置</a>
    </li>
<!--    <li>-->
<!--        <a href="#tab_2" data-toggle="tab">-->
<!--            资产配置-->
<!--        </a>-->
<!--    </li>-->
<!--    <li>-->
<!--        <a href="#tab_3" data-toggle="tab">-->
<!--            运营配置-->
<!--        </a>-->
<!--    </li>-->
    <!--<li>
        <a href="#tab_4" data-toggle="tab">
            云签配置
        </a>
    </li>-->
</ul>
<div class="tab-content">

<div class="tab-pane active" id="tab_1">
    <?php echo CHtml::beginForm(Yii::app()->createUrl('set/update'),$method='post',$htmlOptions=array('class'=>"form-horizontal"));?>
    <?php echo CHtml::errorSummary($model); ?>
    <div class="form-body">
      <div class="form">

        <?php foreach($base as $v):?>
            <div class="form-group">
                <?php echo CHtml::activeLabel($v,$v->china_name,array('class'=>'col-md-1 control-label')); ?>
                <div class="col-md-9">
                    <input type="text" class="form-control input-lg"  name="ConfModel[<?php echo $v->name;?>]" value="<?php echo $v->value;?>"/>
                </div>
            </div>
        <?php endforeach;?>
        </div>
    </div>
    <div class="row submit">
        <?php echo CHtml::submitButton('提交',array('class'=>'btn green','style'=>'margin-left:400px;margin-top:35px;')); ?>
    </div>
    <?php echo CHtml::endForm();?>

</div>
<div class="tab-pane " id="tab_2">
    <div class="form-body">
        <?php echo CHtml::beginForm(Yii::app()->createUrl('set/update'),$method='post',$htmlOptions=array('class'=>"form-horizontal"));?>
        <?php echo CHtml::errorSummary($model); ?>
        <?php foreach($model as $key=>$v):?>
            <?php if($v->name != ConfModel::CONFIG_CONTRACT_EXAMPLE):?>
                <div class="form-group">
                    <?php echo CHtml::activeLabel($v,$v->china_name,array('class'=>'col-md-2 control-label')); ?>
                    <div class="col-md-9">
                        <?php if($v->name == ConfModel::CONFIG_FEE_MODE ):?>
                            <select name="ConfModel[<?php echo $v->name;?>]" class="form-control input-lg">
                                <option value="0" <?php echo $v->value ? '': 'selected'?>>平台</option>
                                <option value="1" <?php echo $v->value ? 'selected' : ''?>>用户</option>
                            </select>
                        <?php elseif($v->name == ConfModel::CONFIG_WITHDRAW_TYPE  ):?>
                            <select name="ConfModel[<?php echo $v->name;?>]" class="form-control input-lg">
                                <option value="0" <?php echo $v->value ? '' : 'selected'?>>普通</option>
                                <option value="1" <?php echo $v->value ? 'selected' : ''?>>加急</option>
                            </select>
                    <?php elseif($v->name == ConfModel::CONFIG_VIP_RECHARGE_FREE  ):?>
                            <select name="ConfModel[<?php echo $v->name;?>]" class="form-control input-lg" value=>
                                <option value="0" <?php echo $v->value ? '' : 'selected'?>>是</option>
                                <option value="1" <?php echo $v->value ? 'selected' : ''?>>否</option>
                            </select>
                    <?php elseif($v->name == ConfModel::CONFIG_VIP_WITHDRAW_FREE  ):?>
                            <select name="ConfModel[<?php echo $v->name;?>]" class="form-control input-lg">
                                <option value="0" <?php echo $v->value ? '' : 'selected'?>>是</option>
                                <option value="1" <?php echo $v->value ? 'selected' : ''?>>否</option>
                            </select>
                    <?php elseif($v->name == ConfModel::CONFIG_RECHARGE_FEE_MODE  ):?>
                            <select name="ConfModel[<?php echo $v->name;?>]" class="form-control input-lg">
                                <option value="0" <?php echo $v->value ? '' : 'selected'?>>平台</option>
                                <option value="1" <?php echo $v->value ? 'selected' : ''?>>用户</option>
                            </select>
                    <?php else:?>
                        <input type="text" class="form-control input-lg" name="ConfModel[<?php echo $v->name;?>]" value="<?php echo $v->value;?>"/>
                   <?php endif;?>
                    </div>
                </div>
            <?php else:?>
                <div class="row">
                    <?php echo CHtml::activeLabel($v,$v->china_name,array('class'=>'col-md-2 control-label')); ?>
                    <div class="col-md-3">
                        <?php  $this->widget('application.extensions.EAjaxUpload.EAjaxUpload',
                            array(
                                'id'=>'invest_EAjaxUpload',
                                'config'=>array(
                                    'action'=>$this->createUrl('file/upload'),
                                    'template'=>'<div class="qq-uploader">
                                                                <input type="hidden" class="form-control " readonly  style="width:400px;height:40px;!important"name="ProjectAttachmentModel[path]" value="">
                                                                <input type="text" class="form-control " readonly  style="width:400px;height:45px;!important"name="ConfModel['.ConfModel::CONFIG_CONTRACT_EXAMPLE.']" value="'.$v->value.'">
                                                                <input type="hidden" class="form-control" name="ProjectAttachmentModel[title]" value="">
                                                                <input type="hidden" class="form-control" name="ProjectAttachmentModel[type]" value="">
                                                                <div class="qq-upload-drop-area" ><span>Drop files here to upload</span></div>
                                                                 <div class="qq-upload-button" style="position:absolute!important;margin-left:400px;height:45px;margin-top:-45px;">上传文件</div>
                                                                <ul class="qq-upload-list hide"></ul>
                                                                </div> ',

                                    'debug'=>false,
                                    'allowedExtensions'=>array('pdf'),
                                    'sizeLimit'=>20*1024*1024,// maximum file size in bytes
                                    'minSizeLimit'=>1*1024,// minimum file size in bytes
                                    'onComplete'=>"js:function (id, fileName, responseJSON){
                                                       $('#invest_EAjaxUpload input[name=\'ConfModel[".ConfModel::CONFIG_CONTRACT_EXAMPLE."]\']').val(responseJSON.savePath);
                                                       $('#invest_EAjaxUpload input[name=\'ProjectAttachmentModel[path]\']').val(responseJSON.savePath);
                                                       $('#invest_EAjaxUpload input[name=\'ProjectAttachmentModel[title]\']').val(responseJSON.filename);
                                                       $('#invest_EAjaxUpload input[name=\'ProjectAttachmentModel[type]\']').val(responseJSON.extension);
                                                    }",
                                )
                            )
                        );
                        ?>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>

    </div>
    <div class="row submit">
        <?php echo CHtml::submitButton('提交',array('class'=>'btn green','style'=>'margin-left:400px;margin-top:35px;')); ?>
    </div>
    <?php echo CHtml::endForm();?>


</div>
<div class="tab-pane " id="tab_3">

    <div class="form-body">
        <?php echo CHtml::beginForm(Yii::app()->createUrl('set/update'),$method='post',$htmlOptions=array('class'=>"form-horizontal"));?>
        <?php echo CHtml::errorSummary($model); ?>
        <?php foreach($share as $v):?>
            <div class="form-group">
                <?php echo CHtml::activeLabel($v,$v->china_name,array('class'=>'col-md-1 control-label')); ?>
                <div class="col-md-9">
                    <input type="text" class="form-control input-lg" name="ConfModel[<?php echo $v->name;?>]" value="<?php echo $v->value;?>"/>
                </div>
            </div>
        <?php endforeach;?>

    </div>
    <div class="row submit">
        <?php echo CHtml::submitButton('提交',array('class'=>'btn green','style'=>'margin-left:400px;margin-top:35px;')); ?>
    </div>
    <?php echo CHtml::endForm();?>

    <!-- <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="portlet  box">

                                            <div class="tabbable">
                                                <div class="tab-content no-space">
                                                    <div class="tab-pane active" id="tab_general">
                                                        <div class="form-body">
                                                            <div class="form">
                                                                <?php /*echo CHtml::beginForm(Yii::app()->createUrl('set/update'),$method='post',$htmlOptions=array());*/?>
                                                                <?php /*echo CHtml::errorSummary($model); */?>
                                                                <?php /*foreach($share as $v):*/?>
                                                                    <?php /*if($v->name != ConfModel::CONFIG_CONTRACT_EXAMPLE):*/?>
                                                                        <div class="row">
                                                                            <?php /*echo CHtml::activeLabel($v,$v->china_name,array('class'=>'col-md-2 control-label')); */?>
                                                                            <div class="col-md-8">
                                                                                <?php /*echo CHtml::activeTextField($v,'value',array('name'=>'ConfModel['.$v->name.']','class'=>'form-control'));*/?>
                                                                            </div>
                                                                        </div>
                                                                    <?php /*else: */?>
                                                                        <div class="row">
                                                                            <?php /*echo CHtml::activeLabel($v,$v->china_name,array('class'=>'col-md-2 control-label')); */?>
                                                                            <div class="col-md-8">
                                                                                <?php
/*                                                                                $this->widget('application.extensions.EAjaxUpload.EAjaxUpload',
                                                                                    array(
                                                                                        'id'=>'invest_EAjaxUpload',
                                                                                        'config'=>array(
                                                                                            'action'=>$this->createUrl('file/upload'),
                                                                                            'template'=>'<div class="qq-uploader">
                                                                                            <input type="hidden" class="form-control " readonly  style="width:400px;height:30px;!important"name="ProjectAttachmentModel[path]" value="">
                                                                                            <input type="text" class="form-control " readonly  style="width:400px;height:30px;!important"name="ConfModel['.ConfModel::CONFIG_CONTRACT_EXAMPLE.']" value="'.$v->value.'">
                                                                                            <input type="hidden" class="form-control" name="ProjectAttachmentModel[title]" value="">
                                                                                            <input type="hidden" class="form-control" name="ProjectAttachmentModel[type]" value="">
                                                                                            <div class="qq-upload-drop-area" ><span>Drop files here to upload</span></div>
                                                                                             <div class="qq-upload-button" style="position:absolute!important;margin-left:400px;margin-top:-30px;">上传文件</div>
                                                                                            <ul class="qq-upload-list hide"></ul>
                                                                                            </div> ',

                                                                                            'debug'=>false,
                                                                                            'allowedExtensions'=>array('docx','doc'),
                                                                                            'sizeLimit'=>20*1024*1024,// maximum file size in bytes
                                                                                            'minSizeLimit'=>1*1024,// minimum file size in bytes
                                                                                            'onComplete'=>"js:function (id, fileName, responseJSON){
                                                                                   $('#invest_EAjaxUpload input[name=\'ConfModel[".ConfModel::CONFIG_CONTRACT_EXAMPLE."]\']').val(responseJSON.savePath);
                                                                                   $('#invest_EAjaxUpload input[name=\'ProjectAttachmentModel[path]\']').val(responseJSON.savePath);
                                                                                   $('#invest_EAjaxUpload input[name=\'ProjectAttachmentModel[title]\']').val(responseJSON.filename);
                                                                                   $('#invest_EAjaxUpload input[name=\'ProjectAttachmentModel[type]\']').val(responseJSON.extension);
                                                                                }",
                                                                                        )
                                                                                    )
                                                                                );
                                                                                */?>
                                                                            </div>
                                                                        </div>
                                                                    <?php /*endif */?>
                                                                <?php /*endforeach;*/?>
                                                                <div class="row submit">
                                                                    <?php /*echo CHtml::submitButton('提交',array('class'=>'btn green','style'=>'margin-left:400px;margin-top:35px;')); */?>
                                                                </div>
                                                                <?php /*echo CHtml::endForm(); */?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>-->
</div>


<!-- <div class="tab-pane " id="tab_3">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="portlet  box">

                                            <div class="tabbable">
                                                <div class="tab-content no-space">
                                                    <div class="tab-pane active" id="tab_general">
                                                        <div class="form-body">
                                                            <div class="form">
                                                                <?php /*echo CHtml::beginForm(Yii::app()->createUrl('set/update'),$method='post',$htmlOptions=array());*/?>
                                                                <?php /*echo CHtml::errorSummary($share); */?>
                                                                <?php /*foreach($share as $v):*/?>
                                                                    <?php /*if($v->name != ConfModel::CONFIG_SHARE_PICS):*/?>
                                                                        <div class="row">
                                                                            <?php /*echo CHtml::activeLabel($v,$v->china_name,array('class'=>'col-md-2 control-label')); */?>
                                                                            <div class="col-md-8">
                                                                                <?php /*echo CHtml::activeTextArea($v,'value',array('name'=>'ConfModel['.$v->name.']','class'=>'form-control'));*/?>
                                                                            </div>
                                                                        </div>
                                                                    <?php /*else: */?>
                                                                        <div class="row">
                                                                            <?php /*echo CHtml::activeLabel($v,$v->china_name,array('class'=>'col-md-2 control-label')); */?>
                                                                            <div class="col-md-8">
                                                                                <?php
/*                                                                                $this->widget('application.extensions.EAjaxUpload.EAjaxUpload',
                                                                                    array(
                                                                                        'id'=>'share_pic_EAjaxUpload',
                                                                                        'config'=>array(
                                                                                            'action'=>$this->createUrl('file/upload'),
                                                                                            'template'=>'<div class="qq-uploader">
                                                                                            <input type="text" class="form-control " readonly  style="width:400px;height:30px;!important"name="ConfModel['.ConfModel::CONFIG_SHARE_PICS.']" value="'.$v->value.'">
                                                                                            <div class="qq-upload-drop-area" ><span>Drop files here to upload</span></div>
                                                                                             <div class="qq-upload-button" style="position:absolute!important;margin-left:400px;margin-top:-30px;">上传文件</div>
                                                                                            <ul class="qq-upload-list hide"></ul>
                                                                                            </div> ',

                                                                                            'debug'=>false,
                                                                                            'allowedExtensions'=>array('jpg','png','jpeg'),
                                                                                            'sizeLimit'=>20*1024*1024,// maximum file size in bytes
                                                                                            'minSizeLimit'=>1*1024,// minimum file size in bytes
                                                                                            'onComplete'=>"js:function (id, fileName, responseJSON){
                                                                                   $('#share_pic_EAjaxUpload input[name=\'ConfModel[".ConfModel::CONFIG_SHARE_PICS."]\']').val(responseJSON.savePath);
                                                                                }",
                                                                                        )
                                                                                    )
                                                                                );
                                                                                */?>
                                                                            </div>

                                                                        </div>
                                                                    <?php /*endif */?>
                                                                <?php /*endforeach;*/?>
                                                                <div class="row submit">
                                                                    <?php /*echo CHtml::submitButton('提交',array('class'=>'btn green','style'=>'margin-left:400px;margin-top:35px;')); */?>
                                                                </div>
                                                                <?php /*echo CHtml::endForm(); */?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>-->
</div>
</div>
</div>
<!-- End: life time stats -->
</div>
</div>
</div>
</div>
<input type="hidden" name="csrf" value="<?php echo Yii::app()->request->getCsrfToken()?>">
<!--style-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<script>
    jQuery(document).ready(function() {
        /* var url = '<?php echo $this->createUrl("index",array('isAjax'=>1))?>';
         var token = $("input[name='csrf']").val();
         EcommerceList.init(url,token);*/
    });
    $().ready(function(){
        $('#group').click(function(){
            if($(this).attr('checked')=='checked'){
                $('#select_group').show();
            }else{
                $('#selelct_group').hide();
            }
        })
    })
</script>

