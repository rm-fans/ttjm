<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/20
 * Time: 17:49
 */
class BuyProcessForm extends CFormModel
{
    public $is_effect;
    public $buy_process_template_id;
    public $name;
    public $number;
    public $pc_content;
    public $wap_content;
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('is_effect,buy_process_template_id,number', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>150),
            array('pc_content,wap_content', 'safe'),
        );
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => '模板标题',
            'is_effect' => '是否有效',
            'buy_process_template_id' => 'Project Buy Process',
            'name' => '标题',
            'pc_content' => 'PC 内容',
            'wap_content' => 'WAP 内容',
        );
    }
    public function save($model)
    {
        if($model)
        {
            $m = new $model;
        }else{
            $m = new ProjectBuyProcessTemplateModel;
        }

        $m->name = $this->name;
        $m->is_effect = $this->is_effect;
        $m->save();
    }
}