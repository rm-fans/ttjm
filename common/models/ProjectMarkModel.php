<?php

/**
 * This is the model class for table "{{project_mark}}".
 *
 * The followings are the available columns in table '{{project_mark}}':
 * @property integer $id
 * @property integer $project_id
 * @property integer $uid
 * @property string $username
 * @property string $content
 * @property integer $created_at
 * @property integer $status
 * @property integer $is_top
 */
class ProjectMarkModel extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{project_mark}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project_id, created_at', 'required'),
            array('project_id, uid, created_at, status, is_top', 'numerical', 'integerOnly'=>true),
            array('username', 'length', 'max'=>15),
            array('content', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, project_id, uid, username, content, created_at, status, is_top', 'safe', 'on'=>'search'),
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
            'project_id' => '资产ID',
            'uid' => '评者UID',
            'username' => '评者用户名',
            'content' => '评论内容',
            'created_at' => '评论时间',
            'status' => '0:审核中1:正常展示-1:审核失败-2:已删除',
            'is_top' => '是否置顶：1是，0否',
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
        $criteria->compare('project_id',$this->project_id);
        $criteria->compare('uid',$this->uid);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('created_at',$this->created_at);
        $criteria->compare('status',$this->status);
        $criteria->compare('is_top',$this->is_top);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProjectMark the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
