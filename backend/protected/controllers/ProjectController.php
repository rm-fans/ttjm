<?php
/**
 * 非委托资产
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/19
 * Time: 10:01
 */
class ProjectController extends LoginedController
{
    public   $status_buttons;

    //非委托资产 - 待审核
    public function actionAudit()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $projectId = Yii::app()->request->getParam('projectId');
            $title = Yii::app()->request->getParam('title');
            $status = Yii::app()->request->getParam('status');
            $grab_from = Yii::app()->request->getParam('grab_from');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            if($projectId)
            {
                $criteria->addCondition("projectId=:projectId");
                $criteria->params[":projectId"] = $projectId;
            }
            if($title)
            {
                $criteria->addCondition("title=:title");
                $criteria->params[":title"] = $title;
            }
            if($grab_from)
            {
                $criteria->addCondition("grab_from=:grab_from");
                $criteria->params[":grab_from"] = $grab_from;
            }
            if($status)
            {
                $criteria->addCondition("status=".$status);
            }else{
                $criteria->addCondition("status <= 1");
            }
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                
                case 3:
                    $criteria->order="t.status ".$order[0]['dir'];
                    break;
                default:
                    $criteria->order="t.projectId desc ";
                    break;
            }
            $criteria->addCondition("type = ".ProjectModel::PROJECT_TYPE_NOT_ENTRUST);
            $criteria->order = "id desc";
            $dataProvider=new CActiveDataProvider('ProjectModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                )) );
            $products=$dataProvider->getData();
            foreach ($products as $p) {
                $updateButton = '<a href="'.$this->createUrl("project/detail/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $product[] = array(
                    $p['projectId'],
                    $p['title'],
                    empty($p['uid']) ? "抓取":"自取",
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
    //非委托资产 - 发布中
    public function actionRelease()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $title = Yii::app()->request->getParam('title');
            $projectId = Yii::app()->request->getParam('projectId');
            $grab_from = Yii::app()->request->getParam('grab_from');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            if($projectId){
                $criteria->addCondition("projectId =:projectId");
                $criteria->params[":projectId"] = $projectId;
            }
            if($title)
            {
                $criteria->addCondition("title=:title");
                $criteria->params[":title"] = $title;
            }
            if($grab_from)
            {
                $criteria->addCondition("grab_from = '".$grab_from."'");
            }
            $criteria->addInCondition("status",array(ProjectModel::STATUS_SUCCESS));
            $criteria->addCondition('type = '.ProjectModel::PROJECT_TYPE_NOT_ENTRUST);
            $criteria->order = "release_at desc";
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="t.status ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.market_price ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="t.price ".$order[0]['dir'];
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
                $url = "project/updateStatus/id/{$p->id}";
                $updateButton = '<a href="javascript:void(0)" class="btn btn-xs default btn-editable pro_shelf" onclick="proShelf('.$p->id.')"><i class="fa fa-pencil"></i>下架</a>';
                $updateButton .= '<a href="'.$this->createUrl("project/detail/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $updateButton .= '<a href="'.$this->createUrl("entrustProject/progress/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>资产进度</a>';
                $product[] = array(
                    $p['projectId'],
                    '<a href="'.$p['origin_url'].'" target="_blank">'.$p['title'].'</a>',
                    empty($p['uid']) ? "抓取":"自主",

                    $p['market_price'],
                    $p['price'],
                    ProjectModel::$status_types[$p['status']],
                    $updateButton
                );
            }
            $recordsFiltered=$total = (int)ProjectModel::model()->count($criteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, ));
            exit;
        }
        $result = array();
        $this->render('release',array('result'=>$result));
    }
    public function actionFailure()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $title = Yii::app()->request->getParam('title');
            $status = Yii::app()->request->getParam('status');
            $projectId = Yii::app()->request->getParam('projectId');
            $id = Yii::app()->request->getParam('id');
            $grab_from = Yii::app()->request->getParam('grab_from');
            $shelf_type = Yii::app()->request->getParam('shelf_type');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            if($id){
                $criteria->addCondition("id = '".$id."'");
            }
            if($projectId){
                $criteria->addCondition("projectId = '".$projectId."'");
            }
            if($title)
            {
                $criteria->addSearchCondition("title",$title);
            }
            if($grab_from){
                $criteria->addCondition("grab_from = '".$grab_from."'");
            }
            if($shelf_type)
            {
                $criteria->addCondition("shelf_type = '".$shelf_type."'");
            }
            $criteria->addCondition('t.status =:status ');
            $criteria->params[":status"] = ProjectModel::STATUS_SUCCESS;
            $criteria->addCondition('t.disposition_end_at>0 && t.disposition_end_at <'.time());
            $criteria->addCondition('type = '.ProjectModel::PROJECT_TYPE_NOT_ENTRUST);
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                
                case 4:
                    $criteria->order="t.status ".$order[0]['dir'];
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
                $url = "project/detail/id/{$p->id}";
                $updateButton = '<a href="'.$this->createUrl($url) . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $type_str = "资产已失效";
                $product[] = array(
                    $p['projectId'],
                    $p['title'],
                    $p['grab_from'],
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
        $this->render('shelf',array('result'=>$result,"action"=>"failure"));
    }
    public function actionSuccess()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $title = Yii::app()->request->getParam('title');
            $status = Yii::app()->request->getParam('status');
            $projectId = Yii::app()->request->getParam('projectId');
            $grab_from = Yii::app()->request->getParam('grab_from');
            $shelf_type = Yii::app()->request->getParam('shelf_type');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            if($projectId){
                $criteria->addCondition("projectId = '".$projectId."'");
            }
            if($title)
            {
                $criteria->addSearchCondition("title",$title);
            }
            if($grab_from){
                $criteria->addCondition("grab_from = '".$grab_from."'");
            }
            if($shelf_type)
            {
                $criteria->addCondition("shelf_type = '".$shelf_type."'");
            }
            $criteria->addCondition('t.status =:status ');
            $criteria->params[":status"] = ProjectModel::STATUS_TRADE_SUCCESS;
            $criteria->addCondition('type = '.ProjectModel::PROJECT_TYPE_NOT_ENTRUST);
            $criteria->order = "release_at desc";
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                
                case 4:
                    $criteria->order="t.status ".$order[0]['dir'];
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
                $url = "project/detail/id/{$p->id}";
                $updateButton = '<a href="'.$this->createUrl($url) . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                 $type_str = "资产成交";
                $product[] = array(
                    $p['projectId'],
                    $p['title'],
                    $p['grab_from'],
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
        $this->render('shelf',array('result'=>$result,"action"=>"success"));
    }
    //非委托资产 - 已下架
    public function actionShelf()
    {
        if($_POST){
            $product=array();
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $title = Yii::app()->request->getParam('title');
            $status = Yii::app()->request->getParam('status');
            $projectId = Yii::app()->request->getParam('projectId');
            $grab_from = Yii::app()->request->getParam('grab_from');
            $shelf_type = Yii::app()->request->getParam('shelf_type');
            $order = Yii::app()->request->getParam('order');
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            if($projectId){
                $criteria->addCondition("projectId = '".$projectId."'");
            }
            if($title)
            {
                $criteria->addSearchCondition("title",$title);
            }
            if($grab_from){
                $criteria->addCondition("grab_from = '".$grab_from."'");
            }
            if($shelf_type)
            {
                $criteria->addCondition("shelf_type = '".$shelf_type."'");
            }
            if($status)
            {
                $criteria->addCondition("status =".$status);
            }else{
                $criteria->addInCondition("status",array(ProjectModel::STATUS_SHELF));
            }
            $criteria->addCondition('type = '.ProjectModel::PROJECT_TYPE_NOT_ENTRUST);
            $criteria->order = "release_at desc";
            switch($order[0]['column']){
                case 0:
                    $criteria->order="t.projectId ".$order[0]['dir'];
                    break;
                case 1:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                
                case 4:
                    $criteria->order="t.status ".$order[0]['dir'];
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
                $url = "project/detail/id/{$p->id}";
                $updateButton = '<a href="'.$this->createUrl($url) . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                if($p['status'] == ProjectModel::STATUS_SHELF)
                    $type_str = $p['shelf_type']==ProjectModel::SHELF_TYPE_USER ? "用户下架":"平台下架";
                else
                    $type_str = "资产成交";
                $product[] = array(
                    $p['projectId'],
                    $p['title'],
                    $p['grab_from'],
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
        $this->render('shelf',array('result'=>$result,"action"=>"shelf"));
    }

    //非委托资产 - 详情
    public function actionDetail($id)
    {
        $from = Yii::app()->request->getParam('from');
        $info = ProjectModel::model()->findByPk($id);
        //$model=$this->loadModel($id);
        if($info['uid'] == 0){
            $model=new AdminProjectFrom();
        }else{
            $model=new AdminProjectFrom('pub');
        }
        $model->id = $id;
        $model->detail();
        if($from == 'tranFailed'){
            $this->status_buttons = array(
                ProjectModel::STATUS_TRANSFER_ENTRUST => "转委托提交",
                $model->status => "保存修改",
                ProjectModel::STATUS_SUBMIT => "提交审核"
            );
        }

        if(isset($_POST['AdminProjectFrom'])) {
            $form = $_POST['AdminProjectFrom'];

            $model->attributes = $form;
            $model->admin_id = Yii::app()->user->id;
            $model->admin_name = Yii::app()->user->name;
            $model->release_at = isset($form['release_at']) && $form['release_at'] !='' ? strtotime($form['release_at']) :time();
            $model->disposition_end_at = isset($form['disposition_end_at']) && $form['disposition_end_at'] !='' ? strtotime($form['disposition_end_at']) :"";
            $model->tag_type = !empty($form['tag_type']) ? implode(',',$form['tag_type']) : '';
            $model->ownership_type = !empty($form['ownership_type']) ? implode(',',$form['ownership_type']) : '';
            $model->add_services = !empty($form['add_services']) ? implode(',',$form['add_services']) : '';
            $model->is_arrears = 0;
            $model->is_lease = 0;
            if($model->validate())
            {
                $model->status = $form['status'];
                if($model->status == ProjectModel::STATUS_SHELF){
                    $model->shelf_type = ProjectModel::SHELF_TYPE_PLATFORM;
                }else{
                    $model->shelf_type = 0 ;
                }

                if($model->province_id && $model->city_id && $model->district_id){

                    $model->area = ProjectModel::areaName($model->province_id,$model->city_id,$model->district_id);
                }

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
                        $this->showSuccess('编辑成功', $this->createUrl('project/release'));
                    }elseif($form['status']==ProjectModel::STATUS_SHELF){
                        $this->showSuccess('编辑成功', $this->createUrl('project/shelf'));
                    }elseif($form['status']==ProjectModel::STATUS_TRANSFER_ENTRUST){
                        $this->showSuccess('编辑成功', $this->createUrl('entrustProject/transfer'));
                    }elseif($form['status']==ProjectModel::STATUS_TRANSFER_FAILED){
                        $this->showSuccess('编辑成功', $this->createUrl('entrustProject/transferFailed'));
                    }
                    else{
                        $this->showSuccess('编辑成功', $this->createUrl('project/audit'));
                    }
                }
            }
        }
        $images = ProjectAttachmentModel::model()->find("project_id=".$id);
        $user = UserProfileModel::model()->findByPk($model->uid);
        $check_logs = ProjectCheckLogModel::model()->findAll("project_id=".$id." order by id desc");
        $project_attachment = ProjectAttachmentModel::model()->findAll("project_id=".$id);
        $server_users = UserServiceDetailModel::serverUsers();
        $attachment = array();
        foreach($project_attachment as $obj)
        {
            $attachment[] = array("src"=>$obj['src']);
        }

        $result = array(
            'model'=> $model,
            'user' => $user,
            'project_attachment' => $attachment,
            'check_logs' => $check_logs,
            'images' => $images,
            'status_buttons' => $this->status_buttons,
            'server_users' => $server_users,
            'type' => 0,
        );

        $this->render('detail',array('result'=>$result));

    }
    public function loadModel($id)
    {
        $model=ProjectModel::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    //资产下架改变
    public function actionUpdateStatus()
    {
        $id = (int)Yii::app()->request->getParam('id');
        if($id){
            ProjectModel::model()->updateAll(array("status"=>ProjectModel::STATUS_SHELF,'shelf_type'=>ProjectModel::SHELF_TYPE_PLATFORM),"id=:id",array(":id"=>$id));
            ProjectCheckLogModel::add($id,'',ProjectModel::STATUS_SHELF);
            die(Utils::jsonResult(200));
        }
        die(Utils::jsonResult(400));
    }


}