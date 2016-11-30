<?php
class PubForm extends CFormModel
{
    const  TYPE_IMG_SERVER = 1;//来自图片服务器
    const  TYPE_SERVER = 2;//来自当前数据库
    public $area;
    public $title;
    public $buy_method_id;
    public $price;
    public $attributes_id;
    public $ownership_type;
    public $build_age;
    public $house_floor;
    public $total_floor;
    public $orientation;
    public $decoration_type;
    public $wap_image;
    public $rooms;
    public $halls;
    public $floor_area;
    public $province_id;
    public $city_id;
    public $district_id;
    public $desc;
    public $phone; //手机号码
    public $code;//验证码
    public $verify_code;//短信验证
    public $images;//上传的图片
    public $image_ids;//上传图片的id
    public $uid;


   public function  rules(){
       return array(
           array('title,price,floor_area,buy_method_id,attributes_id,ownership_type,province_id,city_id,district_id', 'required'),
           array('build_age,orientation,decoration_type,phone,uid', 'numerical', 'integerOnly'=>true),
           array('title', 'length', 'min'=>2, 'max'=>20),
           array('verify_code,code', 'length',  'max'=>6),
           array('desc', 'length',  'max'=>200),
           array('total_floor,house_floor', 'numerical', 'max'=>100),
           array('floor_area', 'numerical', 'min'=>10),
           array('rooms,halls', 'numerical', 'max'=>10),
           array('phone','isPhone','on'=>"submit"),
           array('images,image_ids', 'safe'),
       );
   }
    public function created($id=0)
    {
        if($id)
        {
            $project = ProjectModel::model()->findByPk($id);
        }else{
            $project = new ProjectModel;
        }
        $project->title = $this->title;
        $project->type = ProjectModel::PROJECT_TYPE_NOT_ENTRUST;
        $project->price = $this->price;
        $project->floor_area = $this->floor_area;
        $project->buy_method_id = $this->buy_method_id;
        $project->attributes_id = $this->attributes_id;
        $project->ownership_type = !empty($this->ownership_type) ? implode(',',$this->ownership_type) : '';
        $project->province_id = $this->province_id;
        $project->city_id = $this->city_id;
        $project->district_id = $this->district_id;
        $project->total_floor = $this->total_floor;
        $project->house_floor = $this->house_floor;
        $project->orientation = $this->orientation;
        $project->decoration_type = $this->decoration_type;
        $project->build_age = $this->build_age;
        $project->rooms = $this->rooms;
        $project->halls = $this->halls;
        $project->uid = $this->uid;
        $project->buy_process_template_id = 1;
        $project->area = self::area($this->province_id,$this->city_id,$this->district_id);
        $project->created_at = time();
        $project->status = ProjectModel::STATUS_PENDING;
        $project->release_at = time();
        $project->desc = $this->desc;
        $info = UserProfileModel::getProjectServiceUser($this->city_id);
        $project->service_uid = isset($info['uid']) ? $info['uid']:'';
        //查看图片是否存在
        $images = array();
        if(isset($this->image_ids) && !empty($this->image_ids))
        {
            $img_service = new ImageServiceHandle(Yii::app()->params['frontend_app'],Yii::app()->params['frontend_secret']);
            foreach($this->image_ids as $image_str){
                list($image_id,$type) = explode('_',$image_str);
                if($type == PubForm::TYPE_IMG_SERVER)
                {
                    $file = $img_service->getFile($image_id);
                    if(isset($file["url"])){
                        $images[] = $file["url"];
                    }
                }else{
                    $is_find = ProjectAttachmentModel::model()->findByPk($image_id);
                    if($is_find && $is_find['project_id'] == $project->id)
                    {
                        $images[] = $is_find['src'];
                    }
                }

            }
        }
        $project->image = isset($images[0]) ? $images[0] : Yii::app()->params['pub_default_img'];
        if($project->save())
        {
            ProjectModel::setProjectId($project->id);
            //先删除在添加
            ProjectAttachmentModel::model()->deleteAllByAttributes(array('project_id'=>$project->id));
            //资产附加图片
            foreach($images as $obj)
            {
                $img = new ProjectAttachmentModel;
                $img->project_id = $project->id;
                $img->src = $obj;
                $img->save();
            }
        }
            return $project->id;
    }
    public function setInfo($info)
    {
        $this->title = $info['title'];
        $this->buy_method_id = $info['buy_method_id'];
        $this->price = $info['price'];
        $this->province_id = $info['province_id'];
        $this->city_id =  $info['city_id'];
        $this->district_id =  $info['district_id'];
        $this->floor_area =  $info['floor_area'];
        $this->attributes_id =  $info['attributes_id'];
        $this->build_age =  $info['build_age'];
        $this->house_floor =  $info['house_floor'];
        $this->total_floor =  $info['total_floor'];
        $this->rooms =  $info['rooms'];
        $this->halls =  $info['halls'];
        $this->orientation =  $info['orientation'];
        $this->decoration_type =  $info['decoration_type'];
        $this->desc =  $info['desc'];
        $this->ownership_type = explode(',', $info['ownership_type']);
    }
    public static function area($province_id,$city_id,$district_id)
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
    public function isPhone()
    {
        $isPhone = Utils::isPhone($this->phone);
        if (!$isPhone) {
            $this->addError('phone', '手机号码格式有误');
        }
    }

    public function attributeLabels()
    {
        return array(
            'title' => '标题',
            'buy_method_id' => '交易方式',
            'area' => '地域名：省 市 区',
            'ownership_type' => '权属现状',
            'price' => '出售价格',
            'floor_area'=>'建筑面积',
            'attributes_id' => '资产属性',
            'province_id'=>'区域',
            'city_id'=>'区域',
            'district_id'=>'区域',
            'total_floor'=>'所在楼层',
            'house_floor'=>'所在楼层',
            'rooms'=>'户型',
            'halls'=>'户型',
            'desc'=>'描述',
            'phone'=>'手机号码',
        );
    }







}