<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/20
 * Time: 10:22
 */
class AjaxController extends AdminController
{
    /*
     * 这是关于省市联动中区的请求
     * */
    public function actionDistrict(){
        $type = Yii::app()->request->getParam('type');
        $data = DistrictModel::model()->findAll('upid=:id', array(':id'=>(int) $_POST['id']));
        $data = CHtml::listData($data,'id','name');
        switch($type){
            case 'province':
                $cities="<option value=''>选择城市</option>";
                foreach($data as $value=>$name){
                    $cities .=CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $district="<option value='null'>选择区域</option>";
                echo CJSON::encode(array('cities'=>$cities,'district'=>$district));
                break;
            case 'city':
                echo "<option value=''>选择区域</option>";
                foreach($data as $value=>$name)
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                break;
        }

    }
}