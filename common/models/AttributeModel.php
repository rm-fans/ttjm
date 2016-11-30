<?php

/**
 * This is the model class for table "{{attribute}}".
 *
 * The followings are the available columns in table '{{attribute}}':
 * @property integer $id
 * @property integer $cat_id
 * @property string $name
 * @property integer $input_type
 * @property string $values
 * @property integer $is_effect
 * @property integer $sort
 */
class AttributeModel extends CActiveRecord
{
    //$input_types 请勿随意改动，如有改动请与$need_values 保持一致
    public static $input_types = array(
        1=>'单行文本',
        2=>'多行文本',
        3=>'富文本',
        4=>'单选',
        5=>'多选',
        6=>'下拉框',
        7=>'上传文件',
    );


    //需要属性值的$input_types key
    public static $need_values = array(4,5,6);
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{attribute}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cat_id,input_type, is_effect, sort', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>60),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cat_id, name, input_type, values, is_effect, sort', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'cat_id' => '资产分类ID',
            'name' => '属性名称',
            'input_type' => '输入框类型',
            'values' => '属性值',
            'is_effect' => '是否有效',
            'sort' => '排序',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('cat_id',$this->cat_id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('input_type',$this->input_type);
        $criteria->compare('values',$this->values,true);
        $criteria->compare('is_effect',$this->is_effect);
        $criteria->compare('sort',$this->sort);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return attributeModel the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    //类型为选择框时，检查值格式是否符合
    public static function checkValue($v)
    {
        $result = true;

        $key_vals = explode(',', $v);
        if($key_vals){
            foreach ($key_vals as $val){
                $temp_vals = explode(':', $val);
                if(count($temp_vals) == 2 && is_numeric($temp_vals[0]) && $temp_vals[1]){
                    continue;
                }else{
                    $result = false;
                    break;
                }
            }
        }else{
            $result = false;
        }

        return $result;
    }

    //类型为选择框时，把备选值字符串转换为数组
    public static function parseValue($attr_values)
    {
        $arrs = array();
        $vals = explode(',', $attr_values);
        foreach ($vals as $val){
            $selects = explode(':', $val);
            if(count($selects) == 2 && $selects[0] && $selects[1]){
                $arrs[$selects[0]] = $selects[1];
            }
        }

        return $arrs;
    }

    public static function lists($cat_id=0)
    {
        $where = "is_effect=:is_effect";
        $params = array(":is_effect"=>1);
        if($cat_id)
        {
            $where .= " and cat_id=:cat_id";
            $params[':cat_id'] = $cat_id;
        }
        return AttributeModel::model()->findAll(
            array(
                'order'=>'sort asc',
                'condition'=> $where,
                'params'=> $params,
            )
        );
    }
    public static function objIds($lists)
    {
        $result = array();
        foreach($lists as $obj)
        {
            $result[] = $obj['id'];
        }
        return $result;
    }
    public static function getId($name,$cat_id=0)
    {
        $criteria=new CDbCriteria;
        if($name)
        {
            $criteria->addCondition('name =:name');
            $criteria->params[':name'] = $name;

        }
        if($cat_id)
        {
            $criteria->addCondition('cat_id =:cat_id');
            $criteria->params[':cat_id'] = $cat_id;

        }
        $info = attributeModel::model()->find($criteria);
        return $info;
    }
}
