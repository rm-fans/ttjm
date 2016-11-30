<?php

class SpiderApiController extends Controller
{
	public $chickIP = array('127.0.0.1','218.89.241.79');
	public function actionIndex()
	{

		if( !in_array($this->getIP(),$this->chickIP)){
			echo 'IP被拒绝';
			exit();
		}
		$data = $_POST['data'];
		$sgin = $_POST['sgin'];
		if(md5($data.md5($data).md5('rzqstc'))!=$sgin){
			echo '数据校验失败';
			exit();
		}
		$data = json_decode($data,true);
		if(isset($data['addspider'])){
			$Project = ProjectModel::model()->find(array('condition' => "origin_url='".$data['addspider']['data_url']."'",));
			if($Project!=""){
				if($Project->area == $data['addspider']['area'] && $Project->district_id == $data['addspider']['district_id']
					&& $Project->title == $data['addspider']['title'] && $Project->release_at == $data['addspider']['show_at']
					&& $Project->market_price == $data['addspider']['reference_price'] && $Project->price == $data['addspider']['evaluation_price']
					&& $Project->floor_area == $data['addspider']['building_area']&& $Project->grab_from_type==$data['channel']['channel_name'])
				{
					echo 3;exit();
				}
				if($data['addspider']['reference_price']=='' && $data['addspider']['evaluation_price']=='' && $data['addspider']['title']=='')
				{
					echo 3;exit();
				}
			}
			$model = new ProjectModel();
			$deadline_at = $data['addspider']['deadline_at'];
			if($deadline_at=="")$deadline_at=0;
			//$is_grab_enabled = $data['addspider']['status'] == '已过期' ? 0 : 1;
			if($Project==''){
				$model->title=$data['addspider']['title'];
				$model->release_at=$data['addspider']['show_at'];
				$model->area=$data['addspider']['area'];
				$model->province_id=$data['addspider']['province_id'];
				$model->city_id=$data['addspider']['city_id'];
				$model->district_id=$data['addspider']['district_id'];
				$model->market_price=$data['addspider']['evaluation_price'];
				$model->price=$data['addspider']['reference_price'];
				$model->floor_area=$data['addspider']['building_area'];
				$model->image=$data['channel']['image'];
				$model->grab_from=$data['channel']['channel_name'];
				$model->grab_from_type=$data['channel']['type'];
				$model->origin_url = $data['addspider']['data_url'];
				$model->created_at=time();
				$model->disposition_end_at=$deadline_at;
				$model->asset_attributes_id=1;
				//$model->category_id=1;
				$buy_method = ProjectBuyMethodModel::model()->find('name=:name',array(':name'=>$data['addspider']['purchase_way']));
				if($buy_method)
					$model->buy_method_id=$buy_method->id;
				else
					$model->buy_method_id=2;
				//$service = UserProfileModel::getProjectServiceUser($model->city_id);
				//$model->service_uid = $service->uid;
				$model->status = ProjectModel::STATUS_SUCCESS;
				$model->save();
				ProjectModel::setProjectId($model->id);
				echo 1;
			}else{
				$model = $Project;
				$model->title=$data['addspider']['title'];
				$model->release_at=$data['addspider']['show_at'];
				$model->area=$data['addspider']['area'];
				
				$model->disposition_end_at=$deadline_at;
				$model->province_id=$data['addspider']['province_id'];
				$model->city_id=$data['addspider']['city_id'];
				$model->district_id=$data['addspider']['district_id'];
				$model->market_price=$data['addspider']['reference_price'];
				$model->price=$data['addspider']['evaluation_price'];
				$model->floor_area=$data['addspider']['building_area'];
				$model->origin_url = $data['addspider']['data_url'];
				$model->grab_from_type=$data['channel']['type'];
				$model->status = ProjectModel::STATUS_SUCCESS;
				$buy_method = ProjectBuyMethodModel::model()->find('name=:name',array(':name'=>$data['addspider']['purchase_way']));
				if($buy_method)
					$model->buy_method_id=$buy_method->id;
				else
					$model->buy_method_id=2;
				$model->save();
				echo 2;
			}

		}
	}
	private function getIP()
	{
		global $ip;

		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else
			$ip = "Unknow";

		return $ip;
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