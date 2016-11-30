<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/24
 * Time: 17:10
 */
class AssetAttributesController extends LoginedController
{
    public function  actionIndex()
    {
        if($_POST){
            $product=array();
            $products = AssetAttributesModel::model()->findAll();
            foreach ($products as $p) {
                $product[] = array(
                    $p['id'],
                    $p['name'],
                );
            }
            $recordsFiltered=$total = (int)AssetAttributesModel::model()->count();
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, ));
            exit;
        }
        $result = array();
        $this->render('index',array('result'=>$result));
    }
    public function actionCreate()
    {
        $model=new AssetAttributesModel();
        if(isset($_POST['AssetAttributesModel']))
        {
            $form = $_POST['AssetAttributesModel'];
            if($model->validate())
            {
                $model->name = $form['name'];
                $model->is_effect = $form['is_effect'];
                /*header('Content-Type: text/html; charset=utf-8');
                echo "<pre>";
                print_r($form);exit;*/
                if($model->save()){

                    $this->showSuccess('添加成功', $this->createUrl('assetAttributes/index'));
                }
            }
        }

        $this->render('create',array('model'=>$model));
    }
}