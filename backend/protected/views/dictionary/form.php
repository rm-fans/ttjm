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
//		        'afterValidate' => 'js:function(form, data, hasError) {
//		                  if(hasError) {
//		                      for(var i in data) $("#"+i).parents(".form-group").addClass("has-error");
//		                      return false;
//		                  }
//		                  else {
//		                      form.children().removeClass("has-error");
//		                      return true;
//		                  }
//		              }',
//		        'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
//		                  if(hasError) $("#"+attribute.id).parents(".form-group").addClass("has-error");
//		                      else $("#"+attribute.id).parents(".form-group").removeClass("has-error");
//		              }'
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
		                        <?php echo $form->labelEx($model,'title',array('class'=>'col-md-2 control-label')); ?>
		                        <div class="col-md-8">
		                            <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
		                        </div>
		                        <?php echo $form->error($model,'title'); ?>
		                    </div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'词典分类',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo CHtml::DropDownList('category_id',$model->category_id,CHtml::listData($category,'id','name'),array('class'=>'form-control',
											'id'=>'category_id'))?>
								</div>
								<?php echo $form->error($model,'词典分类'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'content',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textArea($model,'content',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'content'); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'cycle',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textArea($model,'cycle',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'cycle'); ?>
							</div>

							<div class="form-group">
								<?php echo $form->labelEx($model,'price',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->textArea($model,'price',array('class'=>'form-control')); ?>
								</div>
								<?php echo $form->error($model,'price'); ?>
							</div>

							<div class="form-group">
								<?php echo $form->labelEx($model,'status',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php echo $form->dropDownList($model,'status', array('0' => '未发布', '1' => '已发布'),array('class'=>'orm-control')); ?>
								</div>
								<?php echo $form->error($model,'status'); ?>
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
