<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/10
 * Time: 16:38
 */
class OauthController extends LoginedController
{
    /**
     * 审核日志
     */
    public function actionOauthLog()
    {
        if ($_POST) {
            $org = array();
            //得到服务商的名称及是否为服有服务商机构
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $page = $start / $pageSize;

            $order = Yii::app()->request->getParam('order');
            $type = Yii::app()->request->getParam('type');
            $status = Yii::app()->request->getParam('status');
            $criteria = new CDbCriteria;
            switch($type){
                case '--未选择':
                    $type='';break;
                case '服务商':
                    $type=1;break;
                case '中介':
                    $type=2;break;
                case '推荐人':
                    $type=3;break;
            }

            switch($status){
                case '--未选择':
                    $status='';break;
                case '待认证':
                    $criteria->condition='status=0';
                    $status='0';break;
                case '认证成功':
                    $status='1';break;
                case '认证失败':
                    $status='-1';break;
            }
            if($type){
                $criteria->condition='type='.$type;
            }
            if($status) {
                $criteria->condition='status='.$status;
            }
            switch($order[0]['column']){
                case 1:
                    $criteria->order="picture ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="identity_card ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="identity_name ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="lawyer_license_src ".$order[0]['dir'];
                    break;
                case 5:
                    $criteria->order="business_card_src ".$order[0]['dir'];
                    break;
                case 6:
                    $criteria->order="type ".$order[0]['dir'];
                    break;
                case 7:
                    $criteria->order="status ".$order[0]['dir'];
                    break;
                case 8:
                    $criteria->order="created_at ".$order[0]['dir'];
                    break;
                case 9:
                    $criteria->order="completed_at ".$order[0]['dir'];
                    break;
            }
            $countCriteria = $criteria;
//            var_dump($countCriteria);
            $dataProvider = new CActiveDataProvider('UserOauthModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $k => $p) {

                if($p->picture) {
                    $picture = "<img src='$p->picture' style='width: 50px;height: 45px;'/>";
                    $picture = "<a href='$p->picture' target='_blank'>$picture</a>";
                }else $picture='';

                if($p->business_card_src) {
                $business_card_src = "<img src=' $p->business_card_src' style='width: 50px;height: 45px;'/>";
                $business_card_src = "<a href=' $p->business_card_src' target='_blank'>$business_card_src</a>";
                }else $business_card_src='';

                if($p->lawyer_license_src) {
                $lawyer_license_src = "<img src='$p->lawyer_license_src' style='width: 50px;height: 45px;'/>";
                $lawyer_license_src = "<a href='$p->lawyer_license_src' target='_blank'>$lawyer_license_src</a>";
                }else $lawyer_license_src='';

                switch($p->type){
                    case 1:
                        $type='服务商';break;
                    case 2:
                        $type='中介';break;
                    case 3:
                        $type='推荐人';break;
                }
                switch($p->status){
                    case 0:
                        $status='待认证';break;
                    case 1:
                        $status='认证成功';break;
                    case -1:
                        $status='认证失败';break;
                }

                $identity_card=Utils::decrypt($p->identity_card);
                $identity_name=Utils::decrypt($p->identity_name);
                $org[] = array(
                    $p->uid,
                    $picture,
                    $identity_card,
                    $identity_name,
                    $lawyer_license_src,
                    $business_card_src,
                    $type,
                    $status,
                    Utils::date_time($p->created_at),
                    Utils::date_time($p->completed_at),
                    '',
                );
            }
            $recordsFiltered = $total = (int)UserOauthModel::model()->count($countCriteria);
            echo json_encode(array('data' => $org, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('oauth_log');
        }
    }
}