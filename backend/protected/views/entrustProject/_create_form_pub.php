<!---租赁时效-->
<div class="form-group right">
    <?php echo $form->labelEx($model,'租赁时效',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
         data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
        <?php echo $form->textField($model,'lease_expiration_at', array( 'value'=>$model->lease_expiration_at>0 ? date('Y-m-d',$model->lease_expiration_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
        <span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i
                                                    class="fa fa-calendar"></i></button>
											</span>
    </div>
    <span class="help-block right"><?php echo $form->error($model,'lease_expiration_at'); ?></span>
</div>

<!--权属人-->
<div class="form-group clear left" >
    <?php echo $form->labelEx($model,'property_owner',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'property_owner',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'property_owner'); ?></span>
    </div>
</div>

<!--共有人-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'common_people',array('class'=>'control-label col-md-3')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'common_people',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'common_people'); ?></span>
    </div>
</div>

<!--产权号-->
<div class="form-group left" >
    <?php echo $form->labelEx($model,'property_number',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'property_number',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'property_number'); ?></span>
    </div>
</div>

<!--国土证号-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'land_number',array('class'=>'control-label col-md-3 ')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'land_number',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'land_number'); ?></span>
    </div>
</div>



<!--权属来源-->
<div class="form-group left">
    <?php echo $form->labelEx($model,'权属来源',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo $form->dropDownList($model,'ownership_source',ProjectModel::$ownership_source_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
        <span class="help-block"><?php echo $form->error($model,'ownership_source'); ?></span>
    </div>
</div>

<!--土地使用权证号-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'land_use_number',array('class'=>'control-label col-md-3')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'land_use_number',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'land_use_number'); ?></span>
    </div>
</div>

<!--土地期限-->
<div class="form-group left" >
    <?php echo $form->labelEx($model,'land_tenure',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'land_tenure',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'land_tenure'); ?></span>
    </div>
</div>

<!--有无限制转移-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'restricted_transfer',array('class'=>'control-label col-md-3 ')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'restricted_transfer',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'restricted_transfer'); ?></span>
    </div>
</div>

<!--土地使用权是否办妥有偿使用手续-->
<div class="form-group left">
    <?php echo $form->labelEx($model,'土地使用权是否办妥有偿使用手续',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4">
        <?php echo CHtml::radioButtonList('AdminProjectFrom[land_use_procedures]',$model['land_use_procedures'],array(1=>"是",0=>"否"),array('class' => 'form-control','separator'=>'')); ?>
        <span class="help-block"><?php echo $form->error($model,'land_use_procedures'); ?></span>
    </div>
</div>

<!--抵押权人-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'mortgage',array('class'=>'control-label col-md-3')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'mortgage',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'mortgage'); ?></span>
    </div>
</div>

<!--抵押权利部位-->
<div class="form-group clear left" >
    <?php echo $form->labelEx($model,'mortgage_part',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'mortgage_part',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'mortgage_part'); ?></span>
    </div>
</div>

<!--权利面积-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'area_rights',array('class'=>'control-label col-md-3')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'area_rights',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'area_rights'); ?></span>
    </div>
</div>

<!--权利价值(元)-->
<div class="form-group left" >
    <?php echo $form->labelEx($model,'right_value',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'right_value',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'right_value'); ?></span>
    </div>
</div>

<!--登记时间-->
<div class="form-group right">
    <?php echo $form->labelEx($model,'登记时间',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
         data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
        <?php echo $form->textField($model,'registration_at', array( 'value'=>$model->registration_at>0 ? date('Y-m-d',$model->registration_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
        <span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i
                                                    class="fa fa-calendar"></i></button>
											</span>
    </div>
    <span class="help-block right"><?php echo $form->error($model,'registration_at'); ?></span>
</div>
<!--债权数额(元)-->
<div class="form-group left" >
    <?php echo $form->labelEx($model,'amount_debt',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'amount_debt',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'amount_debt'); ?></span>
    </div>
</div>


<div class="form-group right">
    <?php echo $form->labelEx($model,'查封时效',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
         data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
        <?php echo $form->textField($model,'close_down_at', array( 'value'=>$model->close_down_at>0 ? date('Y-m-d',$model->close_down_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
        <span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i
                                                    class="fa fa-calendar"></i></button>
											</span>
    </div>
    <span class="help-block right"><?php echo $form->error($model,'lease_expiration_at'); ?></span>
</div>

<!--查封机关-->
<div class="form-group left" >
    <?php echo $form->labelEx($model,'close_down_organs',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'close_down_organs',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'close_down_organs'); ?></span>
    </div>
</div>

<!--查封案号-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'close_down_number',array('class'=>'control-label col-md-3 ')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'close_down_number',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'close_down_number'); ?></span>
    </div>
</div>

<!--查封标的明细(元)-->
<div class="form-group left" >
    <?php echo $form->labelEx($model,'close_down_price',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'close_down_price',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'close_down_price'); ?></span>
    </div>
</div>

<!--资金递增情况-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'increase_capital',array('class'=>'control-label col-md-3 ')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'increase_capital',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'increase_capital'); ?></span>
    </div>
</div>

<!--解约违约成本-->
<div class="form-group left" >
    <?php echo $form->labelEx($model,'default_cost',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'default_cost',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'default_cost'); ?></span>
    </div>
</div>

<!--借用情况说明-->
<div class="form-group right" >
    <?php echo $form->labelEx($model,'borrow_reason',array('class'=>'control-label col-md-3 ')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'borrow_reason',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'borrow_reason'); ?></span>
    </div>
</div>

<!--占用情况说明-->
<div class="form-group left" >
    <?php echo $form->labelEx($model,'occupy_reason',array('class'=>'control-label col-md-3 l_width')); ?>
    <div class="col-md-4 ">
        <?php echo $form->textField($model,'occupy_reason',array('class'=>'form-control')); ?>
        <span class="help-block"><?php echo $form->error($model,'occupy_reason'); ?></span>
    </div>
</div>