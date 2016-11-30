
<!--朝向-->
<div class="form-group left">
    <?php echo $form->labelEx($model,'orientation',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo $form->dropDownList($model,'orientation',ProjectModel::$orientation_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
        <span class="help-block"><?php echo $form->error($model,'orientation'); ?></span>
    </div>
</div>
<!--户型-->
<div class="form-group right">
    <?php echo $form->labelEx($model,'户型',array('class'=>'control-label col-md-3')); ?>
    <div class="col-md-4" style="width:400px;">
        <?php echo $form->textField($model,'rooms',array('class'=>'',"style"=>"size:5;width:50px;")); ?>
        室 <?php echo $form->textField($model,'halls',array('class'=>'',"style"=>"size:5;width:50px;")); ?> 厅
        <?php echo $form->textField($model,'washroom',array('class'=>'',"style"=>"size:5;width:50px;")); ?> 卫
        <span class="help-block"><?php echo $form->error($model,'rooms'); ?></span>
    </div>
</div>
<!--容积率-->
<div class="form-group clear left">
    <?php echo $form->labelEx($model,'容积率(%)',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo $form->textField($model,'plot_ratio',array('class'=>'form-control input-large')); ?>
        <span class="help-block"><?php echo $form->error($model,'plot_ratio'); ?></span>
    </div>
</div>

<!--绿化率-->
<div class="form-group right">
    <?php echo $form->labelEx($model,'绿化率(%)',array('class'=>'control-label col-md-3 ')); ?>
    <div class="col-md-4">
        <?php echo $form->textField($model,'green_rate',array('class'=>'form-control input-large')); ?>
        <span class="help-block"><?php echo $form->error($model,'green_rate'); ?></span>
    </div>
</div>

<!--唯一住房-->
<div class="form-group left">
    <?php echo $form->labelEx($model,'唯一住房',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo CHtml::radioButtonList('AdminProjectFrom[only_house]',$model['only_house'],array(1=>"是",0=>"否"),array('class' => 'form-control','separator'=>'')); ?>
        <span class="help-block"><?php echo $form->error($model,'only_house'); ?></span>
    </div>
</div>
<!---购买时间-->
<div class="form-group right">
    <?php echo $form->labelEx($model,'购买时间',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
         data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
        <?php echo $form->textField($model,'buy_at', array( 'value'=>$model->buy_at>0 ? date('Y-m-d',$model->buy_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
        <span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i
                                                    class="fa fa-calendar"></i></button>
											</span>
    </div>
    <span class="help-block right"><?php echo $form->error($model,'buy_at'); ?></span>
</div>
