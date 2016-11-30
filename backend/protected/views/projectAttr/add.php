<?php
$this->breadcrumbs=array(
    array('name'=>'资产属性管理'),
    array('name'=>'资产类别','url' => array('projectAttr/index')),
    array('name'=>'类别添加')
);
$this->title = '资产属性管理 ';
?>
<?php echo $this->renderPartial('_form',array('model'=>$model));?>
