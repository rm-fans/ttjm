<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/18
 * Time: 10:16
 */
class CommentController extends LoginedController
{
    /**
     *律师评论汇总
     */
    public function ActionServiceComment()
    {
        if ($_POST) {
            $service = array();
            //得到服务商的名称及是否为服有服务商机构
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
//            $by_username = Yii::app()->request->getParam('by_username');
            $username = Yii::app()->request->getParam('username');
            $content = Yii::app()->request->getParam('content');
            $is_top = Yii::app()->request->getParam('is_top');
            $status = Yii::app()->request->getParam('status');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
//            if ($by_username) {
//                $criteria->addSearchCondition('t.by_username', $by_username);
//            }
            if ($username) {
                $criteria->addSearchCondition('t.username', $username);
            }
            if ($content) {
                $criteria->addSearchCondition('t.content', $content);
            }
            if ($is_top !== '') {
                $criteria->addCondition("t.is_top= ".$is_top);
            }
            if ($status !== '') {
                $criteria->addCondition("t.status= ".$status);
            }
            $criteria->addCondition('t.status<>-2');
            $criteria->order='t.created_at desc';
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('MarkModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $k => $p) {
                $a_link="<a target='_blank' href='".Yii::app()->params['base_url']."/service/detail/{$p->uid}'>";
                //记录统计
                $service[] = array(
                    date('Y-m-d h:s:i', $p->created_at),
                    $a_link.$p->username."</a>",
                    $p->content,
                    $p->is_top==1 ? '<select onchange="is_top(' . $p->id . ',$(this))" style="width: 80px" name="is_top"><option value="1" selected>是</option><option value="0">否</option></select>' : '<select onchange="is_top(' . $p->id . ',$(this))" style="width: 80px" name="is_top"><option value="1">是</option><option value="0" selected>否</option></select>',
                    $p->status > 0 ? '<select onchange="status(' . $p->id . ',$(this))" style="width: 80px" name="status"><option value="1" selected>通过</option><option value="-1">不通过</option></select>' : '<select onchange="status(' . $p->id . ',$(this))" style="width: 80px" name="status"><option value="1" selected>通过</option><option value="-1" selected>不通过</option></select>',
                    '<a rel="' . $this->createUrl("comment/servicedelete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i> 删除</a>'
                );
            }
            $recordsFiltered = $total = (int)MarkModel::model()->count($countCriteria);
            echo json_encode(array('data' => $service, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, 'e' => $status, 'c' => $is_top));
        } else {
            $audit=ConfModel::model()->find('name=:name',array(':name'=>'service_audit'));
            $this->render('service_lists',array('audit'=>$audit));
        }
    }

    /**
     * 律师ajax的操作
     */
    public function ActionServiceAjax()
    {
        $id = $_POST['id'];
        $model = MarkModel::model()->findByPk($id);
        if (isset($_POST['c'])) {
            $model->is_top = $_POST['c'];
            $model->save();

        }
        if (isset($_POST['s'])) {
            if($_POST['s']==1){
                $detail=UserServiceDetailModel::model()->find('uid=:uid',array(':uid'=>$id));
                $detail->mark_num=$detail->mark_num+1;
            }elseif($_POST['s']==-1){
                $detail=UserServiceDetailModel::model()->find('uid=:uid',array(':uid'=>$id));
                $detail->mark_num=$detail->mark_num-1;
            }
            $model->status = $_POST['s'];
            $model->save();
        }
    }

    /**
     * 律师评论删除
     */

    public function ActionServiceDelete()
    {
        $id = $_GET['id'];
        $model = MarkModel::model()->findByPk($id);
        $model->status = -2;
        if($model->save())
            $this->showJsonResult(1);
        else
            $this->showJsonResult(0);
    }


    /**
     *资产评论汇总
     */
    public function ActionProjectComment()
    {
        if ($_POST) {
            $service = array();
            //得到服务商的名称及是否为服有服务商机构
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $username = Yii::app()->request->getParam('username');
            $project_id = Yii::app()->request->getParam('project_id');
            $content = Yii::app()->request->getParam('content');
            $is_top = Yii::app()->request->getParam('is_top');
            $status = Yii::app()->request->getParam('status');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            if ($project_id) {
                $criteria->addSearchCondition('t.project_id', $project_id);
            }
            if ($username) {
                $criteria->addSearchCondition('t.username', $username);
            }
            if ($content) {
                $criteria->addSearchCondition('t.content', $content);
            }
            if ($is_top !== '') {
                $criteria->addCondition("t.is_top=".$is_top);
            }
            if ($status !== '') {
                $criteria->addCondition("t.status=".$status);
            }
            $criteria->addCondition('t.status<>-2');
            $criteria->order='t.created_at desc';
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('ProjectMarkModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $k => $p) {
                //记录统计
                $a_link="<a target='_blank' href='".Yii::app()->params['base_url']."/project/detail/{$p->project_id}'>";
                $project=ProjectModel::model()->findByPk($p->project_id);
                $service[] = array(
                    date('Y-m-d h:s:i', $p->created_at),
                    $a_link.$project['projectId'].'</a>',
                    $p->username,
                    $p->content,
                    $p->is_top==1 ? '<select onchange="is_top(' . $p->id . ',$(this))" style="width: 80px" name="is_top"><option value="1" selected>是</option><option value="0">否</option></select>' : '<select onchange="is_top(' . $p->id . ',$(this))" style="width: 80px" name="is_top"><option value="1">是</option><option value="0" selected>否</option></select>',
                    $p->status > 0 ? '<select onchange="status(' . $p->id . ',$(this))" style="width: 80px" name="status"><option value="1" selected>通过</option><option value="-1">不通过</option></select>' : '<select onchange="status(' . $p->id . ',$(this))" style="width: 80px" name="status"><option value="1" selected>通过</option><option value="-1" selected>不通过</option></select>',
                    '<a rel="' . $this->createUrl("comment/projectdelete/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i> 删除</a>'
                );
            }
            $recordsFiltered = $total = (int)ProjectMarkModel::model()->count($countCriteria);
            echo json_encode(array('data' => $service, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, 'e' => $status, 'c' => $is_top));
        } else {
            $audit=ConfModel::model()->find('name=:name',array(':name'=>'project_audit'));
            $this->render('project_lists',array('audit'=>$audit));
        }
    }

    /**
     * 资产ajax的操作
     */
    public function ActionProjectAjax()
    {
        $id = $_POST['id'];
        $model = ProjectMarkModel::model()->findByPk($id);
        if (isset($_POST['c'])) {
            $model->is_top = $_POST['c'];
            $model->save();

        }
        if (isset($_POST['s'])) {
            $model->status = $_POST['s'];
            $model->save();
        }
    }

    /**
     * 资产评论删除
     */

    public function ActionProjectDelete()
    {
        $id = $_GET['id'];
        $model = ProjectMarkModel::model()->findByPk($id);
        $model->status = -2;
        if($model->save())
            $this->showJsonResult(1);
        else
            $this->showJsonResult(0);
    }

    /**
     * 关键字管理
     */
    public function ActionKeyword()
    {
        if ($_POST) {
            $service = array();
            //得到服务商的名称及是否为服有服务商机构
            $pageSize = Yii::app()->request->getParam('length', 10);
            $start = Yii::app()->request->getParam('start');
            $find = Yii::app()->request->getParam('find');
            $page = $start / $pageSize;
            $criteria = new CDbCriteria;
            if ($find) {
                $criteria->addSearchCondition('t.find', $find);
            }
            $countCriteria = $criteria;
            $dataProvider = new CActiveDataProvider('SensitiveWordModel', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $page,
                ),
            ));
            $products = $dataProvider->getData();
            foreach ($products as $k => $p) {
                //记录统计
                $service[] = array(
                    $p->id,
                    $p->find,
                    $p->replacement?$p->replacement:'*',
                    '<a rel="' . $this->createUrl("comment/delkey/id/{$p->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i> 删除</a>'
                );
            }
            $recordsFiltered = $total = (int)SensitiveWordModel::model()->count($countCriteria);
            echo json_encode(array('data' => $service, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
        } else {
            $this->render('keyword');
        }
    }

    /*
    *  添加关键字
    */
    public function ActionAddkey()
    {
        $model = new SensitiveWordModel();
        if (isset($_POST['SensitiveWordModel'])) {
            $data = $model->attributes = $_POST['SensitiveWordModel'];
            $model->find = $data['find'];
            $model->replacement = $data['replacement'];
            if ($model->save() ) {
                $keywords = CHtml::listData(SensitiveWordModel::model()->findAll(),'find','replacement');
                SensitiveWords::updateWords($keywords);
                $this->showSuccess('添加成功', $this->createUrl('comment/Keyword'));
            } else {
                $this->error('添加失败');
            }
        }
        $result = array(
            'model' => $model,
        );
        $this->render('create', array('result' => $result));
    }
    /**
     * 删除关键字
     */
    public function ActionDelkey($id){
        if (SensitiveWordModel::model()->deleteByPk($id)) {
            $keywords = CHtml::listData(SensitiveWordModel::model()->findAll(),'replacement','find');
            SensitiveWords::updateWords($keywords);
            $this->showJsonResult(1);
        } else {
            $this->showJsonResult(0);
        }
    }
}