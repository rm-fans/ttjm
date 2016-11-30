<?php

class CustomerController extends LoginedController
{
	//客服客户列表
	public function actionLineList()
	{
		if($_POST){
			$product=array();
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$projectId=Yii::app()->request->getParam('projectId');
			$page=$start / $pageSize;

			$criteria=new CDbCriteria;
			$criteria->with = array("project");
			if($projectId){
				$criteria->addSearchCondition('t.projectId',$projectId);
			}
			$criteria->addColumnCondition(array('state' => ProjectUserRecordModel::STATE_CUSTOMER_CONTACT));

			$criteria->addNotInCondition('project.status',array(ProjectModel::STATUS_TRADE_SUCCESS));
			$criteria->order="t.id desc";
			$countCriteria = $criteria;

			$dataProvider=new CActiveDataProvider('ProjectUserRecordModel',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>$pageSize,
							'currentPage'=>$page,
					),
			));

			$products=$dataProvider->getData();

			foreach ($products as $p) {
                switch($p->type){
					case ProjectUserRecordModel::STATE_CUSTOMER_CONTACT:
						$type = '客服联系';
						break;
					case ProjectUserRecordModel::STATE_CONTACTING:
						$type = '接触中';
						break;
					case ProjectUserRecordModel::STATE_CONTACT_FAILURE:
						$type = '接触失败';
						break;
					case ProjectUserRecordModel::STATE_DEAL:
						$type = '成交';
						break;
                }
				if($p->c_interviewed_at!=0)$p->c_interviewed_at=date("Y/m/d", $p->c_interviewed_at);
				$product[] = array(
						date("Y/m/d", $p->created_at),
						$p->projectId,
						$p->name,
						Utils::decrypt($p->phone),
                        $type,
						$p->c_interviewer_count,
						$p->c_interviewer_username,
						$p->c_interviewed_at,
						'<a href="' . $this->createUrl("customer/info/id/{$p->id}") . '" class="btn btn-xs green default">详情</a>'.
						'<a href="' . $this->createUrl("customer/updataRecord/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
				);
			}
			$recordsFiltered = $total = (int)ProjectUserRecordModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else {
			$this->render('lineList');
		}
	}
	//销售客户列表
	public function actionSaleList()
	{
		if($_POST){
			$product=array();
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$projectId=Yii::app()->request->getParam('projectId');
			$page=$start / $pageSize;

			$criteria=new CDbCriteria;
			$criteria->with = array("project");
			if($projectId){
				$criteria->addSearchCondition('t.projectId',$projectId);
			}
			$criteria->addNotInCondition('project.status',array(ProjectModel::STATUS_TRADE_SUCCESS));
			$criteria->addInCondition('state',array(ProjectUserRecordModel::STATE_CUSTOMER_CONTACT,ProjectUserRecordModel::STATE_CONTACTING,ProjectUserRecordModel::STATE_CONTACT_FAILURE));
			$criteria->order="t.id desc";
			$countCriteria = $criteria;

			$dataProvider=new CActiveDataProvider('ProjectUserRecordModel',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>$pageSize,
							'currentPage'=>$page,
					),
			));

			$products=$dataProvider->getData();
			foreach ($products as $p) {
				if($p->c_interviewed_at!=0)$p->c_interviewed_at=date("Y/m/d", $p->c_interviewed_at);
				switch ($p->state)
				{
					case ProjectUserRecordModel::STATE_CUSTOMER_CONTACT:
						$p->state='客服联系';
						$interviewer_count = $p->c_interviewer_count;
						$interviewer_username = $p->c_interviewer_username;
						$interviewed_at = $p->c_interviewed_at;
						break;
					case ProjectUserRecordModel::STATE_CONTACTING:
						$p->state='接触中';
						break;
					case ProjectUserRecordModel::STATE_CONTACT_FAILURE:
						$p->state='接触失败';
						break;
				}
				if($p->state!=ProjectUserRecordModel::STATE_CUSTOMER_CONTACT){
					$interviewer_count = $p->s_interviewer_count;
					$interviewer_username = $p->s_interviewer_username;
					$interviewed_at = $p->s_interviewed_at;
				}
				if($interviewed_at!=0)$interviewed_at = date("Y/m/d", $interviewed_at);
				$product[] = array(
						$p->projectId,
						$p->is_seller_interviewer?"是":"否",
						$p->name,
						Utils::decrypt($p->phone),
						$interviewer_count,
						$interviewer_username,
						$interviewed_at,
						$p->state,
						'<a href="' . $this->createUrl("customer/info/id/{$p->id}") . '" class="btn btn-xs green default">详情</a>'.
						'<a href="' . $this->createUrl("customer/updataRecord/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
				);
			}
			$recordsFiltered = $total = (int)ProjectUserRecordModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else {
			$this->render('saleList');
		}
	}
	//成交客户列表
	public function actionDealList()
	{
		if($_POST){
			$product=array();
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$projectId=Yii::app()->request->getParam('projectId');
			$page=$start / $pageSize;

			$criteria=new CDbCriteria;
			$criteria->with='project';
			if($projectId){
				$criteria->addSearchCondition('t.projectId',$projectId);
			}
			$criteria->addColumnCondition(array('state' =>ProjectUserRecordModel::STATE_DEAL));
			$criteria->order="t.id desc";
			$countCriteria = $criteria;

			$dataProvider=new CActiveDataProvider('ProjectUserRecordModel',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>$pageSize,
							'currentPage'=>$page,
					),
			));

			$products=$dataProvider->getData();
			foreach ($products as $p) {
				$product[] = array(
						$p->projectId,
						date("Y/m/d", $p->project->selled_at),
						$p->project->sell_price,
						$p->name,
						Utils::decrypt($p->phone),
						$p->s_interviewer_username,
						'<a href="' . $this->createUrl("customer/info/id/{$p->id}") . '" class="btn btn-xs green default">详情</a>'
				);
			}
			$recordsFiltered = $total = (int)ProjectUserRecordModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else {
			$this->render('dealList');
		}
	}
	//添加客户
	public function actionAddRecord($state)
	{
		$model = new ProjectUserRecordModel();
		if(isset($_POST['ProjectUserRecordModel'])){
			$model->attributes = $_POST['ProjectUserRecordModel'];
			$model->type = $_POST['type'];
			$model->created_at =time();
			$Project=ProjectModel::model()->find(array(
					'select'=>array('id','title','service_uid'),
					'condition' => 'projectId=:projectId',
					'params' => array(':projectId'=>$_POST['ProjectUserRecordModel']['projectId']),
			));
			if($Project===null){
				$this->showError('项目ID错误');
			}
			$model->project_id = $Project->id;
			$model->project_title = $Project->title;
			$model->service_uid = $Project->service_uid;
			$UserProfile=UserProfileModel::model()->find(array(
					'select'=>array('uid','username'),
					'condition' => 'phone=:phone',
					'params' => array(':phone'=>Utils::encrypt($_POST['ProjectUserRecordModel']['phone'])),
			));
			if($UserProfile!=null){
				$model->uid = $UserProfile->uid;
				$model->username = $UserProfile->username;
			}
			$model->phone = Utils::encrypt($_POST['ProjectUserRecordModel']['phone']);
			$record=ProjectUserRecordModel::model()->find(array(
					'select'=>array('id'),
					'condition' => 'projectId=:projectId and phone=:phone',
					'params' => array(':projectId'=>$_POST['ProjectUserRecordModel']['projectId'],':phone'=>Utils::encrypt($_POST['ProjectUserRecordModel']['phone'])),
			));
			if($record!=null){
				$this->showError('此客户已经添加');
			}
			if($model->save()){
				$this->redirect(array("customer/lineList"));
			}
		}
		$this->render('addRecord',array('model'=>$model,'state'=>$state));
	}
	//更新客户
	public function actionUpdataRecord($id)
	{
		$model = $this->RecordloadModel($id);
		if(isset($_POST['ProjectUserRecordModel'])){
			$model->attributes = $_POST['ProjectUserRecordModel'];
			$model->type = $_POST['type'];
			if(isset($_POST['ProjectUserRecordModel']['phone'])){
				$UserProfile=UserProfileModel::model()->find(array(
						'select'=>array('uid','username'),
						'condition' => 'phone=:phone',
						'params' => array(':phone'=>Utils::encrypt($_POST['ProjectUserRecordModel']['phone'])),
				));
				if($UserProfile!=null){
					$model->uid = $UserProfile->uid;
					$model->username = $UserProfile->username;
				}
				$model->phone = Utils::encrypt($_POST['ProjectUserRecordModel']['phone']);
				$record=ProjectUserRecordModel::model()->find(array(
						'select'=>array('id'),
						'condition' => 'projectId=:projectId and phone=:phone',
						'params' => array(':projectId'=>$model->projectId,':phone'=>Utils::encrypt($_POST['ProjectUserRecordModel']['phone'])),
				));
				if($record!=null){
					$this->showError('此客户已经添加');
				}
			}
			if($model->save()){
				if($model->state==ProjectUserRecordModel::STATE_CUSTOMER_CONTACT)
					$this->redirect(array("customer/lineList"));
				else
					$this->redirect(array("customer/saleList"));

			}
		}
		$model->phone = Utils::decrypt($model->phone);
		$this->render('updataRecord',array('model'=>$model,'state'=>$model->state));
	}
	//客户详情
	public function actionInfo($id){
		$model = $this->RecordloadModel($id);
		if($_POST){
			$product=array();
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$page=$start / $pageSize;

			$criteria=new CDbCriteria;
			$criteria->with='admin';
			if($model->state==ProjectUserRecordModel::STATE_CUSTOMER_CONTACT){
				$criteria->addColumnCondition(array('t.project_user_record_id' => $id,'type' => ProjectUserInterviewLogModel::TYPE_CUSTOMER));
			}elseif($model->state==ProjectUserRecordModel::STATE_DEAL){
				$criteria->addColumnCondition(array('t.project_user_record_id' => $id));
			}else{
				$criteria->addColumnCondition(array('t.project_user_record_id' => $id,'type' => ProjectUserInterviewLogModel::TYPE_SALESPERSON));
			}
			$criteria->order="t.id desc";
			$countCriteria = $criteria;

			$dataProvider=new CActiveDataProvider('ProjectUserInterviewLogModel',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>$pageSize,
							'currentPage'=>$page,
					),
			));
			$products=$dataProvider->getData();
			foreach ($products as $p) {
				$product[] = array(
						date("Y/m/d H:i:s", $p->interviewed_at),
						$p->desc,
						date("Y/m/d H:i:s", $p->created_at),
						$p->admin->username
				);
			}
			$recordsFiltered = $total = (int)ProjectUserInterviewLogModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else {
			$model->phone = Utils::decrypt($model->phone);
			if ($model->c_interviewed_at != 0) $model->c_interviewed_at = date("Y/m/d H:i:s", $model->c_interviewed_at);
			if ($model->s_interviewed_at != 0) $model->s_interviewed_at = date("Y/m/d H:i:s", $model->s_interviewed_at);
			if($model->project_id!=''){
				$project = $this->ProjectloadModel($model->project_id);
				if ($project->selled_at != 0) $project->selled_at = date("Y/m/d H:i:s", $project->selled_at);
//            if($model->type==1){
//
//            }elseif($model->type==2){
//
//            }
				$this->render('info', array('model' => $model,'project'=>$project));
			}else{
				$this->render('info', array('model' => $model));
			}

		}
	}
	//客服联系记录
	public function actionLineInfo($id){
		$model = $this->RecordloadModel($id);
		if($_POST){

			$product=array();
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$page=$start / $pageSize;

			$criteria=new CDbCriteria;
			$criteria->with='admin';
			$criteria->addColumnCondition(array('t.project_user_record_id' => $id,'type' => ProjectUserInterviewLogModel::TYPE_CUSTOMER));
			$criteria->order="t.id desc";
			$countCriteria = $criteria;

			$dataProvider=new CActiveDataProvider('ProjectUserInterviewLogModel',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>$pageSize,
							'currentPage'=>$page,
					),
			));

			$products=$dataProvider->getData();
			foreach ($products as $p) {
				$product[] = array(
						date("Y/m/d H:i:s", $p->interviewed_at),
						$p->desc,
						date("Y/m/d H:i:s", $p->created_at),
						$p->admin->username
				);
			}
			$recordsFiltered = $total = (int)ProjectUserInterviewLogModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else {
			$this->render('lineInfo', array('model' => $model));
		}
	}
	//添加联系记录
	public function actionAddInterview($id)
	{

		$Record = $this->RecordloadModel($id);
		$model = new ProjectUserInterviewLogModel();
		if(isset($_POST['ProjectUserInterviewLogModel'])){
			$model->attributes = $_POST['ProjectUserInterviewLogModel'];
			$admin=AdminModel::model()->find(array(
					'select'=>array('id,username'),
					'condition' => 'id=:id',
					'params' => array(':id'=>Yii::app()->user->id),
			));
			$RecordUpdata = array();
			if($Record->state==ProjectUserRecordModel::STATE_CUSTOMER_CONTACT){
				$model->type=ProjectUserInterviewLogModel::TYPE_CUSTOMER;
				$RecordUpdata['c_interviewer_count'] = $Record->c_interviewer_count+1;
				$RecordUpdata['c_interviewer_username'] = $admin->username;
				$RecordUpdata['c_interviewed_at'] = time();
			}else{
				$model->type=ProjectUserInterviewLogModel::TYPE_SALESPERSON;
				$RecordUpdata['s_interviewer_count'] = $Record->s_interviewer_count+1;
				$RecordUpdata['s_interviewer_username'] = $admin->username;
				$RecordUpdata['s_interviewed_at'] = time();
			}
			$Record->attributes = $RecordUpdata;
			$Record->save();
			$model->project_user_record_id = $id;
			$model->admin_uid = Yii::app()->user->id;
			//$model->admin_username = Yii::app()->user->id;
			$model->interviewed_at = strtotime($_POST['ProjectUserInterviewLogModel']['interviewed_at']);
			$model->created_at = time();
			if($model->save()){
				$this->redirect(array("customer/Info/id/".$id));
			}
		}
		$this->render('addInterview',array('model'=>$model));
	}
	//更新状态
	public function actionUpdataState($id){
		$model = $this->RecordloadModel($id);
		$list = false;
		if($model->state==ProjectUserRecordModel::STATE_CUSTOMER_CONTACT){
			$list = true;
			$model->state=ProjectUserRecordModel::STATE_CONTACTING;
			$model->is_seller_interviewer=ProjectUserRecordModel::STATE_CUSTOMER_CONTACT;
		}elseif($model->state==ProjectUserRecordModel::STATE_CONTACTING){
			$model->state=ProjectUserRecordModel::STATE_CONTACT_FAILURE;
		}elseif($model->state==ProjectUserRecordModel::STATE_CONTACT_FAILURE){
			$model->state=ProjectUserRecordModel::STATE_CONTACTING;
		}
		if($model->save()){
			if($list)
				$this->redirect(array("customer/lineList"));
			else
				$this->redirect(array("customer/info/id/".$id));
		}

	}
	//添加成交信息
	public function actionDeal($id)
	{
		$Record = $this->RecordloadModel($id);
		$model = $this->ProjectloadModel($Record->project_id);
		if($model->status == ProjectModel::STATUS_TRADE_SUCCESS){
			$RecordUpdata['state'] = ProjectUserRecordModel::STATE_CONTACT_FAILURE;
			$Record->attributes = $RecordUpdata;
			$Record->save();
			$this->showError('该资产已被其他客户成交，状态变更为接触失败');
		}
		if(isset($_POST['ProjectModel'])){
			$RecordUpdata['state'] = ProjectUserRecordModel::STATE_DEAL;
			$Record->attributes = $RecordUpdata;
			if($Record->save()) {
				$data = $_POST['ProjectModel'];
				$selled_at = $data['selled_at'];
				$data['selled_at'] = strtotime("$selled_at");
				$model->attributes = $data;
				$model->status = ProjectModel::STATUS_TRADE_SUCCESS;
				if ($model->save()) {
					$projectBuy = new UserProjectBuyModel();
					$projectBuy->uid = $Record->uid;
					$projectBuy->project_id = $model->id;
					$projectBuy->created_at = strtotime($_POST['ProjectModel']['selled_at']);
					$projectBuy->service_uid = $model->service_uid;
					UserServiceDetailModel::updatatimes($model->service_uid);
					if ($projectBuy->save()) {
						$this->redirect(array("customer/Info/id/" . $id));
					}
				}
			}
		}
		$this->render('deal',array('model'=>$model));
	}

	public function RecordloadModel($id)
	{
		$model=ProjectUserRecordModel::model()->findByPk($id);
		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
	public function ProjectloadModel($id)
	{
		$model=ProjectModel::model()->findByPk($id);
		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

}