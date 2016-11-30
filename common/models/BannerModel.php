<?php

/**
 * This is the model class for table "{{banner}}".
 *
 * The followings are the available columns in table '{{banner}}':
 * @property integer $id
 * @property string $src
 * @property string $url
 * @property string $alt
 * @property integer $sort
 * @property integer $status
 */
class BannerModel extends CActiveRecord
{
    const STATUS_NONE = 0;//不显示
    const STATUS_WAP = 1;//WAP显示
    const STATUS_PC = 2;//PC显示
    const STATUS_APP = 3;//app显示
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{banner}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('src', 'required'),
			array('sort, status', 'numerical', 'integerOnly'=>true),
			array('src, url, alt', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, src, url, alt, sort, status', 'safe', 'on'=>'search'),
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
			'src' => 'Src',
			'url' => 'Url',
			'alt' => 'Alt',
			'sort' => 'Sort',
			'status' => 'Status',
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
		$criteria->compare('src',$this->src,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('alt',$this->alt,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BannerModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /**
     * 首页banner图管理
     * @param $status
     * @return array|mixed|null|static[]
     */
    public static function getLists($status)
    {
        $criteria=new CDbCriteria;
        $criteria->addCondition("status =:status");
        $criteria->params[":status"] = $status;
        $criteria->order = "sort asc";
        return BannerModel::model()->findAll($criteria);
    }
}
