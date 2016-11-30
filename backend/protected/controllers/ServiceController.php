<?php

class ServiceController extends LoginedController
{
    /*
     *行业数据
     */
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

    /*
     *机构数据
     */
/*    public function organization()
    {
        $organiza = UserServiceOrganizationModel::model()->findAll();
        $organization = array('0' => '暂无机构');
        foreach ($organiza as $key => $value) {
            $organization[$value['id']] = $value['name'];
        }
        return $organization;
    }*/

    /*
     * 服务商详情
     */
    public function actionServiceInfo()
    {
        $id=$_GET['id'];
        $service_profile = UserProfileModel::model()->find('uid=:uid', array(':uid' => $id));
        $service_detail = UserServiceDetailModel::model()->findByPk($id);
        if (isset($org)) {
            $org_name = $org['name'];
        } else {
            $org_name = '无';
        }
        $industry = IndustryModel::model()->find('id=:id', array(':id' => $service_profile['industry_id']));
        $bank = UserBankModel::model()->find('uid=:uid', array(':uid' => $id));
        $service_profile->identity_name = Utils::decrypt($service_profile->identity_name);
        $service_profile->identity_card = Utils::decrypt($service_profile->identity_card);
        $this->render('service_info', array(
            'bank'=>$bank,
            'profile' => $service_profile,
            'org_name' => $org_name,
            'industry_name' => $industry['name'],
            'detail' => $service_detail,
        ));
    }

    //行业姓名
    public function industry_name($id)
    {
        $industry = IndustryModel::model()->find('id=:id', array(':id' => $id));
        if (isset($industry)) {
            return $industry->attributes['name'];
        }
    }

    /*
     * 服务商列表
     */
    public function actionIndex()
    {
        if ($_POST) {
            $service = array();
            //得到服务商的名称及是否为服有服务商机构
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $order = Yii::app()->request->getParam('order');

            $identity_name = Yii::app()->request->getParam('identity_name');
            $phone = Yii::app()->request->getParam('phone');
            $status = Yii::app()->request->getParam('status');
            $industry_name= Yii::app()->request->getParam('industry_id');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            switch($status){
                case '--未选择':
                    $status='';break;
                case '待认证':
                    $criteria->addColumnCondition(array('t.status'=>'0'));
                    $status='0';break;
                case '认证成功':
                    $status='1';break;
                case '认证失败':
                    $status='-1';break;
            }
            foreach($this->industry() as $key=>$name){
                if($industry_name==$name){
                    $criteria->addColumnCondition(array('t.industry_id'=>$key));
                }
            }
            if($status) {
                $criteria->addColumnCondition(array('t.status'=>$status));
            }
            if ($identity_name) {
                $criteria->addSearchCondition('user_profile.identity_name', Utils::encrypt($identity_name));
            }
            if ($phone) {
                $criteria->addSearchCondition('user_profile.phone', Utils::encrypt($phone));
            }
            switch($order[0]['column']){
                case 1:
                    $criteria->order="user_profile.identity_name ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="user_profile.phone ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.img_src ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="t.service_license_src ".$order[0]['dir'];
                    break;
                case 5:
                    $criteria->order="t.industry_id ".$order[0]['dir'];
                    break;
                case 6:
                    $criteria->order="t.status ".$order[0]['dir'];
                    break;
            }
            $criteria->with=array('user_profile');
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('UserServiceDetailModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $k => $p) {
                if (isset($p->user_profile['phone']))
                    $phone = Utils::decrypt($p->user_profile['phone']);
                else
                    $phone = '';
                if (isset($p->user_profile['identity_name']))
                    $identity_name = Utils::decrypt($p->user_profile['identity_name']);
                else
                    $identity_name = '';
                $industry_name = $this->industry_name($p->user_profile['industry_id']);
                $having = 0;
                $end = 0;
                $success = 0;
                $services_count = ProjectUserRecordModel::model()->findAll(array('condition' => 'service_uid=' . $p->user_profile['uid']));
                foreach ($services_count as $service_count) {
                    if ($service_count->state == ProjectUserRecordModel::STATE_CONTACTING) {
                        $having++;
                    }
                    if ($service_count->state == ProjectUserRecordModel::STATE_DEAL) {
                        $end++;
                    }
                    if ($service_count->state == ProjectUserRecordModel::STATE_DEAL) {
                        $success++;
                    }
                }
                //操作
                if ($p->status == -1) {
                    $operate = '<a href="' . $this->createUrl("service/success/id/{$p->uid}") . '" class="btn btn-xs default btn-editable blue"><i class="fa fa-pencil">认证</i></a>'.
                        '<a href="' . $this->createUrl("service/Update/id/{$p->uid}") . '" class="btn btn-xs default btn-editable yellow"><i class="fa fa-pencil">编辑</i></a>';
                }
                elseif ($p->status == 1) {
                $operate =
                    '<a href="' . $this->createUrl("service/ServiceInfo/id/{$p->uid}") . '" class="btn btn-xs default btn-editable red"><i class="fa fa-pencil">详情</i></a>'.
                    '<a href="' . $this->createUrl("service/Update/id/{$p->uid}") . '" class="btn btn-xs default btn-editable yellow"><i class="fa fa-pencil">编辑</i></a>';
//                    '<a rel="' . $this->createUrl("service/delete/id/{$p->uid}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i> 删除</a>';
                }
                if ($p->status== 0) {
                    $operate = '<a href="' . $this->createUrl("service/success/id/{$p->uid}") . '" class="btn btn-xs default btn-editable green"><i class="fa fa-pencil">确认认证</i></a>'.
                        '<a href="' . $this->createUrl("service/Update/id/{$p->uid}") . '" class="btn btn-xs default btn-editable yellow"><i class="fa fa-pencil">编辑</i></a>';
                }
                if($p->img_src) {
                    $work_log=$p->img_src;
                    $work_img = "<img src=' $work_log' style='width: 50px;height: 45px;'/>";
                    $work_img = "<a href=' $work_log' target='_blank'>$work_img</a>";
                }else $work_img='';
                if($p->service_license_src) {
                    $service_license_src = "<img src=' $p->service_license_src' style='width: 50px;height: 45px;'/>";
                    $service_license_src = "<a href=' $p->service_license_src' target='_blank'>$service_license_src</a>";
                }else $service_license_src='';

                //记录统计
                $service[] = array(
                    $p->user_profile['uid'],
                    $identity_name,
                    $phone,
                    $work_img,
                    $service_license_src,
                    $industry_name,
                    UserServiceDetailModel::status_name($p->status),
                    $having,
                    $end,
                    $success,
                    $operate,
                );
            }
            $recordsFiltered = $total = (int)UserServiceDetailModel::model()->count($countCriteria);
            echo json_encode(array('data' => $service, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('index');
        }
    }

    //方法服务商ID的验证
    public function ProfileModel($id)
    {
        $model = UserProfileModel::model()->find('uid=:uid', array(':uid' => $id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*
     * 添加服务商
     */
  public function actionCreate()
    {
        $model = new UserProfileModel();
        if (isset($_POST['UserProfileModel'])) {
            $profile = $model->attributes = $_POST['UserProfileModel'];
            $register = array(
                'phone' => $profile['phone'],
                'username' => $profile['phone'],
                'password' => rand(100000, 999999),
                'email' => '',
            );
            $uid = User::register($register);
            if ($uid['code'] == '1000') {
                $model->uid =  $uid['data']['uid'];
                $model->identity_card = Utils::encrypt($profile['identity_card']);
                $model->username = $uid['data']['username'];
                $model->phone = $uid['data']['phone'];
                $model->identity_name = Utils::encrypt($profile['identity_name']);
                $model->qq = $profile['qq'];
                $model->wechat = $profile['wechat'];
                $model->province_id = $profile['province_id'];
                $model->city_id = $profile['city_id'];
                $model->district_id = $profile['district_id'];
                $model->is_service = 0;
                $model->industry_id = $profile['industry_id'];
                $obj1 = DistrictModel::model()->findByPk($model->province_id);
                $obj2 = DistrictModel::model()->findByPk($model->city_id);
                $obj3 = DistrictModel::model()->findByPk($model->district_id);
                $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
                $model->area = $str;
                if (isset($_POST['address']))
                    $model->address = $model->area . $_POST['address'];
                else
                    $model->address = '';
                $detail = new UserServiceDetailModel();
                $detail->uid = $uid['data']['uid'];
                $detail->status=0;
                $detail->img_src = $_POST['image']['img_src'];
                $detail->service_license_src = $_POST['image']['license'];
                $detail->industry_id = $profile['industry_id'];
                if (isset($_POST['desc']))
                    $detail->desc = $_POST['desc'];
                else
                    $detail->desc = '';

                $oauth=new UserOauthModel();
                $oauth->uid=$uid['data']['uid'];
                $oauth->picture=$_POST['image']['img_src'];
                $oauth->identity_card=Utils::encrypt($profile['identity_card']);
                $oauth->identity_name=Utils::encrypt($profile['identity_name']);
                $oauth->lawyer_license_src=$_POST['image']['license'];
                $oauth->type=1;
                $oauth->status=0;
                $oauth->created_at=time();
                if ($model->validate() && $detail->validate() && $oauth->validate()) {
                    $oauth->save();
                    $detail->save();
                    $model->save();
                    $this->showSuccess('添加成功', $this->createUrl('service/index'));
                }
            }
            else{

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
        //头像
        $detail = new UserServiceDetailModel();
        $result = array(
            'model' => $model,
            'district' => $district,
            'province' => $province,
            'detail' => $detail,
            'display' => 'create',
            'industry' => $this->industry(),
        );
        $this->render('create', array('result' => $result));
    }

//    public function actionCreate()
//    {
//        $model = new UserProfileModel();
//        if (isset($_POST['UserProfileModel'])) {
//            $profile = $model->attributes = $_POST['UserProfileModel'];
//            $register = array(
//                'phone' => $profile['phone'],
//                'username' => $profile['phone'],
//                'password' => rand(100000, 999999),
//                'email' => '',
//            );
//            $uid = User::register($register);
//            if ($uid['code'] == '1000') {
//
//                $model->uid =  $uid['data']['uid'];
//                $model->identity_card = Utils::encrypt($profile['identity_card']);
//                $model->username = $uid['data']['username'];
//                $model->avatar = $_POST['image']['avatar'];
//                $model->phone = $uid['data']['phone'];
//                $model->identity_name = Utils::encrypt($profile['identity_name']);
//                $model->qq = $profile['qq'];
//                $model->wechat = $profile['wechat'];
//                $model->province_id = $profile['province_id'];
//                $model->city_id = $profile['city_id'];
//                $model->district_id = $profile['district_id'];
//                $model->is_service = 0;
//                $model->industry_id = $profile['industry_id'];
//                $obj1 = DistrictModel::model()->findByPk($model->province_id);
//                $obj2 = DistrictModel::model()->findByPk($model->city_id);
//                $obj3 = DistrictModel::model()->findByPk($model->district_id);
//                $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
//                $model->area = $str;
//                if (isset($_POST['address']))
//                    $model->address = $model->area . $_POST['address'];
//                else
//                    $model->address = '';
//                $detail = new UserServiceDetailModel();
//                $detail->uid = $uid['data']['uid'];
//                $detail->status=0;
//                $detail->img_src = $_POST['image']['avatar'];
//                $detail->service_license_src = $_POST['image']['license'];
//                $detail->industry_id = $profile['industry_id'];
//                if (isset($_POST['desc']))
//                    $detail->desc = $_POST['desc'];
//                else
//                    $detail->desc = '';
//                $oauth=new UserOauthModel();
//                $oauth->uid=$uid['data']['uid'];
//                $oauth->picture=$_POST['image']['avatar'];
//                $oauth->identity_card=Utils::encrypt($profile['identity_card']);
//                $oauth->identity_name=Utils::encrypt($profile['identity_name']);
//                $oauth->lawyer_license_src=$_POST['image']['license'];
//                $oauth->type=1;
//                $oauth->status=0;
//                $oauth->created_at=time();
//                if ($model->validate() && $detail->validate() && $oauth->validate()) {
//                    $oauth->save();
//                    $detail->save();
//                    $model->save();
//                    $this->showSuccess('添加成功', $this->createUrl('service/index'));
//                }
//            }
//            else{
//
//                $this->showError($uid['message'].$uid['code']);
//            }
//        }
//        //地理位置
//        $province = array();
//        $district = new DistrictModel();
//        $districts = DistrictModel::model()->findAll('level=1');
//        foreach ($districts as $key => $dis) {
//            $province[$dis->id] = $dis->name;
//        }
//        //头像
//        $detail = new UserServiceDetailModel();
//        $result = array(
//            'model' => $model,
//            'district' => $district,
//            'province' => $province,
//            'detail' => $detail,
//            'display' => 'create',
//            'industry' => $this->industry(),
//        );
//        $this->render('create', array('result' => $result));
//    }
    /**
     * 认证服务商成功
     */

    public function actionSuccess($id)
    {
        $model = $this->ProfileModel($id);
        if (isset($_POST['UserProfileModel'])) {
            $model->identity_card = Utils::encrypt($_POST['UserProfileModel']['identity_card']);
            $model->identity_name = Utils::encrypt($_POST['UserProfileModel']['identity_name']);
            $model->qq = $_POST['UserProfileModel']['qq'];
            $model->wechat = $_POST['UserProfileModel']['wechat'];
            $model->province_id = $_POST['UserProfileModel']['province_id'];
            $model->city_id = $_POST['UserProfileModel']['city_id'];
            $model->district_id = $_POST['UserProfileModel']['district_id'];
            $model->is_service = 1;
            $model->is_agent = 0;
            $model->is_broker = 0;
            $model->industry_id = $_POST['UserProfileModel']['industry_id'];
            //地理位置
            $obj1 = DistrictModel::model()->findByPk($model->province_id);
            $obj2 = DistrictModel::model()->findByPk($model->city_id);
            $obj3 = DistrictModel::model()->findByPk($model->district_id);
            $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
            $model->area = $str;
            $model->address = $_POST['UserProfileModel']['address'];
            $detail = UserServiceDetailModel::model()->findByPk($model->uid);
            $detail->img_src = $_POST['image']['img_src'];
            $detail->service_license_src = $_POST['image']['license'];
            $detail->status=1;
            $detail->industry_id = $_POST['UserProfileModel']['industry_id'];
            if (isset($_POST['desc']))
                $detail->desc = $_POST['desc'];
            else
                $detail->desc = '';
            //记录日志
            $oauth=UserOauthModel::model()->find('uid=:uid',array(':uid'=>$model->uid));
            if(!$oauth){
                $oauth=new UserOauthModel();
                $oauth->uid=$model->uid;
                $oauth->picture=$model->avatar;
                $oauth->identity_card=Utils::encrypt($model->identity_card);
                $oauth->identity_name=Utils::encrypt($model->identity_name);
                $oauth->lawyer_license_src=$_POST['image']['license'];
                $oauth->type=1;
                $oauth->status=1;
                $oauth->completed_at=time();
            }else {
                $oauth->picture = $model->avatar ? $model->avatar : '';
                $oauth->identity_card = Utils::encrypt($_POST['UserProfileModel']['identity_card']);
                $oauth->identity_name = Utils::encrypt($_POST['UserProfileModel']['identity_name']);
                $oauth->lawyer_license_src = $_POST['image']['license'] ? $_POST['image']['license'] : '';
                $oauth->business_card_src = '';
                $oauth->type = 1;
                $oauth->status = 1;
                $oauth->completed_at = time();
            }
            if ($model->validate() && $detail->validate() && $oauth->validate() ) {
                $oauth->save();
                $detail->save();
                $model->save();
                SmsLogModel::sendTipSMS(Utils::decrypt($model->phone),9,'','您申请的律师认证已通过审核，快登录天天见面接单，轻松获佣！');
                $this->showSuccess('认证成功', $this->createUrl('service/Index'));
            }
        }
        $model->identity_name = Utils::decrypt($model->identity_name);
        $model->identity_card = Utils::decrypt($model->identity_card);
        $model->phone = Utils::decrypt($model->phone);
        $detail = UserServiceDetailModel::model()->findByPk($id);
        $bank=UserBankModel::model()->find('uid=:uid',array(':uid'=>$id));
        $result = array(
            'model' => $model,
            'detail' => $detail,
            'display' => 'success',
            'industry' => $this->industry(),
            'bank' =>  $bank,
        );
        $this->render('success', array('result' => $result));
    }
    /**
     * 修改服务商
     */
    public function actionUpdate($id)
    {
        $model = $this->ProfileModel($id);
        if (isset($_POST['UserProfileModel'])) {
            $data=$_POST['UserProfileModel'];
             if($data['password']){
                 if(strlen($data['password'])>16 || strlen($data['password'])<8)
                     $this->showError('新密码长度错误请输入（8-16位）用户密码');

                 $uid = User::findPassword(array('phone' => Utils::decrypt($model->phone), 'new_password' => $data['password']));
                 if($uid['code']!==1000){
                     $this->showError('密码修改错误！');
                 }
             }

            $model->identity_card = Utils::encrypt($_POST['UserProfileModel']['identity_card']);
//            $model->phone = Utils::encrypt($_POST['UserProfileModel']['phone']);
//            $model->avatar = $_POST['image']['avatar'];
            $model->identity_name = Utils::encrypt($_POST['UserProfileModel']['identity_name']);
            $model->qq = $_POST['UserProfileModel']['qq'];
            $model->wechat = $_POST['UserProfileModel']['wechat'];
            $model->province_id = $_POST['UserProfileModel']['province_id'];
            $model->city_id = $_POST['UserProfileModel']['city_id'];
            $model->district_id = $_POST['UserProfileModel']['district_id'];
//            $model->is_service = 1;
//            $model->service_organization_id = $_POST['UserProfileModel']['service_organization_id'];
            $model->is_broker = 0;
            $model->industry_id = $_POST['UserProfileModel']['industry_id'];
            //地理位置
            $obj1 = DistrictModel::model()->findByPk($model->province_id);
            $obj2 = DistrictModel::model()->findByPk($model->city_id);
            $obj3 = DistrictModel::model()->findByPk($model->district_id);
            $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
            $model->area = $str;
            $model->address = $_POST['UserProfileModel']['address'];
            $detail = UserServiceDetailModel::model()->findByPk($model->uid);
            $detail->img_src = $_POST['image']['img_src'];
            $detail->service_license_src = $_POST['image']['license'];
            $detail->status=0;
            $detail->industry_id = $_POST['UserProfileModel']['industry_id'];
            if (isset($_POST['desc']))
                $detail->desc = $_POST['desc'];
            else
                $detail->desc = '';
            //记录日志
            $oauth=UserOauthModel::model()->find('uid=:uid',array(':uid'=>$model->uid));
            if(!$oauth){
                $oauth=new UserOauthModel();
                $oauth->uid=$model->uid;
                $oauth->picture=$_POST['image']['img_src'];
                $oauth->identity_card=Utils::encrypt($_POST['UserProfileModel']['identity_card']);
                $oauth->identity_name=Utils::encrypt($_POST['UserProfileModel']['identity_name']);
                $oauth->lawyer_license_src=$_POST['image']['license'];
                $oauth->type=1;
                $oauth->status=0;
                $oauth->updated_at=time();
            }else {
                $oauth->picture = $model->avatar ? $model->avatar : '';
                $oauth->identity_card = Utils::encrypt($_POST['UserProfileModel']['identity_card']);
                $oauth->identity_name = Utils::encrypt($_POST['UserProfileModel']['identity_name']);
                $oauth->lawyer_license_src = $_POST['image']['license'] ? $_POST['image']['license'] : '';
                $oauth->business_card_src = '';
                $oauth->type = 1;
                $oauth->status = 0;
//            $oauth->created_at=time();
                $oauth->updated_at = time();
            }
            if ($model->validate() && $detail->validate() && $oauth->validate()) {
                $oauth->save();
                $detail->save();
                $model->save();
                $this->showSuccess('编辑成功', $this->createUrl('service/Index'));
            }
        }
        $model->identity_name = Utils::decrypt($model->identity_name);
        $model->identity_card = Utils::decrypt($model->identity_card);
        $model->phone = Utils::decrypt($model->phone);
        $detail = UserServiceDetailModel::model()->findByPk($id);
//        $password=User::findPassword(array('phone'=>$model->phone,'new_password'=>'12345678'));
        $result = array(
            'model' => $model,
            'detail' => $detail,
            'display' => 'update',
            'password'=>'',
            'industry' => $this->industry(),
        );
        $this->render('update', array('result' => $result));
    }

    /**
     *认证服务商失败
     */
    public function actionLoser(){
        $uid=$_GET['uid'];
        $model=UserProfileModel::model()->find('uid=:uid',array(':uid'=>$uid));
        $model->is_service=0;
        $detail=UserServiceDetailModel::model()->find('uid=:uid',array(':uid'=>$uid));
        $detail->status=-1;
        $profile=UserProfileModel::model()->with('user_service_detail')->find('t.uid=:uid',array(':uid'=>$uid));
        $oauth=UserOauthModel::model()->find('uid=:uid',array(':uid'=>$uid));
        $oauth->picture=$profile->avatar;
        $oauth->identity_card=$profile->identity_card;
        $oauth->identity_name=$profile->identity_name;
        $oauth->lawyer_license_src=$profile->user_service_detail['service_license_src'];
        $oauth->type=1;
        $oauth->status=-1;
        $oauth->completed_at=time();
        if ($oauth->validate()) {
            $detail->save();
            $oauth->save();
            $model->save();
//            SmsLogModel::sendTipSMS(Utils::decrypt($model->phone),9,'','未通过律师的审核');
            $this->showSuccess('操作成功', $this->createUrl('service/Index'));
        }

    }

    /*
     * 删除机构
     */
    public function actionDelete($id)
    {
        if ($this->ProfileModel($id)->delete()) {
            UserProfileModel::model()->deleteAll('uid=:id', array(':id' => $id));
            UserServiceDetailModel::model()->deleteAll('uid=:id', array(':id' => $id));
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }
    }

    /*
    * 服务商机构列表
    */
    public function actionOrg_index()
    {

        $this->industry();
        if ($_POST) {
            $org = array();
            //得到服务商的名称及是否为服有服务商机构
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $name = Yii::app()->request->getParam('name');
            $area = Yii::app()->request->getParam('area');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            if ($name) {
                $criteria->addSearchCondition('t.name', $name);
            }
            if ($area) {
                $criteria->addSearchCondition('t.area', $area);
            }
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('UserServiceOrganizationModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $k => $p) {
                $industry_name = $this->industry_name($p->industry_id);
                switch ($p['status']) {
                    case 1:
                        $org_status = '审核通过';
                        break;
                    case 0:
                        $org_status = '审核中';
                        break;
                    case -1:
                        $org_status = '审核失败';
                        break;
                }
                if (isset($p['identity_name']) && !empty($p['identity_name'])) {
                    $identity_name = Utils::decrypt($p['identity_name']);
                } else {
                    $identity_name = '';
                }
                if ($p['status'] == 1) {
                    $operate = '<a href="' . $this->createUrl("service/org_update/id/{$p->id}") . '" class="btn btn-xs default btn-editable blue"><i class="fa fa-pencil">重新提交</i></a>';
                }
                if ($p['status'] == -1) {
                    $operate = '<a href="' . $this->createUrl("service/org_update/id/{$p->id}") . '" class="btn btn-xs default btn-editable yellow"><i class="fa fa-pencil">重新申请</i></a>';
//                        '<a rel="' . $this->createUrl("service/org_delete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i> 删除</a>'
                }
                if ($p['status'] == 0) {
                    $operate = '<a href="' . $this->createUrl("service/org_audit/id/{$p->id}") . '" class="btn btn-xs default btn-editable green"><i class="fa fa-pencil">确认审核</i></a>';
                }
                $logo = "<img src='$p->logo' style='width: 45px;height: 40px;'/>";
                $logo = "<a href='$p->logo' target='_blank'>$logo</a>";
                $industry_name=Utils::decrypt($p->identity_name);
                $industry_name=$industry_name?$industry_name:'';
                $org[] = array(
                    $p->name,
                    $logo,
                    $industry_name,
                    $p->area,
                    $industry_name,
                    $p->views_number,
                    $org_status,
                    $operate,
                );
            }
            $recordsFiltered = $total = (int)UserServiceOrganizationModel::model()->count($countCriteria);
            echo json_encode(array('data' => $org, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('org_index');
        }
    }

    //方法服务商机构ID的验证
    public function OrgModel($id)
    {
        $model = UserServiceOrganizationModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*
     * 添加服务商机构
     */
    public function actionOrg_create()
    {
        $model = new UserServiceOrganizationModel();
//        $username = Yii::app()->user->name;
        $admin_uid = Yii::app()->user->id;;
        if (isset($_POST['UserServiceOrganizationModel'])) {
            $org = $model->attributes = $_POST['UserServiceOrganizationModel'];
            $model->admin_uid = $admin_uid;//待定
            $model->name = $org['name'];
            $model->identity_name = Utils::encrypt($org['identity_name']);
            $model->identity_card = Utils::encrypt($org['identity_card']);
            $model->province_id = $org['province_id'];
            $model->city_id = $org['city_id'];
            $model->district_id = $org['district_id'];
            $model->business_license_src = $_POST['image']['business_license_src'];
            $model->identity_frontend_src = $_POST['image']['identity_frontend_src'];
            $model->identity_backeend_src = $_POST['image']['identity_backeend_src'];

            $obj1 = DistrictModel::model()->findByPk($model->province_id);
            $obj2 = DistrictModel::model()->findByPk($model->city_id);
            $obj3 = DistrictModel::model()->findByPk($model->district_id);
            $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
            $model->area = $str;
            $model->address = $model->area . $org['address'];

            $model->logo = $_POST['image']['logo'];
            if (isset($_POST['content']))
                $model->desc = $_POST['content'];
            else
                $model->desc = '';
            $model->status = 0;
            if ($model->validate()) {
                $model->save();
                $this->showSuccess('添加成功', $this->createUrl('service/org_index'));
            }
        }
        //地理位置
        $province = array();
        $district = new DistrictModel();
        $districts = DistrictModel::model()->findAll('level=1');
        foreach ($districts as $key => $dis) {
            $province[$dis->id] = $dis->name;
        }
        //服务商机构的图片
        $result = array(
            'model' => $model,
            'district' => $district,
            'province' => $province,
            'industry' => $this->industry(),
        );
        $this->render('org_create', array('result' => $result));
    }

    /*
     * 修改服务商机构
     */
    public function actionOrg_update($id)
    {
        $model = UserServiceOrganizationModel::model()->find('id=:uid', array(':uid' => $id));
        $username = Yii::app()->user->name;
        $admin_id = AdminModel::model()->find('username=:username', array(':username' => $username));
        if (isset($_POST['UserServiceOrganizationModel'])) {
            $org = $model->attributes = $_POST['UserServiceOrganizationModel'];
            $model->admin_uid = $model->admin_uid ? $admin_id['id'] : $model->admin_uid;
            $model->identity_name = $model->identity_name ? Utils::encrypt($org['identity_name']) : $model->identity_name;
            $model->identity_card = $model->identity_card ? Utils::encrypt($org['identity_card']) : $model->identity_card;
            $model->province_id = $model->province_id ? $org['province_id'] : $model->province_id;
            $model->city_id = $model->city_id ? $org['city_id'] : $model->city_id;
            $model->district_id = $model->district_id ? $org['district_id'] : $model->district_id;
            if ($_POST['image']) {
                $model->logo = $_POST['image']['logo'];
                $model->business_license_src = $_POST['image']['business_license_src'];
                $model->identity_frontend_src = $_POST['image']['identity_frontend_src'];
                $model->identity_backeend_src = $_POST['image']['identity_backeend_src'];
            } else {
                $model->logo = '';
                $model->business_license_src = '';
                $model->identity_frontend_src = '';
                $model->identity_backeend_src = '';
            }
            $model->industry_id = $org['industry_id'];
            $obj1 = DistrictModel::model()->findByPk($model->province_id);
            $obj2 = DistrictModel::model()->findByPk($model->city_id);
            $obj3 = DistrictModel::model()->findByPk($model->district_id);
            $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
            $model->area = $str;
            $model->address = $org['address'];
            $model->status = 0;
            if (isset($_POST['content']))
                $model->desc = $_POST['content'];
            else
                $model->desc = '';
            if ($model->validate()) {
                $model->save();
                $this->showSuccess('编辑成功', $this->createUrl('service/org_index'));
            }

        }
        //地理位置
        $province = array();
        $district = new DistrictModel();
        $districts = DistrictModel::model()->findAll('level=1');
        foreach ($districts as $key => $dis) {
            $province[$dis->id] = $dis->name;
        }
        //服务商机构的图片
        $model->identity_name = Utils::decrypt($model->attributes['identity_name']);
        $model->identity_card = Utils::decrypt($model->attributes['identity_card']);
        $result = array(
            'model' => $model,
            'district' => $district,
            'province' => $province,
            'industry' => $this->industry(),
        );
        $this->render('org_update', array('result' => $result));
    }

    /*
     * 删除服务商机构
     */
    public function actionOrg_delete($id)
    {
        $org_del = UserServiceOrganizationModel::model()->deleteAll('id=:id', array(':id' => $id));
        if ($org_del) {
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }
    }

    /*
     * 服务商机构审核
     */
    public function actionOrg_audit($id)
    {
        $model = UserServiceOrganizationModel::model()->find('id=:id', array(':id' => $id));
        if (isset($_POST['UserServiceOrganizationModel'])) {
            $org = $model->attributes = $_POST['UserServiceOrganizationModel'];
            $model->status = $org['status'];
            if ($model->validate()) {
                $model->save();
                $this->showSuccess('编辑成功', $this->createUrl('service/org_index'));
            }
        }
        //地理位置
        $province = array();
        $district = new DistrictModel();
        $districts = DistrictModel::model()->findAll('level=1');
        foreach ($districts as $key => $dis) {
            $province[$dis->id] = $dis->name;
        }
        //服务商机构的图片
        $model->identity_name = Utils::decrypt($model->attributes['identity_name']);
        $model->identity_card = Utils::decrypt($model->attributes['identity_card']);
        $industry = IndustryModel::model()->findByPk($model->industry_id);
//        $model->industry_id=$industry['name'];
        $industry_name = $industry['name'];

        $logo = "<img src='$model->logo' style='width: 100px;height: 50px;'/>";
        $logo = "<a href='$model->logo' target='_blank'>$logo</a>";

        $business_license_src = "<img src='$model->business_license_src' style='width: 100px;height: 50px;'/>";
        $business_license_src = "<a href='$model->business_license_src' target='_blank'>$business_license_src</a>";

        $identity_frontend_src = "<img src='$model->identity_frontend_src' style='width: 100px;height: 50px;'/>";
        $identity_frontend_src = "<a href='$model->identity_frontend_src' target='_blank'>$identity_frontend_src</a>";

        $identity_backeend_src = "<img src='$model->identity_backeend_src' style='width: 100px;height: 50px;'/>";
        $identity_backeend_src = "<a href='$model->identity_backeend_src' target='_blank'>$identity_backeend_src</a>";
        $result = array(
            'model' => $model,
            'district' => $district,
            'logo' => $logo,
            'business_license_src' => $business_license_src,
            'identity_frontend_src' => $identity_frontend_src,
            'identity_backeend_src' => $identity_backeend_src,
            'province' => $province,
            'industry_name' => $industry_name,
            'industry' => $this->industry(),
        );
        $this->render('org_audit', array('result' => $result));
    }


}
