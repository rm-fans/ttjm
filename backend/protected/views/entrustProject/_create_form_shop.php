
<div class="form-group left" >
    <?php echo $form->labelEx($model,'总户数(户)',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo $form->numberField($model,'shop_shop_num',array('class'=>'form-control input-large')); ?>
        <span class="help-block"><?php echo $form->error($model,'shop_num'); ?></span>
    </div>
</div>

<div class="form-group  right" >
    <?php echo $form->labelEx($model,'层高(米)',array('class'=>'control-label col-md-3 ')); ?>
    <div class="col-md-4">
        <?php echo $form->numberField($model,'shop_floor_height',array('class'=>'form-control input-large')); ?>
        <span class="help-block"><?php echo $form->error($model,'floor_height'); ?></span>
    </div>
</div>

<div class="form-group clear left">
    <?php echo $form->labelEx($model,'可否分割',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo CHtml::radioButtonList('AdminProjectFrom[is_split]',$model['is_split'],array(1=>"可以",0=>"不可以"),array('class' => 'form-control','separator'=>'')); ?>
        <span class="help-block"><?php echo $form->error($model,'is_split'); ?></span>
    </div>
</div>


<div class="form-group right">
    <?php echo $form->labelEx($model,'客流人群',array('class'=>'control-label col-md-3')); ?>
    <div class="col-md-4">
        <?php echo $form->dropDownList($model,'shop_user_from',ProjectModel::$user_from_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
        <span class="help-block"><?php echo $form->error($model,'shop_user_from'); ?></span>
    </div>
</div>

<div class="form-group left">
    <?php echo $form->labelEx($model,'商铺特征',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo $form->dropDownList($model,'shop_features_type',ProjectModel::$features_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
        <span class="help-block"><?php echo $form->error($model,'shop_features_type'); ?></span>
    </div>
</div>