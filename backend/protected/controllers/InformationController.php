<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/10
 * Time: 15:40
 */
class InformationController extends Controller
{
    public function actionSms()
{
    if($_POST){
        $pageSize=Yii::app()->request->getParam('length',10);
        $start=Yii::app()->request->getParam('start');
        $page= $start / $pageSize;
        $order=$_POST['order'];
        $phone=Yii::app()->request->getParam('phone');
        $type=Yii::app()->request->getParam('type');
        $criteria=new CDbCriteria();
        switch($order[0]['column']){
            case 1:
                $criteria->order="phone ".$order[0]['dir'];
                break;
            case 2:
                $criteria->order="create_at ".$order[0]['dir'];
                break;
            case 2:
                $criteria->order="error_code ".$order[0]['dir'];
                break;
        }

        if($phone){
            $criteria->addSearchCondition('phone',$phone);
        }
        switch($type){
            case '登录异常':
                $type=1;break;
            case '注册':
                $type=2;break;
            case '重设密码':
                $type=3;break;
            case '其他':
                $type=4;break;
        }
        if($type){
            $criteria->addSearchCondition('type',$type);
        }
        $order_date_from=Yii::app()->request->getParam('order_date_from');
        if($order_date_from){
            $criteria->addCondition("FROM_UNIXTIME(t.created_at,'%Y-%m-%d')>= :order_date_from");
            $criteria->params[':order_date_from'] = $order_date_from;
        }
        $order_date_to=Yii::app()->request->getParam('order_date_to');
        if($order_date_to){
            $criteria->addCondition("FROM_UNIXTIME(t.created_at,'%Y-%m-%d')<= :order_date_to");
            $criteria->params[':order_date_to'] = $order_date_to;
        }
        $total = SmsLogModel::model()->count($criteria);
        $dataProvider=new CActiveDataProvider('SmsLogModel',
            array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                ))
        );
        $sms=$dataProvider->getData();
        $product='';
        $i = $page == 0 ? 1 : $pageSize * ($page+1);
        foreach($sms as $p){
            switch ($p->type){
                case 1:
                    $p->type='登录异常';break;
                case 2:
                    $p->type='注册';break;
                case 3:
                    $p->type='找回密码';break;
                case 4:
                    $p->type='其他';break;
            }
            $i;
            $product[]=array(
                $i,
                isset($p->phone)?$p->phone:'',
                isset($p->created_at)?date('Y-m-d H:i:s',$p->created_at):'',
                isset($p->content)?$p->content:'',
                $p->type,
                $p->error_code ? '失败':'成功',
                '',
            );
            $i++;
        }
        die(json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $total)));
    }else{
        $this->render('smsLog');
    }
}

    /*
	 *消息列表
	 */
    public function actionNotify()
    {
        if($_POST){
            $pageSize=Yii::app()->request->getParam('length',10);
            $start=Yii::app()->request->getParam('start');
            $page= $start / $pageSize;

            $title=Yii::app()->request->getParam('title');
            $content=Yii::app()->request->getParam('content');
            $type=Yii::app()->request->getParam('type');
            $is_read=Yii::app()->request->getParam('is_read');
            $order = Yii::app()->request->getParam('order');
            $criteria=new CDbCriteria();
            if($title){
                $criteria->addSearchCondition('title',$title);
            }
            if($content){
                $criteria->addSearchCondition('content',$content);
            }
            switch($type){
                case '--未选择':
                    $type='';break;
                case '系统消息':
                    $type=1;break;
            }

            switch($is_read){
                case '--未选择':
                    $is_read='';break;
                case '已查看':
                    $is_read=1;break;
                case '未查看':
                    $is_read=0;break;
            }
            if($is_read){
                $criteria->addSearchCondition('is_read',$is_read);
            }
            if($type){
                $criteria->addSearchCondition('type',$type);
            }
            switch($order[0]['column']){
                case 1:
                    $criteria->order="t.title ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="t.uid ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="t.type ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="t.is_read ".$order[0]['dir'];
                    break;
                case 5:
                    $criteria->order="t.from_username ".$order[0]['dir'];
                    break;
                case 6:
                    $criteria->order="t.content ".$order[0]['dir'];
                    break;
                case 7:
                    $criteria->order="t.created_at ".$order[0]['dir'];
                    break;
                case 8:
                    $criteria->order="t.read_at ".$order[0]['dir'];
                    break;
            }
            $total = NotifyModel::model()->count($criteria);
            $dataProvider=new CActiveDataProvider('NotifyModel',
                array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>$pageSize,
                        'currentPage'=>$page,
                    ))
            );
            $notify=$dataProvider->getData();
            $product='';
            $i = $page == 0 ? 1 : $pageSize * ($page+1);
            foreach($notify as $p){
                switch ($p->type){
                    case 1:
                        $p->type='系统消息';break;
                }
                switch ($p->is_read){
                    case 1:
                        $p->is_read='已查看';break;
                    case 0:
                        $p->is_read='未查看';break;
                }
                $i;
                $product[]=array(
                    $i,
                    isset($p->title)?$p->title:'',
                    isset($p->uid)?$p->uid:'',
                    isset($p->type)?$p->type:'',
                    isset($p->is_read)?$p->is_read:'',
//					isset($p->from_uid)?$p->from_uid:'',
                    isset($p->from_username)?$p->from_username:'',
                    isset($p->content)?$p->content:'',
                    isset($p->created_at)?date('Y-m-d H:i:s',$p->created_at):'',
                    isset($p->read_at)?date('Y-m-d H:i:s',$p->read_at):'',
                    '',
                );
                $i++;
            }
            die(json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $total)));
        }else{
            $this->render('notify');
        }
    }
    
}