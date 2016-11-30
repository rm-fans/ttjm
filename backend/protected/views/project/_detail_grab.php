
<!--资产id-->
<div class="form-group">
    <?php echo $form->labelEx($model,'资产id',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-8">
        <?php echo $form->labelEx($model,$model['projectId'],array('class'=>'form-control'));?>
    </div>
</div>
<!--标题-->
<div class="form-group">
    <?php echo $form->labelEx($model,'title',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-8">
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
    </div>
    <?php echo $form->error($model,'title'); ?>
</div>
<!--合作平台-->
<div class="form-group">
    <?php echo $form->labelEx($model,'合作平台',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-8">
        <?php echo $form->textField($model,'grab_from',array('class'=>'form-control')); ?>
    </div>
</div>
<!--原始链接-->
<div class="form-group">
    <?php echo $form->labelEx($model,'原始链接',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-8">
        <?php echo $form->textField($model,'origin_url',array('class'=>'form-control')); ?>
    </div>
</div>
<!--来源类别-->
<div class="form-group">
    <?php echo $form->labelEx($model,'grab_from_type',array('class'=>'control-label col-md-3')); ?>
    <div class="col-md-8">
        <?php echo $form->dropDownList($model,'grab_from_type',ProjectModel::$grab_from_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
        <span class="help-block"><?php echo $form->error($model,'buy_method_id'); ?></span>
    </div>
</div>
<!--交易方式-->
<div class="form-group">
    <?php echo $form->labelEx($model,'buy_method_id',array('class'=>'control-label col-md-3')); ?>
    <div class="col-md-8">
        <?php echo $form->dropDownList($model,'buy_method_id',ProjectBuyMethodModel::getIdToName(),array('class'=>'form-control input-large','empty'=>'请选择')); ?>
        <span class="help-block"><?php echo $form->error($model,'buy_method_id'); ?></span>
    </div>
</div>
<!--参考价-->
<div class="form-group">
    <?php echo $form->labelEx($model,'参考价/评估价(万元)',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-8">
        <?php echo $form->textField($model,'market_price',array('class'=>'form-control')); ?>
    </div>
    <?php echo $form->error($model,'market_price'); ?>
</div>
<!--出售价格-->
<div class="form-group">
    <?php echo $form->labelEx($model,'起拍价/挂牌价/协议价(万元)',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-8">
        <?php echo $form->textField($model,'price',array('class'=>'form-control')); ?>
    </div>
    <?php echo $form->error($model,'price'); ?>
</div>
<!--地理位置-->
<div class="form-group">
    <label class="control-label col-md-3">选择地址 <span class="required" aria-required="true">* </span></label>
    <div class="col-md-8" >
        <?php echo $form->dropDownList($model, 'province_id', CHtml::listData(DistrictModel::model()->findAll('level=1'), 'id', 'name'),
            array(
                'prompt' => '选择省份',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('ajax/district'),
                    'dataType' => 'json',
                    'data' => array('id'=>'js:this.value','csrf'=>'js:$("input[name=\'csrf\']").val()','type'=>'province'),
                    'success' => 'function(data) {
                                                 $("#AdminProjectFrom_city_id").html(data.cities);
                                                 $("#AdminProjectFrom_district_id").html(data.districts);
                                           }',
                )));
        ?>
        <?php echo $form->dropDownList($model,'city_id',$model->province_id ? CHtml::listData(DistrictModel::model()->findAll('upid='.$model->province_id), 'id', 'name') : array(),
            array(
                'prompt' => '选择城市',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('ajax/district'),
                    'update' => '#AdminProjectFrom_district_id',
                    'data' => array('id'=>'js:this.value','csrf'=>'js:$("input[name=\'csrf\']").val()','type'=>'city'),
                )),array('class'=>'form-control')
        ) ; ?>
        <?php echo $form->dropDownList($model, 'district_id', $model->city_id ? CHtml::ListData(DistrictModel::model()->findAll('upid=' . $model->city_id), 'id', 'name') : array(), array('prompt' => '选择区域')); ?>


        <span class="help-block"><?php echo $form->error($model,'district_id'); ?></span>
    </div>
</div>


<!---发布时间-->
<div class="form-group">

    <?php echo $form->labelEx($model,'release_at',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
         data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
        <?php echo $form->textField($model,'release_at', array( 'value'=>$model->release_at>0 ? date('Y-m-d',$model->release_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
        <span class="input-group-btn">
        <button class="btn btn-sm default" type="button"><i
                class="fa fa-calendar"></i></button>
        </span>
    </div>
    <span class="help-block"><?php echo $form->error($model,'release_at'); ?></span>
</div>
<!---过期时间-->
<div class="form-group">

    <?php echo $form->labelEx($model,'disposition_end_at',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
         data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
        <?php echo $form->textField($model,'disposition_end_at', array( 'value'=>$model->disposition_end_at>0 ? date('Y-m-d',$model->disposition_end_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
        <span class="input-group-btn">
        <button class="btn btn-sm default" type="button"><i
                class="fa fa-calendar"></i></button>
        </span>
    </div>
    <span class="help-block"><?php echo $form->error($model,'release_at'); ?></span>
</div>
<!--状态-->
<div class="form-group">
    <?php echo $form->labelEx($model,'状态',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-8">
        <?php echo $form->labelEx($model,ProjectModel::$status_types[$model['status']],array('class'=>'form-control'));?>
    </div>
</div>
<!--建筑面积-->
<div class="form-group">
    <?php echo $form->labelEx($model,'floor_area',array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-8">
        <?php echo $form->textField($model,'floor_area',array('class'=>'form-control')); ?>
    </div>
    <?php echo $form->error($model,'floor_area'); ?>
</div>


