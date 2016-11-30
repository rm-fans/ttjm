<?php

class NoodlesController extends LoginedController
{
	//用户列表
	public function actionIndex()
	{
		if($_POST){
			$product=array();
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$name=Yii::app()->request->getParam('name');
			$order=Yii::app()->request->getParam('order');
			$noodtype = Yii::app()->request->getParam('noodtype');
			$noodprice = Yii::app()->request->getParam('noodprice');
			$nooddetail = Yii::app()->request->getParam('nooddetail');
			$page=$start / $pageSize;
			$criteria=new CDbCriteria;
			if($name){
				$criteria->addSearchCondition('t.name',$name);
			}
			if($nooddetail){
				$criteria->addSearchCondition('t.nooddetail',$nooddetail);
			}
			switch($noodtype){
				case '--未选择':
					break;
				case '干馏系列':
					$criteria->addSearchCondition('t.is_service',1);break;
				case '汤面系列':
					$criteria->addSearchCondition('t.is_agent',1);break;
				case '抄手系列':
					$criteria->addSearchCondition('t.is_broker',1);break;
				case '精品小吃':
					$criteria->addSearchCondition('t.is_broker',1);break;
			}
			if($noodprice) {
				$criteria->addColumnCondition(array('t.noodprice'=>$noodprice));
			}
			switch($order[0]['column']){
				case 1:
					$criteria->order="t.name ".$order[0]['dir'];
					break;
				case 2:
					$criteria->order="t.noodtype ".$order[0]['dir'];
					break;
				case 3:
					$criteria->order="t.noodprice ".$order[0]['dir'];
					break;
				case 4:
					$criteria->order="t.noodprice ".$order[0]['dir'];
					break;
				case 5:
					$criteria->order="t.nooddetail ".$order[0]['dir'];
					break;
			}
			$criteria->select='id,name,noodtype,noodprice,noodprice,nooddetail';
			//$criteria->addColumnCondition(array('is_service' => 0,'is_broker'=>0));
			$countCriteria = $criteria;
			$dataProvider=new CActiveDataProvider('NoodlesModel',array(
					'criteria'=>$criteria,
					'pagination'=>array(
							'pageSize'=>$pageSize,
							'currentPage'=>$page,
					),
			));
			$products=$dataProvider->getData();
			$i = $page*$pageSize;
			foreach ($products as $p) {
				$i++;
				$operate = '<a href="' . $this->createUrl("noodles/Info/id/{$p->id}") . '" class="btn btn-xs default btn-editable "><i class="fa fa-pencil"></i>详情</a>'.
						'<a href="' . $this->createUrl("noodles/Update/id/{$p->id}") . '" class="btn btn-xs default btn-editable red"><i class="fa fa-pencil">修改</i></a>';
				switch($p->noodtype){
					case 1:
						$typeName= '干馏系列';break;
					case 2:
						$typeName='汤面系列';break;
					case 3:
						$typeName='抄手系列';break;
					case 4:
						$typeName='精品小吃';break;
				}
				$product[] = array(
						$i,
						$p->name,
						$typeName,
						$p->noodprice,
						$p->nooddetail,
						$operate,
				);

			}
			$recordsFiltered = $total = (int)NoodlesModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else{
			$this->render('index');
		}
	}

	/**
	 * 增加菜品
	 */
	public function actionAdd(){
		$model=new NoodlesModel();
		if(isset($_POST['NoodlesModel'])){
          $data=$_POST['NoodlesModel'];
			$model->name=$data['name'];
			$model->noodtype=$data['noodtype'];
			$model->noodprice=$data['noodprice'];
			$model->nooddetail=$data['nooddetail'];
			if($model->validate() && $model->save()){
				$this->showSuccess('添加成功',$this->createUrl('noodles/index'));
			}else{
				$this->showError('添加失败');
			}
		}
		$result=array(
			'model'=>$model
		);
		$this->render('add',array('result'=>$result));
	}
	/**
	 * 修改菜品
	 */
	public function actionUpdate(){
		$id=$_GET['id'];
		$model=NoodlesModel::model()->findByPk($id);
		if(isset($_POST['NoodlesModel'])){
			$data=$_POST['NoodlesModel'];
			$nood['name']=$data['name'];
			$nood['noodtype']=$data['noodtype'];
			$nood['noodprice']=$data['noodprice'];
			$nood['nooddetail']=$data['nooddetail'];
			$model->attributes=$nood;
			if($model->validate() && $model->save()){
				$this->showSuccess('更新成功',$this->createUrl('noodles/index'));
			}else{
				$this->showError('更新失败');
			}
		}else{
			$result=array(
				'model'=>$model,
			);
			$this->render('update',array('result'=>$result));
		}
	}

	/**
	 * 详情
	 */

	public function actionInfo(){
		$id=$_GET['id'];
		$model=NoodlesModel::model()->findByPk($id);
		$this->render('info',array('model'=>$model));
	}



	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}