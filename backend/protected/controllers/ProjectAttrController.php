<?php

class ProjectAttrController extends LoginedController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','attribute'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('add','update','addAttr','updateAttr'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * project category lists
	 */
	public function actionIndex()
	{
	    if($_POST){
	        $start = Yii::app()->request->getParam('start');
	        $pageSize = Yii::app()->request->getParam('length',15);
	        $page = $start / $pageSize;
	        
	        $criteria = new CDbCriteria;
	        
	        $dataProvider = new CActiveDataProvider('ProjectCategoryModel',array(
	            'criteria'=>$criteria,
	            'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                ),
	        ));
	        
	        $types = $dataProvider->getData();
	        
	        $datas = array();
	        
	        foreach ($types as $type) {
	            $btn = '<a href="'.$this->createUrl("projectAttr/attribute/id/{$type->id}").'" class="btn btn-xs green">属性列表</a>';
	            $btn .= '<a href="'.$this->createUrl("projectAttr/update/id/{$type->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>修改</a>';
	            //$btn .= $type->is_effect == 1 ? '<a rel="'.$this->createUrl("projectAttr/delete/id/{$type->id}") . '" class="btn btn-xs red default bootbox-confirm"><i class="fa fa-times"></i>删除</a>' : '';
	            
	            $datas[] = array(
                    $type->id,
                    $type->name,
                    $type->is_effect == 1 ? '是' : '否',
                    $btn
	            );
	        }
	        
	        $recordsFiltered = $total =  (int)ProjectCategoryModel::model()->count($criteria);
	        
	        echo json_encode(array('data' => $datas, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
	    }else{
    	    $this->render('index');
	    }
	}
	
	/**
	 * add project category
	 */
	public function actionAdd()
	{
	    if(isset($_POST['ProjectCategoryModel'])){
	        $model = new ProjectCategoryModel('add');
	        
	        $model->sort = 0;
	        $model->name = $_POST['ProjectCategoryModel']['name'];
	        $model->is_effect = isset($_POST['ProjectCategoryModel']['is_effect']) && $_POST['ProjectCategoryModel']['is_effect'] ? 1 : 0;
	        
	        if($model->validate()){
	            if($model->save()){
	                $this->showSuccess('添加成功',$this->createUrl('projectAttr/index'),1);
	            }else{
	                $this->showError('添加失败，请重试',$this->createUrl('projectAttr/index'));
	            }
	        }else{
    	        $this->render('add',array('model'=>$model));
    	        exit;
	        }
	    }
	    
	    $model = new ProjectCategoryModel();
	    $this->render('add',array('model'=>$model));
	}
	
	/**
	 * update project category
	 */
	public function actionUpdate($id)
	{
	    $model = ProjectCategoryModel::model()->findByPk($id);
	    
	    if(isset($_POST['ProjectCategoryModel'])){
	        $model->name = $_POST['ProjectCategoryModel']['name'];
	        $model->is_effect = isset($_POST['ProjectCategoryModel']['is_effect']) && $_POST['ProjectCategoryModel']['is_effect'] ? 1 : 0;
	        $temp = ProjectCategoryModel::model()->findByAttributes(array('name'=>$model->name),'id!=:id',array(':id'=>$id));
	        if($temp){
	            $model->addError('name','资产类别已存在');
	            $this->render('update',array('model'=>$model));
	            exit;
	        }else{
	            if($model->save()){
	                $this->showSuccess('修改成功',$this->createUrl('projectAttr/index'),1);
	            }else{
	                $this->showError('修改失败，请重试',$this->createUrl('projectAttr/index'));
	            }
	        }
	    }
	    $this->render('update',array('model'=>$model));
	}
	
	/**
	 * 资产类别下的附属信息
	 */
	public function actionAttribute($id)
	{
	    $model = ProjectCategoryModel::model()->findByPk($id);
	    if($_POST){
	        $start = Yii::app()->request->getParam('start');
	        $pageSize = Yii::app()->request->getParam('length',15);
	        $page = $start / $pageSize;
	         
	        $criteria = new CDbCriteria;
	        $criteria->addColumnCondition(array('cat_id'=>$id));
	        
	        $dataProvider = new CActiveDataProvider('AttributeModel',array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                    'currentPage'=>$page,
                ),
	        ));
	         
	        $attrs = $dataProvider->getData();
	        
	        $datas = array();
	         
	        foreach ($attrs as $attr) {
	            $btn = '<a href="'.$this->createUrl("projectAttr/updateAttr/id/{$attr->id}") . '" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i>修改</a>';
	             
	            $datas[] = array(
	                    $attr->id,
	                    $attr->name,
	                    $attr->values,
	                    AttributeModel::$input_types[$attr->input_type],
	                    $attr->sort,
	                    $attr->is_effect == 1 ? '是' : '否',
	                    $btn
	            );
	        }
	         
	        $recordsFiltered = $total =  (int)AttributeModel::model()->count($criteria);
	        
	        echo json_encode(array('data' => $datas, 'recordsTotal' => $total, 'recordsFiltered' => $recordsFiltered));
	    }else{
	        $this->render('attr_list',array('model'=>$model));
	    }
	}

    /**
     * 添加资产类别下的附属信息
     */
	public function actionAddAttr($id)
	{
	    $cate = ProjectCategoryModel::model()->findByPk($id);
	    $model = new AttributeModel();
	    
	    if(isset($_POST['attributeModel'])){
	        $temp_atrrs = $_POST['attributeModel'];
	        $model->attributes = $temp_atrrs;
            $obj = AttributeModel::model()->findByAttributes(array('name'=>$temp_atrrs['name'],'cat_id'=>$id));
	        if($obj){
	            $model->addError('name', '属性名称已存在');
	            $this->render('attr_add',array('model'=>$model,'category'=>$cate));
	            exit;
	        }
	        
	        if(in_array($temp_atrrs['input_type'], AttributeModel::$need_values)){
	            if(!$temp_atrrs['values'] || !AttributeModel::checkValue($temp_atrrs['values'])){
	                $model->addError('values', '缺失属性值或者格式错误，请参考说明');
	                $this->render('attr_add',array('model'=>$model,'category'=>$cate));
	                exit;
	            }
	        }else{
	            $model->values = '';
	        }
	        
	        $model->cat_id = $id;
	        $model->sort = isset($temp_atrrs['sort']) && $temp_atrrs['sort'] ? $temp_atrrs['sort'] : 0;;
	        $model->is_effect = isset($temp_atrrs['is_effect']) && $temp_atrrs['is_effect'] ? 1 : 0;
	         
	        if($model->validate()){
	            if($model->save()){
	                $this->showSuccess('添加成功',$this->createUrl('projectAttr/addAttr',array('id'=>$id)),2);
	            }else{
	                $this->showError('添加失败，请重试',$this->createUrl('projectAttr/addAttr',array('id'=>$id)));
	            }
	        }
	    }
	    
	    $this->render('attr_add',array('model'=>$model,'category'=>$cate));
	}
	
	/**
	 * 修改资产类别下的附属信息
	 */
	public function actionUpdateAttr($id)
	{
	    $model = AttributeModel::model()->findByPk($id);
	    $cate = ProjectCategoryModel::model()->findByPk($model->cat_id);
	     
	    if(isset($_POST['attributeModel'])){
	        /**
	         * 如果项目已有此属性，部分信息不允许修改
	         */
	        $old_attrs = $model->attributes;
	        
	        $temp_atrrs = $_POST['attributeModel'];
	        $model->attributes = $temp_atrrs;
	        
	        $p_attr = AttributeModel::model()->findByAttributes(array('id'=>$id));

	        if($p_attr){
	            //属性名称
	            if($old_attrs['name'] != $temp_atrrs['name']){
	                $this->showError('已有项目包含此属性，属性名称不能修改',$this->createUrl('projectAttr/updateAttr',array('id'=>$id)));
	            }
	            //输入类型 : 文本不能改成选择框，反之亦然
	            if(in_array($temp_atrrs['input_type'], AttributeModel::$need_values) && !in_array($old_attrs['input_type'], AttributeModel::$need_values)){
	                $this->showError('已有项目包含此属性，输入类型不能由文本框改变成选择框',$this->createUrl('projectAttr/updateAttr',array('id'=>$id)));
	            }
	            
	            if(!in_array($temp_atrrs['input_type'], AttributeModel::$need_values) && in_array($old_attrs['input_type'], AttributeModel::$need_values)){
	                $this->showError('已有项目包含此属性，输入类型不能由选择框改变成文本框',$this->createUrl('projectAttr/updateAttr',array('id'=>$id)));
	            }
	            //删除
	            if(!isset($temp_atrrs['is_effect']) || !$temp_atrrs['is_effect']){
	                $this->showError('已有项目包含此属性，属性不能置为无效',$this->createUrl('projectAttr/updateAttr',array('id'=>$id)));
	            }
	        }
	        
	        
            $obj = AttributeModel::model()->findByAttributes(array('name'=>$temp_atrrs['name'],'cat_id'=>$model->cat_id),'id!=:id',array(':id'=>$id));
	        if($obj){
	            $model->addError('name', '属性名称已存在');
	            $this->render('attr_update',array('model'=>$model,'category'=>$cate));
	            exit;
	        }
	        
	        if(in_array($temp_atrrs['input_type'], AttributeModel::$need_values)){
	            if(!$temp_atrrs['values'] || !AttributeModel::checkValue($temp_atrrs['values'])){
	                $model->addError('values', '缺失属性值或者格式错误，请参考说明');
	                $this->render('attr_update',array('model'=>$model,'category'=>$cate));
	                exit;
	            }
	        }else{
	            $model->values = '';
	        }
	        
	        $model->sort = isset($temp_atrrs['sort']) && $temp_atrrs['sort'] ? $temp_atrrs['sort'] : 0;;
	        $model->is_effect = isset($temp_atrrs['is_effect']) && $temp_atrrs['is_effect'] ? 1 : 0;
			$model->values = isset($temp_atrrs['values']) && $temp_atrrs['values'] ? $temp_atrrs['values'] : '';
	        if($model->validate()){
	            if($model->save()){
	                $this->showSuccess('修改成功',$this->createUrl('projectAttr/updateAttr',array('id'=>$id)),2);
	            }else{
	                $this->showError('修改失败，请重试',$this->createUrl('projectAttr/updateAttr',array('id'=>$id)));
	            }
	        }
	    }
	     
	    $this->render('attr_update',array('model'=>$model,'category'=>$cate));
	}
}
