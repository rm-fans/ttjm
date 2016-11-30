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


		<div class="portlet-body">
		    <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','',
		        array('class' => 'alert alert-danger'));?>
		    <div class="tabbable">
		        <div class="tab-content no-space">
		            <div class="tab-pane active" id="tab_general">
		                <div class="form-body">
		                    <div class="form-group">
		                        <?php echo $form->labelEx($model,'资产ID',array('class'=>'col-md-2 control-label')); ?>
		                        <div class="col-md-8">
									<?php if($type=='updata'): echo $model->projectId;else:?>
		                            <?php echo $form->textField($model,'projectId',array('class'=>'form-control')); ?>
									<?php endif; ?>
		                        </div>
		                        <?php echo $form->error($model,'资产ID'); ?>
		                    </div>
		                    <div class="form-group">
		                        <?php echo $form->labelEx($model,'客户名称',array('class'=>'col-md-2 control-label')); ?>
		                        <div class="col-md-8">
		                            <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
		                        </div>
		                        <?php echo $form->error($model,'客户名称'); ?>
		                    </div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'联系电话',array('class'=>'col-md-2 control-label')); ?>
								<div class="col-md-8">
									<?php if($type=='updata' && $model->uid!=null): echo $model->phone;else:?>
									<?php echo $form->telField($model,'phone',array('class'=>'form-control')); ?>
									<?php endif; ?>
								</div>
								<?php echo $form->error($model,'联系电话'); ?>
							</div>
		                    <div class="form-group">
		                        <?php echo $form->labelEx($model,'类型',array('class'=>'col-md-2 control-label')); ?>
		                        <div class="col-md-8">
		                            <?php echo CHtml::DropDownList('type',$model->type,array(
											ProjectUserRecordModel::TYPE_OWN_BUY=>'自己购买意愿',
											ProjectUserRecordModel::TYPE_BROKER_BUY=>'介绍购买(用于经纪人)',
											ProjectUserRecordModel::TYPE_OWN_CASH=>'变现',
											ProjectUserRecordModel::TYPE_ENTRUST_PUB=>'委托发布',
									),
											array('class'=>'form-control','id'=>'type'))?>
		                        </div>
		                        <?php echo $form->error($model,'类型'); ?>
		                    </div>
		                    <div class="form-group">
		                        <?php echo $form->labelEx($model,'描述',array('class'=>'col-md-2 control-label')); ?>
		                        <div class="col-md-8">
		                            <?php echo $form->textArea($model,'desc',array('class'=>'form-control')); ?>
		                        </div>
		                       <?php echo $form->error($model,'描述');?>
		                    </div>
							<input class="form-control" name="ProjectUserRecordModel[state]" id="ProjectUserRecordModel_state" type="hidden" value="<?php echo $state?>">
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
