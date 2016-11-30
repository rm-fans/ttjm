


<div class="form-group clear left">
    <?php echo $form->labelEx($model,'可否分割',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo CHtml::radioButtonList('AdminProjectFrom[is_split]',$model['is_split'],array(1=>"可以",0=>"不可以"),array('class' => 'form-control','separator'=>'')); ?>
        <span class="help-block"><?php echo $form->error($model,'is_split'); ?></span>
    </div>
</div>

<div class="form-group right">
    <?php echo $form->labelEx($model,'等级',array('class'=>'control-label col-md-3 ')); ?>
    <div class="col-md-4">
        <?php echo $form->dropDownList($model,'offices_level',ProjectModel::$offices_level_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
        <span class="help-block"><?php echo $form->error($model,'offices_level'); ?></span>
    </div>
</div>

<div class="form-group left">
    <?php echo $form->labelEx($model,'类型',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo $form->dropDownList($model,'offices_type',ProjectModel::$offices_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
        <span class="help-block"><?php echo $form->error($model,'offices_type'); ?></span>
    </div>
</div>


<div class="form-group left">
    <?php echo $form->labelEx($model,'停车位(位)',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo $form->numberField($model,'offices_parking_space',array('class'=>'form-control input-large')); ?>
        <span class="help-block"><?php echo $form->error($model,'offices_parking_space'); ?></span>
    </div>
</div>