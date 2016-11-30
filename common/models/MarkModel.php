<?php

/**
 * This is the model class for table "{{mark}}".
 *
 * The followings are the available columns in table '{{mark}}':
 * @property integer $id
 * @property string $model_code
 * @property integer $project_id
 * @property integer $origin_id
 * @property integer $uid
 * @property string $username
 * @property integer $by_uid
 * @property string $by_username
 * @property integer $stars
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 * @property integer $is_top
 */
class MarkModel extends CActiveRecord
{
	CONST MODEL_CODE_SERVICE = 'service';//服务商
	CONST MODEL_CODE_BROKER = 'broker';//经纪人

	const    STATUS_AUDIT = 0;//审核中
	const    STATUS_SUCCESS = 1;//展示
	const  STATUS_LOSE = -1;//评论审核失败
	const  STATUS_DEL = -2;//已删除
//置顶
	const  IS_TOP = 1;//是
	const  NOT_IS_TOP = 0;//否

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mark}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('model_code, project_id, created_at', 'required'),
			array('project_id, origin_id, uid, by_uid, stars, created_at', 'numerical', 'integerOnly'=>true),
			array('model_code', 'length', 'max'=>20),
			array('username, by_username', 'length', 'max'=>15),
			array('content', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model_code, project_id, origin_id, uid, username, by_uid, by_username, stars, content, created_at', 'safe', 'on'=>'search'),
		);*/

		return array(
				array('model_code, project_id, created_at', 'required'),
				array('project_id, origin_id, uid, by_uid, stars, status, created_at, is_top', 'numerical', 'integerOnly'=>true),
				array('model_code', 'length', 'max'=>20),
				array('username, by_username', 'length', 'max'=>15),
				array('content', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
				array('id, model_code, project_id, origin_id, uid, username, by_uid, by_username, stars, content, status, created_at, is_top', 'safe', 'on'=>'search'),
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
				'user_profile' => array(self::BELONGS_TO, 'UserProfileModel', 'by_uid')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'model_code' => '模型号service:服务商broker:经纪人',
				'project_id' => '资产ID',
				'origin_id' => '源ID',
				'uid' => '被评者UID',
				'username' => '被评者用户名',
				'by_uid' => '评论人UID',
				'by_username' => '评论人用户名',
				'stars' => '评论星数',
				'content' => '评论内容',
				'status' => '0:审核中1成功展示-1:审核失败-2:删除',
				'created_at' => '评论时间',
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
		$criteria->compare('model_code',$this->model_code,true);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('origin_id',$this->origin_id);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('by_uid',$this->by_uid);
		$criteria->compare('by_username',$this->by_username,true);
		$criteria->compare('stars',$this->stars);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('is_top',$this->is_top);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MarkModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * 评论列表
	 * @param $model_code service:服务商 broker:经纪人
	 * @param $origin_id //服务商user_buy_id 经纪人
	 * @param int $uid
	 * @param $page
	 * @param $page_size
	 * @return array
	 * @internal param $broker //服务商，经纪人
	 */
	public static function getLists($model_code,$origin_id=0,$uid=0,$page,$page_size=10)
	{
        $page = $page>=1? $page-1:$page;
		$criteria=new CDbCriteria;
		$criteria->addCondition("t.model_code = :model_code");
		$criteria->params[":model_code"] = $model_code;
		if($uid){
			$criteria->addCondition("t.uid = :uid");
			$criteria->params[":uid"] = $uid;
		}
		if($origin_id)
		{
			$criteria->addCondition("t.origin_id = :origin_id");
			$criteria->params[":origin_id"] = $origin_id;
		}
		$criteria->addCondition('t.status=1');
		$criteria->order = "created_at desc";
		$criteria->with = "user_profile";
		$dataProvider=new CActiveDataProvider('MarkModel',array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageVar' => 'page',
						'pageSize'=>$page_size,
						'currentPage'=>$page,
				)));
		$result = $dataProvider->getData();

		return array("lists"=>$result,"criteria"=>$criteria,"pages"=>$dataProvider->getPagination());
	}

    public static function pages($criteria, $page_size)
    {

        $rowCount = MarkModel::model()->count($criteria);
        $pages = new CPagination($rowCount);
        $pages->validateCurrentPage = true;
        $pages->pageSize = $page_size;
        $pages->applyLimit($criteria);
        return $pages;
    }
}
