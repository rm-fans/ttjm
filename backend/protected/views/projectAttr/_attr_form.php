<style>
<!--
#att_form .radio > span {
    margin-top: -4px;
}

#att_form .errorMessage {
    color:#FF0000;
    padding-top:5px;
}
-->
</style>

<div class="row">
    <div class="col-md-12">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableAjaxValidation'=>false,
            'enableClientValidation' => true,
            'htmlOptions'=>array('id' => 'att_form','class'=>'form-horizontal form-row-seperated',"enctype" => "multipart/form-data"),
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
                    if(hasError){
                        $("#"+attribute.id).parents(".form-group").addClass("has-error");
                    }else{
                        $("#"+attribute.id).parents(".form-group").removeClass("has-error");
                    }
                }'
            )
        ));?>
        
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-child"></i>属性添加/修改
                </div>
                <div class="actions btn-set">
                    <button type="button" name="back" class="btn default"><i class="fa fa-angle-left"></i>返回</button>
                    <button class="btn default" type="reset"><i class="fa fa-reply"></i>重置</button>
                    <button class="btn green" type="submit"><i class="fa fa-check"></i>保存</button>
                </div>
            </div>
        
            <div class="portlet-body">
                <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','',array('class' => 'alert alert-danger'));?>
                <div class="tabbable">
                    <div class="tab-content no-space">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'属性名称',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'name'); ?>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">说明:</label>
                                    <div class="col-md-8" style="color:#FF0000;margin-top:10px;font-size:14px;">当输入框类型为单选、多选、下拉框时，属性值必填。(格式  1:男,2:女,3:人妖)冒号、逗号为英文符号,格式严格要求。</div>
                                </div>
                                
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'输入框类型',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo CHtml::radioButtonList('attributeModel[input_type]', isset($model->input_type) ? $model->input_type : 1, AttributeModel::$input_types,array('style'=>'margin-left:-9px;display:inline-block;'))?>
                                    </div>
                                    <?php echo $form->error($model,'input_type'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'属性值',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form-> textField($model,'values',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'values'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'排序',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo $form->textField($model,'sort',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'sort'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'是否有效',array('class'=>'col-md-2 control-label')); ?>
                                    <div class="col-md-8" style="margin-top: 10px;">
                                        <?php echo CHtml::checkBox('attributeModel[is_effect]',isset($model->is_effect) && $model->is_effect ? true : false,array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'is_effect'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget();?>
    </div>
</div>
