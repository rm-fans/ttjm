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
		));
		?>

		<div class="portlet-body">
		    <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','',
		        array('class' => 'alert alert-danger'));?>
		    <div class="tabbable">
		        <div class="tab-content no-space">
		            <div class="tab-pane active" id="tab_general">
		                <div class="form-body">
		                    <div class="form-group">
		                        <?php echo $form->labelEx($model,'伙伴名称',array('class'=>'col-md-2 control-label')); ?>
		                        <div class="col-md-8">
		                            <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
		                        </div>
		                        <?php echo $form->error($model,'伙伴名称'); ?>
		                    </div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'有效性',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->checkBox($model,'is_effect',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'有效性'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'排序值',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textField($model,'sort',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'排序值'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'图片地址',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php
									$this->widget('application.extensions.baiduUeditor.UeditorWidget',
											array(
													'id'=>'imageId',//容器的id 唯一的[必须配置]
													'name'=>'image[image]',//post到后台接收的name [必须配置]
													'inputId'=>'imageImage',//post到后台接收的input ID [file image 时必须配置]
													'content'=>$model->image,//初始化内容 [可选的]
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
								<?php echo $form->error($model,'图片地址'); ?>
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
