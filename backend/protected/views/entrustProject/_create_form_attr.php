<?php foreach ($attribute as $attrs):?>
    <div class="form-group">
        <?php echo CHtml::label($attrs->name, 'ProjectModel_attrs_'.$attrs->id,array('class' => 'col-sm-3 control-label', "for" => "inputText"));?>
        <div class="col-md-8">
            <?php if($attrs->input_type == 1):?>
                <?php echo CHtml::textField('ProjectModel[attrs]['.$attrs->id.']',$self_attrs && isset($self_attrs[$attrs->id]) ? $self_attrs[$attrs->id] : '',array('class' => 'form-control')); ?>
            <?php elseif($attrs->input_type == 2):?>
                <?php echo CHtml::textArea('ProjectModel[attrs]['.$attrs->id.']',$self_attrs && isset($self_attrs[$attrs->id]) ? $self_attrs[$attrs->id] : '',array('class' => 'form-control','rows'=>4,'style'=>'resize:none;')); ?>
            <?php elseif($attrs->input_type == 3):?>
                <?php
                $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                    array(
                        'id'=>'article_content'.$attrs->id,//容器的id 唯一的[必须配置]
                        'name'=>'ProjectModel[attrs]['.$attrs->id.']',//post到后台接收的name [必须配置]
                        'content'=>$self_attrs && isset($self_attrs[$attrs->id]) ? $self_attrs[$attrs->id] : '',//初始化内容 [可选的]
                        'type'=>'textarea',
                        //配置选项，[可选的]
                        //将ueditor的配置项以数组键值对的方式传入,具体查看ueditor.config.js
                        //不要配置serverUrl(即使配置也会被覆盖)程序会自动处理后端url
                        'config'=>array(
                            // 'toolbars'=>array(array('fullscreen', 'source', '|')),//toolbars注意是嵌套两个数组
                            'lang'=>'zh-cn'
                        )
                    )
                );
                ?>
            <?php elseif($attrs->input_type == 4):?>
                <?php echo CHtml::radioButtonList('ProjectModel[attrs]['.$attrs->id.']',$self_attrs && isset($self_attrs[$attrs->id]) ? $self_attrs[$attrs->id] : '',AttributeModel::parseValue($attrs->values),array('class' => 'form-control')); ?>
            <?php elseif($attrs->input_type == 5):?>
                <?php echo CHtml::checkBoxList('ProjectModel[attrs]['.$attrs->id.']',$self_attrs && isset($self_attrs[$attrs->id]) ? explode(',', $self_attrs[$attrs->id]) : '',AttributeModel::parseValue($attrs->values),array('class' => 'form-control')); ?>
            <?php elseif($attrs->input_type == 6):?>
                <?php echo CHtml::dropDownList('ProjectModel[attrs]['.$attrs->id.']',$self_attrs && isset($self_attrs[$attrs->id]) ? $self_attrs[$attrs->id] : '',AttributeModel::parseValue($attrs->values),array('class' => 'form-control', 'empty' => '请选择')); ?>
            <?php elseif($attrs->input_type == 7):?>
                <?php
                $this->widget('application.extensions.baiduUeditor.UeditorWidget',
                    array(
                        'id'=>'ProjectModel_attrs_'.$attrs->id,//容器的id 唯一的[必须配置]
                        'name'=>'ProjectModel[attrs]['.$attrs->id.']',//post到后台接收的name [必须配置]
                        'titleName'=>'file[title]',
                        'inputId'=>$attrs->id,//post到后台接收的input ID [file image 时必须配置]
                        'content'=>$self_attrs && isset($self_attrs[$attrs->id]) ? $self_attrs[$attrs->id] : '',//初始化内容 [可选的]
                        'type'=>'file',
                        'class'=>'form-control',
                        'btnClass'=>'btn blue',
                        'config'=>array(
                            'lang'=>'zh-cn'
                        )
                    )
                );
                ?>
            <?php endif;?>
        </div>
    </div>
<?php endforeach;?>