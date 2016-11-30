<script src="<?php echo Yii::app()->request->baseUrl;?>/static/js/My97DatePicker/WdatePicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>
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
		                        <?php echo $form->labelEx($model,'文章标题',array('class'=>'col-md-2 control-label')); ?>
		                        <div class="col-md-8">
		                            <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
		                        </div>
		                        <?php echo $form->error($model,'文章标题'); ?>
		                    </div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'文章分类',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo CHtml::DropDownList('cate_id',$model->cate_id,CHtml::listData($category,'id','title'),array('class'=>'form-control',
											'id'=>'cate_id'))?>
								</div>
								<?php echo $form->error($model,'文章分类'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'文章内容',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php
									$this->widget('application.extensions.baiduUeditor.UeditorWidget',
											array(
													'id'=>'article_content',//容器的id 唯一的[必须配置]
													'name'=>'content',//post到后台接收的name [必须配置]
													'content'=>$model->content,//初始化内容 [可选的]
													'type'=>'textarea',
													'config'=>array(
															'lang'=>'zh-cn'
													)
											)
									);
									?>
								</div>
								<?php echo $form->error($model,'文章内容'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'自动跳转的外链',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textField($model,'rel_url',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'自动跳转的外链'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'排序',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textField($model,'sort',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'排序'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'seo页面标题',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textField($model,'seo_title',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'seo页面标题'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'seo页面keyword',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textField($model,'seo_keyword',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'seo页面keyword'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'seo页面标述',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textField($model,'seo_description',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'seo页面标述'); ?>
							</div>
							<!--发布时间-->
							<div class="form-group">
								<?php echo $form->labelEx($model,'发布时间',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
									 data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
									<?php echo $form->textField($model,'created_at', array( 'value'=>$model->created_at>0 ? date('Y-m-d',$model->created_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
									<span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i
														class="fa fa-calendar"></i></button>
											</span>
								</div>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'简介',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textField($model,'summary',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'简介'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'热门',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->checkBox($model,'is_hot',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'热门'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'置顶',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->checkBox($model,'is_top',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'置顶'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'有效性',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->checkBox($model,'is_effect',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'有效性'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'展示图片',array('class'=>'col-md-2 control-label')); ?>
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
								<?php echo $form->error($model,'展示图片'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'wap展示图片',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php
									$this->widget('application.extensions.baiduUeditor.UeditorWidget',
											array(
													'id'=>'wapImageId',//容器的id 唯一的[必须配置]
													'name'=>'image[wap_image]',//post到后台接收的name [必须配置]
													'inputId'=>'imageWap_image',//post到后台接收的input ID [file image 时必须配置]
													'content'=>$model->wap_image,//初始化内容 [可选的]
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
								<?php echo $form->error($model,'wap展示图片'); ?>
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
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<script>
	$().ready(function(){
		$('.date-picker').datepicker({
			rtl: Metronic.isRTL(),
			autoclose: true
		});
	});
</script>
