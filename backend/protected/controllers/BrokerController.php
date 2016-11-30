<?php

class BrokerController extends LoginedController
{

    /*
     * 行业数据
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
     * 经纪人列表
     */
    public function actionIndex()
    {
        if ($_POST) {
            $product = array();
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $username = Yii::app()->request->getParam('username');
            $phone = Yii::app()->request->getParam('phone');
            $order = Yii::app()->request->getParam('order');
            //print_r($phone);die;
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            if ($phone) {
                $criteria->addSearchCondition('t.phone', Utils::encrypt($phone));
            }
            if ($username) {
                $criteria->addSearchCondition('t.identity_name', Utils::encrypt($username));
            }
            switch($order[0]['column']){
                case 1:
                    $criteria->order="t.username ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="t.phone ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.industry_id ".$order[0]['dir'];
                    break;
            }
            $criteria->addCondition('is_broker=1');
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('UserProfileModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $p) {

                //获取经纪人详情表中的发布资产数
                $broker = UserBrokerDetailModel::model()->find('uid=:uid', array(':uid' => $p->uid));
                if ($broker) {
                    $pub_count = $broker['pub_count'];
                    $introduction_count = $broker['introduction_count'];
                    $pub_success_count = $broker['pub_success_count'];
                } else {
                    $pub_count = 0;
                    $introduction_count = 0;
                    $pub_success_count = 0;
                }
                $product[] = array(
                    $p->uid,
                    Utils::decrypt($p->identity_name),
                    Utils::decrypt($p->phone),
                    $pub_count,
                    $introduction_count,
                    $pub_success_count,
                    '<a href="' . $this->createUrl("broker/info/id/{$p->uid}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">详情</i></a>'.
                    '<a href="' . $this->createUrl("broker/update/id/{$p->uid}") . '" class="btn btn-xs default btn-editable red"><i class="fa fa-pencil">修改</i></a>'
//                    '<a rel="' . $this->createUrl("broker/delete/id/{$p->uid}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i> 删除</a>',
                );
            }
            $recordsFiltered = $total = (int)UserProfileModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('index');
        }
    }

    /*
     * 添加经纪人
     */
    public function actionAdd()
    {
        $model = new UserProfileModel();
        if (isset($_POST['UserProfileModel'])) {
            $profile = $model->attributes = $_POST['UserProfileModel'];
            $register = array(
                'phone' => $profile['phone'],
                'username' => $profile['phone'],
                'password' => rand(1000, 9999),
                'email' => '',
            );
            $uid = User::register($register);
            if ($uid['code'] == '1000') {
                $model->uid = $uid['data']['uid'];
                $model->username = $uid['data']['username'];
                $model->nickname = $profile['nickname'];
                $model->identity_card = Utils::encrypt($profile['identity_card']);
                $model->identity_name = Utils::encrypt($profile['identity_name']);
                $model->phone = $uid['data']['phone'];
                $model->is_broker = 1;
                $model->industry_id = $profile['industry_id'];
                $model->province_id = $profile['province_id'];
                $model->avatar = $_POST['image']['avatar'];
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
                $detail = new UserBrokerDetailModel();
                $detail->uid = $uid['data']['uid'];
                $detail->industry_id = $profile['industry_id'];
                $detail->business_card_src = $_POST['image']['business_card_src'];
                $detail->certificate_src = $_POST['image']['certificate_src'];
                if(isset($_POST['desc'])){
                    $detail->desc = $_POST['desc'];
                }else{
                    $detail->desc='';
                }
                $invite = new UserInviteModel();
                $invite->uid = $uid;
                $invite->username = $profile['username'];
                $invite->created_at=time();
                if ($model->validate() && $invite->validate() && $detail->validate()) {
                    $model->save();
                    $detail->save();
                    $invite->save();
                    $this->showSuccess('添加成功', $this->createUrl('broker/Index'));
                }
            }
            //转为推荐人
            elseif($uid['code'] == '1002'){
                $model=$_POST['UserProfileModel'];
                $user_profile=UserProfileModel::model()->find('phone=:phone',array(':phone'=>Utils::encrypt($profile['phone'])));
                $user_profile->username = $model['username'];
                $user_profile->nickname = $model['nickname'];
                $user_profile->identity_card = Utils::encrypt($model['identity_card']);
                $user_profile->identity_name = Utils::encrypt($model['identity_name']);
                $user_profile->phone = Utils::encrypt($model['phone']);
                $user_profile->is_broker = 1;

                $user_profile->industry_id = $model['industry_id'];
                $user_profile->province_id = $model['province_id'];
                $user_profile->avatar = $_POST['image']['avatar'];
                $user_profile->city_id = $model['city_id'];
                $user_profile->district_id = $model['district_id'];
                $obj1 = DistrictModel::model()->findByPk($user_profile->province_id);
                $obj2 = DistrictModel::model()->findByPk($user_profile->city_id);
                $obj3 = DistrictModel::model()->findByPk($user_profile->district_id);
                $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
                $user_profile->area = $str;
                if (isset($_POST['address']))
                    $user_profile->address = $user_profile->area . $_POST['address'];
                else
                    $user_profile->address = '';
                $user_profile->qq=$model['qq'];
                $user_profile->wechat=$model['wechat'];

                $detail = new UserBrokerDetailModel();
                $detail->uid = $user_profile['uid'];
                $detail->industry_id = $model['industry_id'];
                $detail->business_card_src = $_POST['image']['business_card_src'];
                $detail->certificate_src = $_POST['image']['certificate_src'];

                if(isset($_POST['desc'])){
                    $detail->desc = $_POST['desc'];
                }else{
                    $detail->desc='';
                }

                $invite = new UserInviteModel();
                $invite->uid = $user_profile['uid'];
                $invite->username = $model['username'];
                $invite->created_at=time();

                if ($user_profile->validate() && $invite->validate() && $detail->validate()) {
                    $detail->save();
                    $invite->save();
                    $user_profile->save();
                    $this->showSuccess('转经纪人成功', $this->createUrl('broker/Index'));
                }
            }else{
                $this->showError($uid['message']);
            }
        }
        $province = array();
        $district = new DistrictModel();
        $districts = DistrictModel::model()->findAll('level=1');
        foreach ($districts as $dis) {
            $province[$dis->id] = $dis->name;
        }
        $detail = new UserBrokerDetailModel();
        $invite = new UserInviteModel();
        $model = new UserProfileModel();
        $result = array(
            'model' => $model,
            'district' => $district,
            'province' => $province,
            'detail' => $detail,
            'invite' => $invite,
            'display'=>'create',
            'industry' => $this->industry(),
        );
        $this->render('add', array('result' => $result));

    }
    //方法服务商ID的验证
    public function ProfileModel($id)
    {
        $model = UserProfileModel::model()->find('uid=:uid',array(':uid'=>$id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*
     * 修改经纪人
     */
    public function actionUpdate($id){
        $model = $this->ProfileModel($id);
        if (isset($_POST['UserProfileModel'])) {
            $model->identity_card = Utils::encrypt($_POST['UserProfileModel']['identity_card']);
            $model->nickname =$_POST['UserProfileModel']['nickname'];
            $model->identity_name = Utils::encrypt($_POST['UserProfileModel']['identity_name']);
            $model->province_id = $_POST['UserProfileModel']['province_id'];
            $model->city_id = $_POST['UserProfileModel']['city_id'];
            $model->avatar = $_POST['image']['avatar'];
            $model->district_id = $_POST['UserProfileModel']['district_id'];
            $model->is_broker = 1;
            $model->industry_id = $_POST['UserProfileModel']['industry_id'];
            $obj1 = DistrictModel::model()->findByPk($model->province_id);
            $obj2 = DistrictModel::model()->findByPk($model->city_id);
            $obj3 = DistrictModel::model()->findByPk($model->district_id);
            $str = $obj1->name . ' ' . $obj2->name . ' ' . $obj3->name;
            $model->area = $str;
            if (isset($_POST['address']))
                $model->address = $model->area . $_POST['address'];
            else
                $model->address = '';
            $model->qq=$_POST['UserProfileModel']['qq'];
            $model->wechat=$_POST['UserProfileModel']['wechat'];

            $detail =UserBrokerDetailModel::model()->find('uid=:uid',array(':uid'=>$id));
            $detail->industry_id = $_POST['UserProfileModel']['industry_id'];
            $detail->business_card_src = $_POST['image']['business_card_src'];
            $detail->certificate_src = $_POST['image']['certificate_src'];
            if(isset($_POST['desc']))
                $detail->desc = $_POST['desc'];
            else
                $detail->desc='';
            $detail->save();
            if ($model->validate() &&$detail->validate()) {
                $model->save();
                $detail->save();
                $this->showSuccess('编辑成功', $this->createUrl('broker/Index'));
            }
        }
        $province = array();
        $district = new DistrictModel();
        $districts = DistrictModel::model()->findAll('level=1');
        foreach ($districts as $dis) {
            $province[$dis->id] = $dis->name;
        }
        $detail =UserBrokerDetailModel::model()->find('uid=:uid',array(':uid'=>$id));
        $invite =UserInviteModel::model()->find('uid=:uid',array(':uid'=>$id));
        $model->identity_card=Utils::decrypt($model->identity_card);
        $model->identity_name=Utils::decrypt($model->identity_name);
        $model->phone=Utils::decrypt($model->phone);
        $result = array(
            'model' => $model,
            'district' => $district,
            'province' => $province,
            'detail' => $detail,
            'invite' => $invite,
            'display'=>'update',
            'industry' => $this->industry(),
        );
        $this->render('update', array('result' => $result));
    }

    /*
     * 删除经纪人
     */
    public function actionDelete($id){
        if ($this->ProfileModel($id)->delete()) {
            UserProfileModel::model()->deleteAll('uid=:id', array(':id' => $id));
            UserBrokerDetailModel::model()->deleteAll('uid=:id', array(':id' => $id));
            UserInviteModel::model()->deleteAll('uid=:id', array(':id' => $id));
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }


    }
//经纪人详情
    public function actionInfo($id)
    {
        $model = $this->UserProfileloadModel($id);
        $detail = UserBrokerDetailModel::model()->find('uid=:uid', array(':uid' => $id));
        $invite = UserInviteModel::model()->find('uid=:uid', array(':uid' => $id));
        $industry = IndustryModel::model()->findByPk($model->industry_id);
        $model->industry_id = $industry->name;
        $model->phone = Utils::decrypt($model->phone);
        $model->identity_name = Utils::decrypt($model->identity_name);
        $model->identity_card = Utils::decrypt($model->identity_card);
        $model->address = $model->area . $model->address;
        $this->render('info', array(
            'detail' => $detail,
            'model' => $model,
            'invite' => $invite,
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