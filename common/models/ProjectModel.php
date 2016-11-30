<?php

/**
 * This is the model class for table "{{project}}".
 *
 * The followings are the available columns in table '{{project}}':
 * @property string $id
 * @property string $projectId
 * @property string $title
 * @property string $image
 * @property string $image_thumb
 * @property string $wap_image
 * @property string $wap_image_thumb
 * @property string $qr_code_src
 * @property integer $attributes_id
 * @property integer $type
 * @property integer $buy_method_id
 * @property integer $category_id
 * @property string $price
 * @property string $market_price
 * @property string $disposition_end_at
 * @property string $discount_rate
 * @property string $area
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property integer $view_count
 * @property integer $service_uid
 * @property integer $uid
 * @property integer $admin_id
 * @property string $admin_name
 * @property string $created_at
 * @property integer $status
 * @property string $release_at
 * @property integer $is_recommend
 * @property string $grab_from
 * @property integer $is_grab_data
 * @property integer $is_grab_enabled
 * @property integer $max_serve_rate
 * @property integer $min_serve_rate
 * @property string $introducer_buy_rate
 * @property string $introducer_seller_rate
 * @property string $platform_rate
 * @property string $e_taxes_price
 * @property string $third_part_price
 * @property integer $shelf_type
 * @property string $sell_price
 * @property integer $selled_at
 * @property string $serve_price
 * @property integer $orientation
 * @property integer $floor_type
 * @property integer $house_floor
 * @property integer $total_floor
 * @property integer $rooms
 * @property integer $halls
 * @property string $build_age
 * @property string $cell_name
 * @property double $land_area
 * @property double $floor_area
 * @property string $ownership_type
 * @property integer $decoration_type
 * @property string $tag_type
 * @property string $trading_tips
 * @property string $desc
 * @property integer $current_situation_type
 * @property string $court_verdict
 * @property string $summary
 * @property string $origin_url
 * @property integer $process_template_id
 * @property integer $buy_process_template_id
 * @property integer $project_reason_id
 * @property string $submissions
 * @property string $court_entrust
 * @property string $property_fee
 * @property integer $is_transfer_ownership
 * @property string $unit_price
 * @property string $unit_market_price
 * @property string $thirdparty_url
 * @property integer $land_type
 * @property integer $delivery_type
 * @property integer $transfer_ownership_type
 * @property integer $is_arrears
 * @property string $arrears_reason
 * @property integer $is_lease
 * @property integer $is_split
 */
class ProjectModel extends CActiveRecord
{
    public static $serve_rates = array(//服务佣金比例
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5
    );

    const    STATUS_PENDING = 0;//待审核
    const    STATUS_DRAFT = -1;//保存资料，草稿
    const  STATUS_FAILED = -2;//未通过审核
    const  STATUS_TRANSFER_ENTRUST = 3;//申请委托
    const  STATUS_TRANSFER_FAILED = -3;//申请委托失败
    const  STATUS_SUBMIT = 1;//提交审核
    const  STATUS_SUCCESS = 2;//通过审核
    const  STATUS_SHELF = 4;//资产下架
    const  STATUS_TRADE_SUCCESS = 5;//交易成功


    const  SHELF_TYPE_PLATFORM = 1;//平台下架
    const  SHELF_TYPE_USER = 2;//用户下架

    const  PROJECT_TYPE_ENTRUST = 1;//委托资产
    const  PROJECT_TYPE_NOT_ENTRUST = 0;//非委托
    public static $field_default = "核实中";//字段为空默认值
    public static $status_reason = array(
        ProjectModel::STATUS_TRANSFER_FAILED,
        ProjectModel::STATUS_FAILED,
        ProjectModel::STATUS_SHELF
        );
    public static $recommend_type = array(1 => '是', '0' => '否');
    public static $project_type = array(1 => '是', '0' => '否');//委托
    public static $status_types = array(
        self::STATUS_TRANSFER_ENTRUST => '申请委托',
        self::STATUS_PENDING => '待审核',
        self::STATUS_DRAFT => '保存资料',
        self::STATUS_FAILED => '审核未通过',
        self::STATUS_SUBMIT => '提交审核',
        self::STATUS_SUCCESS => '通过审核',
        self::STATUS_SHELF => '资产下架',
        self::STATUS_TRANSFER_FAILED => '委托失败',
        self::STATUS_TRADE_SUCCESS => '交易成功',
    );

    public static $status_type = array(
        self::STATUS_TRANSFER_ENTRUST => '申请委托中',
        self::STATUS_TRANSFER_FAILED => '申请委托失败',
        self::STATUS_PENDING => '审核中',
        self::STATUS_DRAFT => '等待提交',
        self::STATUS_FAILED => '审核失败',
        self::STATUS_SUBMIT => '审核中',
        self::STATUS_SUCCESS => '发布中',
        self::STATUS_SHELF => '等待提交',
        self::STATUS_TRADE_SUCCESS => '交易成功',
    );
    public static $accessStatus = array(
        self::STATUS_SUCCESS,
        self::STATUS_TRADE_SUCCESS,
    );
    //朝向
    public static $orientation_types = array(
        1 => "南北通透",
        2 => "东西向",
        3 => "朝南",
        4 => "朝北",
        5 => "朝西",
        6 => "朝东",
    );
    //权属现状
    public static $ownership_types = array(
        1 => "房产证",
        2 => "国土证",
        3 => "购房合同",
        4 => "未办证",
        5 => "其他"
    );
    //装修状态
    public static $decoration_types = array(
        1 => "毛坯",
        2 => "简装修",
        3 => "中装修",
        4 => "精装修",
        5 => "豪华装修",
    );
    //标签
    public static $tag_types = array(
        /*1 => "可按揭",
        2 => "双证齐全",
        3 => "快速过户",
        4 => "尽调中",
        5 => "尽调完成",
        */
        6 => "学区房",
        7 => "轨道沿线",
        8 => "品牌地产",
        9 => "投资地产",

    );
    public static $project_types = array(
        1 => "委托类",
        2 => '非委托-抓取',
        3 => '非委托-自主'
    );
    //标的物现状
    public static $current_situation_types = array(
        1 => "闲置",
        2 => "自住",
        3 => "出租"
    );

    //资产成因
    public static $project_reason = array(
        1 => '金融不良',
        2 => '司法处置',
        3 => '企业处置',
        4 => '商账抵款',
        5 => '应急变现',
        6 => '促销特价',
        7 => '积压清仓',
    );
    public static $delivery_types = array(
        1 => '物业移交',
        2 => '其他'
    );
    public static $land_types = array(
        1 => '出让',
        2 => '划拨'
    );
    public static $transfer_ownership_types = array(
        1 => '买家承担',
        2 => '卖家承担',
        3 => '双方各自承担'
    );
    public static $offices_level_types = array(
        1 => '顶级',
        2 => '甲级',
        3 => '乙级',
        4 => '丙级',
    );
    public static $offices_types = array(
        1 => '纯写字楼',
        2 => '商业综合体'
    );
    public static $user_from_types = array(
        1 => '学生',
        2 => '旅游',
        3 => '居民',
    );
    public static $features_types = array(
        1 => '不可餐饮',
        2 => '不可分割',
        3 => '可餐饮',
        4 => '可分割',
    );
    public $create_type;
    public $end_at;
    public $images;
    public $attr;
    public $attribute_lists;
    public $tag_type_lists;
    public $num;
    public  $diff_day;
    public  $last_area;


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{project}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        /*return array(
            array('title, attributes_id, buy_method_id, created_at, release_at', 'required'),
            array('attributes_id, type, buy_method_id, category_id, view_count, service_uid, uid, admin_id, status, is_recommend, is_grab_data, is_grab_enabled, max_serve_rate, min_serve_rate, shelf_type, selled_at, orientation, house_floor, total_floor, rooms, halls, decoration_type, current_situation_type,project_reason_id,process_template_id, buy_process_template_id', 'numerical', 'integerOnly'=>true),
            array('land_area, floor_area', 'numerical'),
            array('projectId', 'length', 'max'=>15),
            array('title, grab_from, origin_url', 'length', 'max'=>150),
            array('image, image_thumb, wap_image, wap_image_thumb, qr_code_src, cell_name, court_verdict', 'length', 'max'=>255),
            array('price, market_price, disposition_end_at, province_id, city_id, district_id, created_at, release_at, sell_price, serve_price, build_age', 'length', 'max'=>10),
            array('discount_rate', 'length', 'max'=>6),
            array('admin_name, e_taxes_price, third_part_price, ownership_type, tag_type', 'length', 'max'=>25),
            array('introducer_buy_rate, introducer_seller_rate, platform_rate', 'length', 'max'=>5),
            array('trading_tips, summary, submissions, court_entrust', 'safe'),
            array('area', 'area', 'on' => 'entrust'),
            array('desc', 'length', 'max'=>200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, projectId, title, image, image_thumb, wap_image, wap_image_thumb, qr_code_src, attributes_id, type, buy_method_id, category_id, price, market_price, disposition_end_at, discount_rate, area, province_id, city_id, district_id, view_count, service_uid, uid, admin_id, admin_name, created_at, status, release_at, is_recommend, grab_from, is_grab_data, is_grab_enabled, max_serve_rate, min_serve_rate, introducer_buy_rate, introducer_seller_rate, platform_rate, e_taxes_price, third_part_price, shelf_type, sell_price, selled_at, serve_price, orientation, house_floor, total_floor, rooms, halls, build_age, cell_name, land_area, floor_area, ownership_type, decoration_type, tag_type, trading_tips, desc, current_situation_type, court_verdict, summary, origin_url,project_reason_id,process_template_id, buy_process_template_id, submissions, court_entrust', 'safe', 'on'=>'search'),
        );*/
        return array(
            array('title, attributes_id, buy_method_id, created_at, release_at', 'required'),
            array('attributes_id, type, buy_method_id, category_id, view_count, service_uid, uid, admin_id, status, is_recommend, is_grab_data, is_grab_enabled, max_serve_rate, min_serve_rate, shelf_type, selled_at, orientation, floor_type, house_floor, total_floor, rooms, halls, decoration_type, current_situation_type, process_template_id, buy_process_template_id, project_reason_id, is_transfer_ownership, land_type, delivery_type, transfer_ownership_type, is_arrears, is_split,is_lease', 'numerical', 'integerOnly'=>true),
            array('land_area, floor_area', 'numerical'),
            array('projectId', 'length', 'max'=>15),
            array('title, grab_from, origin_url, property_fee, thirdparty_url', 'length', 'max'=>150),
            array('image, image_thumb, wap_image, wap_image_thumb, qr_code_src, cell_name, court_verdict, arrears_reason', 'length', 'max'=>255),
            array('price, market_price, disposition_end_at, province_id, city_id, district_id, created_at, release_at, sell_price, serve_price, build_age, unit_price, unit_market_price', 'length', 'max'=>10),
            array('discount_rate', 'length', 'max'=>6),
            array('admin_name, e_taxes_price, third_part_price, ownership_type, tag_type', 'length', 'max'=>25),
            array('introducer_buy_rate, introducer_seller_rate, platform_rate', 'length', 'max'=>5),
            array('trading_tips,summary, submissions, court_entrust', 'safe'),
            array('area', 'area', 'on' => 'entrust'),
            array('desc', 'length', 'max'=>200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, projectId, title, image, image_thumb, wap_image, wap_image_thumb, qr_code_src, attributes_id, type, buy_method_id, category_id, price, market_price, disposition_end_at, discount_rate, area, province_id, city_id, district_id, view_count, service_uid, uid, admin_id, admin_name, created_at, status, release_at, is_recommend, grab_from, is_grab_data, is_grab_enabled, max_serve_rate, min_serve_rate, introducer_buy_rate, introducer_seller_rate, platform_rate, e_taxes_price, third_part_price, shelf_type, sell_price, selled_at, serve_price, orientation, floor_type, house_floor, total_floor, rooms, halls, build_age, cell_name, land_area, floor_area, ownership_type, decoration_type, tag_type, trading_tips, desc, current_situation_type, court_verdict, summary, origin_url, process_template_id, buy_process_template_id, project_reason_id, submissions, court_entrust, property_fee, is_transfer_ownership, unit_price, unit_market_price, thirdparty_url, land_type, delivery_type, transfer_ownership_type, is_arrears, arrears_reason, is_split,is_lease', 'safe', 'on'=>'search'),
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
            'project_attribute' => array(self::HAS_MANY, 'ProjectAttributeModel', 'project_id'),
            'project_attachment' => array(self::HAS_MANY, 'ProjectAttachmentModel', 'project_id'),
            'project_buy_method' => array(self::BELONGS_TO, 'ProjectBuyMethodModel', 'buy_method_id'),
            'asset_attributes' => array(self::BELONGS_TO, 'AssetAttributesModel', 'attributes_id'),
            'service' => array(self::BELONGS_TO, 'UserServiceDetailModel', 'service_uid'),
            'service_info' => array(self::BELONGS_TO, 'UserProfileModel', 'service_uid'),

        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'projectId' => '资产编号',
            'title' => '标题',
            'image' => '封面图片',
            'image_thumb' => 'Image Thumb',
            'wap_image' => 'Wap Image',
            'wap_image_thumb' => 'Wap Image Thumb',
            'qr_code_src' => '二维码',
            'attributes_id' => '资产属性',
            'type' => '类型: 委托类1 非委托类0',
            'buy_method_id' => '购买方式',
            'category_id' => '属性ID',
            'price' => '起拍、出售价格、处置价(万元）',
            'market_price' => '市场参考总价(万元)',
            'disposition_end_at' => '处置截止时间',
            'discount_rate' => '折扣率9.5折',
            'area' => '地域名：省 市 区',
            'province_id' => 'Province',
            'city_id' => 'City',
            'district_id' => 'District',
            'view_count' => '访问量',
            'service_uid' => '服务商UID',
            'uid' => '发布者UID(后台发布类为空）',
            'admin_id' => 'Admin',
            'admin_name' => 'Admin Name',
            'created_at' => ' 创建时间',
            'status' => '资产状态',
            'release_at' => '发布时间',
            'is_recommend' => '是否推荐：1是，0否',
            'grab_from' => '抓取来源',
            'is_grab_data' => '是否是抓取数据：1是，0否',
            'is_grab_enabled' => '是否有效：1有效，0无效',
            'max_serve_rate' => '最大佣金比率',
            'min_serve_rate' => '最小佣比例',
            'introducer_buy_rate' => '介绍买方%',
            'introducer_seller_rate' => '介绍卖方%',
            'platform_rate' => '平台比例%',
            'e_taxes_price' => '预估税费',
            'third_part_price' => '第三方费用',
            'shelf_type' => '资产下架类型:1平台下架，2.用户下架',
            'sell_price' => '成交金额(万元)',
            'selled_at' => '成交时间',
            'serve_price' => '佣金',
            'orientation' => '朝向',
            'floor_type' => '楼层显示样式：1:14/18 2:14',
            'house_floor' => '房屋楼层',
            'total_floor' => '总楼层数',
            'rooms' => '几室',
            'halls' => '厅',
            'build_age' => '建筑年代',
            'cell_name' => '小区名称',
            'land_area' => '土地面积',
            'floor_area' => '建筑面积',
            'ownership_type' => '权属现状',
            'decoration_type' => '装修状态',
            'tag_type' => '标签',
            'trading_tips' => '交易提醒',
            'desc' => '描述',
            'current_situation_type' => '标的物现状',
            'court_verdict' => '法院执行裁定书号',
            'summary' => '标的物简介',
            'origin_url' => '抓取类原始URL,变现类原始资产URL',
            'process_template_id' => '资产流程模板id',
            'buy_process_template_id' => '购买流程模板ID',
            'project_reason_id' => '资产成因',
            'submissions' => '项目意见书',
            'court_entrust' => '法院委托书',
            'property_fee' => '物业费',
            'is_transfer_ownership' => '是否直接过户:1是，0否',
            'unit_price' => '处置单价',
            'unit_market_price' => '市场单价',
            'thirdparty_url' => '第三方平台对比链接',
            'land_type' => '土地使用类型1出让,2划拨',
            'delivery_type' => '交割方式:1物业移交2其他',
            'transfer_ownership_type' => '过户费用承担:1买家承担2卖家承担3双方各自承担',
            'is_arrears' => '是否欠缴费用1是，0否',
            'arrears_reason' => '欠费原因',
            'is_lease' => '是否带租约:1是，0否',
            'is_split' => '可否分割:1可以，0否',
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

        $criteria->compare('id',$this->id,true);
        $criteria->compare('projectId',$this->projectId,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('image',$this->image,true);
        $criteria->compare('image_thumb',$this->image_thumb,true);
        $criteria->compare('wap_image',$this->wap_image,true);
        $criteria->compare('wap_image_thumb',$this->wap_image_thumb,true);
        $criteria->compare('qr_code_src',$this->qr_code_src,true);
        $criteria->compare('attributes_id',$this->attributes_id);
        $criteria->compare('type',$this->type);
        $criteria->compare('buy_method_id',$this->buy_method_id);
        $criteria->compare('category_id',$this->category_id);
        $criteria->compare('price',$this->price,true);
        $criteria->compare('market_price',$this->market_price,true);
        $criteria->compare('disposition_end_at',$this->disposition_end_at,true);
        $criteria->compare('discount_rate',$this->discount_rate,true);
        $criteria->compare('area',$this->area,true);
        $criteria->compare('province_id',$this->province_id,true);
        $criteria->compare('city_id',$this->city_id,true);
        $criteria->compare('district_id',$this->district_id,true);
        $criteria->compare('view_count',$this->view_count);
        $criteria->compare('service_uid',$this->service_uid);
        $criteria->compare('uid',$this->uid);
        $criteria->compare('admin_id',$this->admin_id);
        $criteria->compare('admin_name',$this->admin_name,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('release_at',$this->release_at,true);
        $criteria->compare('is_recommend',$this->is_recommend);
        $criteria->compare('grab_from',$this->grab_from,true);
        $criteria->compare('is_grab_data',$this->is_grab_data);
        $criteria->compare('is_grab_enabled',$this->is_grab_enabled);
        $criteria->compare('max_serve_rate',$this->max_serve_rate);
        $criteria->compare('min_serve_rate',$this->min_serve_rate);
        $criteria->compare('introducer_buy_rate',$this->introducer_buy_rate,true);
        $criteria->compare('introducer_seller_rate',$this->introducer_seller_rate,true);
        $criteria->compare('platform_rate',$this->platform_rate,true);
        $criteria->compare('e_taxes_price',$this->e_taxes_price,true);
        $criteria->compare('third_part_price',$this->third_part_price,true);
        $criteria->compare('shelf_type',$this->shelf_type);
        $criteria->compare('sell_price',$this->sell_price,true);
        $criteria->compare('selled_at',$this->selled_at);
        $criteria->compare('serve_price',$this->serve_price,true);
        $criteria->compare('orientation',$this->orientation);
        $criteria->compare('floor_type',$this->floor_type);
        $criteria->compare('house_floor',$this->house_floor);
        $criteria->compare('total_floor',$this->total_floor);
        $criteria->compare('rooms',$this->rooms);
        $criteria->compare('halls',$this->halls);
        $criteria->compare('build_age',$this->build_age,true);
        $criteria->compare('cell_name',$this->cell_name,true);
        $criteria->compare('land_area',$this->land_area);
        $criteria->compare('floor_area',$this->floor_area);
        $criteria->compare('ownership_type',$this->ownership_type,true);
        $criteria->compare('decoration_type',$this->decoration_type);
        $criteria->compare('tag_type',$this->tag_type,true);
        $criteria->compare('trading_tips',$this->trading_tips,true);
        $criteria->compare('desc',$this->desc,true);
        $criteria->compare('current_situation_type',$this->current_situation_type);
        $criteria->compare('court_verdict',$this->court_verdict,true);
        $criteria->compare('summary',$this->summary,true);
        $criteria->compare('origin_url',$this->origin_url,true);
        $criteria->compare('process_template_id',$this->process_template_id);
        $criteria->compare('buy_process_template_id',$this->buy_process_template_id);
        $criteria->compare('project_reason_id',$this->project_reason_id);
        $criteria->compare('submissions',$this->submissions,true);
        $criteria->compare('court_entrust',$this->court_entrust,true);
        $criteria->compare('property_fee',$this->property_fee,true);
        $criteria->compare('is_transfer_ownership',$this->is_transfer_ownership);
        $criteria->compare('unit_price',$this->unit_price,true);
        $criteria->compare('unit_market_price',$this->unit_market_price,true);
        $criteria->compare('thirdparty_url',$this->thirdparty_url,true);
        $criteria->compare('land_type',$this->land_type);
        $criteria->compare('delivery_type',$this->delivery_type);
        $criteria->compare('transfer_ownership_type',$this->transfer_ownership_type);
        $criteria->compare('is_arrears',$this->is_arrears);
        $criteria->compare('arrears_reason',$this->arrears_reason,true);
        $criteria->compare('is_lease',$this->is_lease);
        $criteria->compare('is_split',$this->is_split);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return projectModel the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function area()
    {
        $str = self::areaName($this->province_id,$this->city_id,$this->district_id);
        if ($str == '') {
            $this->addError('area', '请选择区域');
        } else {
            $this->area = $str;
        }

    }
    public static function areaName($province_id,$city_id,$district_id)
    {

        $obj1 = DistrictModel::model()->findByPk($province_id);
        $obj2 = DistrictModel::model()->findByPk($city_id);
        $obj3 = DistrictModel::model()->findByPk($district_id);
        $str = '';
        if (isset($obj1->name)) $str .= $obj1->name . ' ';
        if (isset($obj2->name)) $str .= $obj2->name . ' ';
        if (isset($obj3->name)) $str .= $obj3->name . ' ';
        return $str;
    }

    /**
     * 生成projectId
     * @param $id
     */
    public static function setProjectId($id)
    {
        $num = 'T' . (103923901 + $id);
        ProjectModel::model()->updateByPk($id, array('projectId' => $num));
    }

    /**
     * 资产列表
     * @param $where
     * @param int $pageSize
     * @param int $page
     * @param $where
     * keywords 搜索关键词
     * $id int
     * $province_id  int  省id
     * $city_id int  市id
     * $attributes_id 资产属性 array()
     * $price 出售总价 array('gte'=>0,'lte'=>0,'eq'=>0)  lte 小于等，gte大于等于
     * $buy_method_id int 交易方式
     * $discount_rate 折扣率  array('gte'=>0,'lte'=>0,'eq'=>0)  lte 小于等，gte大于等于,eq等于
     * $area 房子面积 array('gte'=>0,'lte'=>0,'eq'=>0)  lte 小于等，gte大于等于,eq等于
     * 户型 ?????
     */
    public static function getEntrustLists($where = array(), $order = '', $page_size = 20, $page = 0)
    {
        $page = $page>=1? $page-1:$page;
        $criteria = new CDbCriteria;
        $criteria->with = array("project_attachment","asset_attributes", "project_buy_method");
        if (isset($where['order']) && !empty($where['order'])) {
            $criteria->order = $where['order'];
            if($where['order'] == "price asc" && $where['type']==0)
                $criteria->order = "market_price asc,price asc";
            if($where['order'] == "price desc" && $where['type']==0)
                $criteria->order = "market_price desc,price desc";
        }elseif($order){
            $criteria->order = $order;
        } else {
            $criteria->order = "t.is_recommend desc,t.release_at desc";
        }
        if (isset($where['city_id']) && !empty($where['city_id'])) {

            $criteria->addCondition('t.city_id =:city_id or t.province_id =:province_id');
            $criteria->params[':city_id'] = $where['city_id'];
            $criteria->params[':province_id'] = $where['city_id'];

        }
        if (isset($where['type']) && $where['type']!=='') {
            $criteria->addCondition('t.type =:type');
            $criteria->params[':type'] = $where['type'];
        }
        if (isset($where['id']) && !empty($where['id'])) {
            $criteria->addCondition('t.id =:id');
            $criteria->params[':id'] = $where['id'];
        }
        if (isset($where['is_recommend']) && !empty($where['is_recommend'])) {
            $criteria->addCondition('t.is_recommend =:is_recommend');
            $criteria->params[':is_recommend'] = $where['is_recommend'];
        }
        if (isset($where['keywords']) && !empty($where['keywords'])) {
            $criteria->addSearchCondition("t.title", $where['keywords']);
        }
        if (isset($where['province_id']) && !empty($where['province_id'])) {
            $criteria->addCondition('t.province_id =:province_id');
            $criteria->params[':province_id'] = $where['province_id'];
        }
        if (isset($where['not_city_id']) && !empty($where['not_city_id'])) {
            $criteria->addCondition('t.city_id !=:not_city_id');
            $criteria->params[':not_city_id'] = $where['not_city_id'];
        }

        if (isset($where['attributes_id']) && !empty($where['attributes_id'])) {
            $criteria->addInCondition("t.attributes_id", $where['attributes_id']);
        }
        if (isset($where['floor_area']) && !empty($where['floor_area'])) {
            if (isset($where['floor_area']['gte']) && !empty($where['floor_area']['gte'])) {
                $criteria->addCondition('t.floor_area >=:floor_area_gte');
                $criteria->params[':floor_area_gte'] = $where['floor_area']['gte'];
            }
            if (isset($where['floor_area']['lte']) && !empty($where['floor_area']['lte'])) {
                $criteria->addCondition('t.floor_area <=:floor_area_lte');
                $criteria->params[':floor_area_lte'] = $where['floor_area']['lte'];
            }
        }
        if (isset($where['price']) && !empty($where['price'])) {
            if (isset($where['price']['gte']) && !empty($where['price']['gte'])) {
                $criteria->addCondition('t.price >=:price_gte');
                $criteria->params[':price_gte'] = $where['price']['gte'];
            }
            if (isset($where['price']['lte']) && !empty($where['price']['lte'])) {
                $criteria->addCondition('t.price <=:price_lte');
                $criteria->params[':price_lte'] = $where['price']['lte'];
            }
            if (isset($where['price']['eq']) && !empty($where['price']['eq'])) {
                $criteria->addCondition('t.price =:price_eq');
                $criteria->params[':price_eq'] = $where['price']['eq'];
            }
        }
        if (isset($where['discount_rate']) && !empty($where['discount_rate'])) {
            if (isset($where['discount_rate']['gte']) && !empty($where['discount_rate']['gte'])) {
                $criteria->addCondition('t.discount_rate >=:discount_rate_gte');
                $criteria->params[':discount_rate_gte'] = $where['discount_rate']['gte'];
            }
            if (isset($where['discount_rate']['lte']) && !empty($where['discount_rate']['lte'])) {
                $criteria->addCondition('t.discount_rate <=:discount_rate_lte');
                $criteria->params[':discount_rate_lte'] = $where['discount_rate']['lte'];
            }
            if (isset($where['discount_rate']['eq']) && !empty($where['discount_rate']['eq'])) {
                $criteria->addCondition('t.discount_rate =:discount_rate_eq');
                $criteria->params[':discount_rate_eq'] = $where['discount_rate']['eq'];
            }
        }
        if (isset($where['rooms']) && !empty($where['rooms'])) {
            if (isset($where['rooms']['gte']) && !empty($where['rooms']['gte'])) {
                $criteria->addCondition('t.rooms >=:rooms_gte');
                $criteria->params[':rooms_gte'] = $where['rooms']['gte'];
            }
            if (isset($where['rooms']['lte']) && !empty($where['rooms']['lte'])) {
                $criteria->addCondition('t.rooms <=:rooms_lte');
                $criteria->params[':rooms_lte'] = $where['rooms']['lte'];
            }
            if (isset($where['rooms']['eq']) && !empty($where['rooms']['eq'])) {
                $criteria->addCondition('t.rooms =:rooms_eq');
                $criteria->params[':rooms_eq'] = $where['rooms']['eq'];
            }
        }
        if (isset($where['buy_method_id']) && !empty($where['buy_method_id'])) {
            $criteria->addCondition('t.buy_method_id =:buy_method_id');
            $criteria->params[':buy_method_id'] = $where['buy_method_id'];
        }
        if(isset($where['orientation']) && !empty($where['orientation']))
        {
            $criteria->addCondition('t.orientation =:orientation');
            $criteria->params[":orientation"] = $where['orientation'];
        }
        if (isset($where['house_floor']) && !empty($where['house_floor'])) {
            if (isset($where['house_floor']['gte']) && !empty($where['house_floor']['gte'])) {
                $criteria->addCondition('t.house_floor >=:house_floor_gte');
                $criteria->params[':house_floor_gte'] = $where['house_floor']['gte'];
            }
            if (isset($where['house_floor']['lte']) && !empty($where['house_floor']['lte'])) {
                $criteria->addCondition('t.house_floor <=:house_floor_lte');
                $criteria->params[':house_floor_lte'] = $where['house_floor']['lte'];
            }
            if (isset($where['house_floor']['eq']) && !empty($where['house_floor']['eq'])) {
                $criteria->addCondition('t.house_floor =:house_floor_eq');
                $criteria->params[':house_floor_eq'] = $where['house_floor']['eq'];
            }
        }
        if (isset($where['build_age']) && !empty($where['build_age'])) {
            if (isset($where['build_age']['gte']) && !empty($where['build_age']['gte'])) {
                $criteria->addCondition('t.build_age >=:build_age_gte');
                $criteria->params[':build_age_gte'] = $where['build_age']['gte'];
            }
            if (isset($where['build_age']['lte']) && !empty($where['build_age']['lte'])) {
                $criteria->addCondition('t.build_age <=:build_age_lte');
                $criteria->params[':build_age_lte'] = $where['build_age']['lte'];
            }
            if (isset($where['build_age']['eq']) && !empty($where['build_age']['eq'])) {
                $criteria->addCondition('t.house_floor =:build_age_eq');
                $criteria->params[':build_age_eq'] = $where['build_age']['eq'];
            }
        }
        if(isset($where['decoration_type']) && !empty($where['decoration_type']))
        {
            $criteria->addCondition('t.decoration_type =:decoration_type');
            $criteria->params[":decoration_type"] = $where['decoration_type'];
        }
        $criteria->addCondition('t.release_at <='.time());
        $time = strtotime('2016-1-1');
        if (isset($where['status']) && !empty($where['status'])) {

            if($where['status'] == ProjectModel::STATUS_SUCCESS) //已成交已失效用户不显示
            {
                $criteria->addCondition('t.status =:status  and  (t.disposition_end_at =0 or t.disposition_end_at >'.time().")");
                $criteria->params[':status'] = $where['status'];
            }
            elseif($where['status'] == ProjectModel::STATUS_TRADE_SUCCESS)
            {
                $criteria->addCondition('t.status =:status  or (t.disposition_end_at>0 && t.disposition_end_at <'.time().")");
                $criteria->params[':status'] = $where['status'];
            }
        }
        if(isset($where['no_entrust_from']) && !empty($where['no_entrust_from']))
        {
            if($where['no_entrust_from'] == 1)
            {
                $criteria->addCondition('t.uid >0');
            }elseif($where['no_entrust_from'] == 2){
                $criteria->addCondition('t.is_grab_data = 1');
            }


        }
        /*echo "<pre>";
        print_r($criteria);exit;*/
        return self::getData($criteria, $page, $page_size);
    }

    /**
     * 首页搜索
     * @param array $where
     * @param string $order
     * @param $page
     * @param $page_size
     * @return array
     */
    public static function getHomeLists($where = array(), $order = '', $page_size = 16, $page = 0)
    {

        $criteria = new CDbCriteria;
        $criteria->with = array("project_attribute", "project_buy_method");
        if ($order) {
            $criteria->order = $order;
        } else {
            $criteria->order = "t.is_recommend desc,t.release_at desc";
        }

        if (isset($where['province_id']) && !empty($where['province_id'])) {
            $criteria->addCondition('t.province_id =:province_id');
            $criteria->params[':province_id'] = $where['province_id'];
        }
        if (isset($where['shelf_type']) && !empty($where['shelf_type'])) {
            $criteria->addCondition('t.shelf_type =:shelf_type');
            $criteria->params[':shelf_type'] = $where['shelf_type'];
        }
        if (isset($where['city_id']) && !empty($where['city_id'])) {
            $criteria->addCondition('t.city_id =:city_id','or');
            $criteria->params[':city_id'] = $where['city_id'];
        }
        if (isset($where['type']) && $where['type']!==null) {
            $criteria->addCondition('t.type =:type');
            $criteria->params[':type'] = $where['type'];
        }
        if (isset($where['is_recommend']) && $where['is_recommend']!==null) {
            $criteria->addCondition('t.is_recommend =:is_recommend');
            $criteria->params[':is_recommend'] = $where['is_recommend'];
        }
        if (isset($where['status']) && $where['status']!==null) {
            $criteria->addCondition('t.status =:status');
            $criteria->params[':status'] = $where['status'];
        }
        $criteria->addCondition('t.release_at <='.time());
        if (isset($where['status']) && !empty($where['status'])) {

            if($where['status'] == ProjectModel::STATUS_SUCCESS) //已成交已失效用户不显示
            {
                $criteria->addCondition('t.status =:status and (t.disposition_end_at =0 or t.disposition_end_at >'.time().")");
                $criteria->params[':status'] = $where['status'];
            }
            elseif($where['status'] == ProjectModel::STATUS_TRADE_SUCCESS)
            {
                $criteria->addCondition('t.status =:status or t.disposition_end_at <'.time());
                $criteria->params[':status'] = $where['status'];
            }
        }

        return self::getData($criteria, $page, $page_size);
    }



    /**
     * 列表 内部调用
     * @param $criteria
     * @param $page
     * @param $page_size
     * @return array
     */
    private static function getData(&$criteria, $page, $page_size)
    {
        $dataProvider = new CActiveDataProvider('ProjectModel', array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageVar'=>'page',
                'pageSize'=>$page_size,//设置分页条数以确定取出数据的条数
                'currentPage' => $page,
            ),

        ));
        $result = $dataProvider->getData();
        if($result)
        {
            foreach($result as $obj)
            {
                //$obj['attribute_lists'] =  ProjectAttributeModel::getProjectInfo($obj['id']);
                $tag_type_lists = array();
                if($obj['tag_type']){
                    $tag_type = explode(',',$obj['tag_type']);
                    foreach($tag_type as $t)
                    {
                        $types = self::$tag_types;
                        if(isset($types[$t]))
                        {
                            $tag_type_lists[] = self::$tag_types[$t];
                        }

                    }
                }
                $obj['tag_type_lists'] = $tag_type_lists;
                $obj['diff_day'] = 0;
                if($obj['disposition_end_at']>0 && $obj['status'] == ProjectModel::STATUS_SUCCESS)
                {
                    $day = Utils::timediff(time(),$obj['disposition_end_at'],false,true);
                    $obj['diff_day'] = (int)$day['day'];
                }
                if(empty($obj['image']))
                {
                    $obj['image'] = Yii::app()->params['pub_default_img'];
                }
                $params = $criteria->params;
                $area = explode(" ",$obj['area']);
                $area = array_filter($area);
                $obj['last_area'] = end($area);
               /* if(isset($params[':province_id']) || isset($params[':city_id'])){
                    $obj['last_area'] = end($area);
                }else{
                    if(count($area) == 3) unset($area[0]);
                    $obj['last_area'] = implode(" ",$area);
                }*/

            }
        }
        return array("lists" => $result, "criteria" => $criteria,"pages"=>$dataProvider->getPagination());
    }

    public static function pages($criteria, $page_size)
    {
        $rowCount = ProjectModel::model()->count($criteria);
        $pages = new CPagination($rowCount);
        $pages->pageVar = "page";
        $pages->pageSize = $page_size;
        $pages->applyLimit($criteria);
        return $pages;
    }

    /**
     * 获取一条信息
     * @param $id
     * @return array
     */
    public static function getInfo($id)
    {
        $types= array();
        self::updateViewNum($id);
        $model = ProjectModel::model()->findByPk($id);
        $data = $model->attributes;
        $data['price'] = $data['price'] * 100 / 100;
        $data['market_price'] = $data['market_price'] * 100 / 100;
        $data['discount_rate'] = $data['discount_rate'] * 100 / 100;
        $data['e_taxes_price'] = $data['e_taxes_price'];
        $data['third_part_price'] = $data['third_part_price'];
        $data['city_name'] = Utils::getCityName($data['area']);
        $data['area'] = str_replace(' ', '-', trim($data['area']));

        $data['decoration_type_name'] = isset(self::$decoration_types[$data['decoration_type']])?self::$decoration_types[$data['decoration_type']]:'';
        if($data['tag_type']) {
            $tag_type = explode(',', $data['tag_type']);
            foreach ($tag_type as $t) {
                $types[$t] = isset(self::$tag_types[$t]) ? self::$tag_types[$t] : '';
            }
        }
        $data['tag_type'] = $types;
        foreach ($model->getMetaData()->relations as $r) {
            $t = $model->getRelated($r->name);
            if ($t) {
                if(is_object($t)){
                    foreach ($t as $key => $v) {
                        $data[$r->name . '_' . $key] = $v;
                    }
                }else{
                    foreach ($t as $key => $v) {
                        $data[$r->name][] = $v->attributes;
                    }
                }
            } else {
                $className = $r->className;
            }
        };
        if($data['service_uid']){
            $data['service_info_phone'] = Utils::decrypt($data['service_info_phone']);
            $data['service_info_identity_name'] = Utils::decrypt($data['service_info_identity_name']);
            $data['service_info_identity_card'] = Utils::decrypt($data['service_info_identity_card']);
        }
        //获取扩展属性
        $data['project_attribute'] = ProjectAttributeModel::getProjectInfo($data['id']);
        $data['project_attachment'] = isset($data['project_attachment']) && $data['project_attachment'] ? $data['project_attachment'] : array();
        $data['url'] = Yii::app()->createUrl('project/detail/'.$data['id']);
        $data['absolute_url'] = Yii::app()->createAbsoluteUrl('project/detail/'.$data['id']);
        if(!$model->is_grab_data){
            //流程模板
            $templateModel = ProjectBuyProcessTemplateModel::getTemplate($data['buy_process_template_id']);
            $data['buy_process_template'] = $templateModel;



            $ownership_type =explode(',',$data['ownership_type']);

            foreach($ownership_type as $ot){
                $data['ownership_type_name'][$ot] = isset(self::$ownership_types[$ot]) ? self::$ownership_types[$ot]:"";
            }
        }

        //是否收藏
        $data['has_favorite'] =UserFavoriteModel::hasFavorite(Yii::app()->user->id,$data['id'],UserFavoriteModel::KEEP_TYPE_PROJECT);
        //标的物现状
        $data['current_situation_name'] = isset(self::$current_situation_types[$data['current_situation_type']]) ? self::$current_situation_types[$data['current_situation_type']] : '';
        return $data;
    }

    /**
     * 用户发布的资产
     * @param $uid
     * @param $type 委托非委托
     */
    public static function userPublishLists($uid, $page, $page_size,$status=array())
    {
        $page = $page>1 ? $page-1:0;
        $criteria = new CDbCriteria;
        $criteria->addCondition("uid=:uid");
        $criteria->params[":uid"] = $uid;
//        $criteria->addCondition("type=".ProjectModel::PROJECT_TYPE_NOT_ENTRUST);

        if(!empty($status)){
            $criteria->addInCondition("status",$status);
        }
        $criteria->addCondition("is_grab_data=0");
        $criteria->order = "created_at desc";
        return ProjectModel::getData($criteria, $page, $page_size);
    }

    /**
     * 清除选项
     *其他清除某个project_field
     * @param string $project_field_name
     * @param $param_lists
     * @param $param_url_lists
     */
    public static function clearChecked($project_field_name="",$url,$param_url_lists=array(),$param_lists=array())
    {
        $lists = array();
        $url = rtrim($url,'/').'/';
        foreach($param_lists as $key=>$obj)
        {
            if(isset($param_url_lists[$obj]) && $param_url_lists[$obj]['project_field'] != $project_field_name)
            {
                $lists[] = $obj;
            }
        }
        $p = implode("_",$lists);
        $url.= trim($p,'_');
        return $url;
    }
    /**
     * 被选择列表的名字
     * @param $project_field
     * @param $param_lists
     * @param string $default_name
     * @return string
     */
    public static function checkedListsName($project_field_lists,$param_lists,$default_name='')
    {
        $name = $default_name;
        foreach($project_field_lists as $obj)
        {
            if(in_array($obj['url_param'],$param_lists))
            {
                $name = $obj['name'];
                break;
            }
        }
        return $name;
    }
    public static function wapProjectListsUrl($url_param=array(),$params_lists=array(),$tag_param=array())
    {
        if(!array_filter($tag_param))
        {
            $p = implode("_",$params_lists);
            $p = trim($p,'_');
            return $p;
        }
        $params_lists = array_filter($params_lists);
        foreach($tag_param as $now_param)
        {
            if(!in_array($now_param,$params_lists))
            {
                $now_info = $url_param[$now_param];
                if($now_info['project_field'] == 'attributes_id')
                {
                    if(!in_array($now_param,$params_lists))
                    {
                        $params_lists[] = $now_param;
                    }
                }else{
                    $find = true;
                    $update = true;
                    if($params_lists){
                        foreach($params_lists as $k=>$obj)
                        {
                            if(isset($url_param[$obj])){
                                $checked_info = $url_param[$obj];
                                if(($now_info['project_field'] == $checked_info['project_field']) && $now_info['project_field']!='')
                                {
                                    $params_lists[$k] = $now_param;
                                    $update = false;
                                }
                            }
                        }
                        if(!$update && in_array($now_param,$params_lists) )
                        {
                            $find = false;
                        }
                    }
                    if($find)
                    {
                        $params_lists[] = $now_param;
                    }

                }
            }

        }
        $p = implode("_",$params_lists);
        $p= trim($p,'_');
        if($p) return "s/".$p;
        return "";
    }



    /**
     * 资产列表url链接组合
     * @param array $params_lists  已选择的参数
     * @param $now_param 当前选择的参数
     */
    public static function projectListsUrl($url_param=array(),$url='',$params_lists=array(),$now_param)
    {

        $url = rtrim($url,'/').'/';
        if(empty($now_param))
        {
            $p = implode("_",$params_lists);
            $url= !empty($p) ? $url."s/".trim($p,'_'):$url;
            return $url;
        }

        $params_lists = array_filter($params_lists);
        //已选择去掉选择
        if(in_array($now_param,$params_lists))
        {
            $key = array_search($now_param, $params_lists);
            if ($key !== false)
                unset($params_lists[$key]);
        }
        //未选择，添加搜索
        else
        {
            $now_info = $url_param[$now_param];
            if($now_info['project_field'] == 'attributes_id')
            {
                if(!in_array($now_param,$params_lists))
                {
                    $params_lists[] = $now_param;
                }
            }else{
                $find = true;
                $update = true;
                if($params_lists){
                    foreach($params_lists as $k=>$obj)
                    {
                        if(isset($url_param[$obj])){
                            $checked_info = $url_param[$obj];
                            if(($now_info['project_field'] == $checked_info['project_field']) && $now_info['project_field']!='')
                            {
                                $params_lists[$k] = $now_param;
                                $update = false;
                            }
                        }
                    }
                    if(!$update && in_array($now_param,$params_lists) )
                    {
                        $find = false;
                    }

                }
                if($find)
                {
                    $params_lists[] = $now_param;
                }
            }
        }
        $p = implode("_",$params_lists);
        $url = $url= !empty($p) ? $url."s/".trim($p,'_'):$url;
        return $url;
    }

    public static function updateViewNum($id,$count=1){
        $sql = "update {{project}} set view_count=view_count+$count where id=$id";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function behaviors()
    {
        return array(
            // 行为类名 => 类文件别名路径
            'ProjectBehavior' =>
                'common.behaviors.ProjectBehavior',
        );
    }
}
