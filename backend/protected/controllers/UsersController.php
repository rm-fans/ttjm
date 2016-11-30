<?php

class UsersController extends LoginedController
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
					$criteria->order="t.username ".$order[0]['dir'];
					break;
				case 4:
					$criteria->order="t.is_broker ".$order[0]['dir'];
					break;
				case 5:
					$criteria->order="t.identity_name ".$order[0]['dir'];
					break;
				case 6:
					$criteria->order="t.status ".$order[0]['dir'];
					break;
			}
			if($phone){
				$criteria->addSearchCondition('t.phone',Utils::encrypt($phone));
			}
			if($nickname){
				$criteria->addSearchCondition('t.nickname',$nickname);
			}
			if($uid){
				$criteria->addSearchCondition('t.uid',$uid);
			}
			if($identity_name){
				$criteria->addSearchCondition('t.identity_name',Utils::encrypt($identity_name));
			}
			$criteria->select='uid,phone,username,identity_name,is_service,is_agent,is_broker,status';
			//$criteria->addColumnCondition(array('is_service' => 0,'is_broker'=>0));
			$countCriteria = $criteria;
			$dataProvider=new CActiveDataProvider('UserProfileModel',array(
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
				$operate = '<a href="' . $this->createUrl("users/Info/id/{$p->uid}") . '" class="btn btn-xs default btn-editable "><i class="fa fa-pencil"></i>详情</a>'.
						'<a href="' . $this->createUrl("users/Update/id/{$p->uid}") . '" class="btn btn-xs default btn-editable red"><i class="fa fa-pencil">修改</i></a>';
				$role='';
				if($p->status==1){
					$operate .= '<a href="' . $this->createUrl("users/Freeze/id/{$p->uid}") . '" class="btn btn-xs blue default btn-editable"><i class="fa fa-times">冻结</i></a>';
				}if($p->status==-1){
					$operate .= '<a href="' . $this->createUrl("users/NoFreeze/id/{$p->uid}") . '" class="btn btn-xs yellow default btn-editable"><i class="fa fa-times">解冻</i></a>';
				}
				if($p->is_service){
					$role='律师';
				}if($p->is_agent){
					$role='经纪人';
				}if($p->is_broker){
					$role='推荐人';
				}
				$product[] = array(
					$i,
					$p->uid,
					Utils::decrypt($p->phone),
					$p->username,
					$role,
					$p->identity_name?Utils::decrypt($p->identity_name):'',
					$p->status==1?'正常':'冻结',
					$operate,
				);

			}
			$recordsFiltered = $total = (int)UserProfileModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
		}else{
			$this->render('index');
		}
	}
	//冻结用户
	public function actionFreeze($id){
		$model = $this->UserProfileloadModel($id);
		$role=$this->RoleProfileloadModel($id);
		$model->status=-1;
		$role->status=-1;
		if($model->save() && $role->save()){
//			$this->showJsonResult(1);
			$this->showSuccess('冻结用户成功', $this->createUrl('users/index'));
		}else{
//			$this->showJsonResult(0);
			$this->error('冻结用户失败', $this->createUrl('users/index'));
		}
	}
	//解冻用户
	public function actionNoFreeze($id){
		$model = $this->UserProfileloadModel($id);
		$role=$this->RoleProfileloadModel($id);
		$model->status=1;
		$role->status=0;
		if($model->save() && $role->save()){
//			$this->showJsonResult(1);
			$this->showSuccess('解冻用户成功', $this->createUrl('users/index'));
		}else{
//			$this->showJsonResult(0);
			$this->error('解冻用户失败', $this->createUrl('users/index'));
		}
	}
	//添加用户
	public function actionAdd()
	{
		$model = new UserProfileModel();
		if (isset($_POST['UserProfileModel'])) {
			$data = $_POST['UserProfileModel'];
			$data['identity_name'] = Utils::encrypt($data['identity_name']);
			$data['identity_card'] = Utils::encrypt($data['identity_card']);
			$data['avatar'] = $_POST['image']['avatar'];
			if(!isset($data['province_id']) || $data['province_id']==''||!isset($data['city_id']) || $data['city_id']==''||!isset($data['district_id']) || $data['district_id']=='')$this->showError('请填写完整省市区信息');
			$obj1 = DistrictModel::model()->findByPk($data['province_id']);
			$obj2 = DistrictModel::model()->findByPk($data['city_id']);
			$obj3 = DistrictModel::model()->findByPk($data['district_id']);
			$data['area'] = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
			if(!isset($data['username']) || $data['username']=='')$this->showError('请填写用户名');
			if(!isset($data['phone']) || $data['phone']=='')$this->showError('请填写手机号码');
			if(!isset($_POST['password']) || $_POST['password']=='')$this->showError('密码不能为空');
			if(!isset($_POST['email']) || $_POST['email']=='')$this->showError('邮箱不能为空');
			$register = array(
				'phone'=>$data['phone'],
				'username'=>$data['username'],
				'password'=>$_POST['password'],
				'email'=>$_POST['email'],
			);
			$data['phone'] = Utils::encrypt($data['phone']);
			$model->attributes = $data;
			$uid = User::register($register);
			if($uid['code']=='1000'){
				$model->uid=$uid['data']['uid'];
				if($model->save()){
					$this->redirect(array("users/index"));
				}
			}else{
				$this->showError($uid['message'].$uid['code']);
			}
		}
		//地理位置
		$province = array();
		$district = new DistrictModel();
		$districts = DistrictModel::model()->findAll('level=1');
		foreach ($districts as $key => $dis) {
			$province[$dis->id] = $dis->name;
		}
		$result = array(
				'model' => $model,
				'district' => $district,
				'province' => $province,
				'industry'=>$this->industry(),
		);
		$this->render('add', array('result' => $result));
	}
	//用户更新
	public function actionUpdate($id){
		$model = $this->UserProfileloadModel($id);
		if (isset($_POST['UserProfileModel'])) {
			$data = $_POST['UserProfileModel'];
			$data['identity_name'] = Utils::encrypt($data['identity_name']);
			$data['identity_card'] = Utils::encrypt($data['identity_card']);
			$data['avatar'] = $_POST['image']['avatar'];
			if(!isset($data['province_id']) || $data['province_id']==''||!isset($data['city_id']) || $data['city_id']==''||!isset($data['district_id']) || $data['district_id']=='')$this->showError('请填写完整省市区信息');
			$obj1 = DistrictModel::model()->findByPk($data['province_id']);
			$obj2 = DistrictModel::model()->findByPk($data['city_id']);
			$obj3 = DistrictModel::model()->findByPk($data['district_id']);
			$data['area'] = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
			$model->attributes = $data;
			if($model->save()){
				$this->redirect(array("users/index"));
			}

		}
		//地理位置
		$province = array();
		$district = new DistrictModel();
		$districts = DistrictModel::model()->findAll('level=1');
		foreach ($districts as $key => $dis) {
			$province[$dis->id] = $dis->name;
		}
		$model->phone = Utils::decrypt($model->phone);
		$model->identity_name = Utils::decrypt($model->identity_name);
		$model->identity_card = Utils::decrypt($model->identity_card);
		$bank = UserBankModel::model()->find('uid=:uid', array(':uid' => $id));
		if($bank){
			$bank['bank_card']=Utils::decrypt($bank['bank_card']);
			$bank['bank_name']=Utils::decrypt($bank['bank_name']);
		}else{
			$bank=new UserBankModel();
		}
		$result = array(
				'model' => $model,
				'district' => $district,
				'province' => $province,
				'industry'=>$this->industry(),
				'bank'=>$bank,
		);
		$this->render('update', array('result' => $result));
	}
	//用户详情
	public function actionInfo($id){
		if($_POST){
			$product=array();
			$pageSize=Yii::app()->request->getParam('length',10);
			$start=Yii::app()->request->getParam('start');
			$page=$start / $pageSize;

			$criteria=new CDbCriteria;

			$criteria->addColumnCondition(array('uid' =>$id));
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
						'<a href="' . $this->createUrl("/entrustProject/detail/id/{$p->project_id}") . '">'.$p->project_title.'</a>',
						$p->type?"自己购买意愿":"介绍购买",
						Utils::decrypt($p->phone),
						$p->name,
						$p->desc,
						date("Y-m-d H:i", $p->created_at) ,
				);
			}
			$recordsFiltered = $total = (int)ProjectUserRecordModel::model()->count($countCriteria);
			echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
			exit();
		}else{
			$model = $this->UserProfileloadModel($id);
			//地理位置
			switch ($model->sex)
			{
				case 0:
					$model->sex='不限';
					break;
				case 1:
					$model->sex='男';
					break;
				case 2:
					$model->sex='女';
					break;
			}
			$industry = IndustryModel::model()->findByPk($model->industry_id);
			$model->phone = Utils::decrypt($model->phone);
			$model->identity_name = Utils::decrypt($model->identity_name);
			$model->identity_card = Utils::decrypt($model->identity_card);
			$model->address = $model->area.$model->address;
			$model->industry_id = $industry->name;
			$bank = UserBankModel::model()->find('uid=:uid', array(':uid' => $id));
			$this->render('info',  array('model' => $model,'bank'=>$bank));
		}
	}
	//删除用户
	/*public function actionDelete($id)
	{
		if($this->UserProfileloadModel($id)->delete()){
			UserProfileModel::model()->deleteAll('uid=:id',array(':id'=>$id));
			$this->showJsonResult(1);
		}else{
			$this->showJsonResult(0);
		}
	}*/
	public function actionLogin(){
		if($_POST){
			//登录
			$uid = User::login($_POST);
			if($uid['code']==1000){
				$data = $uid['data'];
				//刷新Token
				$token = User::refreshToken(array('refresh_token'=>$data['refresh_token']));
				//获取详情
				$info = User::getUserInfo(array('access_token'=>$token['data']['access_token'],'uid'=>$data['uid']));
				$this->render('login',array('uid'=>$uid,'token'=>$token,'info'=>$info));
			}else{
				$this->showError($uid['message']);
			}
		}else{
			$this->render('login');
		}
	}
	//行业数据
	public function industry()
	{
		$industry = IndustryModel::model()->findAll();
		$industries = array();
		$i = 1;
		foreach ($industry as $value) {
			$industries[$i] = $value['name'];
			$i++;
		}
		return $industries;
	}
	public function UserProfileloadModel($id)
	{
		$model=UserProfileModel::model()->find(array(
				'condition' => 'uid=:uid',
				'params' => array(':uid'=>$id),
		));
		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
	public function RoleProfileloadModel($id)
	{
		$agent=UserAgentDetailModel::model()->find(array(
				'condition' => 'uid=:uid',
				'params' => array(':uid'=>$id),
		));
		if($agent==null){
			$service=UserServiceDetailModel::model()->find(array(
					'condition' => 'uid=:uid',
					'params' => array(':uid'=>$id),
			));
			if($service){
				return $service;
			}else{
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}else{
			return $agent;
		}
	}

}