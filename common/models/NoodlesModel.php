<?php

/**
 * This is the model class for table "{{noodles}}".
 *
 * The followings are the available columns in table '{{noodles}}':
 * @property integer $id
 * @property string $name
 * @property string $noodtype
 * @property double $noodprice
 * @property string $nooddetail
 */
class NoodlesModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{noodles}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,noodprice,noodtype', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('noodprice', 'numerical'),
			array('name', 'length', 'max'=>20),
			array('noodtype', 'length', 'max'=>50),
			array('nooddetail', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, noodtype, noodprice, nooddetail', 'safe', 'on'=>'search'),
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
			'name' => '面条标题',
			'noodtype' => '面条类型',
			'noodprice' => '苗条价格',
			'nooddetail' => '面条说明',
		);
	}

	public static function noodlesname($id){
		$arr=array(
			'1'=>'干馏系列',
			'2'=>'汤面系列',
			'3'=>'抄手系列',
			'4'=>'精品小吃',
		);
		return isset($arr[$id])?$arr[$id]:'其他';
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('noodtype',$this->noodtype,true);
		$criteria->compare('noodprice',$this->noodprice);
		$criteria->compare('nooddetail',$this->nooddetail,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NoodlesModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
