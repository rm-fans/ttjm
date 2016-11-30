<script src="<?php echo Yii::app()->request->baseUrl;?>/static/js/My97DatePicker/WdatePicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 资产信息
                </div>

            </div>

            <div class="portlet-body form">
                <div class="form-wizard">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'product-model-form',
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

                            <li>
                                <a href="#tab4" data-toggle="tab" class="step">
												<span class="number">
												4 </span>
												<span class="desc">
												<i class="fa fa-check"></i> 佣金类信息 </span>
                                </a>
                            </li>
                        </ul>
                        <style>
                            .tip{margin-bottom:10px;clear:both;width:80%;margin-left: 30px;background: #8E44AD;font-size: 18px;color: #fff;line-height: 34px;padding-left:20px;}
                            .left{float:left;
                                width:40%;}
                            .right{float:left;width: 60%;}
                            .clear{clear:both}
                            .block{width:100%;}
                            .l_width{width:150px;}
                            .form .form-row-seperated .form-group{padding: 5px 0px;}
                        </style>
                        <div class="tab-content">
                            <div class="alert alert-success display-none">
                                <button class="close" data-dismiss="alert"></button>
                                Your form validation is successful!
                            </div>
                            <div class="tab-pane active" id="tab1">
                                <div class="tip" ><span>* 号栏为必填项</span></div>
                                <?php //echo $form->errorSummary($model, '<button data-close="alert" class="close"></button>','', array('class' => 'alert alert-danger'));?>

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
                                            <?php echo $form->labelEx($model,$model['projectId'],array('class'=>'form-control l_width'));?>
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
                                        <input type="hidden" name="AdminProjectFrom[uid]" value="<?php echo $model->uid;?>"/>
                                        <?php echo $form->labelEx($model,'发布人',array('class'=>'col-md-3 control-label l_width')); ?>
                                        <div class="col-md-4">
                                            <label class="form-control l_width"><?php echo $user->username;?></label>
                                            <?php //echo $form->labelEx($model,$model['admin_name'],array('class'=>'form-control input-large ')); ?>
                                        </div>
                                    </div>
                                <?php }?>

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
                                <!--资产图片-->
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
                                    <!--详细地址-->
                                    <div class="form-group right" >
                                        <?php echo $form->labelEx($model,'address',array('class'=>'control-label col-md-3')); ?>
                                        <div class="col-md-4">
                                            <?php echo $form->textField($model,'address',array('class'=>'form-control input-large')); ?>
                                            <span class="help-block"><?php echo $form->error($model,'address'); ?></span>
                                        </div>
                                    </div>
                                <!--小区名称-->
                                <div class="form-group clear left" >
                                    <?php echo $form->labelEx($model,'cell_name',array('class'=>'control-label col-md-3 l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'cell_name',array('class'=>'form-control input-large')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'cell_name'); ?></span>
                                    </div>
                                </div>
                                <!--建筑面积-->
                                <div class="form-group clear left">
                                    <?php echo $form->labelEx($model,'floor_area',array('class'=>'control-label col-md-3 l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'floor_area',array('class'=>'form-control input-large')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'floor_area'); ?></span>
                                    </div>
                                </div>

                                <!--资产成因-->
                                <div class="form-group right">
                                    <?php echo $form->labelEx($model,'project_reason_id',array('class'=>'control-label col-md-3')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->dropDownList($model,'project_reason_id',ProjectModel::$project_reason,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'project_reason_id'); ?></span>
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


                                <!---标签-->
                                <!--<div class="form-group right">
                                    <?php /*echo $form->labelEx($model,'tag_type',array('class'=>'control-label col-md-3')); */?>
                                    <div class="col-md-4" style="width: 400px;">
                                        <?php /*echo CHtml::checkBoxList('AdminProjectFrom[tag_type]',isset($model['tag_type']) ? explode(',', $model['tag_type']) : '',ProjectModel::$tag_types,array('class' => 'form-control','separator'=>'')); */?>
                                        <span class="help-block"><?php /*echo $form->error($model,'tag_type'); */?></span>
                                    </div>
                                </div>-->
                                    <!--物业费-->
                                    <div class="form-group clear left" >
                                        <?php echo $form->labelEx($model,'property_fee',array('class'=>'control-label col-md-3 l_width')); ?>
                                        <div class="col-md-4">
                                            <?php echo $form->textField($model,'property_fee',array('class'=>'form-control input-large')); ?>
                                            <span class="help-block"><?php echo $form->error($model,'property_fee'); ?></span>
                                        </div>
                                    </div>
                                    <!--楼层-->
                                    <div class="form-group right">
                                        <?php echo $form->labelEx($model,'所在楼层',array('class'=>'control-label col-md-3')); ?>
                                        <div class="col-md-4" >
                                            <?php echo CHtml::radioButtonList('AdminProjectFrom[floor_type]',$model['floor_type'],AdminProjectFrom::$floor_types,array('class' => 'form-control floor_type','separator'=>'')); ?>
                                            <br />
                                            <div class="house_1" style="<?php if($model['floor_type']!=1){echo 'display: none';}?>">
                                                <?php echo $form->numberField($model,'house_floor',array('value'=>$model['floor_type'] == 1 ? $model['house_floor']:'','class'=>'',"style"=>"size:5;width:50px;")); ?>
                                                / <?php echo $form->numberField($model,'total_floor',array('class'=>'',"style"=>"size:5;width:50px;")); ?>
                                            </div>
                                            <div class="house_2" style="<?php if($model['floor_type']!=2){echo 'display: none';}?>">
                                                地上<?php echo $form->numberField($model,'ground_floor',array('value'=>$model['floor_type'] == 2 ? $model['house_floor']:'','class'=>'',"style"=>"size:5;width:50px;")); ?>层
                                            </div>
                                            <span class="help-block"><?php echo $form->error($model,'ground_floor'); ?></span>
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
                                <div id="house_div" style="<?php if($model['asset_attributes_id'] != 1){echo 'display: none';}?>">
                                <?php $this->renderPartial('_create_form_house',array('model'=>$model,'form'=>$form))?>
                                </div>
                                    <div id="offices_div" style="<?php if($model['asset_attributes_id'] != 3){echo 'display: none';}?>">
                                <?php $this->renderPartial('_create_form_offices',array('model'=>$model,'form'=>$form))?>
                                </div>
                                    <div id="shop_div" style="<?php if($model['asset_attributes_id'] != 2){echo 'display: none';}?>">
                                <?php $this->renderPartial('_create_form_shop',array('model'=>$model,'form'=>$form))?>
                                    </div>
                                </div>
                                <div class="tip" ><span><i class="fa fa-minus-circle" status="info_2"></i> 价格及购买相关信息</span></div>

                                <div class="info_2">

                                <!--市场价--->
                                <div class="form-group left">
                                    <?php echo $form->labelEx($model,'market_price',array('class'=>'control-label col-md-3 l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'market_price',array('class'=>'form-control input-large')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'market_price'); ?></span>
                                    </div>
                                </div>
                                <!--市场单价--->
                                <div class="form-group right">
                                    <?php echo $form->labelEx($model,'unit_market_price',array('class'=>'control-label col-md-3')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'unit_market_price',array('class'=>'form-control')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'unit_market_price'); ?></span>
                                    </div>
                                </div>
                                <!--处置价--->
                                <div class="form-group left">
                                    <?php echo $form->labelEx($model,'price',array('class'=>'control-label col-md-3 l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'price',array('class'=>'form-control input-large')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'price'); ?></span>
                                    </div>
                                </div>
                                <!--处置单价--->
                                <div class="form-group right">
                                    <?php echo $form->labelEx($model,'unit_price',array('class'=>'control-label col-md-3')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'unit_price',array('class'=>'form-control input-large')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'unit_price'); ?></span>
                                    </div>
                                </div>
                                <!---折扣率-->
                                <div class="form-group left">
                                    <?php echo $form->labelEx($model,'discount_rate',array('class'=>'col-md-3 control-label l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'discount_rate',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'discount_rate'); ?>
                                </div>
                                <!--交易方式-->
                                <div class="form-group right">
                                    <?php echo $form->labelEx($model,'buy_method_id',array('class'=>'control-label col-md-3 ')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->dropDownList($model,'buy_method_id',ProjectBuyMethodModel::getIdToName(),array('class'=>'form-control input-large','empty'=>'请选择')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'buy_method_id'); ?></span>
                                    </div>
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
                                    <!--资产成因-->
                                    <div class="form-group right">
                                        <?php echo $form->labelEx($model,'payment_type',array('class'=>'control-label col-md-3')); ?>
                                        <div class="col-md-4">
                                            <?php echo $form->dropDownList($model,'payment_type',ProjectModel::$payment_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
                                            <span class="help-block"><?php echo $form->error($model,'payment_type'); ?></span>
                                        </div>
                                    </div>
                                    </div>
                                <div class="tip" ><span><i class="fa fa-minus-circle" status="info_3"></i> 现状信息</span></div>
                                    <div class="info_3">
                                <!---标的物现状-->
                                <div class="form-group left">
                                    <?php echo $form->labelEx($model,'current_situation_type',array('class'=>'col-md-3 control-label l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->dropDownList($model,'current_situation_type',ProjectModel::$current_situation_types,array('class' => 'form-control input-large','empty'=>'请选择')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'current_situation_type'); ?></span>
                                    </div>
                                </div>
                                 <!---租金-->
                                <div class="form-group left">
                                    <?php echo $form->labelEx($model,'rent',array('class'=>'col-md-3 control-label l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'rent',array('class'=>'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'rent'); ?>
                                </div>
                                <!--交割方式-->
                                <div class="form-group clear left">
                                    <?php echo $form->labelEx($model,'交割方式',array('class'=>'control-label col-md-3 l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->dropDownList($model,'delivery_type',ProjectModel::$delivery_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'delivery_type'); ?></span>
                                    </div>
                                </div>

                                <!--过户费用承担-->
                                <div class="form-group clear left">
                                    <?php echo $form->labelEx($model,'过户费用承担',array('class'=>'control-label col-md-3 l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->dropDownList($model,'transfer_ownership_type',ProjectModel::$transfer_ownership_types,array('class'=>'form-control input-large','empty'=>'请选择')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'transfer_ownership_type'); ?></span>
                                    </div>
                                </div>
                                <!--是否欠缴费用-->
                               <!-- <div class="form-group right">
                                    <?php /*echo $form->labelEx($model,'is_arrears',array('class'=>'control-label col-md-3')); */?>
                                    <div class="col-md-4">
                                        <?php /*echo CHtml::radioButtonList('AdminProjectFrom[is_arrears]',$model['is_arrears'],array(1=>"是",0=>"否"),array('class' => 'form-control','separator'=>'')); */?>
                                        <span class="help-block"><?php /*echo $form->error($model,'is_arrears'); */?></span>
                                    </div>
                                </div>-->

                                <div class="form-group clear left">
                                    <?php echo $form->labelEx($model,'请输入欠缴描述',array('class'=>'control-label col-md-3 l_width')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'arrears_reason',array('class'=>'form-control input-large')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'arrears_reason'); ?></span>
                                    </div>
                                </div>
                                        <?php $this->renderPartial('_create_form_pub',array('model'=>$model,'form'=>$form))?>

                                </div>

                                <div class="tip show_4" ><span><i class="fa fa-minus-circle" status="info_4"></i>补充介绍</span></div>
                                <div class="info_4">
                                    <!---扩展介绍-->
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model,'其他描述',array('class'=>'col-md-3 control-label l_width')); ?>

                                        <div class="col-md-4">
                                            <?php
                                            $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                                array(
                                                    'id'=>'article_content_desc',//容器的id 唯一的[必须配置]
                                                    'name'=>'AdminProjectFrom[desc]',//post到后台接收的name [必须配置]
                                                    'content'=>isset($model['desc']) ? $model['desc'] : '',//初始化内容 [可选的]
                                                    'type'=>'textarea',
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
                                            <span class="help-block"><?php echo $form->error($model,'summary'); ?></span>
                                        </div>
                                    </div>

                                    <!---扩展介绍-->
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model,'扩展介绍',array('class'=>'col-md-3 control-label l_width')); ?>

                                        <div class="col-md-4">
                                            <?php
                                            $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                                                array(
                                                    'id'=>'article_content_summary',//容器的id 唯一的[必须配置]
                                                    'name'=>'AdminProjectFrom[summary]',//post到后台接收的name [必须配置]
                                                    'content'=>isset($model['summary']) ? $model['summary'] : '',//初始化内容 [可选的]
                                                    'type'=>'textarea',
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
                                            <span class="help-block"><?php echo $form->error($model,'summary'); ?></span>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="tab-pane" id="tab2">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'增值服务',array('class'=>'control-label col-md-3 l_width')); ?>
                                    <div class="col-md-4" style="width:700px;">
                                        <?php echo CHtml::checkBoxList('AdminProjectFrom[add_services]',explode(',', "1,3,4,5,6,7,8,9"),ProjectModel::addServiceLists(),array('class' => 'form-control','disabled'=>'disabled')); ?>
                                        <span class="help-block"><?php echo $form->error($model,'add_services'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab4">
                                <!---介绍买方-->
                                <!--<div class="form-group">
                                    <?php /*echo $form->labelEx($model,'introducer_buy_rate',array('class'=>'col-md-3 control-label')); */?>
                                    <div class="col-md-4">
                                        <?php /*echo $form->textField($model,'introducer_buy_rate',array("value"=>(float)$model["introducer_buy_rate"],'class'=>'form-control')); */?>
                                        <span class="help-block"><?php /*echo $form->error($model,'introducer_buy_rate'); */?></span>
                                    </div>
                                </div>-->
                                <!--平台比例%-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'platform_rate',array('class'=>'col-md-3 control-label')); ?>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model,'platform_rate',array("value"=>isset($model['platform_rate'])?(float)$model['platform_rate']:"","readOnly"=>"true",'class'=>'form-control')); ?>
                                        <span style="color: red;display: none" class="platform_rate_error">＊与基准线不符，需要确认。基准线：50%</span>
                                        <span class="help-block"><?php echo $form->error($model,'platform_rate'); ?></span>
                                    </div>
                                </div>
                                <!---预估税费-->
                                <!--<div class="form-group">
                                    <?php /*echo $form->labelEx($model,'e_taxes_price',array('class'=>'col-md-3 control-label')); */?>

                                    <div class="col-md-4">
                                        <?php /*echo $form->textField($model,'e_taxes_price',array("value"=>$model["e_taxes_price"],'class'=>'form-control')); */?>
                                        <span class="help-block"><?php /*echo $form->error($model,'e_taxes_price'); */?></span>
                                    </div>
                                </div>-->
                                <!---第三方撮合费用-->
                                <!--<div class="form-group">
                                    <?php /*echo $form->labelEx($model,'third_part_price',array('class'=>'col-md-3 control-label')); */?>
                                    <div class="col-md-4">
                                        <?php /*echo $form->textField($model,'third_part_price',array("value"=>$model["third_part_price"],'class'=>'form-control')); */?>

                                        <span class="help-block"><?php /*echo $form->error($model,'third_part_price'); */?></span>
                                    </div>
                                </div>-->

                                <!---是否推荐-->
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'是否推荐',array('class'=>'col-md-3 control-label')); ?>
                                    <div class="col-md-8">
                                        <?php echo CHtml::radioButtonList('AdminProjectFrom[is_recommend]',$model['is_recommend'],ProjectModel::$recommend_type,array('class' => 'form-control')); ?>
                                    </div>
                                    <?php echo $form->error($model,'is_recommend'); ?>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-8">
                                        <input type="hidden" value="<?php echo ProjectModel::PROJECT_TYPE_ENTRUST;?>" name="AdminProjectFrom[type]" />
                                        <?php if($model->id>0){?>
                                            <button class="btn green" type="submit" name="AdminProjectFrom[status]" value="<?php echo $model->status; ?>"><i class="fa fa-check"></i>保存修改</button>
                                        <?php }?>
                                        <?php if($detail_button==1){?>
                                            <button class="btn green" type="submit" name="AdminProjectFrom[status]" value="<?php echo ProjectModel::STATUS_SUBMIT; ?>"><i class="fa fa-check"></i><?php echo ProjectModel::$status_types[ProjectModel::STATUS_SUBMIT];?></button>
                                        <?php }if($detail_button==2){?>
                                            <button class="btn green unPass" type="button" ><i class="fa fa-check"></i><?php echo ProjectModel::$status_types[ProjectModel::STATUS_FAILED]; ?></button>
                                            <button class="btn green" type="submit" name="AdminProjectFrom[status]" value="<?php echo ProjectModel::STATUS_SUCCESS; ?>"><i class="fa fa-check"></i><?php echo ProjectModel::$status_types[ProjectModel::STATUS_SUCCESS]; ?></button>
                                        <?php }?>
                                    </div>
                                </div>
                                <div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title">退回理由</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible1="1">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <textarea name="AdminProjectFrom[reason]" class="form-control" rows="7" id="reason"></textarea>
                                                            <span id="reason-error" class="help-block help-block-error hide">不能为空</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn default">关闭</button>
                                                <button type="submit" class="btn green"  name="AdminProjectFrom[status]" value="<?php echo ProjectModel::STATUS_FAILED; ?>"  id="submit">确认</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if($this->getAction()->id=='detailAudit' || $this->getAction()->id=='detail'){?>
                                    <div class="portlet-body">
                                        <div class="table-container">
                                            <table class="table table-striped table-bordered table-hover" id="datatable_list">
                                                <thead>
                                                <tr role="row" class="heading">
                                                    <th width="10%">日期</th>
                                                    <th width="10%">理由</th>
                                                    <th width="10%">审核状态</th>
                                                    <th width="10%">审核人</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if($check_logs != Null){ foreach($check_logs as $logs){?>
                                                    <tr>
                                                        <td><?php echo date('Y-m-d H:i:s',$logs['created_at']);?></td>
                                                        <td><?php echo $logs['reason'];?></td>
                                                        <td><?php echo ProjectModel::$status_types[$logs['status']];?></td>
                                                        <td><?php echo $logs['admin_name'];?></td>
                                                    </tr>
                                                <?php }}?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>

                        </div>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<script>
    $("#AdminProjectFrom_price").blur(function(){
        var price = parseFloat($(this).val())*10000;
        var mark_price = parseFloat($("#AdminProjectFrom_market_price").val())*10000;
        var area = parseFloat($("#AdminProjectFrom_floor_area").val());
        var unit_price = parseInt(price/area);
        $("#AdminProjectFrom_unit_price").val(unit_price);
        if(price >0 && mark_price>0)
        {
            var rate = price/mark_price*10
            $("#AdminProjectFrom_discount_rate").val(rate.toFixed(1));
        }
    })
    $("#AdminProjectFrom_market_price").blur(function(){
        var price = parseFloat($("#AdminProjectFrom_price").val())*10000;
        var mark_price = parseFloat($("#AdminProjectFrom_market_price").val())*10000;
        var area = parseFloat($("#AdminProjectFrom_floor_area").val());
        var unit_price = parseInt(mark_price/area);
        $("#AdminProjectFrom_unit_market_price").val(unit_price);
        if(price >0 && mark_price>0)
        {
            var rate = price/mark_price*10
            $("#AdminProjectFrom_discount_rate").val(rate.toFixed(1));
        }
    })

    $("#AdminProjectFrom_asset_attributes_id").change(function(){
        var id = $(this).val();
        if(id == '1')
        {
            $("#house_div").show();
            $("#shop_div").hide();
            $("#offices_div").hide();
        }
        else if(id == '2')
        {
            $("#house_div").hide();
            $("#shop_div").show();
            $("#offices_div").hide();

        }else if(id == '3')
        {
            $("#house_div").hide();
            $("#shop_div").hide();
            $("#offices_div").show();
        }
    })
    $(".floor_type").change(function(){
        var val = $(this).val();
        if(val == '1')
        {
            $(".house_1").show();
            $(".house_2").hide();
        }else{
            $(".house_1").hide();
            $(".house_2").show();
        }
    })
    $(".lease_income").blur(function(){
        var lease_income = $(this).val();
        var lease_expiration_at = $(".lease_expiration_at").val();
        var release_at = $("#AdminProjectFrom_release_at").val();
        var price = $("#AdminProjectFrom_price").val();
        $.ajax({
            url:'<?php echo $this->createUrl('entrustProject/easeRate')?>',
            //dataType:'json',
            type:'post',
            data:{lease_income:lease_income,lease_expiration_at:lease_expiration_at,release_at:release_at,price:price,csrf:$('input[name="csrf"]').val()},
            success:function(data){
                if(data == '0')
                {
                    $(".lease_income_error").html("发布时间和到期时间选择有误,年回报率不能小于0%");
                    $(".lease_income").attr("value","");
                    $(".lease_expiration_at").attr("value","");
                    $("#AdminProjectFrom_lease_year_rate").attr("value","");
                }else {
                    $(".lease_income_error").html("");
                    $("#AdminProjectFrom_lease_year_rate").attr("value",data);
                }

            }
        });
    })

    $(".is_lease").click(function(){
        var val = $(this).val();
        if(val == '1')
        {
            $(".has_is_lease").show();
        }else{
            $(".has_is_lease").hide();
        }
    })
    $(".tip > span > .fa").click(function(){
        var is_use = $(this).hasClass("fa-minus-circle");
        var id = $(this).attr("status");
        if(is_use)
        {
            $(this).removeClass("fa-minus-circle");
            $(this).addClass("fa-plus-circle");
            $("."+id).hide();
        }else{
            $(this).removeClass("fa-plus-circle");
            $(this).addClass("fa-minus-circle");
            $("."+id).show();
        }
    })
</script>
<script>

    $().ready(function(){
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
        $("#reason").keyup(function(){
            if($(this).val().length>=50)
            {
                var val = $(this).val().substring(0,50) ;
                $(this).val(val);
            }
        })
        $("#AdminProjectFrom_introducer_buy_rate").blur(function(){
            var num =  parseFloat($(this).val());
            if(num != 50)
            {
                $('.platform_rate_error').show();
            }else{
                $('.platform_rate_error').hide();
            }
            $('#AdminProjectFrom_platform_rate').val(100-num);
        })
        $(".unPass").click(function(){
            $("#reason").val('');
            $("#responsive").modal('show');
        })

    });
</script>