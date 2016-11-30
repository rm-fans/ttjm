<?php

/**
 * This is the model class for table "{{oauth_apps}}".
 *
 * The followings are the available columns in table '{{oauth_apps}}':
 * @property integer $id
 * @property string $app_key
 * @property string $app_name
 * @property string $app_secret
 * @property string $created_at
 * @property string $callback_url
 * @property integer $status
 */
class OauthAppsModel extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{oauth_apps}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('app_key, app_name, app_secret', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('app_key', 'length', 'max'=>15),
            array('app_name', 'length', 'max'=>20),
            array('app_secret', 'length', 'max'=>32),
            array('callback_url', 'length', 'max'=>255),
            array('created_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, app_key, app_name, app_secret, created_at, callback_url, status', 'safe', 'on'=>'search'),
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
            'app_key' => 'App Key',
            'app_name' => '应用名称',
            'app_secret' => 'App Secret',
            'created_at' => '创建时间',
            'callback_url' => '回跳Url',
            'status' => '是否通过审核',
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
        $criteria->compare('app_key',$this->app_key,true);
        $criteria->compare('app_name',$this->app_name,true);
        $criteria->compare('app_secret',$this->app_secret,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('callback_url',$this->callback_url,true);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OauthAppsModel the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
