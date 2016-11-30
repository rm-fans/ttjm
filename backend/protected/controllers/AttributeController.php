<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/19
 * Time: 16:15
 */
class AttributeController extends LoginedController
{
    public function actionCreate()
    {
        $model=new AttributeModel;

        // uncomment the following code to enable ajax-based validation
        /*
        if(isset($_POST['ajax']) && $_POST['ajax']==='attribute-model-attributeCreate-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        */

        if(isset($_POST['AttributeModel']))
        {
            $model->attributes=$_POST['AttributeModel'];
            if($model->validate())
            {
                // form inputs are valid, do something here
                return;
            }
        }
        $category = ProjectCategoryModel::getIdToName();
        $this->render('create',array('model'=>$model,'category'=>$category));
    }
}