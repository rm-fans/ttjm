<?php
/**
 * 委托资产
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/19
 * Time: 10:40
 */
class EntrustProjectController extends LoginedController
{
    public $status_buttons;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            switch ($action->id) {
                case "transferDetail":

                    break;
                case "detail" :
                    break;
                case "detailAudit":
                    break;
            }
        }
        return true;

    }

    public function loadModel($id)
    {
        $model=ProjectModel::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    public function actionFailure()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $shelf_type = Yii::app()->request->getParam('shelf_type');
            $title = Yii::app()->request->getParam('title');
            $projectId = Yii::app()->request->getParam('projectId');
            $is_recommend = Yii::app()->request->getParam('is_recommend');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            $criteria->addCondition('type = '.ProjectModel::PROJECT_TYPE_ENTRUST);
            $criteria->addCondition('t.status =:status ');
            $criteria->params[":status"] = ProjectModel::STATUS_SUCCESS;
            $criteria->addCondition('t.disposition_end_at>0 && t.disposition_end_at <'.time());
            if($projectId){
                $criteria->addCondition("projectId = '".$projectId."'");
            }
            if($shelf_type)
            {
                $criteria->addCondition("shelf_type = '".$shelf_type."'");
            }
            if($is_recommend !== ''){
                $criteria->addCondition("is_recommend = ".$is_recommend);
            }
            if($title){
                $criteria->addSearchCondition("title",$title);
            }
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.is_recommend ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.shelf_type ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="t.status ".$order[0]['dir'];
                    break;
                default:
                    $criteria->order="t.projectId desc ";
                    break;
            }
            $dataProvider=new CActiveDataProvider('ProjectModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                )) );
            $products=$dataProvider->getData();
            foreach ($products as $p) {
                $url = "entrustProject/detail/id/{$p->id}";
                $updateButton = '<a href="'.$this->createUrl($url) . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $type_str = "资产已失效";
                $product[] = array(
                    $p['projectId'],
                    $p['is_recommend']==0 ? "否":"是",
                    $p['title'],
                    $type_str,
                    ProjectModel::$status_types[$p['status']],
                    $updateButton
                );
            }
            $recordsFiltered=$total = (int)ProjectModel::model()->count($criteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, ));
            exit;
        }
        $result = array();
        $this->render('shelf',array('result'=>$result,"action"=>'failure'));
    }
    //委托资产 - 已成交
    public function actionSuccess()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $title = Yii::app()->request->getParam('title');
            $projectId = Yii::app()->request->getParam('projectId');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            $criteria->with=array('sell_info','order');
            $criteria->addCondition('t.type = '.ProjectModel::PROJECT_TYPE_ENTRUST);
            $criteria->addCondition('order.status = '.ProjectOrderModel::STATUS_SUCCESS);
            $criteria->addCondition('t.status =:status ');
            $criteria->params[":status"] = ProjectModel::STATUS_TRADE_SUCCESS;
            if($projectId){
                $criteria->addCondition("t.projectId = '".$projectId."'");
            }
            if($title){
                $criteria->addSearchCondition("t.title",$title);
            }
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                default:
                    $criteria->order="t.projectId desc ";
                    break;
            }
            $dataProvider=new CActiveDataProvider('ProjectModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                )) );
            $products=$dataProvider->getData();
            //print_r($products);
            foreach ($products as $p) {
                $url = "entrustProject/detail/id/{$p->id}";
                $updateButton = '<a href="'.$this->createUrl($url) . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $product[] = array(
                    $p['projectId'],
                    $p['title'],
                    $p['sell_price']."万元",
                    isset($p->sell_info->identity_name)?'<a href="'.$this->createUrl("users/Info/id/".$p->sell_info->uid) . '">'.Utils::decrypt($p->sell_info->identity_name).'</a>':"",
                    isset($p->order->uid)?'<a href="'.$this->createUrl("users/Info/id/".$p->order->uid) . '">'.$p->order->uid.'</a>':"",
                    isset($p->order->service_uid)?'<a href="'.$this->createUrl("users/Info/id/".$p->order->service_uid) . '">'.$p->order->service_uid.'</a>':"",
                    isset($p->order->service_money)?$p->order->service_money:"",
                    isset($p->order->agent_uid)?'<a href="'.$this->createUrl("users/Info/id/".$p->order->agent_uid) . '">'.$p->order->agent_uid.'</a>':"",
                    isset($p->order->agent_money)?$p->order->agent_money:"",
                    date("Y-m-d",$p['selled_at']),
                    $updateButton
                );
            }
            $recordsFiltered=$total = (int)ProjectModel::model()->count($criteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, ));
            exit;
        }
        $result = array();
        $this->render('shelfSuccess',array('result'=>$result,"action"=>'success'));
    }
    //委托资产 - 待审核
    public function actionAudit()
    {

        if($_POST){
            $product=array();
            $pageSize = Yii::app()->request->getParam('length',10);
            $start = Yii::app()->request->getParam('start');
            $status = Yii::app()->request->getParam('status');
            $title = Yii::app()->request->getParam('title');
            $projectId = Yii::app()->request->getParam('projectId');
            $is_recommend = Yii::app()->request->getParam('is_recommend');
            $order = Yii::app()->request->getParam('order');

            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            if($status === ''){
               // $criteria->addCondition("status =".ProjectModel::STATUS_PENDING);
                $criteria->addInCondition("status",array(ProjectModel::STATUS_PENDING,ProjectModel::STATUS_SUBMIT));
            }else{
                $criteria->addCondition("status =".intval($status));
            }
            if($projectId){
                $criteria->addCondition("projectId = '".$projectId."'");
            }
            if($title)
            {
                $criteria->addSearchCondition("title",$title);
            }
            if($is_recommend !== ''){
                $criteria->addCondition("is_recommend = ".$is_recommend);
            }
            $criteria->addCondition("type = ".ProjectModel::PROJECT_TYPE_ENTRUST);
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.is_recommend ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.status ".$order[0]['dir'];
                    break;
                default:
                    $criteria->order="t.projectId desc ";
                    break;
            }
            /*echo "<pre>";
            print_r($criteria);*/
            $dataProvider=new CActiveDataProvider('ProjectModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                )) );
            $products=$dataProvider->getData();
            foreach ($products as $p) {
                $updateButton = '<a href="'.$this->createUrl("entrustProject/detail/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $updateButton .= '<a href="'.$this->createUrl("entrustProject/detailAudit/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>审核</a>';
                $product[] = array(
                    $p['projectId'],
                    $p['is_recommend']==0 ? "否":"是",
                    $p['title'],
                    ProjectModel::$status_types[$p['status']],
                    $updateButton
                );
            }
            $recordsFiltered=$total = (int)ProjectModel::model()->count($criteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, ));
            exit;
        }
        $result = array();
        $this->render('audit',array('result'=>$result));
    }
    //委托资产 - 详情 普通权限
    public function actionDetail($id)
    {
        //$model=$this->loadModel($id);
        $model=new AdminProjectFrom('entrust');
        $model->id = $id;
        $model->detail();
        $this->detail($model,$id,1);
    }
    private function detail(&$model,$id,$detail_button)
    {
        if(isset($_POST['AdminProjectFrom'])) {


            $form = $_POST['AdminProjectFrom'];
            $model->attributes = $form;
            $model->disposition_end_at  = $form['disposition_end_at']!='' ? strtotime($form['disposition_end_at']):0;
            $model->lease_expiration_at  = $form['lease_expiration_at']!='' ? strtotime($form['lease_expiration_at']):0;
            $model->registration_at  = $form['registration_at']!='' ? strtotime($form['registration_at']):0;
            $model->release_at = $form['release_at'] !='' ? strtotime($form['release_at']) :time();
            $model->close_down_at  = $form['close_down_at']!='' ? strtotime($form['close_down_at']):0;
            $model->buy_at  = $form['buy_at']!='' ? strtotime($form['buy_at']):0;
            $model->area = ProjectModel::areaName($model->province_id,$model->city_id,$model->district_id);
            $model->status = $form['status'];
            if($model->status == ProjectModel::STATUS_SHELF){
                $model->shelf_type = ProjectModel::SHELF_TYPE_PLATFORM;
            }else{
                $model->shelf_type = 0 ;
            }

            $model->tag_type = !empty($form['tag_type']) ? implode(',',$form['tag_type']) : '';
            $model->add_services = !empty($form['add_services']) ? implode(',',$form['add_services']) : '';
            $model->ownership_type = !empty($form['ownership_type']) ? implode(',',$form['ownership_type']) : '';
            $model->admin_id = Yii::app()->user->id;
            $model->admin_name = Yii::app()->user->name;
            $model->created_at = time();
            //$model->court_entrust = !empty($form['court_entrust']) ? implode(',',$form['court_entrust']):'';
            $model->submissions = !empty($form['submissions']) ? implode(',',$form['submissions']):'';
            if($model->validate())
            {

                if($model->save()){
                    //用户是否发布过资产
                    UserProfileModel::setPubProject($model->uid,$model->status);

                    if(isset($form['project_attachment']) && !empty($form['project_attachment'])){
                        ProjectAttachmentModel::model()->deleteAllByAttributes(array('project_id'=>$model->id));
                        foreach($form['project_attachment'] as $img){
                            $attachment = new ProjectAttachmentModel();
                            $attachment->project_id = $model->id;
                            $attachment->src = $img;
                            $attachment->save();
                        }
                    }

                    ProjectCheckLogModel::add($model->id,$form['reason'],$form['status']);
                    if($form['status']==ProjectModel::STATUS_SUCCESS)
                    {
                        $this->showSuccess('编辑成功', $this->createUrl('entrustProject/release'));
                    }elseif($form['status']==ProjectModel::STATUS_SHELF){
                        $this->showSuccess('编辑成功', $this->createUrl('entrustProject/shelf'));
                    }
                    else{
                        $this->showSuccess('编辑成功', $this->createUrl('entrustProject/audit'));
                    }

                }
            }
            else{
                echo "<pre>";

                print_r($model->getErrors());exit;
            }
        }

        $project_attachment = ProjectAttachmentModel::model()->findAll("project_id=".$id);
        $attachment = array();
        foreach($project_attachment as $obj)
        {
            $attachment[] = array("src"=>$obj['src']);
        }
        $submissions = array();
        if(!empty($model->submissions))
        {
            $ls = explode(',',$model->submissions);
            foreach($ls as $obj)
            {
                $submissions[] = array("src"=>$obj);
            }
        }
       // $court_entrust = array();
        /*if(!empty($model->court_entrust))
        {
            $ls = explode(',',$model->court_entrust);
            foreach($ls as $obj)
            {
                $court_entrust[] = array("src"=>$obj);
            }
        }*/

        $server_users = UserServiceDetailModel::serverUsers();
        $check_logs = ProjectCheckLogModel::model()->findAll("project_id=".$id." order by id desc");
        $result = array(
            'model'=> $model,
            'project_attachment' => $attachment,
            'detail_button' => $detail_button,
            'server_users' => $server_users,
            'check_logs' => $check_logs,
            'submissions' => $submissions,
            'user' => UserProfileModel::model()->findByPk($model['uid']),
            //'court_entrust' => $court_entrust,
            'type' => 1,
        );
        $this->render('detail',array('result'=>$result));
    }
    //委托资产 - 详情 审核权限
    public function actionDetailAudit($id)
    {

       /* $model=$this->loadModel($id);
        $this->detail($model,$id,2);*/
        $model=new AdminProjectFrom('entrust');
        $model->id = $id;
        $model->detail();
        $this->detail($model,$id,2);
    }


    public function actionEaseRate()
    {
        $lease_income = Yii::app()->request->getParam('lease_income');
        $lease_expiration_at = Yii::app()->request->getParam('lease_expiration_at');
        $release_at = Yii::app()->request->getParam('release_at');
        $price = Yii::app()->request->getParam('price');
        $rate = 0;
        if(!empty($release_at) && !empty($lease_expiration_at) && $release_at!=$lease_expiration_at)
        {
            $release_at = strtotime($release_at);
            $lease_expiration_at = strtotime($lease_expiration_at);
            $time = Utils::timediff($release_at,$lease_expiration_at,false,true);
            $day = $time['day'];
            $p = $price*10000;
            $rate = $lease_income/$day*365/$p*100;
        }
        echo round($rate,2);
        die();

    }
    //委托资产 - 添加
    public function actionCreate()
    {
        $result = array();
        $model=new AdminProjectFrom('entrust');

        if(isset($_POST['AdminProjectFrom']))
        {
            $form = $_POST['AdminProjectFrom'];
            $model->attributes = $form;
            $model->disposition_end_at  = $form['disposition_end_at']!='' ? strtotime($form['disposition_end_at']):0;
            $model->lease_expiration_at  = $form['lease_expiration_at']!='' ? strtotime($form['lease_expiration_at']):0;
            $model->close_down_at  = $form['close_down_at']!='' ? strtotime($form['close_down_at']):0;
            $model->registration_at  = $form['registration_at']!='' ? strtotime($form['registration_at']):0;
            $model->release_at = $form['release_at'] !='' ? strtotime($form['release_at']) :time();
            $model->buy_at = $form['buy_at'] !='' ? strtotime($form['buy_at']) :time();
            $model->area = ProjectModel::areaName($model->province_id,$model->city_id,$model->district_id);

            $model->admin_id = Yii::app()->user->id;
            $model->admin_name = Yii::app()->user->name;
            $model->created_at = time();
            $model->tag_type = !empty($form['tag_type']) ? implode(',',$form['tag_type']) : '';
            $model->add_services = !empty($form['add_services']) ? implode(',',$form['add_services']) : '';
            $model->ownership_type = !empty($form['ownership_type']) ? implode(',',$form['ownership_type']) : '';

            if($model->validate())
            {
                if($model->save()){
                    if(isset($form['project_attachment']) && !empty($form['project_attachment'])){
                        ProjectAttachmentModel::model()->deleteAllByAttributes(array('project_id'=>$model->id));
                        foreach($form['project_attachment'] as $img){
                            $attachment = new ProjectAttachmentModel();
                            $attachment->project_id = $model->id;
                            $attachment->src = $img;
                            $attachment->save();
                        }
                    }
                    ProjectCheckLogModel::add($model->id,'',$form['status']);
                    $this->showSuccess('添加成功', $this->createUrl('entrustProject/audit'));
                }
            }else{
                print_r($model->getErrors());exit;
            }
        }
        //$category = ProjectCategoryModel::getIdToName();
        $server_users = UserServiceDetailModel::serverUsers();
        $result = array(
            'model'=> $model,
            //'category' => $category,
            //'attribute1' => $attribute1,
           // 'attribute2' => $attribute2,
            'project_attachment' => array(),
            'self_attrs' => array(),
            'server_users' => $server_users,
            'detail_button' => 1,
            'type' => 1,

        );
        $this->render('create',array('result'=>$result));
    }
    //委托资产 - 发布中
    public function actionRelease()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $title=Yii::app()->request->getParam('title');
            $projectId = Yii::app()->request->getParam('projectId');
            $id = Yii::app()->request->getParam('id');
            $status = Yii::app()->request->getParam('status');
            $is_recommend = Yii::app()->request->getParam('is_recommend');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;

            if($projectId){
                $criteria->addCondition("t.projectId = '".$projectId."'");
            }
            if($id){
                $criteria->addCondition("t.id = '".$id."'");
            }
            if($is_recommend != ''){
                $criteria->addCondition("t.is_recommend = ".$is_recommend);
            }
            if($title){
                $criteria->addSearchCondition("t.title",$title);
            }
            $criteria->addInCondition("t.status",array(ProjectModel::STATUS_SUCCESS));
            $criteria->addCondition('t.type = '.ProjectModel::PROJECT_TYPE_ENTRUST);
            $criteria->order = "t.id desc";
            switch($order[0]['column']){
                case 1:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="t.is_recommend ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="t.release_at ".$order[0]['dir'];
                    break;
                case 5:
                    $criteria->order="t.status ".$order[0]['dir'];
                case 6:
                        $criteria->order="t.status ".$order[0]['dir'];
                    break;
            }
            $criteria->with = array("sell_info");
            $dataProvider=new CActiveDataProvider('ProjectModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                )) );
            $products=$dataProvider->getData();

            foreach ($products as $p) {
                $task = ProjectTaskModel::model()->find("project_id=:project_id",array(":project_id"=>$p['id']));
                $order_number = ProjectOrderModel::model()->count("project_id=:project_id",array(":project_id"=>$p['id']));
                $url = "project/updateStatus/id/{$p->id}/status/".ProjectModel::STATUS_SHELF;
                $updateButton = '<a href="javascript:void(0)" class="btn btn-xs default btn-editable pro_shelf" onclick="proShelf('.$p->id.')"><i class="fa fa-pencil"></i>下架</a>';
                $updateButton .= '<a href="'.$this->createUrl("entrustProject/detail/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $updateButton .= '<a href="'.$this->createUrl("entrustProject/progress/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>资产进度</a>';
                $a_link = "<a target='_blank' href='".Yii::app()->params['base_url']."/project/detail/{$p->id}'>";
                $user_name = !empty($p['uid']) ? $p->sell_info['username'] : '系统发布';
                $product[] = array(
                    $a_link.$p['id']."</a>",
                    $a_link.$p['projectId']."</a>",
                    $user_name,
                    $p['is_recommend']==0 ? "否":"是",
                    $a_link.$p['title']."</a>",
                    date('Y-m-d',$p['release_at']),
                    ProjectModel::$status_types[$p['status']],
                   /* !empty($task) ? "是":"否",
                    $order_number,*/
                    $updateButton
                );
            }
            echo json_encode(array('data' => $product, 'recordsTotal' => $dataProvider->getPagination()->getItemCount(), 'recordsFiltered' => $dataProvider->getPagination()->getItemCount(), ));
            exit;
        }
        $result = array();
        $this->render('release',array('result'=>$result));
    }
    //一键委托资产
    public function actionEntrust()
    {

        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $title=Yii::app()->request->getParam('title');
            $projectId = Yii::app()->request->getParam('projectId');
            $id = Yii::app()->request->getParam('id');
            $status = Yii::app()->request->getParam('status');
            $is_recommend = Yii::app()->request->getParam('is_recommend');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;

            if($projectId){
                $criteria->addCondition("projectId = '".$projectId."'");
            }
            if($id){
                $criteria->addCondition("id = '".$id."'");
            }
            if($is_recommend != ''){
                $criteria->addCondition("is_recommend = ".$is_recommend);
            }
            if($title){
                $criteria->addSearchCondition("title",$title);
            }
            $criteria->addInCondition("status",array(ProjectModel::STATUS_DRAFT));
            $criteria->addCondition('is_entrust =:is_entrust');
            $criteria->params["is_entrust"] = 1;
            $criteria->addCondition('type =:type');
            $criteria->params[":type"] =1;
            $criteria->order = "id desc";
            switch($order[0]['column']){
                case 1:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="t.is_recommend ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="t.release_at ".$order[0]['dir'];
                    break;
                case 5:
                    $criteria->order="t.status ".$order[0]['dir'];
                    break;
            }
        //echo "<pre>";
        //var_dump($criteria);exit;
            $dataProvider=new CActiveDataProvider('ProjectModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                )) );
            $products=$dataProvider->getData();
            $attributes = AssetAttributesModel::getIdToName();
            foreach ($products as $p) {
                $task = ProjectTaskModel::model()->find("project_id=:project_id",array(":project_id"=>$p['id']));
                $order_number = ProjectOrderModel::model()->count("project_id=:project_id",array(":project_id"=>$p['id']));
                $url = "project/updateStatus/id/{$p->id}/status/".ProjectModel::STATUS_SHELF;
                $updateButton = '<a href="javascript:void(0)" class="btn btn-xs default btn-editable pro_shelf" onclick="proShelf('.$p->id.')"><i class="fa fa-pencil"></i>下架</a>';
                $updateButton .= '<a href="'.$this->createUrl("entrustProject/detail/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $updateButton .= '<a href="'.$this->createUrl("entrustProject/progress/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>资产进度</a>';
                $a_link = "<a target='_blank' href='".Yii::app()->params['base_url']."/project/detail/{$p->id}'>";
                $product[] = array(
                    $a_link.$p['id']."</a>",
                    $a_link.$p['projectId']."</a>",
                    $attributes[$p['asset_attributes_id']],
                    $p['area'],
                    $p['cell_name'],
                    date('Y-m-d H:i:s',$p['created_at']),
                    ProjectModel::$status_types[$p['status']],
                    !empty($task) ? "是":"否",
                    $order_number,
                    $updateButton
                );

            }
        //echo $dataProvider->getPagination()->getItemCount();
            echo json_encode(array('data' => $product, 'recordsTotal' => $dataProvider->getPagination()->getItemCount(), 'recordsFiltered' => $dataProvider->getPagination()->getItemCount(), ));
            exit;
        }
        $result = array();
        $this->render('entrust',array('result'=>$result));
    }

    //委托资产 - 已下架
    public function actionShelf()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $shelf_type = Yii::app()->request->getParam('shelf_type');
            $status = Yii::app()->request->getParam('status');
            $title = Yii::app()->request->getParam('title');
            $projectId = Yii::app()->request->getParam('projectId');
            $is_recommend = (int)Yii::app()->request->getParam('is_recommend');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            $criteria->addCondition('type = '.ProjectModel::PROJECT_TYPE_ENTRUST);
            if($status)
            {
                $criteria->addCondition("status =".$status);
            }else{
                $criteria->addInCondition("status",array(ProjectModel::STATUS_SHELF,ProjectModel::STATUS_TRADE_SUCCESS));
            }
            if($projectId){
                $criteria->addCondition("projectId = '".$projectId."'");
            }
            if($shelf_type)
            {
                $criteria->addCondition("shelf_type = '".$shelf_type."'");
            }
            if($is_recommend !== ''){
                $criteria->addCondition("is_recommend = ".$is_recommend);
            }
            if($title){
                $criteria->addSearchCondition("title",$title);
            }
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.is_recommend ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.shelf_type ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="t.status ".$order[0]['dir'];
                    break;
                default:
                    $criteria->order="t.projectId desc ";
                    break;
            }

        $dataProvider=new CActiveDataProvider('ProjectModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                )) );
            $products=$dataProvider->getData();
            foreach ($products as $p) {
                $url = "entrustProject/detail/id/{$p->id}";
                $updateButton = '<a href="'.$this->createUrl($url) . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';

                if($p['status'] == ProjectModel::STATUS_SHELF)
                    $type_str = $p['shelf_type']==ProjectModel::SHELF_TYPE_USER ? "用户下架":"平台下架";
                else
                    $type_str = "资产成交";
                $product[] = array(
                    $p['projectId'],
                    $p['is_recommend']==0 ? "否":"是",
                    $p['title'],
                    $type_str,
                    ProjectModel::$status_types[$p['status']],
                    $updateButton
                );
            }
            $recordsFiltered=$total = (int)ProjectModel::model()->count($criteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, ));
            exit;
        }
        $result = array();
        $this->render('shelf',array('result'=>$result,"action"=>'shelf'));
    }

    /**
     * 资产进度
     * @param $id 资产id
     */
    public function actionProgress($id)
    {

        $agent = ProjectTaskModel::lastSendTime($id,ProjectTaskModel::TYPE_AGENT);
        $service = ProjectTaskModel::lastSendTime($id,ProjectTaskModel::TYPE_SERVICE);
        if($_POST) {

            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $page = $start / $pageSize;


            $lists = ProjectOrderModel::getProjectOrder($id,array(),$page,$pageSize);
            $product= array();
            foreach ($lists['lists'] as $p) {
                $url = "entrustProject/progressDetail/id/{$p->id}";
                $button = "<button  class='btn btn-xs default btn-editable' onclick='progress_detail({$p->id},{$p->service_uid},{$p->agent_uid})'><i class='fa fa-pencil'></i>查看节点</button>";
                $next_status = $p['status']+1;
                //平台确认按钮
                if($p['status'] == ProjectOrderModel::FLOW_STATUS_SERVICE_SIGNED  || $p['status'] == ProjectOrderModel::FLOW_STATUS_SERVICE_PAYMENT){
                    $is_find = ProjectOrderLogModel::model()->count("to_flow_status=:to_flow_status and uid=0",array(":to_flow_status"=>ProjectOrderModel::FLOW_STATUS_SERVICE_PAYMENT));//平台还未确认
                    if($is_find == 0){
                        $button .= '<button class="btn btn-xs default btn-editable" onclick="pay_button({$p->id},{$p->project_id})">服务费支付</button>';
                    }
                   }

                $contract = '';
                if(!empty($p->project_order_contract))
                {
                    $contract.= "<button  class='btn btn-xs default btn-editable' onclick='order_contract({$p->id})'><i class='fa fa-pencil'></i>服务协议</a>";
                }
                $product[] = array(
                    $p->user_info['username'],
                    date("Y-m-d H:i:s",$p['created_at']),
                    $p->service_user_info['uid'],
                    Utils::decrypt($p->service_user_info['identity_name']),
                    $p->agent_user_info['uid'],
                    Utils::decrypt($p->agent_user_info['identity_name']),
                    $p['service_money'],
                    $p['agent_money'],
                    ProjectOrderModel::$protocol_status_str[$p['status']],
                    isset(ProjectOrderModel::$protocol_status_str[$next_status]) ? ProjectOrderModel::$protocol_status_str[$next_status]:"",
                    $button,
                    $contract
                );
            }
            $total = (int)ProjectOrderModel::model()->count($lists['criteria']);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $total,));
            exit;
        }
        $this->render('progress',array("id"=>$id,"agent"=>$agent,"service"=>$service));
    }

    /**
     * 重新派单
     */
    public function actionOrderTask()
    {
        $id = (int)Yii::app()->request->getParam('id');
        $phone = Yii::app()->request->getParam('phone');
        if(!empty($phone))
        {
            $info = UserProfileModel::model()->find("phone=:phone",array(":phone"=>Utils::encrypt($phone)));
            $type = $info['is_agent'] == 1 ? ProjectTaskModel::TYPE_AGENT:0;
            $result = ProjectTaskModel::sendTask($id,$type,$info['uid']);
            if($result)
                die(Utils::jsonResult(200,"派单成功"));
            else
                die(Utils::jsonResult(-200,"派单异常"));
        }
        die(Utils::jsonResult(400,"派单失败"));
    }

    /**
     * 进度节点
     */
    public function actionProgressDetail()
    {
        $order_id = (int)Yii::app()->request->getParam('order_id');
        $service_uid = (int)Yii::app()->request->getParam('service_uid');
        $agent_uid = (int)Yii::app()->request->getParam('agent_uid');
        $service_lists = ProjectOrderLogModel::userStatusLog($order_id,$service_uid);
        $agent_lists = ProjectOrderLogModel::userStatusLog($order_id,$agent_uid);

        $html = "";
        ob_start();
        $this->renderPartial('progress_detail',array(
            "order"=>ProjectOrderModel::model()->findByPk($order_id),
            "service_lists"=>$service_lists["lists"],
            "agent_lists"=>$agent_lists["lists"],
            "agent_username" => $agent_lists['username'],
            "service_username" => $service_lists['username'],
        ));
        $html  = ob_get_contents();
        ob_clean();
        die(Utils::jsonResult(200,'',array('html'=>$html)));

    }
    //流程状态更新
    public function actionUpdateFlowStatus(){
       // $uid=Yii::app()->user->id;
        $order_id=$_POST['order_id'];
        $to_status=$_POST['to_status'];
        $type=$_POST['type'];

        $updateFlowStatus=ProjectOrderModel::updateFlowStatus($order_id, $to_status, 0,$type);
        if($updateFlowStatus){
            echo CJSON::encode($updateFlowStatus);
        }else{
            echo CJSON::encode($updateFlowStatus);
        }
    }
    /**
     * 服务协议
     * @throws CException
     */
    public function actionOrderContract()
    {
        $order_id = (int)Yii::app()->request->getParam('order_id');
        $contract = ProjectOrderContractModel::model()->find("order_id=:order_id",array(":order_id"=>$order_id));
        $html = "";
        ob_start();
        $this->renderPartial('order_contract',array(
            "info"=>$contract,
        ));
        $html  = ob_get_contents();
        ob_clean();
        die(Utils::jsonResult(200,'',array('html'=>$html)));
    }

    /**
     * 三方确认 --开发中---
     * 缺少站内信
     */
    public function actionOrderLogUpdate()
    {
        $order_id = (int)Yii::app()->request->getParam('order_id');
        $project_id = (int)Yii::app()->request->getParam('project_id');
        $find = ProjectOrderLogModel::model()->find("uid=0 and order_id=:order_id and from_flow_status=:f_status",
            array(":order_id"=>$order_id,
                ":f_status" => ProjectOrderModel::FLOW_STATUS_SERVICE_SIGNED,
                )
        );
        if($find == Null)
        {
            $log = new ProjectOrderLogModel();
            $log->uid = 0;
            $log->username = "system";
            $log->from_flow_status = ProjectOrderModel::FLOW_STATUS_SERVICE_SIGNED;
            $log->to_flow_status = ProjectOrderModel::FLOW_STATUS_SERVICE_PAYMENT;
            $log->created_at = time();
            if($log->save())
            {
                /*$order = ProjectOrderModel::model()->findByPk($order_id);
                $send_type = NotifyModel::SEND_TYPE_ORDER_USER_PAYMENT;
                if($order->agent_uid)
                {
                    $name = UserProfileModel::getUsername($order->agent_uid);
                    NotifyModel::send($send_type, array($name),$order->agent_uid, 0, 'system', true);
                }
                if($order->service_uid){
                    $name = UserProfileModel::getUsername($order->service_uid);
                    NotifyModel::send($send_type, array($name),$order->service_uid, 0, 'system', true);
                }*/

                ProjectOrderModel::model()->updateAll(array("status"=>ProjectOrderModel::STATUS_FAILED),
                    "project_id=:project_id and order_id!=:order_id",
                    array(":project_id"=>$project_id,":order_id"=>$order_id)
                    );
            }
        }
    }

}