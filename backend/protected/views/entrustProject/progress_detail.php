<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">节点</h4>
        </div>
<div class="modal-body">
    <table class="table table-striped table-bordered table-hover" id="datatable_list">
        <caption align="top">律师:<?php echo $service_username;?></caption>
        <thead>
        <tr role="row" class="heading">
            <th width="10%" class="sorting_disabled"> 时间 </th>
            <th width="5%" class="sorting_disabled"> 状态 </th>
            <th width="10%" class="sorting_disabled">状态</th>
            <th width="10%" class="sorting_disabled">超时时间</th>
            <th width="10%" class="sorting_disabled">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach(ProjectOrderModel::$protocol_status_str as $k=>$v){?>
            <?php
                    if($k==ProjectOrderModel::FLOW_STATUS_SENDING) continue;
                    if(isset($service_lists[$k])){
                        $info = $service_lists[$k];
                ?>
            <tr>
                <td><?php echo date("Y-m-d H:i:s",$info['created_at']);?></td>
                <td><i class="fa fa-check" style="color: deepskyblue"></i></td>
                <td><span ><?php echo $v;?></span></td>
                <td><?php echo $info['timeout'];?></td>
                <td>

                    <?php if(!empty($info['timeout'])){?>
                    <button>发送提醒</button>
                    <?php }?>
                </td>
            </tr>
        <?php }else{?>
                <tr>
                    <td></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><span style="color:grey"><?php echo $v;?></span></td>
                    <td></td>
                    <td>
                        <?php if(ProjectOrderModel::FLOW_STATUS_SERVICE_PAYMENT== $k):?>
                        <a onclick='updateFlowStatus(<?= $order->id?>,<?= ProjectOrderModel::FLOW_STATUS_SERVICE_PAYMENT?>,<?= ProjectOrderModel::USER_TYPE_PLATFROM?>)'>确认服务费</a>
                        <?php endif;?>
                    </td>
                </tr>
        <?php }?>
        <?php }?>
        </tbody>
    </table>

    <table class="table table-striped table-bordered table-hover" id="datatable_list">
        <caption align="top">中介:<?php echo $agent_username;?></caption>
        <thead>
        <tr role="row" class="heading">
            <th width="10%" class="sorting_disabled"> 时间 </th>
            <th width="5%" class="sorting_disabled"> 状态 </th>
            <th width="10%" class="sorting_disabled">状态</th>
            <th width="10%" class="sorting_disabled">超时时间</th>
            <th width="10%" class="sorting_disabled">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach(ProjectOrderModel::$protocol_status_str as $k=>$v){?>
            <?php
                if($k==ProjectOrderModel::FLOW_STATUS_SENDING) continue;
                if(isset($agent_lists[$k])){
                    $info = $agent_lists[$k];
                ?>
                <tr>
                    <td><?php echo date("Y-m-d H:i:s",$info['created_at']);?></td>
                    <td><i class="fa fa-check" style="color: deepskyblue"></i></td>
                    <td><span ><?php echo $v;?></span></td>
                    <td><?php echo $info['timeout'];?></td>
                    <td>
                        <?php if(!empty($info['timeout'])){?>
                            <button>发送提醒</button>
                        <?php }?>
                    </td>
                </tr>
            <?php }else{?>
                <tr>
                    <td></td>
                    <td><i class="fa fa-times"></i></td>
                    <td><span style="color:grey"><?php echo $v;?></span></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php }?>
        <?php }?>
        </tbody>
    </table>
</div>
    </div>
</div>
