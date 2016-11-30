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
            'id'=>'buy-process-form',
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
                            <!--标题名称-->
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'name',array('class'=>'col-md-3 control-label')); ?>
                                <div class="col-md-8">
                                    <?php echo $form->textField($model,'name',array("value"=>isset($info['name']) ? $info['name']:'','class'=>'form-control')); ?>
                                </div>
                                <?php echo $form->error($model,'name'); ?>
                            </div>

                            <div class="form-group">
                                <?php echo $form->labelEx($model,'使用资产数',array('class'=>'col-md-3 control-label')); ?>
                                <div class="col-md-8">
                                    <?php echo $form->labelEx($model,$number,array('class'=>'form-control')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'pc资产图片',array('class'=>'col-md-3 control-label')); ?>
                                <div class="col-md-8">
                                    <?php
                                    $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                        array(
                                            'id'=>'project_pc_content',//容器的id 唯一的[必须配置]
                                            'name'=>'BuyProcessForm[pc_content]',//post到后台接收的name [必须配置]
                                            'inputId'=>'BuyProcessForm_pc_content',//post到后台接收的input ID [file image 时必须配置]
                                            'content'=>isset($images['pc']) && $images['pc']!=Null ? $images['pc']:array(),//初始化内容 [可选的]
                                            'class'=>'form-control',
                                            'btnClass'=>'btn blue',
                                            'type'=>'images',
                                            'config'=>array(
                                                'lang'=>'zh-cn'
                                            )
                                        )
                                    );
                                    ?>
                                </div>
                                <?php echo $form->error($model,'project_attachment'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'wap资产图片',array('class'=>'col-md-3 control-label')); ?>
                                <div class="col-md-8">
                                    <?php
                                    $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                        array(
                                            'id'=>'project_wap_content',//容器的id 唯一的[必须配置]
                                            'name'=>'BuyProcessForm[wap_content]',//post到后台接收的name [必须配置]
                                            'inputId'=>'BuyProcessForm_wap_content',//post到后台接收的input ID [file image 时必须配置]
                                            'content'=>isset($images['wap']) && $images['wap']!=Null ? $images['wap']:array(),//初始化内容 [可选的]
                                            'class'=>'form-control',
                                            'btnClass'=>'btn blue',
                                            'type'=>'images',
                                            'config'=>array(
                                                'lang'=>'zh-cn'
                                            )
                                        )
                                    );
                                    ?>
                                </div>
                                <?php echo $form->error($model,'project_attachment'); ?>
                            </div>

                            <div class="form-group">
                                <?php echo $form->labelEx($model,'is_effect',array('class'=>'col-md-3 control-label')); ?>
                                <div class="col-md-8">
                                    <?php $is_effect = isset($info['is_effect']) ? array($info['is_effect']):array();?>
                                    <?php echo CHtml::checkBoxList('BuyProcessForm[is_effect]',$is_effect,array("1"=>"是"),array('class' => 'form-control')); ?>
                                </div>
                                <?php echo $form->error($model,'name'); ?>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
                                    <button class="btn green" type="submit" value=""><i class="fa fa-check"></i>保存修改</button>
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
<script>
    $().ready(function() {
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
    })

</script>

