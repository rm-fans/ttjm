<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    array('name' => '首页', 'url' => array('site/index')),
    array('name'=>'客户管理'),
    array('name' => '客户管理', 'url' => array('customer/lineList')),
    array('name'=>'客户详情')
);
$this->pageTitle = '客户详情';
$this->title = '客户详情<small>客户详情</small>';
?>

<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title form-horizontal">
                <div class="caption">
                    <i class="fa fa-child"></i>客户详情
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-lg" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#tab_1" aria-expanded="true" data-id="1">
                                客户信息 </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#tab_2" aria-expanded="false" data-id="2">
                                联系记录
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1" class="tab-pane active">
                            <div class="table-responsive">

                                <table class="table table-striped table-hover table-bordered">
                                    <tbody>
                                    <tr>
                                        <td width='30%'>资产ID</td>
                                        <td width='70%'><?php echo $model->projectId?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>创建时间</td>
                                        <td width='70%'><?php echo date("Y/m/d", $model->created_at)?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>客户名称</td>
                                        <td width='70%'><?php echo $model->name?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>联系电话</td>
                                        <td width='70%'><?php echo $model->phone?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>类型</td>
                                        <td width='70%'> <?php echo $model->type?> </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>描述</td>
                                        <td width='70%'>  <?php echo $model->desc?></td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>用户来源</td>
                                        <td width='70%'>  <?php switch($model->type){
                                                case ProjectUserRecordModel::TYPE_OWN_BUY:
                                                    echo "自愿购买";
                                                    break;
                                                case ProjectUserRecordModel::TYPE_BROKER_BUY:
                                                    echo "介绍购买";
                                                    break;
                                                case ProjectUserRecordModel::TYPE_OWN_CASH:
                                                   echo "快速变现";
                                                    break;
                                                case ProjectUserRecordModel::TYPE_ENTRUST_PUB:
                                                    echo "委托发布";
                                                    break;
                                            }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width='30%'>状态</td>
                                        <td width='70%'>
                                            <?php
                                            switch ($model->state)
                                            {
                                                case ProjectUserRecordModel::STATE_CUSTOMER_CONTACT:
                                                    echo '客服联系';
                                                    break;
                                                case ProjectUserRecordModel::STATE_CONTACTING:
                                                    echo '接触中';
                                                    break;
                                                case ProjectUserRecordModel::STATE_CONTACT_FAILURE:
                                                    echo '接触失败';
                                                    break;
                                                case ProjectUserRecordModel::STATE_DEAL:
                                                    echo '成交';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php if($model->state==ProjectUserRecordModel::STATE_CUSTOMER_CONTACT):?>
                                        <tr>
                                            <td width='30%'>联系次数</td>
                                            <td width='70%'> <?php echo $model->c_interviewer_count?> </td>
                                        </tr>
                                        <tr>
                                            <td width='30%'>最后联系人</td>
                                            <td width='70%'> <?php echo $model->c_interviewer_username?> </td>
                                        </tr>
                                        <tr>
                                            <td width='30%'>最后联系时间</td>
                                            <td width='70%'><?php echo $model->c_interviewed_at ?></td>
                                        </tr>
                                    <?php else:?>
                                        <tr>
                                            <td width='30%'>客服联系次数</td>
                                            <td width='70%'> <?php echo $model->c_interviewer_count?> </td>
                                        </tr>
                                        <tr>
                                            <td width='30%'>客服最后联系人</td>
                                            <td width='70%'> <?php echo $model->c_interviewer_username?> </td>
                                        </tr>
                                        <tr>
                                            <td width='30%'>客服最后联系时间</td>
                                            <td width='70%'><?php echo $model->c_interviewed_at ?></td>
                                        </tr>
                                        <?php if($model->state!=ProjectUserRecordModel::STATE_DEAL):?>
                                            <tr>
                                                <td width='30%'></td>
                                                <td width='70%'>
                                                    <a class="btn btn green" href="<?php echo Yii::app()->createUrl('customer/lineInfo/id/'.$model->id)?>">
                                                        <i class="fa fa-plus"></i>
                                                        <span class="hidden-480">查看客服联系记录 </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif;?>
                                        <tr>
                                            <td width='30%'>销售联系次数</td>
                                            <td width='70%'> <?php echo $model->s_interviewer_count?> </td>
                                        </tr>
                                        <tr>
                                            <td width='30%'>销售最后联系人</td>
                                            <td width='70%'> <?php echo $model->s_interviewer_username?> </td>
                                        </tr>
                                        <tr>
                                            <td width='30%'>销售最后联系时间</td>
                                            <td width='70%'><?php echo $model->s_interviewed_at ?></td>
                                        </tr>
                                    <?php endif;?>
                                    <?php if($model->state!=ProjectUserRecordModel::STATE_DEAL):?>
                                        <tr>
                                            <td width='30%'></td>
                                            <td width='70%'>
                                                <a class="btn btn green" href="<?php echo Yii::app()->createUrl('customer/updataState/id/'.$model->id)?>">
                                                    <i class="fa fa-plus"></i>
                                                    <span class="hidden-480">
                                                        <?php
                                                            if($model->state==ProjectUserRecordModel::STATE_CUSTOMER_CONTACT){
                                                                echo '推送到销售 ';
                                                            }elseif($model->state==ProjectUserRecordModel::STATE_CONTACTING){
                                                                echo '设置为接触失败 ';
                                                            }elseif($model->state==ProjectUserRecordModel::STATE_CONTACT_FAILURE){
                                                                echo '设置为接触中 ';
                                                            }
                                                        ?>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php else:?>
                                        <tr>
                                            <td width='30%'>成交金额</td>
                                            <td width='70%'> <?php echo $project->sell_price?> </td>
                                        </tr>
                                        <tr>
                                            <td width='30%'>成交时间</td>
                                            <td width='70%'> <?php echo $project->selled_at?> </td>
                                        </tr>
                                        <tr>
                                            <td width='30%'>经纪人佣金</td>
                                            <td width='70%'> <?php echo $project->serve_price?> </td>
                                        </tr>
                                    <?php endif;?>
                                    <?php if($model->project_id!='' && $model->state==ProjectUserRecordModel::STATE_CONTACTING && ($model->type==ProjectUserRecordModel::TYPE_OWN_BUY || $model->type==ProjectUserRecordModel::TYPE_BROKER_BUY)):?>
                                        <tr>
                                            <td width='30%'></td>
                                            <td width='70%'>
                                                <a class="btn btn green" href="<?php echo Yii::app()->createUrl('customer/deal/id/'.$model->id)?>">
                                                    <i class="fa fa-plus"></i>
                                                    <span class="hidden-480">填写成交信息</span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div id="tab_2" class="tab-pane">
                            <div class="table-container">
                                <a class="btn btn green" href="<?php echo Yii::app()->createUrl('customer/addInterview/id/'.$model->id)?>">
                                    <i class="fa fa-plus"></i>
                                    <span class="hidden-480">添加联系信息 </span>
                                </a>
                                <table class="table table-striped table-bordered table-hover" id="datatable_list">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th width="15%">联系时间</th>
                                        <th width="55%">沟通内容</th>
                                        <th width="15%">报告时间</th>
                                        <th width="15%">联系人</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="csrf" value="<?php echo Yii::app()->request->getCsrfToken()?>">
<!-- END PAGE CONTENT-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/datatable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/ecommerce-list.js"></script>
<!--style-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/static/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<script>
    jQuery(document).ready(function() {
        var url = '<?php echo $this->createUrl("info",array('id'=>$model->id))?>';
        var token = $("input[name='csrf']").val();
        EcommerceList.init(url,token);
    });
</script>