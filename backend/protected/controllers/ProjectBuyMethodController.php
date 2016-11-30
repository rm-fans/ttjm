<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/24
 * Time: 17:10
 */
class ProjectBuyMethodController extends LoginedController
{
    public function  actionIndex()
    {
        if($_POST){
            $product=array();
            $products = ProjectBuyMethodModel::model()->findAll();
                foreach ($products as $p) {
                    $product[] = array(
                        $p['id'],
                        $p['name'],
                    );
                }
            $recordsFiltered=$total = (int)ProjectBuyMethodModel::model()->count();
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, ));
            exit;
        }
        $result = array();
        $this->render('index',array('result'=>$result));
    }
    public function actionCreate()
    {
        $model=new ProjectBuyMethodModel();
        if(isset($_POST['ProjectBuyMethodModel']))
        {
            $form = $_POST['ProjectBuyMethodModel'];
            if($model->validate())
            {
                /*header('Content-Type: text/html; charset=utf-8');
                echo "<pre>";
                print_r($form);exit;*/
                if($model->save()){
                    $model->name = $form['name'];
                    $this->showSuccess('添加成功', $this->createUrl('projectBuyMethod/index'));
                }
            }
        }

        $this->render('create',array('model'=>$model));
    }
}