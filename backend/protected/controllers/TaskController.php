<?php

class TaskController extends LoginedController
{
	public function actionTaskList()
	{
		if($_POST){
			$product=array();
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$projectId=Yii::app()->request->getParam('projectId');
			$title=Yii::app()->request->getParam('title');

			$page=$start / $pageSize;

			$criteria=new CDbCriteria;
			$criteria->with = array("project");
			if($title){
				$criteria->addSearchCondition('project.title',$title);
			}
			if($projectId){
				$criteria->addSearchCondition('project.projectId',$projectId);
			}
			//$criteria->select='t.id,project.id,project.title,project.projectId,project.area';
			$criteria->group = "t.project_id";
			$countCriteria = $criteria;
			$dataProvider=new CActiveDataProvider('ProjectTaskModel',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>$pageSize,
							'currentPage'=>$page,
					),
			));
			$products=$dataProvider->getData();
			foreach ($products as $p) {
				$product[] = array(
						'<a target="_blank" href="' . $this->createUrl("entrustProject/detail/id/{$p->project_id}") . '" >'.$p->project->title.'</a>',
						$p->project->projectId,
						$p->project->area,
						ProjectTaskModel::model()->count("`project_id` =".$p->project_id." and `type`=".ProjectTaskModel::TYPE_SERVICE),
						ProjectTaskModel::model()->count("`project_id` =".$p->project_id." and `type`=".ProjectTaskModel::TYPE_AGENT),
						'<a href="' . $this->createUrl("Task/taskInfo/type/1/projectid/{$p->project_id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>律师详情</a>'.
						'<a href="' . $this->createUrl("Task/taskInfo/type/2/projectid/{$p->project_id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>中介详情</a>'
				);
			}
			$recordsFiltered = $total = (int)ProjectTaskModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else {
			$this->render('TaskList');
		}
	}
	public function actionTaskInfo($projectid,$type){
		if($_POST){
			$product=array();
			$projectid = Yii::app()->request->getParam('projectid',10);
			$type = Yii::app()->request->getParam('type',10);
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$page=$start / $pageSize;
			$criteria=new CDbCriteria;
			$criteria->with = array("user");
			$criteria->addColumnCondition(array('t.project_id' =>$projectid));
			$criteria->addColumnCondition(array('t.type' =>$type));
			$countCriteria = $criteria;
			$dataProvider=new CActiveDataProvider('ProjectTaskModel',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>$pageSize,
							'currentPage'=>$page,
					),
			));
			$products=$dataProvider->getData();
			foreach ($products as $p) {
				$product[] = array(
						'<a target="_blank" href="' . $this->createUrl("users/Info/id/{$p->uid}") . '">'.Utils::decrypt($p->user->identity_name).'</a>',
						ProjectTaskModel::model()->count("`uid` =".$p->uid." and `status`=".ProjectTaskModel::STATUS_ACCEPTED),
						$p->status==1?"接单":"未接单"
				);
			}
			$recordsFiltered = $total = (int)ProjectTaskModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else {
			$this->render('taskInfo',array("projectid"=>$projectid,"type"=>$type));
		}
	}
}