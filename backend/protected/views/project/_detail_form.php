<?php
/* @var $this ProjectController */
/* @var $model ProjectModel */
/* @var $form CActiveForm */
?>
<script src="<?php echo Yii::app()->request->baseUrl;?>/static/js/My97DatePicker/WdatePicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/static/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>
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
<div class="row">
    <div class="col-md-12">

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
                                    <?php
                                       
                                            $this->renderPartial('_detail_grab', array('model' => $model, 'form' => $form));
                                        
                                            //$this->renderPartial('_detail_user', array('type'=>$type,'server_users'=>$server_users,'model' => $model,'user'=>$user, 'form' => $form,'project_attachment'=>$project_attachment));
                                        
                                     ?>.


                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="AdminProjectFrom[type]" value="<?php echo ProjectModel::PROJECT_TYPE_NOT_ENTRUST;?>">
                                        <?php if(!empty($status_buttons)){?>
                                            <?php foreach($status_buttons as $k=>$v){?>
                                                <?php if(in_array($k,ProjectModel::$status_reason) && $v!='保存修改'){?>
                                                    <button class="btn green unPass" type="button" status="<?php echo $k; ?>"><i class="fa fa-check"></i><?php echo $v ?></button>
                                                <?php } else{?>
                                                    <button class="btn green button_submit" type="submit" name="AdminProjectFrom[status]"  value="<?php echo $k; ?>" status="<?php echo $k; ?>"><i class="fa fa-check"></i><?php echo $v;?></button>
                                                <?php }}?>
                                        <?php }else{?>
                                        <button class="btn green unPass" type="button" status="<?php echo ProjectModel::STATUS_FAILED; ?>"><i class="fa fa-check"></i><?php echo ProjectModel::$status_types[ProjectModel::STATUS_FAILED]; ?></button>
                                        <button class="btn green" type="submit" name="AdminProjectFrom[status]" value="<?php echo $model["status"]; ?>"><i class="fa fa-check"></i>保存修改</button>
                                        <button class="btn green" type="submit" name="AdminProjectFrom[status]" value="<?php echo ProjectModel::STATUS_SHELF; ?>"><i class="fa fa-check"></i><?php echo ProjectModel::$status_types[ProjectModel::STATUS_SHELF];?></button>
                                        <button class="btn green" type="submit" name="AdminProjectFrom[status]" value="<?php echo ProjectModel::STATUS_SUCCESS; ?>"><i class="fa fa-check"></i><?php echo ProjectModel::$status_types[ProjectModel::STATUS_SUCCESS]; ?></button>

                                        <?php }?>
                                       </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
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
                                <textarea name="AdminProjectFrom[reason]" class="form-control" rows="7" id="reason" style="width:80%;margin-left:10%"></textarea>
                                <span id="reason-error" class="help-block help-block-error hide">不能为空</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn default">关闭</button>
                    <button type="submit" class="btn green"  name="AdminProjectFrom[status]" value=""  id="submit">确认</button>
                </div>
            </div>
        </div>
    </div>

    </div>
<?php $this->endWidget(); ?>
</div>
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
    $("#reason").keyup(function(){
        if($(this).val().length>=50)
        {
            var val = $(this).val().substring(0,50) ;
            $(this).val(val);
        }
    })
    $(".unPass").click(function(){
        var status = $(this).attr("status");
        $("#submit").attr("value",status);
        $("#reason").val('');
        $("#responsive").modal('show');
    })
    $().ready(function() {
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
    })

</script>

