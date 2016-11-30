<?php

class AgentController extends LoginedController
{
    //行业姓名
    public function industry_name($id)
    {
        $industry = IndustryModel::model()->find('id=:id', array(':id' => $id));
        if (isset($industry)) {
            return $industry->attributes['name'];
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
    //中介机构数据
    public function org_agent(){
        $org_agents=UserAgentOrganizationModel::model()->findAll();
        $org_agent =array('0'=>'暂无机构');
        if(isset($org_agents)){
            foreach($org_agents as $value){
                $org_agent[$value['id']]=$value['name'];
            }
        }
        return $org_agent;
    }
    //中介列表
    public function actionIndex()
    {
        if ($_POST) {
            $product = array();
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
                $criteria->addSearchCondition('userprofile.identity_name', Utils::encrypt($identity_name));
            }
            if ($phone) {
                $criteria->addSearchCondition('userprofile.phone', Utils::encrypt($phone));
            }
            switch($order[0]['column']){
                case 1:
                    $criteria->order="userprofile.username ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="userprofile.phone ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.img_src ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="t.business_card_src ".$order[0]['dir'];
                    break;
                case 5:
                    $criteria->order="t.industry_id ".$order[0]['dir'];
                    break;
                case 6:
                    $criteria->order="t.status ".$order[0]['dir'];
                    break;
            }
            $criteria->with=array('userprofile');
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('UserAgentDetailModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products  as $k=>$p) {
                //机构显示
                if (isset($p->userprofile['phone']))
                    $phone = Utils::decrypt($p->userprofile['phone']);
                else
                    $phone = '';
                if (isset($p->userprofile['identity_name']))
                    $identity_name = Utils::decrypt($p->userprofile['identity_name']);
                else
                    $identity_name = '';
                $industry_name = $this->industry_name($p->userprofile['industry_id']);
                $organ = UserAgentOrganizationModel::model()->find('id=:id', array(':id' => $p->userprofile['agent_organization_id']));
                if ($organ) {
                    $org_name = $organ['name'];
                } else {
                    $org_name = '无';
                }
                $having = 0;
                $end = 0;
                $success = 0;
                $agent_count = ProjectUserRecordModel::model()->findAll(array('condition' => 'agent_uid=' .$p->userprofile['uid']));
                foreach ($agent_count as $agent_count) {
                    if ($agent_count->state == ProjectUserRecordModel::STATE_CONTACTING) {
                        $having++;
                    }
                    if ($agent_count->state == ProjectUserRecordModel::STATE_DEAL) {
                        $end++;
                    }
                    if ($agent_count->state == ProjectUserRecordModel::STATE_DEAL) {
                        $success++;
                    }
                }
                //操作
                if ($p->status == -1) {
                    $operate = '<a href="' . $this->createUrl("agent/success/id/{$p->uid}") . '" class="btn btn-xs default btn-editable blue"><i class="fa fa-pencil">认证</i></a>';
                }
                elseif ($p->status == 1) {
                    $operate =
//                        '<a href="' . $this->createUrl("agent/success/id/{$p->uid}") . '" class="btn btn-xs default btn-editable blue"><i class="fa fa-pencil">重新认证</i></a>'.
                        '<a href="' . $this->createUrl("agent/AgentInfo/id/{$p->uid}") . '" class="btn btn-xs default btn-editable red"><i class="fa fa-pencil">详情</i></a>'.
                        '<a href="' . $this->createUrl("agent/update/id/{$p->uid}") . '" class="btn btn-xs default btn-editable yellow"><i class="fa fa-pencil">修改</i></a>';
//                    '<a rel="' . $this->createUrl("service/delete/id/{$p->uid}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i> 删除</a>';
                }
                if ($p->status == 0) {
                    $operate = '<a href="' . $this->createUrl("agent/success/id/{$p->uid}") . '" class="btn btn-xs default btn-editable green"><i class="fa fa-pencil">认证</i></a>';
                }
                if($p->img_src) {
                    $work=$p->img_src;
                    $work_img = "<img src=' $work' style='width: 50px;height: 45px;'/>";
                    $work_log = "<a href=' $work' target='_blank'>$work_img</a>";
                }else $work_log='';
                if($p->business_card_src) {
                    $business_card_src = "<img src=' $p->business_card_src' style='width: 50px;height: 45px;'/>";
                    $business_card_src = "<a href=' $p->business_card_src' target='_blank'>$business_card_src</a>";
                }else $business_card_src='';
                //记录统计
                $product[] = array(
                    $p->userprofile['uid'],
                    $identity_name,
                    $phone,
                    $work_log,
                    $business_card_src,
                 //  $p->service_organization_id == 0 ? '个人' : '机构',
                    $industry_name,
                    UserAgentDetailModel::status_name($p->status),
                    $having,
                    $end,
                    $success,
                    $operate,
                );
            }
            $recordsFiltered = $total = (int)UserAgentDetailModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('index');
        }
    }
    public function actionAgentInfo()
    {
        $id=$_GET['id'];
        $agent_profile = UserProfileModel::model()->find('uid=:uid', array(':uid' => $id));
        $agent_detail = UserAgentDetailModel::model()->findByPk($id);
        $org = UserAgentOrganizationModel::model()->find('id=:id', array(':id' => $agent_profile['service_organization_id']));
        if (isset($org)) {
            $org_name = $org['name'];
        } else {
            $org_name = '无';
        }
        $bank = UserBankModel::model()->find('uid=:uid', array(':uid' => $id));
        $industry = IndustryModel::model()->find('id=:id', array(':id' => $agent_profile['industry_id']));
        $agent_profile->identity_name = Utils::decrypt($agent_profile->identity_name);
        $agent_profile->identity_card = Utils::decrypt($agent_profile->identity_card);
        $this->render('agent_info', array(
            'profile' => $agent_profile,
            'org_name' => $org_name,
            'industry_name' => $industry['name'],
            'detail' => $agent_detail,
            'bank'=>$bank
        ));
    }
    //添加中介
    public function actionAdd()
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
                $model->uid = $uid['data']['uid'];
                $model->sex = $profile['sex'];
                $model->username = $uid['data']['username'];
                $model->identity_card = Utils::encrypt($profile['identity_card']);
                $model->identity_name = Utils::encrypt($profile['identity_name']);
                $model->phone = $uid['data']['phone'];
                $model->agent_organization_id = $profile['agent_organization_id'];
                $model->is_agent = 0;
                $model->industry_id = $profile['industry_id'];
                $model->province_id = $profile['province_id'];
                $model->city_id = $profile['city_id'];
                $model->district_id = $profile['district_id'];
                $obj1 = DistrictModel::model()->findByPk($model->province_id);
                $obj2 = DistrictModel::model()->findByPk($model->city_id);
                $obj3 = DistrictModel::model()->findByPk($model->district_id);
                $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
                $model->area = $str;
                if (isset($_POST['address']))
                    $model->address = $model->area . $_POST['address'];
                else
                    $model->address = '';
                $model->qq=$profile['qq'];
                $model->wechat=$profile['wechat'];
                $detail = new UserAgentDetailModel();
                $detail->uid = $uid['data']['uid'];
                $detail->status=0;
                $detail->industry_id = $profile['industry_id'];
                $detail->img_src = $_POST['image']['img_src'];
                $detail->business_card_src = $_POST['image']['src'];
                if(isset($_POST['desc'])){
                    $detail->desc = $_POST['desc'];
                }else{
                    $detail->desc='';
                }
                $oauth=new UserOauthModel();
                $oauth->uid=$uid['data']['uid'];
                $oauth->picture=$_POST['image']['img_src'];
                $oauth->identity_card=Utils::encrypt($profile['identity_card']);
                $oauth->identity_name=Utils::encrypt($profile['identity_name']);
                $oauth->business_card_src=$_POST['image']['src'];
                $oauth->type=2;
                $oauth->status=0;
                $oauth->created_at=time();
                if ($model->validate()) {
                    $model->save();
                    $detail->save();
                    $oauth->save();
                    $this->showSuccess('添加成功', $this->createUrl('agent/index'));
                }
            }else{

                $this->showError($uid['message'].$uid['code']);
            }
        }
        //位置
        $province = array();
        $district = new DistrictModel();
        $districts = DistrictModel::model()->findAll('level=1');
        foreach ($districts as $dis) {
            $province[$dis->id] = $dis->name;
        }
        //头像
        $detail = new UserAgentDetailModel();
        $result = array(
            'model' => $model,
            'org'=>$this->org_agent(),
            'district' => $district,
            'province' => $province,
            'detail' => $detail,
            'display'=>'add',
            'industry' => $this->industry(),
        );
        $this->render('add', array('result' => $result));
    }
    //方法中介ID的验证
    public function ProfileModel($id)
    {
        $model = UserProfileModel::model()->find('uid=:uid',array(':uid'=>$id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    //认证中介成功
    public function actionSuccess($id)
    {
        $model = $this->ProfileModel($id);
        if (isset($_POST['UserProfileModel'])) {
            $model->identity_card = Utils::encrypt($_POST['UserProfileModel']['identity_card']);
            $model->identity_name = Utils::encrypt($_POST['UserProfileModel']['identity_name']);
            $model->sex =  $_POST['UserProfileModel']['sex'];
            $model->qq = $_POST['UserProfileModel']['qq'];
            $model->wechat = $_POST['UserProfileModel']['wechat'];
            $model->province_id = $_POST['UserProfileModel']['province_id'];
            $model->city_id = $_POST['UserProfileModel']['city_id'];
            $model->district_id = $_POST['UserProfileModel']['district_id'];
            $model->is_service = 0;
            $model->is_agent = 1;
            $model->is_broker = 0;
//            $model->agent_organization_id = $_POST['UserProfileModel']['agent_organization_id'];
            $model->industry_id = $_POST['UserProfileModel']['industry_id'];
            //地理位置
            $obj1 = DistrictModel::model()->findByPk($model->province_id);
            $obj2 = DistrictModel::model()->findByPk($model->city_id);
            $obj3 = DistrictModel::model()->findByPk($model->district_id);
            $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
            $model->area = $str;
            $model->address = $_POST['UserProfileModel']['address'];
            $detail = UserAgentDetailModel::model()->findByPk($model->uid);
            $detail->img_src = $_POST['image']['img_src'];
            $detail->business_card_src=$_POST['image']['license'];
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
                $oauth->picture=$model->avatar?$model->avatar:'';
                $oauth->identity_card=Utils::encrypt($_POST['UserProfileModel']['identity_card']);
                $oauth->identity_name=Utils::encrypt($_POST['UserProfileModel']['identity_name']);
                $oauth->business_card_src=$_POST['image']['license']?$_POST['image']['license']:'';
                $oauth->type=2;
                $oauth->status=1;
                $oauth->completed_at=time();
            }else{
                $oauth->picture=$model->avatar?$model->avatar:'';
                $oauth->identity_card=Utils::encrypt($_POST['UserProfileModel']['identity_card']);
                $oauth->identity_name=Utils::encrypt($_POST['UserProfileModel']['identity_name']);
                $oauth->business_card_src=$_POST['image']['license']?$_POST['image']['license']:'';
                $oauth->type=2;
                $oauth->status=1;
                $oauth->completed_at=time();
            }

            if ($model->validate() && $detail->validate() && $oauth->validate() ) {
                $oauth->save();
                $detail->save();
                $model->save();
                SmsLogModel::sendTipSMS(Utils::decrypt($model->phone),9,'','您的申请的经纪人认证已通过审核，快登录天天见面接单，轻松获佣！');
                $this->showSuccess('编辑成功', $this->createUrl('agent/index'));
            }
        }
        $model->identity_name = Utils::decrypt($model->identity_name);
        $model->identity_card = Utils::decrypt($model->identity_card);
        $model->phone = Utils::decrypt($model->phone);
        $detail = UserAgentDetailModel::model()->findByPk($id);
        $bank=UserBankModel::model()->find('uid=:uid',array(':uid'=>$id));
        $result = array(
            'model' => $model,
            'detail' => $detail,
            'display' => 'success',
            'industry' => $this->industry(),
            'org' => $this->org_agent(),
            'bank' =>  $bank,
        );
        $this->render('success', array('result' => $result));
    }
    //认证中介失败
    public function actionLoser(){
        $uid=$_GET['uid'];
        $model=UserProfileModel::model()->find('uid=:uid',array(':uid'=>$uid));
        $model->is_agent=0;
        $detail=UserAgentDetailModel::model()->find('uid=:uid',array(':uid'=>$uid));
        $detail->status=-1;
        $profile=UserProfileModel::model()->with('user_agent_detail')->find('t.uid=:uid',array(':uid'=>$uid));
        $oauth=UserOauthModel::model()->find('uid=:uid',array(':uid'=>$uid));
        $oauth->picture=$profile->avatar;
        $oauth->identity_card=$profile->identity_card;
        $oauth->identity_name=$profile->identity_name;
        $oauth->business_card_src=$profile->user_agent_detail['business_card_src'];
        $oauth->type=2;
        $oauth->status=-1;
        $oauth->completed_at=time();
        if ($oauth->validate()) {
            $detail->save();
            $oauth->save();
            $model->save();
            $this->showSuccess('操作成功', $this->createUrl('agent/Index'));
        }

    }

    /*
     * 修改中介
     */
    public function actionUpdate($id){
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
            $detail = UserAgentDetailModel::model()->findByPk($model->uid);
            $detail->img_src = $_POST['image']['img_src'];
            $detail->business_card_src = $_POST['image']['license'];
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
                $this->showSuccess('编辑成功', $this->createUrl('Agent/Index'));
            }
        }
        $model->identity_name = Utils::decrypt($model->identity_name);
        $model->identity_card = Utils::decrypt($model->identity_card);
        $model->phone = Utils::decrypt($model->phone);
        $detail = UserAgentDetailModel::model()->findByPk($id);
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
    /*
     * 删除中介
     */
    public function actionDelete($id){
        if ($this->ProfileModel($id)->delete()) {
            UserProfileModel::model()->deleteAll('uid=:id', array(':id' => $id));
            UserAgentDetailModel::model()->deleteAll('uid=:id', array(':id' => $id));
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }


    }
    //中介详情
    public function actionInfo($id)
    {
        $model = $this->UserProfileloadModel($id);
        $detail = UserAgentDetailModel::model()->find('uid=:uid', array(':uid' => $id));
        $industry = IndustryModel::model()->findByPk($model->industry_id);
        $model->industry_id = $industry->name;
        $model->phone = Utils::decrypt($model->phone);
        $model->identity_name = Utils::decrypt($model->identity_name);
        $model->identity_card = Utils::decrypt($model->identity_card);
        $model->address = $model->area . $model->address;
        $this->render('info', array(
            'detail' => $detail,
            'model' => $model,
        ));
    }
    public function UserProfileloadModel($id)
    {
        $model = UserProfileModel::model()->find('uid=:uid',array(':uid'=>$id));
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }


}