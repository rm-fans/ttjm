<?php
class EntrustForm extends CFormModel
{
    public $phone;
    public $code;
    public $name;
    public $desc;
    public $verify_code;
    private $_identity;

    public function rules()
    {
        return array(
            array('phone,code,name,verify_code', 'required'),
            array('phone', 'match', 'pattern'=>'/^(13|14|15|17|18)\d{9}$/i', 'message'=>'请输入正确的手机号'),
            array('name','match','pattern'=>'/^[\x{4e00}-\x{9fa5}]+$/u','message'=>'名字只能为中文'),
            array('code', 'authenticate'),

        );
    }
    public function attributeLabels()
    {
        return array(
            'phone' => '手机号',
            'code' => '手机验证码',
            'verify_code' => '图形验证码',
            'name'=>'联系人姓名',
        );
    }
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $SmsLogModel = new SmsLogModel;
            $this->_identity=$SmsLogModel->checkSmsCode($this->code,$this->phone);
            if($this->_identity['code']!=1)
                $this->addError('code',$this->_identity['message']);
        }
    }
}