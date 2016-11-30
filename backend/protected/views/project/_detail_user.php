<div class="form-body">
    <ul class="nav nav-pills nav-justified steps">
        <li class="active">
            <a href="#tab1" data-toggle="tab" class="step" aria-expanded="true">
												<span class="number">
												1 </span>
												<span class="desc">
												<i class="fa fa-check"></i>资产详情 </span>
            </a>
        </li>
        <li>
            <a href="#tab2" data-toggle="tab" class="step">
												<span class="number">
												2 </span>
												<span class="desc">
												<i class="fa fa-check"></i> 增值服务 </span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="alert alert-success display-none">
            <button class="close" data-dismiss="alert"></button>
        </div>
        <div class="tab-pane active" id="tab1">
            <div class="tip" ><span>* 号栏为必填项</span></div>
            <?php echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','', array('class' => 'alert alert-danger'));?>

            <!--资产属性-->
            <div class="form-group left">
                <?php echo $form->labelEx($model,'asset_attributes_id',array('class'=>'control-label col-md-3')); ?>
                <div class="col-md-4">
                    <?php echo $form->dropDownList($model,'asset_attributes_id',AssetAttributesModel::getIdToName(array(4)),array('class'=>'form-control','empty'=>'请选择')); ?>
                    <span class="help-block"><?php echo $form->error($model,'asset_attributes_id'); ?></span>
                </div>
            </div>
            <!---发布时间-->
            <div class="form-group right">
                <?php echo $form->labelEx($model,'release_at',array('class'=>'col-md-3 control-label')); ?>
                <div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
                     data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
                    <?php echo $form->textField($model,'release_at', array( 'value'=>$model->release_at>0 ? date('Y-m-d',$model->release_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
                    <span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i
                                                    class="fa fa-calendar"></i></button>
											</span>
                </div>
                <span class="help-block right"><?php echo $form->error($model,'release_at'); ?></span>
            </div>
            <?php if(!empty($model['id'])){?>
                <!--资产id-->
                <div class="form-group left">
                    <?php echo $form->labelEx($model,'资产id',array('class'=>'col-md-3 control-label l_width')); ?>
                    <div class="col-md-4">
                        <?php echo $form->labelEx($model,$model['id'],array('class'=>'form-control l_width'));?>
                    </div>
                </div>

                <!--状态-->
                <div class="form-group right">
                    <?php echo $form->labelEx($model,'状态',array('class'=>'col-md-3 control-label')); ?>
                    <div class="col-md-4">
                        <?php echo $form->labelEx($model,ProjectModel::$status_types[$model['status']],array('class'=>'form-control'));?>
                    </div>
                </div>
                <!--发布人-->
                <div class="form-group left">
                    <?php echo $form->labelEx($user,'发布人',array('class'=>'col-md-3 control-label l_width')); ?>
                    <div class="col-md-4">
                        <?php echo $form->labelEx($user,$user['username'],array('class'=>'form-control input-large ')); ?>
                    </div>
                </div>
                <!--身份-->
                <div class="form-group right">
                    <?php echo $form->labelEx($user,'身份',array('class'=>'col-md-3 control-label ')); ?>
                    <div class="col-md-4">
                        <?php echo $form->labelEx($user,$user['is_broker']==1 ? "经纪人":"会员",array('class'=>'form-control input-large'));?>
                    </div>
                </div>
            <?php }?>
            <!---律师-->
            <div class="form-group clear left">
                <?php echo $form->labelEx($model,'选择律师',array('class'=>'col-md-3 control-label l_width')); ?>

                <div class="col-md-4">
                    <?php echo $form->dropDownList($model,'service_uid',$server_users,array('class'=>'form-control','empty'=>'请选择')); ?>
                    <span class="help-block"><?php echo $form->error($model,'service_uid'); ?></span>
                </div>
            </div>
            <div class="tip" ><span><i class="fa fa-minus-circle" status="info_1"></i>基本信息</span></div>
            <div class="info_1">
                <!--标题-->
                <div class="form-group clear" >
                    <?php echo $form->labelEx($model,'title',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-4 ">
                        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
                        <span class="help-block"><?php echo $form->error($model,'title'); ?></span>
                    </div>
                </div>
                <!--封面图片-->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'image',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-4">
                        <?php
                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                            array(
                                'id'=>'imageId',//容器的id 唯一的[必须配置]
                                'name'=>'AdminProjectFrom[image]',//post到后台接收的name [必须配置]
                                'inputId'=>'AdminProjectFrom_image',//post到后台接收的input ID [file image 时必须配置]
                                'content'=>isset( $model['image']) &&  $model['image']!=Null ? $model['image']:'',//初始化内容 [可选的]
                                'class'=>'form-control',
                                'btnClass'=>'btn blue',
                                'type'=>'image',
                                'config'=>array(
                                    'lang'=>'zh-cn'
                                )
                            )
                        );
                        ?>
                        <span class="help-block"><?php echo $form->error($model,'image'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'资产图片',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-4">
                        <?php
                        $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                            array(
                                'id'=>'project_attachment',//容器的id 唯一的[必须配置]
                                'name'=>'AdminProjectFrom[project_attachment]',//post到后台接收的name [必须配置]
                                'inputId'=>'AdminProjectFrom_project_attachment',//post到后台接收的input ID [file image 时必须配置]
                                'content'=>isset($project_attachment) && $project_attachment!=Null ? $project_attachment:array(),//初始化内容 [可选的]
                                'class'=>'form-control',
                                'btnClass'=>'btn blue',
                                'type'=>'images',
                                'config'=>array(
                                    'lang'=>'zh-cn'
                                )
                            )
                        );
                        ?>
                        <span class="help-block"> <?php echo $form->error($model,'project_attachment'); ?></span>
                    </div>
                </div>
                <!--地理位置-->
                <div class="form-group left">
                    <label class="control-label col-md-3 l_width">选择地址 <span class="required" aria-required="true">* </span></label>
                    <div class="col-md-4" style="width:400px;">
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
                <!--建筑面积-->
                <div class="form-group right">
                    <?php echo $form->labelEx($model,'floor_area',array('class'=>'control-label col-md-3')); ?>
                    <div class="col-md-4">
                        <?php echo $form->textField($model,'floor_area',array('class'=>'form-control input-large')); ?>
                        <span class="help-block"><?php echo $form->error($model,'floor_area'); ?></span>
                    </div>
                </div>
                <!---权属现状-->
                <div class="form-group clear left">
                    <?php echo $form->labelEx($model,'ownership_type',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-4" style="width: 400px;">
                        <?php echo CHtml::checkBoxList('AdminProjectFrom[ownership_type]',isset($model['ownership_type']) ? explode(',', $model['ownership_type']) : '',ProjectModel::$ownership_types,array('class' => 'form-control','separator'=>'')); ?>
                        <span class="help-block"><?php echo $form->error($model,'ownership_type'); ?></span>
                    </div>
                </div>
                <!--楼层-->
                <div class="form-group right">
                    <?php echo $form->labelEx($model,'所在楼层',array('class'=>'control-label col-md-3')); ?>
                    <div class="col-md-4" >
                            <input type="hidden" name="AdminProjectFrom[floor_type]" value="1">
                            <?php echo $form->numberField($model,'house_floor',array('class'=>'',"style"=>"size:5;width:50px;")); ?>
                            / <?php echo $form->numberField($model,'total_floor',array('class'=>'',"style"=>"size:5;width:50px;")); ?>
                        <span class="help-block"><?php echo $form->error($model,'total_floor'); ?></span>
                    </div>
                </div>
                <!--建筑年代-->
                <div class="form-group clear left">
                    <?php echo $form->labelEx($model,'build_age',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-4">
                        <?php echo $form->numberField($model,'build_age',array('class'=>'form-control input-large')); ?>
                        <span class="help-block"><?php echo $form->error($model,'build_age'); ?></span>
                    </div>
                </div>
                <!---装修情况-->
                <div class="form-group right">
                    <?php echo $form->labelEx($model,'decoration_type',array('class'=>'control-label col-md-3 ')); ?>
                    <div class="col-md-4">
                        <?php echo $form->dropDownList($model,'decoration_type',ProjectModel::$decoration_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
                        <span class="help-block"><?php echo $form->error($model,'decoration_type'); ?></span>
                    </div>
                </div>
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
                        <?php echo $form->numberField($model,'rooms',array('class'=>'',"style"=>"size:5;width:50px;")); ?>
                        室 <?php echo $form->numberField($model,'halls',array('class'=>'',"style"=>"size:5;width:50px;")); ?> 厅
                        <?php echo $form->numberField($model,'washroom',array('class'=>'',"style"=>"size:5;width:50px;")); ?> 卫
                        <span class="help-block"><?php echo $form->error($model,'rooms'); ?></span>
                    </div>
                </div>
            </div>
            <div class="tip" ><span><i class="fa fa-minus-circle" status="info_2"></i> 价格及购买相关信息</span></div>
            <div class="info_2">
                <!--交易方式-->
                <div class="form-group left">
                    <?php echo $form->labelEx($model,'buy_method_id',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-4">
                        <?php echo $form->dropDownList($model,'buy_method_id',ProjectBuyMethodModel::getIdToName(),array('class'=>'form-control input-large','empty'=>'请选择')); ?>
                        <span class="help-block"><?php echo $form->error($model,'buy_method_id'); ?></span>
                    </div>
                </div>
                <!--处置价--->
                <div class="form-group right">
                    <?php echo $form->labelEx($model,'price',array('class'=>'control-label col-md-3')); ?>
                    <div class="col-md-4">
                        <?php echo $form->textField($model,'price',array('class'=>'form-control input-large')); ?>
                        <span class="help-block"><?php echo $form->error($model,'price'); ?></span>
                    </div>
                </div>
                <!--处置单价--->
                <div class="form-group left">
                    <?php echo $form->labelEx($model,'unit_price',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-4">
                        <?php echo $form->textField($model,'unit_price',array('class'=>'form-control input-large')); ?>
                        <span class="help-block"><?php echo $form->error($model,'unit_price'); ?></span>
                    </div>
                </div>

                <!--市场价--->
                <div class="form-group right">
                    <?php echo $form->labelEx($model,'market_price',array('class'=>'control-label col-md-3 ')); ?>
                    <div class="col-md-4">
                        <?php echo $form->textField($model,'market_price',array('class'=>'form-control input-large')); ?>
                        <span class="help-block"><?php echo $form->error($model,'market_price'); ?></span>
                    </div>
                </div>
                <!--市场单价--->
                <div class="form-group left">
                    <?php echo $form->labelEx($model,'unit_market_price',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-4">
                        <?php echo $form->textField($model,'unit_market_price',array('class'=>'form-control')); ?>
                        <span class="help-block"><?php echo $form->error($model,'unit_market_price'); ?></span>
                    </div>
                </div>
                <!---折扣率-->
                <div class="form-group right">
                    <?php echo $form->labelEx($model,'discount_rate',array('class'=>'col-md-3 control-label')); ?>
                    <div class="col-md-4">
                        <?php echo $form->textField($model,'discount_rate',array('class'=>'form-control')); ?>
                    </div>
                    <?php echo $form->error($model,'discount_rate'); ?>
                </div>
                <!--截止日期-->
                <div class="form-group clear left">
                    <?php echo $form->labelEx($model,'disposition_end_at',array('class'=>'col-md-3 control-label l_width')); ?>
                    <div class="col-md-4 input-group date date-picker margin-bottom-5" data-date=""
                         data-date-format="yyyy-mm-dd" data-lanague="zh-CN">
                        <?php echo $form->textField($model, 'disposition_end_at', array( 'value'=>$model->disposition_end_at>0 ? date('Y-m-d',$model->disposition_end_at):'','class' => 'form-control', 'readonly' => "readonly")); ?>
                        <span class="input-group-btn">
											<button class="btn btn-sm default" type="button"><i
                                                    class="fa fa-calendar"></i></button>
											</span>
                    </div>
                    <span class="help-block"><?php echo $form->error($model,'end_at'); ?></span>
                </div>
                <div class="form-group right">
                    <?php echo $form->labelEx($model,'付款方式',array('class'=>'control-label col-md-3')); ?>
                    <div class="col-md-4">
                        <?php echo $form->dropDownList($model,'payment_type',ProjectModel::$payment_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
                        <span class="help-block"><?php echo $form->error($model,'payment_type'); ?></span>
                    </div>
                </div>

            </div>
            <div class="tip" ><span><i class="fa fa-minus-circle" status="info_2"></i> 其它描素</span></div>
            <div class="info_3">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'其它描素',array('class'=>'control-label col-md-3 l_width')); ?>
                    <div class="col-md-8">
                        <?php echo $form->textArea($model,'desc',array('class'=>'form-control',"rows"=>3)); ?>
                        <span class="help-block"><?php echo $form->error($model,'buy_method_id'); ?></span>
                    </div>
                </div>
            </div>
            <!--购买流程图选择-->
            <div class="form-group">
                <?php echo $form->labelEx($model,'购买流程图选择',array('class'=>'col-md-3 control-label l_width')); ?>
                <div class="col-md-4">
                    <?php echo $form->dropDownList($model,'buy_process_template_id',ProjectBuyProcessTemplateModel::getIdToName(),array('class'=>'form-control','empty'=>'请选择')); ?>

                    <span class="help-block"><?php echo $form->error($model,'buy_process_template_id'); ?></span>
                </div>
            </div>
        </div>


        <div class="tab-pane" id="tab2">
            <div class="form-group">
                <?php echo $form->labelEx($model,'增值服务',array('class'=>'control-label col-md-3 l_width')); ?>
                <div class="col-md-4" style="width:700px;">
                    <?php echo CHtml::checkBoxList('AdminProjectFrom[add_services]',isset($model['add_services'])&&!empty($model['add_services']) ? explode(',', $model['add_services']) : '',ProjectModel::addServiceLists(),array('class' => 'form-control')); ?>
                    <span class="help-block"><?php echo $form->error($model,'add_services'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
