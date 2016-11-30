<div class="row">
    <div class="col-md-12" style="background: white;">
	    <?php $form=$this->beginWidget('CActiveForm', array(
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

		<div class="portlet-body">
		    <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','',
		        array('class' => 'alert alert-danger'));?>
		    <div class="tabbable">
		        <div class="tab-content no-space">
		            <div class="tab-pane active" id="tab_general">
		                <div class="form-body">
		                    <div class="form-group">
		                        <?php echo $form->labelEx($model,'分类名',array('class'=>'col-md-2 control-label')); ?>
		                        <div class="col-md-8">
		                            <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
		                        </div>
		                        <?php echo $form->error($model,'分类名'); ?>
		                    </div>
<!--		                    <div class="form-group">-->
<!--		                        --><?php //echo $form->labelEx($model,'简介',array('class'=>'col-md-2 control-label')); ?>
<!--		                        <div class="col-md-8">-->
<!--		                            --><?php //echo $form->textField($model,'brief',array('class'=>'form-control')); ?>
<!--		                        </div>-->
<!--		                        --><?php //echo $form->error($model,'简介'); ?>
<!--		                    </div>-->
<!--		                    <div class="form-group">-->
<!--		                        --><?php //echo $form->labelEx($model,'排序',array('class'=>'col-md-2 control-label')); ?>
<!--		                        <div class="col-md-8">-->
<!--		                            --><?php //echo $form->textField($model,'sort',array('class'=>'form-control')); ?>
<!--		                        </div>-->
<!--		                        --><?php //echo $form->error($model,'排序'); ?>
<!--		                    </div>-->
<!--		                    <div class="form-group">-->
<!--		                        --><?php //echo $form->labelEx($model,'是否有效',array('class'=>'col-md-2 control-label')); ?>
<!--		                        <div class="col-md-8">-->
<!--		                            --><?php //echo $form->checkBox($model,'is_effect',array('class'=>'form-control')); ?>
<!--		                        </div>-->
<!--		                       --><?php //echo $form->error($model,'是否有效');?>
<!--		                    </div>-->
<!---->
<!--							<div class="form-group">-->
<!--								--><?php //echo $form->labelEx($model,'类型',array('class'=>'col-md-2 control-label')); ?>
<!--								<div class="col-md-8">-->
<!--									--><?php //echo CHtml::DropDownList('type_id',$model->type_id,array(0=>'普通文章',1=>'帮助文章',2=>'公告文章',3=>'系统文章'),
//											array('class'=>'form-control','id'=>'type_id'))?>
<!--								</div>-->
<!--								--><?php //echo $form->error($model,'类型');?>
<!--							</div>-->
							<?php echo $form->hiddenField($model,'pid',array('class'=>'form-control')); ?>


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
