<?php
/**
 * 购买流程模板
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/20
 * Time: 17:04
 */
class BuyProcessController extends LoginedController
{
    public function actionIndex()
    {
        if($_POST)
        {
            $start=Yii::app()->request->getParam('start');
            $pageSize=Yii::app()->request->getParam('length',10);
            $page=$start / $pageSize;
            $criteria=new CDbCriteria;
            $dataProvider=new CActiveDataProvider('ProjectBuyProcessTemplateModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                )) );
            $products=$dataProvider->getData();
            foreach ($products as $p) {
                $num = ProjectModel::model()->count("buy_process_template_id=".$p->id);
                $updateButton = '<a href="'.$this->createUrl("buyProcess/detail/id/{$p->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>编辑</a>';
                $product[] = array(
                    $p['name'],
                    $num,
                    $updateButton
                );
            }
            $recordsFiltered=$total = (int)ProjectBuyProcessTemplateModel::model()->count($criteria);
            echo json_encode(array('data' => $product, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered, ));
            exit;
        }
        //$result = ProjectBuyProcessTemplateModel::model()->findAll();
        $this->render('index',array('result'=>array()));
    }

    /**
     * 添加模板
     */
    public function actionCreate()
    {
        $form_model = new BuyProcessForm;
        if(isset($_POST['BuyProcessForm']))
        {
            $form = $_POST['BuyProcessForm'];
            $form_model->attributes = $form;
            $form_model->name = $form['name'];
            $form_model->is_effect = isset($form['is_effect'][0]) ? $form['is_effect'][0]:0;

            if($form_model->validate())
            {
                $m = new ProjectBuyProcessTemplateModel();
                $m->name = $form_model->name;
                $m->is_effect = $form_model->is_effect;
                if( $m->save())
                {
                    if(!empty($form['pc_content']) || !empty($form['wap_content'])){
                        $pc_num = count($form['pc_content']);
                        $wap_num = count($form['wap_content']);
                        $num = $pc_num>$wap_num ? $pc_num:$wap_num;
                        ProjectBuyProcessTemplateFieldModel::model()->deleteAllByAttributes(array('buy_process_template_id'=>$m->id));
                        for($i=0;$i<$num;$i++)
                        {
                            $field = new ProjectBuyProcessTemplateFieldModel();
                            $field->buy_process_template_id = $m->id;
                            $field->name = $m->name;
                            $field->type = ProjectBuyProcessTemplateFieldModel::TYPE_IMAGE;
                            $field->pc_content = isset($form['pc_content'][$i]) ? $form['pc_content'][$i]:'';
                            $field->wap_content = isset($form['wap_content'][$i]) ? $form['wap_content'][$i]:'';
                            $field->sort = $i+1;
                            $field->save();
                        }
                    }
                    $this->showSuccess('添加成功', $this->createUrl('buyProcess/index'));
                }
            }
        }
        $images = array("pc"=>array(),"wap"=>array());
        $this->render('create',array("images"=>$images,'result'=>array( 'model'=> $form_model,"number"=>0)));

    }

    /**
     * 模板详情
     */
    public function actionDetail($id)
    {
        $buyProcess = ProjectBuyProcessTemplateModel::model()->findByPk($id);
        $form_model = new BuyProcessForm;
        if(isset($_POST['BuyProcessForm']))
        {
            $form = $_POST['BuyProcessForm'];
            $form_model->attributes = $form;
            $form_model->name = $form['name'];
            $form_model->is_effect = isset($form['is_effect'][0]) ? $form['is_effect'][0]:0;
            if($form_model->validate())
            {
                $buyProcess->name = $form_model->name;
                $buyProcess->is_effect = $form_model->is_effect;
                if( $buyProcess->save())
                {
                    if(!empty($form['pc_content']) || !empty($form['wap_content'])){
                        $pc_num = count($form['pc_content']);
                        $wap_num = count($form['wap_content']);
                        $num = $pc_num>$wap_num ? $pc_num:$wap_num;
                        ProjectBuyProcessTemplateFieldModel::model()->deleteAllByAttributes(array('buy_process_template_id'=>$buyProcess->id));
                        for($i=0;$i<$num;$i++)
                        {
                            $field = new ProjectBuyProcessTemplateFieldModel();
                            $field->buy_process_template_id = $buyProcess->id;
                            $field->name = $buyProcess->name;
                            $field->type = ProjectBuyProcessTemplateFieldModel::TYPE_IMAGE;
                            $field->pc_content = isset($form['pc_content'][$i]) ? $form['pc_content'][$i]:'';
                            $field->wap_content = isset($form['wap_content'][$i]) ? $form['wap_content'][$i]:'';
                            $field->sort = $i+1;
                            $field->save();
                        }
                    }
                    $this->showSuccess('添加成功', $this->createUrl('buyProcess/index'));
                }
            }
        }
        $img = ProjectBuyProcessTemplateFieldModel::model()->findAll("buy_process_template_id=:id and type=:type",
            array(
                ":id"=>$buyProcess->id,
                ":type"=>ProjectBuyProcessTemplateFieldModel::TYPE_IMAGE
            )
        );

        $images = array("pc"=>array(),"wap"=>array());
        foreach($img as $obj)
        {
            if(!empty($obj->pc_content)){
                $images["pc"][] = array("src"=>$obj->pc_content);
            }
            if(!empty($obj->wap_content))
            {
                $images["wap"][] = array("src"=>$obj->wap_content);
            }

        }
        $number = ProjectModel::model()->count("buy_process_template_id=".$buyProcess->id);
        $this->render('create',array('result'=>array("images"=>$images,"model"=>$form_model, 'info'=> $buyProcess,"number"=>$number)));
    }
}