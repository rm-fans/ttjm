<?php
$this->breadcrumbs=array(
    array('name'=>'资产属性管理'),
    array('name'=>'资产类别','url' => array('projectAttr/index')),
    array('name' => $category->name,'url' => array('projectAttr/attribute/id/'.$category->id)),
    array('name'=>'属性添加'),
);
$this->title = '资产属性管理 ';
?>
<?php echo $this->renderPartial('_attr_form',array('model'=>$model,'action'=>'add'));?>
