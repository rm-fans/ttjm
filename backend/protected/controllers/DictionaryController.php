<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/12
 * Time: 9:23
 */
class DictionaryController extends LoginedController
{
    /**
     * 协议字典列表
     */
    public function actionIndex(){
        if ($_POST) {
            $product = array();
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');

            $content = Yii::app()->request->getParam('content');
            $title = Yii::app()->request->getParam('title');
            $status = Yii::app()->request->getParam('status');
            $order = Yii::app()->request->getParam('order');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            if ($content) {
                $criteria->addSearchCondition('content', $content);
            }
            if ($title) {
                $criteria->addSearchCondition('title', $title);
            }
            switch($status){
                case '--未选择':
                    $status='';break;
                case '未发布':
                    $criteria->condition='status=0';
                    $status=0;break;
                case '已发布':
                    $status=1;break;
            }

            switch($order[0]['column']){
                case 1:
                    $criteria->order="title ".$order[0]['dir'];
                    break;
                case 2:
                    $criteria->order="content ".$order[0]['dir'];
                    break;
                case 3:
                    $criteria->order="cycle ".$order[0]['dir'];
                    break;
                case 4:
                    $criteria->order="price ".$order[0]['dir'];
                    break;
                case 5:
                    $criteria->order="status ".$order[0]['dir'];
                    break;
                case 6:
                    $criteria->order="created_at ".$order[0]['dir'];
                    break;
                case 7:
                    $criteria->order="updated_at ".$order[0]['dir'];
                    break;
            }
            if ($status) {
                $criteria->addSearchCondition('status', $status);
            }
            $criteria->with = 'category';
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('ServiceDictionaryModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            $i=0;
            foreach ($products as $p) {
                $i++;
                $product[] = array(
                    $i,
                    $p->title,
                    $p->category->name,
                    $p->content,
                    $p->cycle,
                    $p->price,
                    ServiceDictionaryModel::status_name($p->status),
                    Utils::date_time($p->created_at),
                    Utils::date_time($p->updated_at),
//                    '<a href="' . $this->createUrl("broker/info/id/{$p->uid}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">详情</i></a>'.
                    '<a href="' . $this->createUrl("dictionary/update/id/{$p->id}") . '" class="btn btn-xs default btn-editable black"><i class="fa fa-pencil">修改</i></a>'.
                    '<a rel="' . $this->createUrl("dictionary/delete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i> 删除</a>',
                );
            }
            $recordsFiltered = $total = (int)ServiceDictionaryModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('index');
        }


    }

    /**
     * 添加词典
     */
    public function actionAdd(){
        $model=new ServiceDictionaryModel();
        $category = ServiceDictionaryCategoryModel::DropDownList();
        $getCategory = array();
        foreach($category as $key_p=>$category_p){
            foreach($category_p['chile'] as $category_c){
                $category_c['name'] = $category_p['name']."-->".$category_c['name'];
                array_push($getCategory,$category_c);
            }
        }
        if(isset($_POST['ServiceDictionaryModel'])){
            $content = strip_tags( $_POST['ServiceDictionaryModel']['content']);
            $model->category_id  = $_POST['category_id'];
            $model->created_at = time();
            $model->content =$content;
            $model->attributes=$_POST['ServiceDictionaryModel'];
            if($model->validate() && $model->save()){
                $this->showSuccess('添加成功',$this->createUrl('dictionary/index'));
            }
        }
        $this->render('add', array('model' => $model,'category' => $getCategory));
    }

    /**
     * 修改词典
     */
    public function actionUpdate($id){
        $model=ServiceDictionaryModel::model()->findByPk($id);
        $category = ServiceDictionaryCategoryModel::DropDownList();
        $getCategory = array();
        foreach($category as $key_p=>$category_p){
            foreach($category_p['chile'] as $category_c){
                $category_c['name'] = $category_p['name']."-->".$category_c['name'];
                array_push($getCategory,$category_c);
            }
        }
        if(isset($_POST['ServiceDictionaryModel'])){
          $content = strip_tags( $_POST['ServiceDictionaryModel']['content']);
            $model->updated_at=time();
            $model->category_id  = $_POST['category_id'];
            $model->content= $content;
            $model->attributes=$_POST['ServiceDictionaryModel'];
            if($model->validate() && $model->save()){
                $this->showSuccess('修改成功',$this->createUrl('dictionary/index'));
            }
        }
        $this->render('update', array('model' => $model,'category'=>$getCategory));

    }

    /**
     * 删除词典
     */
    public function actionDelete($id){
         $del=$this->loadModel($id);
//        $this->showSuccess('删除成功',$this->createUrl('dictionary/index'));
        if($del->delete()){
            $this->showJsonResult(1);
        }else{
            $this->showJsonResult(0);
        }
    }
    public function loadModel($id){
        $model = ServiceDictionaryModel::model()->findByPk($id);
        if(!$model){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }
    //词典分类
    public function actionCategoryList()
    {
        if ($_POST) {
            $product = array();
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('pid' => 0));
            $criteria->order = "t.id desc";
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('ServiceDictionaryCategoryModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $p) {
                $product[] = array(
                    $p->name,
                    '<a href="' . $this->createUrl("dictionary/CategoryGroupList/id/{$p->id}") . '" class="btn btn-xs green default">子分类</a>' .
                    '<a rel="' . $this->createUrl("dictionary/CategoryDelete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i>删除</a>' .
                    '<a href="' . $this->createUrl("dictionary/CategoryUpdate/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
                );
            }
            $recordsFiltered = $total = (int)ServiceDictionaryCategoryModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('categoryList');
        }
    }
    //添加分类
    public function actionCategoryAdd()
    {
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $redirect = array("dictionary/CategoryGroupList/id/" . $pid);
        } else {
            $pid = 0;
            $redirect = array("dictionary/CategoryList");
        }
        $model = new ServiceDictionaryCategoryModel();
        if (isset($_POST['ServiceDictionaryCategoryModel'])) {
            $category = ServiceDictionaryCategoryModel::model()->find('name=:name', array(':name' => $_POST['ServiceDictionaryCategoryModel']['name']));
            if ($category) {
                $this->showError("分类名称已存在");
            }
            $model->attributes = $_POST['ServiceDictionaryCategoryModel'];
            if ($model->save()) {
                $this->redirect($redirect);
            }
        }
        $model->pid = $pid;
        $this->render('categoryAdd', array('model' => $model));
    }

    //更新分类
    public function actionCategoryUpdate($id)
    {
        $model = $this->CategoryloadModel($id);
        if (isset($_POST['ServiceDictionaryCategoryModel'])) {
            $model->attributes = $_POST['ServiceDictionaryCategoryModel'];
            if ($model->save()) {
                if ($model->attributes['pid'] != 0) {
                    $redirect = array("dictionary/CategoryGroupList/id/" . $model->attributes['pid']);
                } else {
                    $redirect = array("dictionary/CategoryList");
                }
                $this->redirect($redirect);
            }
        }
        $this->render("categoryUpdate", array('model' => $model));
    }

    //删除分类
    public function actionCategoryDelete($id)
    {
        if ($this->CategoryloadModel($id)->delete()) {
            ServiceDictionaryCategoryModel::model()->deleteAll('pid=:id', array(':id' => $id));
            ServiceDictionaryModel::model()->deleteAll('category_id=:id', array(':id' => $id));
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }
    }

    public function CategoryloadModel($id)
    {
        $model = ServiceDictionaryCategoryModel::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    //子分类列表
    public function actionCategoryGroupList($id)
    {
        if ($_POST) {
            $product = array();
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('pid' => $id));
            $criteria->order = "t.id desc";
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('ServiceDictionaryCategoryModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));

            $products = $dataProvider->getData();
            foreach ($products as $p) {
                $product[] = array(
                    $p->name,
                    '<a rel="' . $this->createUrl("dictionary/CategoryDelete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i>删除</a>' .
                    '<a href="' . $this->createUrl("dictionary/CategoryUpdate/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
                );
            }
            $recordsFiltered = $total = (int)ServiceDictionaryCategoryModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, 'pid' => 1));
        } else {
            $this->render('categoryGroupList', array('id' => $id));
        }
    }

}