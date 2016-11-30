<?php

/**
 * Created by JetBrains PhpStorm.
 * User: home
 * Date: 15-8-1
 * Time: 下午4:34
 * To change this template use File | Settings | File Templates.
 */
class ArticleController extends LoginedController
{
    //分类列表
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

            $dataProvider = new CActiveDataProvider('ArticleCategoryModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));

            $products = $dataProvider->getData();
            foreach ($products as $p) {
                switch ($p->type_id) {
                    case 0:
                        $p->type_id = '普通文章';
                        break;
                    case 1:
                        $p->type_id = '帮助文章';
                        break;
                    case 2:
                        $p->type_id = '公告文章';
                        break;
                    case 3:
                        $p->type_id = '系统文章';
                        break;
                }
                $product[] = array(
                    $p->title,
                    $p->brief,
                    $p->is_effect ? "是" : "否",
                    $p->type_id,
                    $p->sort,
                    '<a href="' . $this->createUrl("article/CategoryGroupList/id/{$p->id}") . '" class="btn btn-xs green default">子分类</a>' .
                    '<a rel="' . $this->createUrl("article/CategoryDelete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i>删除</a>' .
                    '<a href="' . $this->createUrl("article/CategoryUpdata/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
                );
            }
            $recordsFiltered = $total = (int)ArticleCategoryModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('categoryList');
        }
    }

    //单页面
    public function actionSignal()
    {
        if ($_POST) {
            $product = array();
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $page = $start / $pageSize;

            $criteria = new CDbCriteria;
            $criteria->addInCondition('id',ArticleModel::$signalPage);
            $criteria->order = "t.id desc";
            $countCriteria = $criteria;

            $dataProvider = new CActiveDataProvider('ArticleModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));

            $products = $dataProvider->getData();
            foreach ($products as $p) {
                $_cate=ArticleCategoryModel::model()->find('id=:id',array(':id'=>$p->cate_id));
                switch ($_cate['type_id']) {
                    case 0:
                        $p->cate_id = '普通文章';
                        break;
                }
                $product[] = array(
                    $p->title,
                    $p->cate_id,
                    $p->sort,
                    '<a href="' . $this->createUrl("article/update/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
                );
            }
            $recordsFiltered = $total = (int)ArticleModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('signal');
        }
    }
    //添加分类
    public function actionCategoryAdd()
    {
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $redirect = array("article/CategoryGroupList/id/" . $pid);
        } else {
            $pid = 0;
            $redirect = array("article/CategoryList");
        }
        $model = new ArticleCategoryModel();
        if (isset($_POST['ArticleCategoryModel'])) {
            $category = ArticleCategoryModel::model()->find('title=:title', array(':title' => $_POST['ArticleCategoryModel']['title']));
            if ($category) {
                $this->showError("分类名称已存在");
            }

            $model->attributes = $_POST['ArticleCategoryModel'];
            $model->type_id = $_POST['type_id'];
            if ($model->save()) {
                $this->redirect($redirect);
            }
        }
        $model->pid = $pid;
        $this->render('categoryAdd', array('model' => $model));
    }

    //更新分类
    public function actionCategoryUpdata($id)
    {
        $model = $this->CategoryloadModel($id);
        if (isset($_POST['ArticleCategoryModel'])) {
            $model->attributes = $_POST['ArticleCategoryModel'];
            $model->type_id = $_POST['type_id'];
            if ($model->save()) {
                if ($model->attributes['pid'] != 0) {
                    $redirect = array("article/CategoryGroupList/id/" . $model->attributes['pid']);
                } else {
                    $redirect = array("article/CategoryList");
                }
                $this->redirect($redirect);
            }
        }
        $this->render("categoryUpdata", array('model' => $model));
    }

    //删除分类
    public function actionCategoryDelete($id)
    {
        if ($this->CategoryloadModel($id)->delete()) {
            ArticleCategoryModel::model()->deleteAll('pid=:id', array(':id' => $id));
            ArticleModel::model()->deleteAll('cate_id=:id', array(':id' => $id));
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }
    }

    public function CategoryloadModel($id)
    {
        $model = ArticleCategoryModel::model()->findByPk($id);
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

            $dataProvider = new CActiveDataProvider('ArticleCategoryModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));

            $products = $dataProvider->getData();
            foreach ($products as $p) {
                switch ($p->type_id) {
                    case 0:
                        $p->type_id = '普通文章';
                        break;
                    case 1:
                        $p->type_id = '帮助文章';
                        break;
                    case 2:
                        $p->type_id = '公告文章';
                        break;
                    case 3:
                        $p->type_id = '系统文章';
                        break;
                }
                $product[] = array(
                    $p->title,
                    $p->brief,
                    $p->is_effect ? "是" : "否",
                    $p->type_id,
                    $p->sort,
                    '<a rel="' . $this->createUrl("article/CategoryDelete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i>删除</a>' .
                    '<a href="' . $this->createUrl("article/CategoryUpdata/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
                );
            }
            $recordsFiltered = $total = (int)ArticleCategoryModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, 'pid' => 1));
        } else {
            $this->render('categoryGroupList', array('id' => $id));
        }
    }

    //文章列表
    public function actionList()
    {
        if ($_POST) {
            $product = array();
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $title = Yii::app()->request->getParam('title');

            $page = $start / $pageSize;

            $criteria = new CDbCriteria;
            if ($title) {
                $criteria->addSearchCondition('t.title', $title);
            }
            $criteria->addNotInCondition('t.id',ArticleModel::$signalPage);
            $criteria->with = 'addAdmin';
            $criteria->with = 'category';
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('ArticleModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $p) {
                $product[] = array(
                    $p->title,
                    $p->category->title,
                    $p->summary,
                    isset($p->addAdmin->username)?$p->addAdmin->username:'',
                    date("Y-m-d H:i", $p->created_at),
                    isset($p->click_count)?$p->click_count:'',
                    $p->is_effect ? "是" : "否",
                    $p->is_top ? "是" : "否",
                    '<a rel="' . $this->createUrl("article/Delete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i>删除</a>' .
                    '<a href="' . $this->createUrl("article/Update/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
                );
//                var_dump($product);exit;
            }
            $recordsFiltered = $total = (int)ArticleModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('list');
        }
    }

    //添加文章
    public function actionadd()
    {
        $model = new ArticleModel();
        $category = ArticleCategoryModel::DropDownList();
        if (isset($_POST['ArticleModel'])) {
            $data = $_POST['ArticleModel'];
            $data['cate_id'] = $_POST['cate_id'];
            if (isset($_POST['content']))
                $data['content'] = $_POST['content'];
            else
                $this->showError('内容不能为空');

            $data['created_at'] = isset($data['created_at'])?strtotime($data['created_at']):time();
            $data['add_admin_id'] = Yii::app()->user->id;
            $data['image'] = $_POST['image']['image'];
            $data['wap_image'] = $_POST['image']['wap_image'];

            $model->attributes = $data;
            if ($model->save()) {
                $this->redirect(array("article/list"));
            }
        }
        $this->render('add', array('model' => $model, 'category' => $category));
    }

    //更新文章
    public function actionUpdate($id)
    {
        $model = $this->ArticleloadModel($id);
        $category = ArticleCategoryModel::model()->findAll();
        if (isset($_POST['ArticleModel'])) {
            $data = $_POST['ArticleModel'];
            $data['cate_id'] = $_POST['cate_id'];
            if (isset($_POST['content']))
                $data['content'] = $_POST['content'];
            else
                $this->showError('内容不能为空');

            $data['created_at'] = isset($data['created_at'])?strtotime($data['created_at']):time();
            $data['update_admin_id'] = Yii::app()->user->id;
            $data['image'] = $_POST['image']['image'];
            $data['wap_image'] = $_POST['image']['wap_image'];
            $model->attributes = $data;

            if ($model->save()) {
                $this->redirect(array("article/list"));
            }
        }
        $this->render("update", array('model' => $model, 'category' => $category));
    }

    /**
     * 合作伙伴列表
     */
    public function actionTeam()
    {
        if ($_POST) {
            $product = array();
            //得到服务商的名称及是否为服有服务商机构
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $title = Yii::app()->request->getParam('title');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            if ($title) {
                $criteria->addSearchCondition('t.title', $title);
            }
            $criteria->with = 'addAdmin';
            $criteria->with = 'category';
            $criteria->addCondition('t.cate_id=6 and t.is_effect=1');
            $criteria->order = 't.sort desc';
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('ArticleModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $p) {
                $product[] = array(
                    $p->title,
                    $p->category->title,
                    isset($p->addAdmin->username)?$p->addAdmin->username:'',
                    $p->is_effect ? "是" : "否",
                    $p->sort ,
                    '<a rel="' . $this->createUrl("article/teamDel/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i>删除</a>' .
                    '<a href="' . $this->createUrl("article/teamUp/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
                );
            }
            $recordsFiltered = $total = (int)ArticleModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('team');
        }
    }
    /**
     * 添加合作伙伴
     */
    public function actionTeamAdd(){
        $model=new ArticleModel();
        if(isset($_POST['ArticleModel'])){
            $data = $_POST['ArticleModel'];
            $model->content='合作伙伴';
            $model->cate_id=6;
            $model->add_admin_id= Yii::app()->user->id;
            $model->summary=$model->content;
            $model->is_hot='0';
            $model->created_at= time();
            $model->sort=$data['sort'];
            $model->title=$data['title'];
            $model->is_effect=$data['is_effect'];
            $model->image=$_POST['image']['image'];
            if($model->save()){
                $this->showSuccess('添加成功', $this->createUrl('article/team'));
            }
        }
        $result=array(
            'model'=>$model,
        );
        $this->render('team_add',array('result'=>$result));
    }

    /**
     * 编辑合作伙伴
     */
    public function actionTeamUp($id){
        $model = ArticleModel::model()->find('id=:id', array(':id' => $id));
        if(isset($_POST['ArticleModel'])){
            $data = $_POST['ArticleModel'];
            $model->content=$data['title'];
            $model->cate_id=6;
            $model->summary=$data['title'];
            $model->created_at= time();
            $model->is_hot='0';
            $model->sort=isset($data['sort'])?$data['sort']:'';
            $model->title=$data['title'];
            $model->is_effect=isset($data['is_effect'])?$data['is_effect']:1;
            $model->image=$_POST['image']['image'];
            if($model->save()){
                $this->showSuccess('编辑成功', $this->createUrl('article/team'));
            }
        }
        $result=array(
            'model'=>$model,
        );
        $this->render('team_update',array('result'=>$result));
        }

    /**
     * 删除合作伙伴
     */
    public function actionTeamDel($id){
        $org_del=ArticleModel::model()->deleteAll('id=:id',array(':id'=>$id));
        if ($org_del) {
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }
    }

    /**
     * 关于我们
     */
    public function actionAbout(){
        if ($_POST) {
            $product = array();
            //得到服务商的名称及是否为服有服务商机构
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $title = Yii::app()->request->getParam('title');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            if ($title) {
                $criteria->addSearchCondition('t.title', $title);
            }
            $criteria->with = 'addAdmin';
            $criteria->with = 'category';
            $criteria->addCondition('t.cate_id=16 and t.is_effect=1');
            $criteria->order = 't.sort desc';
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('ArticleModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $p) {
                $product[] = array(
                    $p->title,
                    $p->category->title,
                    isset($p->addAdmin->username)?$p->addAdmin->username:'',
                    $p->is_effect ? "是" : "否",
                    $p->sort ,
                    '<a rel="' . $this->createUrl("article/aboutDel/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i>删除</a>' .
                    '<a href="' . $this->createUrl("article/aboutUp/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil">修改</i></a>'
                );
            }
            $recordsFiltered = $total = (int)ArticleModel::model()->count($countCriteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('about');
        }
    }
    /**
    * 添加关于我们
    */
    public function actionAboutAdd(){
        $model=new ArticleModel();
        $category = ArticleCategoryModel::AboutDownList();
        if(isset($_POST['ArticleModel'])){
            $data = $_POST['ArticleModel'];
            $model->content='关于我们';
            $model->cate_id=$_POST['cate_id'];
            $model->summary=$model->content;
            $model->is_hot='0';
            $model->created_at= time();
            $model->add_admin_id= Yii::app()->user->id;
            $model->sort=$data['sort'];
            $model->title=$data['title'];
            $model->is_effect=$data['is_effect'];
            isset($_POST['content'])?$model->content = $_POST['content']:'';
            if($model->save()){
                $this->showSuccess('添加成功', $this->createUrl('article/about'));
            }
        }
        $result=array(
            'model'=>$model,
            'category'=>$category,
        );
        $this->render('about_add',array('result'=>$result));
    }

    /**
     * 编辑关于我们
     */
    public function actionAboutUp($id){
        $category = ArticleCategoryModel::AboutDownList();
        $model = ArticleModel::model()->find('id=:id', array(':id' => $id));
        if(isset($_POST['ArticleModel'])){
            $data = $_POST['ArticleModel'];
//            var_dump($_POST);exit;
            $model->content=$data['title'];
            $model->cate_id= $_POST['cate_id'];
            $model->summary=$data['title'];
            $model->is_hot='0';
            $model->created_at= time();
            $model->sort=isset($data['sort'])?$data['sort']:'';
            $model->title=$data['title'];
            $model->is_effect=isset($data['is_effect'])?$data['is_effect']:1;
            isset($_POST['content'])?$model->content = $_POST['content']:'';
            if($model->save()){
                $this->showSuccess('编辑成功', $this->createUrl('article/about'));
            }
        }
        $result=array(
            'model'=>$model,
            'category'=>$category,
        );
        $this->render('about_update',array('result'=>$result));
    }

    /**
     * 删除关于我们
     */
    public function actionAboutDel($id){
        $org_del=ArticleModel::model()->deleteAll('id=:id',array(':id'=>$id));
        if ($org_del) {
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }
    }

    public function ArticleloadModel($id)
    {

        $model = ArticleModel::model()->findByPk($id);
//        var_dump($model);exit;
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    //删除文章
    public function actionDelete($id)
    {
        if ($this->ArticleloadModel($id)->delete()) {
            ArticleModel::model()->deleteAll('id=:id', array(':id' => $id));
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }
    }
}