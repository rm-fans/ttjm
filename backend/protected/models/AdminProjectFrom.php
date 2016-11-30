<?php

class AdminProjectFrom extends CFormModel
{
    public $id;
    public $projectId;
    public $title;
    public $image;
    public $image_thumb;
    public $wap_image;
    public $wap_image_thumb;
    public $qr_code_src;
    public $asset_attributes_id;
    public $type;
    public $buy_method_id;
    
    public $price;
    public $market_price;
    public $disposition_end_at;
    public $discount_rate;
    public $area;
    public $province_id;
    public $city_id;
    public $district_id;
    public $view_count;

    public $uid;
    public $admin_id;
    public $admin_name;
    public $created_at;
    public $status;
    public $release_at;
    public $is_recommend;
    public $grab_from;

    
    public $serve_rate;

    public $introducer_buy_rate;
    public $introducer_seller_rate;
    public $platform_rate;
    public $e_taxes_price;
    public $third_part_price;
    public $shelf_type;
    public $sell_price;
    public $selled_at;
    public $serve_price;
    public $orientation;
    public $floor_type;
    public $house_floor;
    public $total_floor;
    public $rooms;
    public $halls;
    public $build_age;
    public $cell_name;
    public $land_area;
    public $floor_area;
    public $ownership_type;
    public $decoration_type;
    public $tag_type;
    public $trading_tips;
    public $desc;
    public $current_situation_type;
    public $court_verdict;
    public $summary;
    public $origin_url;
    public $process_template_id;
    public $buy_process_template_id;
    public $project_reason_id;
    public $submissions;
    //2016-7-19 新添加字段
    public $property_fee;
    public $is_transfer_ownership,$unit_price,$unit_market_price,$thirdparty_url;
    public  $land_type,$delivery_type,$transfer_ownership_type,$is_arrears,$arrears_reason;
    public  $is_lease;
    public  $is_split,$add_services;
    //2016-7-20
    public $lease_expiration_at,$lease_income,$lease_year_rate,$lease_financing,$lease_lending_rate;
    public $ground_floor;
    //2016-7-25
    public $payment_type,$grab_from_type;
    //2016-8-13
    public $is_mortgage,$is_close_down,$property_owner,$common_people,$property_number,$land_number,$ownership_source,$land_use_number,$land_tenure;
    public $restricted_transfer,$land_use_procedures,$mortgage,$mortgage_part,$area_rights,$right_value,$registration_at,$amount_debt,$close_down_at;
    public $close_down_organs,$close_down_number,$close_down_price,$increase_capital,$default_cost,$borrow_reason,$occupy_reason;
    //住宅表
    public $plot_ratio,$green_rate,$washroom;
    //2016-8-13;
    public $only_house,$buy_at;


    //写字楼
    public $offices_seats;//工位数
    public $offices_room_rate;//得房率
    public $offices_level;//级别：1顶级，2甲级3乙级4丙级
    public $offices_type;//类型1纯写字楼2商业综合体
    public $offices_elevator_num;//电梯数
    public $offices_parking_space;//停车位

    //商业
    public $shop_shop_num; //总户数
    public $shop_floor_height;//层高
    public $shop_user_from;//客流人群:1学生2旅游3居民
    public $shop_features_type;//商铺特征1:不可餐饮2不可分割3可餐饮4可分割
    public $parking_space;
    public $history_legacy;
    public $rent;
    public $address;


    public static $floor_types = array(
        1 => 'X层／X层',
        2 => '地上X层',
    );

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title,district_id,asset_attributes_id,buy_method_id,created_at, release_at,floor_area', 'required'),
            array('price,unit_price,image,disposition_end_at','required','on' => 'pub'),//除抓取数据，其他为必填
            array('price,unit_price,image,disposition_end_at,market_price,unit_market_price,address,cell_name','required','on' => 'entrust'),//除抓取数据，其他为必填
            array('discount_rate,project_reason_id,build_age','required','on' => 'entrust'),
            array('grab_from_type,payment_type,washroom,is_transfer_ownership,is_split,is_lease,transfer_ownership_type,delivery_type,land_type,asset_attributes_id, type, buy_method_id, view_count, uid, admin_id, status, is_recommend, shelf_type, selled_at, orientation, floor_type, house_floor,ground_floor, total_floor, rooms, halls, decoration_type, current_situation_type, process_template_id, buy_process_template_id, project_reason_id', 'numerical', 'integerOnly'=>true),
            array('land_area,floor_area,plot_ratio,green_rate,property_fee,price,unit_price,market_price,unit_market_price,lease_income', 'numerical'),
            array('projectId', 'length', 'max'=>15),
            //array('plot_ratio,green_rate,property_fee', 'length', 'max'=>10),
            array('title,grab_from,add_services', 'length', 'max'=>150),
            array('thirdparty_url,arrears_reason,image,origin_url,image_thumb, wap_image, wap_image_thumb, qr_code_src, cell_name, court_verdict', 'length', 'max'=>255),
            array('lease_financing,lease_lending_rate,lease_year_rate,lease_income,lease_expiration_at,unit_market_price,price, market_price, disposition_end_at, province_id, city_id, district_id, created_at, release_at, sell_price, serve_price, build_age', 'length', 'max'=>10),
            array('discount_rate,serve_rate', 'length', 'max'=>6),
            array('admin_name, e_taxes_price, third_part_price, ownership_type, tag_type', 'length', 'max'=>25),
            array('thirdparty_url','url'),
            array('introducer_buy_rate, introducer_seller_rate, platform_rate', 'length', 'max'=>5),
            array('trading_tips, summary, submissions', 'safe'),
            array('area', 'area'),// 'on' => 'entrust'
            array('desc', 'length', 'max'=>1000),
            //2016-8-23
            array('only_house,is_mortgage,is_close_down,ownership_source,land_use_procedures,area_rights,right_value,amount_debt,close_down_at,close_down_price','numerical'),
            array('property_number,land_number,land_use_number,land_tenure,restricted_transfer,mortgage,mortgage_part,close_down_organs,close_down_number,increase_capital,default_cost,borrow_reason,occupy_reason', 'length', 'max'=>150),
            array('property_owner,common_people', 'length', 'max'=>25),
            array('buy_at,area_rights,right_value,registration_at,amount_debt,close_down_at,close_down_price', 'length', 'max'=>10),
            //写字楼
            array('offices_seats, offices_room_rate, offices_parking_space', 'length', 'max'=>25),
            array('offices_room_rate', 'numerical'),
            array('offices_level, offices_type, offices_elevator_num', 'numerical', 'integerOnly'=>true),

            //商业
            array('shop_user_from, shop_features_type,', 'numerical', 'integerOnly'=>true),
            );

    }
    public function area()
    {
        $str = ProjectModel::areaName($this->province_id,$this->city_id,$this->district_id);
        if ($str == '') {
            $this->addError('area', '请选择区域');
        } else {
            $this->area = $str;
        }

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
            'projectId' => '资产编号',
            'title' => '标题',
            'image' => '封面图片',
            'image_thumb' => 'Image Thumb',
            'wap_image' => 'Wap Image',
            'wap_image_thumb' => 'Wap Image Thumb',
            'qr_code_src' => '二维码',
            'asset_attributes_id' => '资产属性',
            'type' => '类型: 委托类1 非委托类0',
            'buy_method_id' => '交易方式',
            
            'price' => '处置价(万元）',
            'market_price' => '市场价(万元)',
            'disposition_end_at' => '价格有效期',
            'discount_rate' => '折扣率',
            'area' => '地域名：省 市 区',
            'province_id' => 'Province',
            'city_id' => 'City',
            'district_id' => '省 市 区',
            'view_count' => '访问量',
            'uid' => '发布者UID(后台发布类为空）',
            'admin_id' => 'Admin',
            'admin_name' => 'Admin Name',
            'created_at' => ' 创建时间',
            'status' => '资产状态',
            'release_at' => '发布时间',
            'is_recommend' => '是否推荐：1是，0否',
            'grab_from' => '抓取来源',
            'serve_rate' => '服务佣金',
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
            'property_fee' => '物业费(元/㎡)',
            'project_reason_id' => '资产成因',
            'unit_price' => '处置单价(元)',
            'unit_market_price' => '市场单价(元)',
            'is_arrears' => '欠缴费用',
            'is_lease' => '租约',
            'lease_lending_rate' => '贷款服务',
            'buy_process_template_id' => '购买流程图',
            'add_services' => '增值服务',
            'thirdparty_url' => '平台链接',
            'is_lease' => '是否带租约',
            'lease_lending_rate' => '贷款服务',
            'is_arrears' => '是否欠缴费用',
            'grab_from_type' => '来源类别',
            'is_mortgage' => '有无抵押：1有，0无',
            'is_close_down' => '是否被查封：1是，0否',
            'property_owner' => '权属人',
            'common_people' => '共有人',
            'property_number' => '产权号',
            'land_number' => '国土证号',
            'ownership_source' => '权属来源:1自建,2购买,3分割',
            'land_use_number' => '土地使用权证号',
            'land_tenure' => '土地期限',
            'restricted_transfer' => '有无限制转移',
            'land_use_procedures' => '土地使用权是否办妥有偿使用手续:1是，0否',
            'mortgage' => '抵押权人',
            'mortgage_part' => '抵押权利部位',
            'area_rights' => '权利面积(㎡)',
            'right_value' => '权利价值(元)',
            'registration_at' => '登记时间',
            'amount_debt' => '债权数额(元)',
            'close_down_at' => '查封时效',
            'close_down_organs' => '查封机关',
            'close_down_number' => '查封案号',
            'close_down_price' => '查封标的明细(元)',
            'increase_capital' => '资金递增情况',
            'default_cost' => '解约违约成本',
            'borrow_reason' => '借用情况说明',
            'occupy_reason' => '占用情况说明',
            "address" =>"详细地址",
            "rent" => "租金",
            "project_reason_id" => "资产成因",
            "transfer_ownership_type" => "过户费用承担",
            "payment_type" => '付款方式'

        );
    }

    public function save()
    {
        if(!empty($this->id))
        {
            $p = ProjectModel::model()->findByPk($this->id);
        }else{
            $p = new ProjectModel();
        }
        //$this->projectId;
        $p->title = $this->title;
        $p->image = $this->image;
        $p->image_thumb = $this->image_thumb;
        $p->wap_image = $this->wap_image;
        $p->wap_image_thumb = $this->wap_image_thumb;
        $p->qr_code_src = $this->qr_code_src;
        $p->asset_attributes_id = $this->asset_attributes_id;
        $p->type = $this->type;
        $p->buy_method_id = $this->buy_method_id;
        
        $p->price = $this->price;
        $p->market_price = $this->market_price;
        $p->disposition_end_at = $this->disposition_end_at;
        $p->discount_rate = $this->discount_rate;
        $p->area = $this->area;
        $p->province_id = $this->province_id;
        $p->city_id = $this->city_id;
        $p->district_id = $this->district_id;
        $p->view_count = $this->view_count;
        $p->uid = $this->uid;
        $p->admin_id = $this->admin_id;
        $p->admin_name = $this->admin_name;
        $p->created_at = $this->created_at;
        $p->status = $this->status;
        $p->release_at = $this->release_at;
        $p->is_recommend = $this->is_recommend;
        $p->grab_from = $this->grab_from;

        

        $serve_rate =  ConfModel::getValue("serve_rate");
        $p->serve_rate = $serve_rate;
        $p->serve_price = $this->price*10000*$serve_rate/100;
        $rate_arr = array(
            'introduce_buy_rate' => ConfModel::getValue(ConfModel::CONFIG_INTRODUCE_BUY_RATE),
            'introduce_seller_rate' => ConfModel::getValue(ConfModel::CONFIG_INTRODUCE_SELLER_RATE),
            'agent_rate' => ConfModel::getValue(ConfModel::CONFIG_AGENT_RATE),
            'platform_rate' => ConfModel::getValue(ConfModel::CONFIG_PLATFORM_RATE)
        );
        $p->serve_price_prorate = serialize($rate_arr);
       
        $p->introducer_buy_rate = ConfModel::getValue("introduce_buy_rate");
        $p->introducer_seller_rate = ConfModel::getValue("introduce_seller_rate");
        $p->platform_rate = $this->platform_rate;
        $p->e_taxes_price = $this->e_taxes_price;
        $p->third_part_price = $this->third_part_price;
        $p->shelf_type = $this->shelf_type;
        $p->sell_price = $this->sell_price;
        $p->selled_at = $this->selled_at;
        $p->serve_price = $this->serve_price;
        $p->orientation = $this->orientation;
        $p->floor_type = $this->floor_type;
        $p->house_floor = $this->house_floor;
        $p->total_floor = $this->total_floor;
        if(!empty($this->ground_floor) && $this->floor_type==2)
        {
            $p->house_floor = $this->ground_floor;
            $p->total_floor = '';
        }
        $p->rooms = $this->rooms;
        $p->halls = $this->halls;
        $p->build_age = $this->build_age;
        $p->cell_name = $this->cell_name;
        $p->land_area = $this->land_area;
        $p->floor_area = $this->floor_area;
        $p->ownership_type = $this->ownership_type;
        $p->decoration_type = $this->decoration_type;
        $p->tag_type = $this->tag_type;
        $p->trading_tips = $this->trading_tips;
        $p->desc = $this->desc;
        $p->current_situation_type = $this->current_situation_type;
        $p->court_verdict = $this->court_verdict;
        $p->summary = $this->summary;
        $p->origin_url = $this->origin_url;
        $p->process_template_id = $this->process_template_id;

        $buy_method = ProjectBuyMethodModel::getAll();
        $buy_method_id = $this->buy_method_id;
        if ($buy_method[$buy_method_id]['type'] == ProjectBuyMethodModel::TYPE_BIDDING) {
            $p->buy_process_template_id = 1;
        } else {
            $p->buy_process_template_id = 4;
        }

        $p->project_reason_id = $this->project_reason_id;
        $p->submissions = $this->submissions;
        $p->property_fee = $this->property_fee;
        $p->is_transfer_ownership = $this->is_transfer_ownership;
        $p->unit_price = $this->unit_price;
        $p->unit_market_price = $this->unit_market_price;
        $p->thirdparty_url = $this->thirdparty_url;
        $p->land_type = $this->land_type;
        $p->delivery_type = $this->delivery_type;
        $p->transfer_ownership_type = $this->transfer_ownership_type;
        $p->is_arrears = $this->is_arrears;
        $p->arrears_reason = $this->arrears_reason;
        $p->is_lease = $this->is_lease;
        $p->is_split = $this->is_split;
        $p->add_services = '1,3,4,5,6,7,8,9';//$this->add_services;
        $p->lease_expiration_at = $this->lease_expiration_at;
        $p->lease_income = $this->lease_income;
        $p->lease_year_rate = $this->lease_year_rate;
        $p->lease_financing = $this->lease_financing;
        $p->lease_lending_rate = $this->lease_lending_rate;
        $p->is_mortgage = $this->is_mortgage;
        $p->is_close_down = $this->is_close_down;
        $p->property_owner = $this->property_owner;
        $p->common_people = $this->common_people;
        $p->property_number = $this->property_number;
        $p->land_number = $this->land_number;
        $p->ownership_source = $this->ownership_source;
        $p->land_use_number = $this->land_use_number;
        $p->land_tenure = $this->land_tenure;
        $p->restricted_transfer = $this->restricted_transfer;
        $p->land_use_procedures = $this->land_use_procedures;
        $p->mortgage = $this->mortgage;
        $p->mortgage_part = $this->mortgage_part;
        $p->area_rights = $this->area_rights;
        $p->right_value = $this->right_value;
        $p->registration_at = $this->registration_at;
        $p->amount_debt = $this->amount_debt;
        $p->close_down_at = $this->close_down_at;
        $p->close_down_organs = $this->close_down_organs;
        $p->close_down_number = $this->close_down_number;
        $p->close_down_price = $this->close_down_price;
        $p->increase_capital = $this->increase_capital;
        $p->default_cost = $this->default_cost;
        $p->borrow_reason = $this->borrow_reason;
        $p->occupy_reason = $this->occupy_reason;
        $p->parking_space = $this->parking_space;
        $p->history_legacy = $this->history_legacy;
        $p->rent = $this->rent;
        $p->address = $this->address;
        $p->payment_type = $this->payment_type;
        if($p->save())
        {
            $this->id = $p->id;
            if(empty($p->projectId)){
                ProjectModel::setProjectId($p->id);
            }
            $this->setHouse();//住宅

            $this->setOffices();
            $this->setShop();
        }

        return $p;
    }
    public function setOffices()
    {
        if($this->asset_attributes_id != 3) return false;
        $offices= ProjectAttributeOfficesModel::model()->find("project_id=".$this->id);
        if($offices == Null){
            $offices = new ProjectAttributeOfficesModel();
        }
        $offices->project_id = $this->id;
        $offices->seats = $this->offices_seats;
        $offices->room_rate = $this->offices_room_rate;
        $offices->level = $this->offices_level ;
        $offices->type = $this->offices_type ;
        $offices->elevator_num = $this->offices_elevator_num ;
        $offices->parking_space = $this->offices_parking_space ;
        $offices->save();

    }
    public function setShop()
    {

        if($this->asset_attributes_id != 2) return false;
        $shop = ProjectAttributeShopModel::model()->find("project_id=".$this->id);
        if($shop == Null){
            $shop = new ProjectAttributeShopModel();
        }

        $shop->project_id = $this->id;
        $shop->shop_num = $this->shop_shop_num;
        $shop->floor_height = $this->shop_floor_height;
        $shop->user_from = $this->shop_user_from;
        $shop->features_type = $this->shop_features_type;
        $shop->save();
    }
    public function getShop()
    {
        $shop = ProjectAttributeShopModel::model()->find("project_id=".$this->id);
        if($shop == Null) return false;
        $this->shop_shop_num = $shop->shop_num;
        $this->shop_floor_height = $shop->floor_height;
        $this->shop_user_from = $shop->user_from;
        $this->shop_features_type = $shop->features_type;
    }
    public function setHouse()
    {
       if($this->asset_attributes_id != 1) return false;
        $house = ProjectAttributeHouseModel::model()->find("project_id=".$this->id);
        if($house == Null){
            $house = new ProjectAttributeHouseModel();
        }
        $house->project_id = $this->id;
        $house->plot_ratio = $this->plot_ratio;
        $house->green_rate = $this->green_rate;
        $house->washroom = $this->washroom;
        $house->only_house = $this->only_house;
        $house->buy_at = $this->buy_at;
        $house->save();
    }
    public function getHouse()
    {
        $house = ProjectAttributeHouseModel::model()->find("project_id=".$this->id);
        if($house == Null) return false;
        $this->plot_ratio = $house->plot_ratio>0 ? floatval($house->plot_ratio) : '';
        $this->green_rate = $house->green_rate>0 ? floatval($house->green_rate) : '';
        $this->washroom = $house->washroom;
        $this->only_house = $house->only_house;
        $this->buy_at = $house->buy_at;
    }
    public function detail()
    {
        $p = ProjectModel::model()->findByPk($this->id);
        if($p == Null) return false;
        $this->projectId = $p->projectId;
        $this->title = $p->title;
        $this->image = $p->image;
        $this->image_thumb = $p->image_thumb;
        $this->wap_image = $p->wap_image;
        $this->wap_image_thumb = $p->wap_image_thumb;
        $this->qr_code_src = $p->qr_code_src;
        $this->asset_attributes_id = $p->asset_attributes_id;
        $this->type = $p->type;
        $this->buy_method_id = $p->buy_method_id;
        
        $this->price = $p->price;
        $this->market_price = $p->market_price;
        $this->disposition_end_at = $p->disposition_end_at;
        $this->discount_rate = $p->discount_rate;
        $this->area = $p->area;
        $this->province_id = $p->province_id;
        $this->city_id = $p->city_id;
        $this->district_id = $p->district_id;
        $this->view_count = $p->view_count;
        $this->uid = $p->uid;
        $this->admin_id = $p->admin_id;
        $this->admin_name = $p->admin_name;
        $this->created_at = $p->created_at;
        $this->status = $p->status;
        $this->release_at = $p->release_at;
        $this->is_recommend = $p->is_recommend;
        $this->grab_from = $p->grab_from;

        
        $this->serve_rate = $p->serve_rate;

        $this->introducer_buy_rate = $p->introducer_buy_rate;
        $this->introducer_seller_rate = $p->introducer_seller_rate;
        $this->platform_rate = $p->platform_rate;
        $this->e_taxes_price = $p->e_taxes_price;
        $this->third_part_price = $p->third_part_price;
        $this->shelf_type = $p->shelf_type;
        $this->sell_price = $p->sell_price;
        $this->selled_at = $p->selled_at;
        $this->serve_price = $p->serve_price;
        $this->orientation = $p->orientation;
        $this->floor_type = $p->floor_type;
        $this->house_floor = $p->house_floor;

        $this->total_floor = $p->total_floor;

        $this->rooms = $p->rooms;
        $this->halls = $p->halls;
        $this->build_age = $p->build_age;
        $this->cell_name = $p->cell_name;
        $this->land_area = $p->land_area;
        $this->floor_area = $p->floor_area;
        $this->ownership_type = $p->ownership_type;
        $this->decoration_type = $p->decoration_type;
        $this->tag_type = $p->tag_type;
        $this->trading_tips = $p->trading_tips;
        $this->desc = $p->desc;
        $this->current_situation_type = $p->current_situation_type;
        $this->court_verdict = $p->court_verdict;
        $this->summary = $p->summary;
        $this->origin_url = $p->origin_url;
        $this->process_template_id = $p->process_template_id;
        $this->buy_process_template_id = $p->buy_process_template_id;
        $this->project_reason_id = $p->project_reason_id;
        $this->submissions = $p->submissions;
        $this->property_fee = $p->property_fee >0 ? floatval($p->property_fee):'';
        $this->is_transfer_ownership = $p->is_transfer_ownership;
        $this->unit_price = $p->unit_price;
        $this->unit_market_price = $p->unit_market_price;
        $this->thirdparty_url = $p->thirdparty_url;
        $this->land_type = $p->land_type;
        $this->delivery_type = $p->delivery_type;
        $this->transfer_ownership_type = $p->transfer_ownership_type;
        $this->is_arrears = $p->is_arrears;
        $this->arrears_reason = $p->arrears_reason;
        $this->is_lease = $p->is_lease;
        $this->is_split = $p->is_split;
        $this->add_services = $p->add_services;
        $this->lease_expiration_at = $p->lease_expiration_at;
        $this->lease_income = $p->lease_income;
        $this->lease_year_rate = $p->lease_year_rate;
        $this->lease_financing = $p->lease_financing;
        $this->lease_lending_rate = $p->lease_lending_rate;
        $this->is_mortgage = $p->is_mortgage;
        $this->is_close_down = $p->is_close_down;
        $this->property_owner = $p->property_owner;
        $this->common_people = $p->common_people;
        $this->property_number = $p->property_number;
        $this->land_number = $p->land_number;
        $this->ownership_source = $p->ownership_source;
        $this->land_use_number = $p->land_use_number;
        $this->land_tenure = $p->land_tenure;
        $this->restricted_transfer = $p->restricted_transfer;
        $this->land_use_procedures = $p->land_use_procedures;
        $this->mortgage = $p->mortgage;
        $this->mortgage_part = $p->mortgage_part;
        $this->area_rights = $p->area_rights;
        $this->right_value = $p->right_value;
        $this->registration_at = $p->registration_at;
        $this->amount_debt = $p->amount_debt;
        $this->close_down_at = $p->close_down_at;
        $this->close_down_organs = $p->close_down_organs;
        $this->close_down_number = $p->close_down_number;
        $this->close_down_price = $p->close_down_price;
        $this->increase_capital = $p->increase_capital;
        $this->default_cost = $p->default_cost;
        $this->borrow_reason = $p->borrow_reason;
        $this->occupy_reason = $p->occupy_reason;
        $this->parking_space = $p->parking_space >0 ? $p->parking_space:'';
        $this->history_legacy = $p->history_legacy;
        $this->rent = $p->rent;
        $this->address = $p->address;
        $this->payment_type = $p->payment_type;
        $this->getHouse();
        $this->getOffices();
        $this->getShop();
    }
    public function getOffices()
    {
        $offices = ProjectAttributeOfficesModel::model()->find("project_id=".$this->id);
        if($offices == Null) return false;
        $this->offices_seats = $offices->seats;
        $this->offices_room_rate = $offices->room_rate;
        $this->offices_level = $offices->level;
        $this->offices_type= $offices->type;
        $this->offices_elevator_num= $offices->elevator_num;
        $this->offices_parking_space= $offices->parking_space;
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



}
