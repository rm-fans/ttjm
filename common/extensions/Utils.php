<?php
 
/**
 * Created by PhpStorm.
 * User: druphliu@gmail.com
 * Date: 15-7-28
 * Time: 下午3:26
 */
class Utils
{
    /**
     * 获取客户端ip
     * @return string
     */
    public static function getIp()
    {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        return $onlineip;
    }

    /**
     *获取当前用户城市
     */
    public static function getLocalCity()
    {

        $ip = self::getIp();
        $key = ip2long($ip);
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        if(empty($res)){ return false; }
        $jsonMatches = array();
        preg_match('#\{.+?\}#', $res, $jsonMatches);
        if(!isset($jsonMatches[0])){ return false; }
        $json = json_decode($jsonMatches[0], true);
        if(isset($json['ret']) && $json['ret'] == 1){
           return $json['city'];
        }else{
            return false;
        }

    }

    public static function setCookie($name,$value,$expire=2592000)
    {
        $cookie = new CHttpCookie($name, $value);
        if ($expire) {
            $cookie->expire = time() + $expire;
        }
        Yii::app()->getRequest()->cookies[$name] = $cookie;
        return true;
    }

    public static function getCookie($name)
    {
        $cookie = Yii::app()->getRequest()->getCookies();
        return isset($cookie[$name]) ? $cookie[$name]->value : '';
    }

    public static function delCookie($name)
    {
        $cookie = Yii::app()->request->getCookies();
        unset($cookie[$name]);
    }
    /**
     * 返回用户名类型1手机2邮箱0默认
     * @param $username
     * @return int
     */
    public static function getInputType($username)
    {
        if ((bool)preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)+$/i', $username)) {
            return 2;
        } else if ((bool)preg_match('/^(13|14|15|17|18)\d{9}$/i', $username)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function filterIntval($id)
    {
        return intval($id);
    }

    /**
     * 随机生成验证码
     * @param $count
     * @return string
     */
    public static function generateCode($count, $hasABC = false)
    {
        $str = $hasABC ? '23456789abcdefghjkmnpqrstuvwxyz' : '23456789';
        $len = strlen($str) - 1;
        $count = $count < 4 ? 4 : $count;
        $string = '';
        for ($i = 0; $i < $count; $i++) {
            $string .= $str[mt_rand(0, $len)];
        }
        return $string;
    }

    /**
     * 随机生成用户名
     * @return string
     */
    public static function generateName()
    {
    	$username = 'U'.substr(time(),-3).substr(microtime(),2,5);
    	return $username;
    }

    /**
     * json消息返回
     * @param $code
     * @param string $msg
     * @param null $data
     * @param null $options
     * @return string
     */
    public static function jsonResult($code, $msg = '', $data = null, $options = null)
    {
    	return json_encode(array('code'=>$code, 'message'=>$msg, 'data'=>$data, 'options'=>$options));
    }

    /**
     * 加星号
     * @param $string
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function addPointer($string, $start, $end)
    {
        $pointer = '';
        $length = $end - $start;
        $string = preg_replace("/ +/",' ',$string);
        if (preg_match("/^[\x7f-\xff]+$/", $string)) {
            //如果中文
            $start *= 3;
            $end *= 3;
            
            $tempLength = floor($length / 3);
            for ($i = 1; $i <= $tempLength; $i++) {
            	$pointer .= "*";
            }
        }else{
	        for ($i = 1; $i <= $length; $i++) {
	            $pointer .= "*";
	        }
        }
        return strlen($string) > $start ? substr_replace($string, $pointer, $start, $length) : $string;
    }

    public static function createDir($path){
            if(!is_dir($path)){
                if(!self::createDir(dirname($path))){
                    return false;
                }
                if(!mkdir($path,0777)){
                    return false;
                }
            }
            return true;
    }

    /**
     * 发送HTTP请求
     */
    public static function sendHttpRequest($url, $params = array(), $method = 'GET', $header = array(), $timeout = 5)
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            if ($method == 'GET') {
                if (strpos($url, '?')) $url .= '&' . is_array($params) ? http_build_query($params) : $params;
                else $url .= '?' . is_array($params) ? http_build_query($params) : $params;

                curl_setopt($ch, CURLOPT_URL, $url);
            } elseif ($method == 'POST') {
               // $post_data = is_array($params) ? http_build_query($params) : $params;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

            }
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            //https不验证证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if (!empty($header)) {
                //curl_setopt($ch, CURLOPT_NOBODY,FALSE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
            }
            if ($timeout) curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $content = curl_exec($ch);
            $info = curl_getinfo($ch);
            $errors = curl_error($ch);
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
                $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($content, 0, $headerSize);
                $content = substr($content, $headerSize);
                return array('content' => $content, 'info' => $info, 'error' => $errors, 'header' => $header);
            }else{
                return array('content' => $content, 'info' => $info, 'error' => $errors);
            }
        } else {
            $data_string = http_build_query($params);
            $context = array(
                'http' => array('method' => $method,
                    'header' => 'Content-type: application/x-www-form-urlencoded' . "\r\n" .
                        'Content-length: ' . strlen($data_string),
                    'content' => $data_string)
            );
            $contextid = stream_context_create($context);
            $sock = fopen($url, 'r', false, $contextid);
            if ($sock) {
                $result = '';
                while (!feof($sock)) $result .= fgets($sock, 4096);
                fclose($sock);
            }
            return array('content' => $result);
        }
    }

    /**
     * 加密解密函数
     * @param $string
     * @param string $operation
     * @param string $key
     * @param int $expiry
     * @return string
     */
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        $codeKey = '4f6647577904fab5614dbf7385d1b0ed';
        $ckey_length = 4;
        $key = md5($key ? $key : $codeKey);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $string = $operation == 'DECODE' ? strtr($string, '-_', '+/') : $string;
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return strtr( $keyc . str_replace('=', '', base64_encode($result)), '+/', '-_');
        }
    }
    
    /**
     * 返回两个时间点相差时分秒
     * param $onlyDay 只返回天（补差）
     */
    public static function timediff($begin_time, $end_time, $return_day = false,$onlyDay = false)
    {
    	$days = 0;
    	$hours = 0;
    	$mins = 0;
    	$secs = 0;

    	if($begin_time < $end_time){
    		$timediff = $end_time - $begin_time;
    		$days = intval($timediff / 86400);
    		$remain = $timediff % 86400;
    		if($onlyDay){
    			return array('day'=>($remain>0?$days+1:$days));
    		}
    		$hours = intval($remain / 3600);
    		if(!$return_day){
    			$hours = $hours + ($days * 24);
    		}
    		$remain = $remain % 3600;
    		$mins = intval($remain / 60);
    		$secs = $remain % 60;
    	}
    	
    	$res = array(
    		"day" => sprintf('%02d',$days),
    		"hour" => sprintf('%02d',$hours),
    		"min" => sprintf('%02d',$mins),
    		"sec" => sprintf('%02d',$secs)
    	);
    	return $res;
    }
   
    /**
     * 基于PHP没有安装 mb_substr 等扩展截取字符串，如果截取中文字则按2个字符计算
     * @param $string
     * @param $length
     * @param string $dot
     * @return mixed|string
     */
    public static function cutstr($string, $length, $dot = ' ...')
    {
        if (strlen($string)*2 <= $length*3) {
            return $string;
        }
        $pre = chr(1);
        $end = chr(1);
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre . '&' . $end, $pre . '"' . $end, $pre . '<' . $end, $pre . '>' . $end), $string);
        $strcut = '';
        if (strtolower('utf-8') == 'utf-8') {
            $n = $tn = $noc = 0;
            while ($n < strlen($string)) {
                $t = ord($string[$n]);
                if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n++;
                    $noc++;
                } elseif (194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } elseif (224 <= $t && $t <= 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } elseif (240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } elseif (248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } elseif ($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n++;
                }
                if ($noc >= $length) {
                    break;
                }
            }
            if ($noc > $length) {
                $n -= $tn;
            }
            $strcut = substr($string, 0, $n);
        } else {
            $_length = $length - 1;
            for ($i = 0; $i < $length; $i++) {
                if (ord($string[$i]) <= 127) {
                    $strcut .= $string[$i];
                } else if ($i < $_length) {
                    $strcut .= $string[$i] . $string[++$i];
                }
            }
        }
        $strcut = str_replace(array($pre . '&' . $end, $pre . '"' . $end, $pre . '<' . $end, $pre . '>' . $end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
        $pos = strrpos($strcut, chr(1));
        if ($pos !== false) {
            $strcut = substr($strcut, 0, $pos);
        }
        return $strcut . $dot;
    }

    /**
     * 跳转
     * @param string $default
     * @return mixed|string
     */
    public static function jsDreferer($default='') {
        if(isset($GLOBALS['_SERVER']['HTTP_REFERER'])) {
           return "window.history.go(-1)";
        } else {
            $referer = Yii::app()->createUrl('site/index');
        }
        if (strpos($referer, 'site/login') || strpos($referer, 'site/register') || !$referer) {
            $referer = Yii::app()->createUrl('site/index');
        }
        return "window.location.href='{$referer}'";
        //return $referer;
    }
    /**
     * 跳转
     * @param string $default
     * @return mixed|string
     */
    public static function dreferer($default='') {
        if(isset($GLOBALS['_SERVER']['HTTP_REFERER'])) {
            $referer = preg_replace("/([\?&])((sid\=[a-z0-9]{6})(&|$))/i", '\\1', $GLOBALS['_SERVER']['HTTP_REFERER']);
            $referer = substr($referer, -1) == '?' ? substr($referer, 0, -1) : $referer;
        } else {
            $referer = $default;
        }
        if (strpos($referer, 'site/login') || strpos($referer, 'site/register') || !$referer) {
            $referer = Yii::app()->createUrl('site/index');
        }
        return $referer;
    }
    
    /**
     * return city name
     */
    public static function getCityName($str)
    {
    	$str = trim($str);
    	$strs = array();
    	$cityName = '';
    	$sp_citys = array(
    		'北京市','天津市','上海市','重庆市'
    	);
    	if($str){
    		$strs = explode(' ', $str);
    		if(count($strs)>1){
    			if(in_array($strs[0], $sp_citys)){
    				$cityName = $strs[0];
    			}else{
    				$cityName = $strs[1];
    			}
    		}
    	}
    	return $cityName;
    }

    /**
     * url添加变量参数
     * @param $url
     * @param $params
     * @return string
     */
    public static function addUrlParam($url, $params)
    {
        $query = $comm = '';
        $urlParse = parse_url(preg_match('/^(http|https:\/\/)/isU', $url) ? $url : 'http://' . $url);
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $query .= $comm . $key . '=' . $value;
                $comm = '&';
            }
        } else {
            $query = $params;
        }
        $scheme = isset($urlParse['scheme']) ? $urlParse['scheme'] : 'http';
        $host = $scheme.'://'.$urlParse['host'];
        $port = isset($urlParse['port'])?':'.$urlParse['port']:'';
        $path = isset($urlParse['path']) ? $urlParse['path'] : '';
        $qu = isset($urlParse['query']) ? $urlParse['query'] . '&' . $query : $query;
        $fragment = isset($urlParse['fragment']) ? '#' . $urlParse['fragment'] : '';
        return $host.$port.$path.'?'.$qu.$fragment;

    }
    
    /**
     * 平台用户关键信息加密、解密
     */
    public static function encrypt($input)
    {
        $key = Yii::app()->params['crypt_key'];
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = self::pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }
    
    public static function decrypt($sStr)
    {
        $sKey = Yii::app()->params['crypt_key'];
        $decrypted= mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $sKey,
            base64_decode($sStr),
            MCRYPT_MODE_ECB
        );
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
    
    private static function pkcs5_pad ($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * @param $num
     * @return float
     * 将金额数转换成只保留小数点后两位，并四舍五入
     */
    public static function formatPriceNumber($num){
        return (float)number_format($num,2,'.','');
    }

    /**
     * 验证是否是合法价格
     * @param $str
     * @return int
     */
    public static  function  isPrice($str){
        return preg_match('/^\d{0,8}\.{0,1}(\d{1,2})?$/', $str);
    }

    /*
     * zip打包
     */
    public static  function ZipPackage($file_path=array(),$filename){
        $zip = new ZipArchive(); //使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
        $path= substr($filename,0,strrpos($filename,'/')+1);
        if (!is_dir($path))
            Utils::createDir($path);
        if (file_exists($filename))
            @unlink($filename);
        $res = $zip->open($filename, ZIPARCHIVE::CREATE);
        if ($res !== TRUE) {
            exit('无法打开文件，或者文件创建失败');
        }
        foreach ($file_path as $src) {
            if (file_exists($src)) {
                $zip->addFile($src, basename($src)); //第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
            }
        }
        $zip->close(); //关闭
        return file_exists($filename);
    }

    public static function getCitys(){
        return array (
            'hot' =>
                array (
                    0 =>
                        array (
                            'name' => '全国',
                            'id' => -1,
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '北京',
                            'id' => 1,
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '上海',
                            'id' => 9,
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '天津',
                            'id' => 2,
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '成都',
                            'id' => 385,
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '重庆',
                            'id' => 22,
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '杭州',
                            'id' => 175,
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '深圳',
                            'id' => 291,
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '南京',
                            'id' => 162,
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '武汉',
                            'id' => 258,
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '广州',
                            'id' => 289,
                            'disabled' => false,
                        ),
                ),
            'A' =>
                array (
                    0 =>
                        array (
                            'name' => '阿坝藏族羌族自治州',
                            'id' => '403',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '阿克苏地',
                            'id' => '482',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '阿拉善盟',
                            'id' => '106',
                            'disabled' => true,
                        ),
                    3 =>
                        array (
                            'name' => '阿勒泰地',
                            'id' => '488',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '阿里地',
                            'id' => '436',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '安康',
                            'id' => '446',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '安庆',
                            'id' => '193',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '鞍山',
                            'id' => '109',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '安顺',
                            'id' => '409',
                            'disabled' => true,
                        ),
                    9 =>
                        array (
                            'name' => '安阳',
                            'id' => '244',
                            'disabled' => true,
                        ),
                    10 =>
                        array (
                            'name' => '澳门',
                            'id' => '34',
                            'disabled' => false,
                        ),
                ),
            'B' =>
                array (
                    0 =>
                        array (
                            'name' => '白城',
                            'id' => '128',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '百色',
                            'id' => '319',
                            'disabled' => true,
                        ),
                    2 =>
                        array (
                            'name' => '白山',
                            'id' => '126',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '白银',
                            'id' => '451',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '蚌埠',
                            'id' => '188',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '保定',
                            'id' => '78',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '宝鸡',
                            'id' => '440',
                            'disabled' => true,
                        ),
                    7 =>
                        array (
                            'name' => '保山',
                            'id' => '418',
                            'disabled' => true,
                        ),
                    8 =>
                        array (
                            'name' => '包头',
                            'id' => '96',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '巴彦淖尔',
                            'id' => '102',
                            'disabled' => true,
                        ),
                    10 =>
                        array (
                            'name' => '巴音郭楞蒙古自治州',
                            'id' => '481',
                            'disabled' => true,
                        ),
                    11 =>
                        array (
                            'name' => '巴中',
                            'id' => '401',
                            'disabled' => true,
                        ),
                    12 =>
                        array (
                            'name' => '北海',
                            'id' => '314',
                            'disabled' => true,
                        ),
                    13 =>
                        array (
                            'name' => '北京',
                            'id' => '1',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '本溪',
                            'id' => '111',
                            'disabled' => false,
                        ),
                    15 =>
                        array (
                            'name' => '毕节',
                            'id' => '412',
                            'disabled' => false,
                        ),
                    16 =>
                        array (
                            'name' => '滨州',
                            'id' => '238',
                            'disabled' => true,
                        ),
                    17 =>
                        array (
                            'name' => '博尔塔拉蒙古自治州',
                            'id' => '480',
                            'disabled' => true,
                        ),
                    18 =>
                        array (
                            'name' => '亳州',
                            'id' => '200',
                            'disabled' => true,
                        ),
                ),
            'C' =>
                array (
                    0 =>
                        array (
                            'name' => '沧州',
                            'id' => '83',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '长春',
                            'id' => '121',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '常德',
                            'id' => '281',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '昌都地',
                            'id' => '432',
                            'disabled' => true,
                        ),
                    4 =>
                        array (
                            'name' => '昌吉回族自治州',
                            'id' => '479',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '长沙',
                            'id' => '275',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '常熟',
                            'id' => '2069',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '长治',
                            'id' => '87',
                            'disabled' => true,
                        ),
                    8 =>
                        array (
                            'name' => '常州',
                            'id' => '165',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '巢湖',
                            'id' => '198',
                            'disabled' => true,
                        ),
                    10 =>
                        array (
                            'name' => '朝阳',
                            'id' => '119',
                            'disabled' => false,
                        ),
                    11 =>
                        array (
                            'name' => '潮州',
                            'id' => '307',
                            'disabled' => true,
                        ),
                    12 =>
                        array (
                            'name' => '承德',
                            'id' => '80',
                            'disabled' => true,
                        ),
                    13 =>
                        array (
                            'name' => '成都',
                            'id' => '385',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '澄迈',
                            'id' => '334',
                            'disabled' => true,
                        ),
                    15 =>
                        array (
                            'name' => '郴州',
                            'id' => '284',
                            'disabled' => false,
                        ),
                    16 =>
                        array (
                            'name' => '赤峰',
                            'id' => '98',
                            'disabled' => false,
                        ),
                    17 =>
                        array (
                            'name' => '池州',
                            'id' => '201',
                            'disabled' => true,
                        ),
                    18 =>
                        array (
                            'name' => '重庆',
                            'id' => '22',
                            'disabled' => false,
                        ),
                    19 =>
                        array (
                            'name' => '崇左',
                            'id' => '323',
                            'disabled' => true,
                        ),
                    20 =>
                        array (
                            'name' => '楚雄彝族自治州',
                            'id' => '423',
                            'disabled' => true,
                        ),
                    21 =>
                        array (
                            'name' => '滁州',
                            'id' => '195',
                            'disabled' => false,
                        ),
                    22 =>
                        array (
                            'name' => '慈溪',
                            'id' => '2151',
                            'disabled' => false,
                        ),
                ),
            'D' =>
                array (
                    0 =>
                        array (
                            'name' => '大连',
                            'id' => '108',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '大理白族自治州',
                            'id' => '427',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '丹东',
                            'id' => '112',
                            'disabled' => true,
                        ),
                    3 =>
                        array (
                            'name' => '儋州',
                            'id' => '328',
                            'disabled' => true,
                        ),
                    4 =>
                        array (
                            'name' => '大庆',
                            'id' => '135',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '大同',
                            'id' => '85',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '大兴安岭',
                            'id' => '142',
                            'disabled' => true,
                        ),
                    7 =>
                        array (
                            'name' => '达州',
                            'id' => '399',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '德宏傣族景颇族自治州',
                            'id' => '428',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '德阳',
                            'id' => '389',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '德州',
                            'id' => '236',
                            'disabled' => true,
                        ),
                    11 =>
                        array (
                            'name' => '定西',
                            'id' => '458',
                            'disabled' => true,
                        ),
                    12 =>
                        array (
                            'name' => '迪庆藏族自治州',
                            'id' => '430',
                            'disabled' => true,
                        ),
                    13 =>
                        array (
                            'name' => '东莞',
                            'id' => '305',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '东台',
                            'id' => '2101',
                            'disabled' => true,
                        ),
                    15 =>
                        array (
                            'name' => '东营',
                            'id' => '227',
                            'disabled' => false,
                        ),
                ),
            'E' =>
                array (
                    0 =>
                        array (
                            'name' => '鄂尔多斯',
                            'id' => '100',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '恩施土家族苗族自治州',
                            'id' => '270',
                            'disabled' => true,
                        ),
                    2 =>
                        array (
                            'name' => '鄂州',
                            'id' => '263',
                            'disabled' => false,
                        ),
                ),
            'F' =>
                array (
                    0 =>
                        array (
                            'name' => '防城港',
                            'id' => '315',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '奉化',
                            'id' => '2149',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '佛山',
                            'id' => '294',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '抚顺',
                            'id' => '110',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '阜新',
                            'id' => '115',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '阜阳',
                            'id' => '196',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '福州',
                            'id' => '203',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '抚州',
                            'id' => '221',
                            'disabled' => true,
                        ),
                ),
            'G' =>
                array (
                    0 =>
                        array (
                            'name' => '甘南藏族自治州',
                            'id' => '461',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '赣州',
                            'id' => '218',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '甘孜藏族自治州',
                            'id' => '404',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '广安',
                            'id' => '398',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '广元',
                            'id' => '391',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '广州',
                            'id' => '289',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '贵港',
                            'id' => '317',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '桂林',
                            'id' => '312',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '贵阳',
                            'id' => '406',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '果洛藏族自治州',
                            'id' => '467',
                            'disabled' => true,
                        ),
                    10 =>
                        array (
                            'name' => '固原',
                            'id' => '473',
                            'disabled' => true,
                        ),
                ),
            'H' =>
                array (
                    0 =>
                        array (
                            'name' => '哈尔滨',
                            'id' => '130',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '海北藏族自治州',
                            'id' => '464',
                            'disabled' => true,
                        ),
                    2 =>
                        array (
                            'name' => '海东',
                            'id' => '463',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '海口',
                            'id' => '324',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '海南藏族自治州',
                            'id' => '466',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '海宁',
                            'id' => '2173',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '哈密',
                            'id' => '478',
                            'disabled' => true,
                        ),
                    7 =>
                        array (
                            'name' => '邯郸',
                            'id' => '76',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '杭州',
                            'id' => '175',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '汉中',
                            'id' => '444',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '鹤壁',
                            'id' => '245',
                            'disabled' => true,
                        ),
                    11 =>
                        array (
                            'name' => '河池',
                            'id' => '321',
                            'disabled' => false,
                        ),
                    12 =>
                        array (
                            'name' => '合肥',
                            'id' => '186',
                            'disabled' => false,
                        ),
                    13 =>
                        array (
                            'name' => '鹤岗',
                            'id' => '133',
                            'disabled' => true,
                        ),
                    14 =>
                        array (
                            'name' => '黑河',
                            'id' => '140',
                            'disabled' => true,
                        ),
                    15 =>
                        array (
                            'name' => '衡水',
                            'id' => '81',
                            'disabled' => false,
                        ),
                    16 =>
                        array (
                            'name' => '衡阳',
                            'id' => '278',
                            'disabled' => false,
                        ),
                    17 =>
                        array (
                            'name' => '和田',
                            'id' => '485',
                            'disabled' => true,
                        ),
                    18 =>
                        array (
                            'name' => '河源',
                            'id' => '302',
                            'disabled' => false,
                        ),
                    19 =>
                        array (
                            'name' => '菏泽',
                            'id' => '239',
                            'disabled' => true,
                        ),
                    20 =>
                        array (
                            'name' => '贺州',
                            'id' => '320',
                            'disabled' => false,
                        ),
                    21 =>
                        array (
                            'name' => '红河哈尼族彝族自治州',
                            'id' => '424',
                            'disabled' => false,
                        ),
                    22 =>
                        array (
                            'name' => '淮安',
                            'id' => '169',
                            'disabled' => false,
                        ),
                    23 =>
                        array (
                            'name' => '淮北',
                            'id' => '191',
                            'disabled' => false,
                        ),
                    24 =>
                        array (
                            'name' => '怀化',
                            'id' => '286',
                            'disabled' => false,
                        ),
                    25 =>
                        array (
                            'name' => '淮南',
                            'id' => '189',
                            'disabled' => true,
                        ),
                    26 =>
                        array (
                            'name' => '黄冈',
                            'id' => '267',
                            'disabled' => false,
                        ),
                    27 =>
                        array (
                            'name' => '黄南藏族自治州',
                            'id' => '465',
                            'disabled' => true,
                        ),
                    28 =>
                        array (
                            'name' => '黄山',
                            'id' => '194',
                            'disabled' => false,
                        ),
                    29 =>
                        array (
                            'name' => '黄石',
                            'id' => '259',
                            'disabled' => false,
                        ),
                    30 =>
                        array (
                            'name' => '呼和浩特',
                            'id' => '95',
                            'disabled' => false,
                        ),
                    31 =>
                        array (
                            'name' => '惠州',
                            'id' => '299',
                            'disabled' => false,
                        ),
                    32 =>
                        array (
                            'name' => '葫芦岛',
                            'id' => '120',
                            'disabled' => false,
                        ),
                    33 =>
                        array (
                            'name' => '呼伦贝尔',
                            'id' => '101',
                            'disabled' => false,
                        ),
                    34 =>
                        array (
                            'name' => '湖州',
                            'id' => '179',
                            'disabled' => true,
                        ),
                    35 =>
                        array (
                            'name' => '海西蒙古族藏族自治州',
                            'id' => '469',
                            'disabled' => false,
                        ),
                ),
            'J' =>
                array (
                    0 =>
                        array (
                            'name' => '佳木斯',
                            'id' => '137',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '吉安',
                            'id' => '219',
                            'disabled' => true,
                        ),
                    2 =>
                        array (
                            'name' => '江门',
                            'id' => '295',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '江阴',
                            'id' => '2045',
                            'disabled' => true,
                        ),
                    4 =>
                        array (
                            'name' => '焦作',
                            'id' => '247',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '嘉兴',
                            'id' => '178',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '嘉峪关',
                            'id' => '449',
                            'disabled' => true,
                        ),
                    7 =>
                        array (
                            'name' => '揭阳',
                            'id' => '308',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '吉林',
                            'id' => '122',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '济南',
                            'id' => '223',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '金昌',
                            'id' => '450',
                            'disabled' => true,
                        ),
                    11 =>
                        array (
                            'name' => '晋城',
                            'id' => '88',
                            'disabled' => true,
                        ),
                    12 =>
                        array (
                            'name' => '景德镇',
                            'id' => '213',
                            'disabled' => false,
                        ),
                    13 =>
                        array (
                            'name' => '荆门',
                            'id' => '264',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '荆州',
                            'id' => '266',
                            'disabled' => false,
                        ),
                    15 =>
                        array (
                            'name' => '金华',
                            'id' => '183',
                            'disabled' => true,
                        ),
                    16 =>
                        array (
                            'name' => '济宁',
                            'id' => '230',
                            'disabled' => false,
                        ),
                    17 =>
                        array (
                            'name' => '金坛',
                            'id' => '2064',
                            'disabled' => false,
                        ),
                    18 =>
                        array (
                            'name' => '晋中',
                            'id' => '90',
                            'disabled' => false,
                        ),
                    19 =>
                        array (
                            'name' => '锦州',
                            'id' => '113',
                            'disabled' => false,
                        ),
                    20 =>
                        array (
                            'name' => '九江',
                            'id' => '215',
                            'disabled' => false,
                        ),
                    21 =>
                        array (
                            'name' => '酒泉',
                            'id' => '456',
                            'disabled' => true,
                        ),
                    22 =>
                        array (
                            'name' => '鸡西',
                            'id' => '132',
                            'disabled' => false,
                        ),
                    23 =>
                        array (
                            'name' => '句容',
                            'id' => '2120',
                            'disabled' => false,
                        ),
                ),
            'K' =>
                array (
                    0 =>
                        array (
                            'name' => '开封',
                            'id' => '241',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '喀什地区',
                            'id' => '484',
                            'disabled' => true,
                        ),
                    2 =>
                        array (
                            'name' => '克拉玛依',
                            'id' => '476',
                            'disabled' => true,
                        ),
                    3 =>
                        array (
                            'name' => '克孜勒苏柯尔克孜自治州',
                            'id' => '483',
                            'disabled' => true,
                        ),
                    4 =>
                        array (
                            'name' => '昆明',
                            'id' => '415',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '昆山',
                            'id' => '2072',
                            'disabled' => true,
                        ),
                ),
            'L' =>
                array (
                    0 =>
                        array (
                            'name' => '来宾',
                            'id' => '322',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '莱芜',
                            'id' => '234',
                            'disabled' => true,
                        ),
                    2 =>
                        array (
                            'name' => '廊坊',
                            'id' => '82',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '兰州',
                            'id' => '448',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '拉萨',
                            'id' => '431',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '乐山',
                            'id' => '394',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '凉山彝族自治州',
                            'id' => '405',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '连云港',
                            'id' => '168',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '聊城',
                            'id' => '237',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '辽阳',
                            'id' => '116',
                            'disabled' => true,
                        ),
                    10 =>
                        array (
                            'name' => '辽源',
                            'id' => '124',
                            'disabled' => true,
                        ),
                    11 =>
                        array (
                            'name' => '丽江',
                            'id' => '420',
                            'disabled' => true,
                        ),
                    12 =>
                        array (
                            'name' => '临沧',
                            'id' => '422',
                            'disabled' => true,
                        ),
                    13 =>
                        array (
                            'name' => '临汾',
                            'id' => '93',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '临夏回族自治州',
                            'id' => '460',
                            'disabled' => true,
                        ),
                    15 =>
                        array (
                            'name' => '临沂',
                            'id' => '235',
                            'disabled' => false,
                        ),
                    16 =>
                        array (
                            'name' => '林芝',
                            'id' => '437',
                            'disabled' => true,
                        ),
                    17 =>
                        array (
                            'name' => '丽水',
                            'id' => '185',
                            'disabled' => true,
                        ),
                    18 =>
                        array (
                            'name' => '六安',
                            'id' => '199',
                            'disabled' => true,
                        ),
                    19 =>
                        array (
                            'name' => '六盘水',
                            'id' => '407',
                            'disabled' => true,
                        ),
                    20 =>
                        array (
                            'name' => '柳州',
                            'id' => '311',
                            'disabled' => false,
                        ),
                    21 =>
                        array (
                            'name' => '溧阳',
                            'id' => '2063',
                            'disabled' => true,
                        ),
                    22 =>
                        array (
                            'name' => '陇南',
                            'id' => '459',
                            'disabled' => true,
                        ),
                    23 =>
                        array (
                            'name' => '龙岩',
                            'id' => '210',
                            'disabled' => false,
                        ),
                    24 =>
                        array (
                            'name' => '娄底',
                            'id' => '287',
                            'disabled' => true,
                        ),
                    25 =>
                        array (
                            'name' => '吕梁',
                            'id' => '94',
                            'disabled' => false,
                        ),
                    26 =>
                        array (
                            'name' => '漯河',
                            'id' => '250',
                            'disabled' => false,
                        ),
                    27 =>
                        array (
                            'name' => '洛阳',
                            'id' => '242',
                            'disabled' => true,
                        ),
                    28 =>
                        array (
                            'name' => '泸州',
                            'id' => '388',
                            'disabled' => false,
                        ),
                ),
            'M' =>
                array (
                    0 =>
                        array (
                            'name' => '马鞍山',
                            'id' => '190',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '茂名',
                            'id' => '297',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '眉山',
                            'id' => '396',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '梅州',
                            'id' => '300',
                            'disabled' => true,
                        ),
                    4 =>
                        array (
                            'name' => '绵阳',
                            'id' => '390',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '牡丹江',
                            'id' => '139',
                            'disabled' => false,
                        ),
                ),
            'N' =>
                array (
                    0 =>
                        array (
                            'name' => '南昌',
                            'id' => '212',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '南充',
                            'id' => '395',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '南京',
                            'id' => '162',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '南宁',
                            'id' => '310',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '南平',
                            'id' => '209',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '南通',
                            'id' => '167',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '南阳',
                            'id' => '252',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '那曲地',
                            'id' => '435',
                            'disabled' => true,
                        ),
                    8 =>
                        array (
                            'name' => '内江',
                            'id' => '393',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '宁波',
                            'id' => '176',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '宁德',
                            'id' => '211',
                            'disabled' => true,
                        ),
                    11 =>
                        array (
                            'name' => '怒江傈僳族自治州',
                            'id' => '429',
                            'disabled' => false,
                        ),
                ),
            'P' =>
                array (
                    0 =>
                        array (
                            'name' => '盘锦',
                            'id' => '117',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '攀枝花',
                            'id' => '387',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '平顶山',
                            'id' => '243',
                            'disabled' => true,
                        ),
                    3 =>
                        array (
                            'name' => '平湖',
                            'id' => '2171',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '平凉',
                            'id' => '455',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '萍乡',
                            'id' => '214',
                            'disabled' => true,
                        ),
                    6 =>
                        array (
                            'name' => '莆田',
                            'id' => '205',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '濮阳',
                            'id' => '248',
                            'disabled' => true,
                        ),
                ),
            'Q' =>
                array (
                    0 =>
                        array (
                            'name' => '黔东南',
                            'id' => '413',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '潜江',
                            'id' => '272',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '黔南',
                            'id' => '414',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '黔西南',
                            'id' => '411',
                            'disabled' => true,
                        ),
                    4 =>
                        array (
                            'name' => '青岛',
                            'id' => '224',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '庆阳',
                            'id' => '457',
                            'disabled' => true,
                        ),
                    6 =>
                        array (
                            'name' => '清远',
                            'id' => '304',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '秦皇岛',
                            'id' => '75',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '钦州',
                            'id' => '316',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '琼海',
                            'id' => '327',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '齐齐哈尔',
                            'id' => '131',
                            'disabled' => false,
                        ),
                    11 =>
                        array (
                            'name' => '七台河',
                            'id' => '138',
                            'disabled' => false,
                        ),
                    12 =>
                        array (
                            'name' => '泉州',
                            'id' => '207',
                            'disabled' => false,
                        ),
                    13 =>
                        array (
                            'name' => '曲靖',
                            'id' => '416',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '衢州',
                            'id' => '182',
                            'disabled' => true,
                        ),
                ),
            'R' =>
                array (
                    0 =>
                        array (
                            'name' => '日喀则地',
                            'id' => '434',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '日照',
                            'id' => '233',
                            'disabled' => false,
                        ),
                ),
            'S' =>
                array (
                    0 =>
                        array (
                            'name' => '三门峡',
                            'id' => '251',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '三明',
                            'id' => '206',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '三亚',
                            'id' => '325',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '厦门',
                            'id' => '204',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '上海',
                            'id' => '9',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '商洛',
                            'id' => '447',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '商丘',
                            'id' => '253',
                            'disabled' => true,
                        ),
                    7 =>
                        array (
                            'name' => '上饶',
                            'id' => '222',
                            'disabled' => true,
                        ),
                    8 =>
                        array (
                            'name' => '上虞',
                            'id' => '2181',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '山南地',
                            'id' => '433',
                            'disabled' => true,
                        ),
                    10 =>
                        array (
                            'name' => '汕头',
                            'id' => '293',
                            'disabled' => false,
                        ),
                    11 =>
                        array (
                            'name' => '汕尾',
                            'id' => '301',
                            'disabled' => true,
                        ),
                    12 =>
                        array (
                            'name' => '韶关',
                            'id' => '290',
                            'disabled' => false,
                        ),
                    13 =>
                        array (
                            'name' => '绍兴',
                            'id' => '180',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '邵阳',
                            'id' => '279',
                            'disabled' => false,
                        ),
                    15 =>
                        array (
                            'name' => '神农架',
                            'id' => '274',
                            'disabled' => true,
                        ),
                    16 =>
                        array (
                            'name' => '沈阳',
                            'id' => '107',
                            'disabled' => false,
                        ),
                    17 =>
                        array (
                            'name' => '深圳',
                            'id' => '291',
                            'disabled' => false,
                        ),
                    18 =>
                        array (
                            'name' => '石河子',
                            'id' => '489',
                            'disabled' => true,
                        ),
                    19 =>
                        array (
                            'name' => '石家庄',
                            'id' => '73',
                            'disabled' => false,
                        ),
                    20 =>
                        array (
                            'name' => '十堰',
                            'id' => '260',
                            'disabled' => true,
                        ),
                    21 =>
                        array (
                            'name' => '石嘴山',
                            'id' => '471',
                            'disabled' => true,
                        ),
                    22 =>
                        array (
                            'name' => '朔州',
                            'id' => '89',
                            'disabled' => false,
                        ),
                    23 =>
                        array (
                            'name' => '思茅',
                            'id' => '421',
                            'disabled' => true,
                        ),
                    24 =>
                        array (
                            'name' => '四平',
                            'id' => '123',
                            'disabled' => false,
                        ),
                    25 =>
                        array (
                            'name' => '松原',
                            'id' => '127',
                            'disabled' => false,
                        ),
                    26 =>
                        array (
                            'name' => '绥化',
                            'id' => '141',
                            'disabled' => true,
                        ),
                    27 =>
                        array (
                            'name' => '遂宁',
                            'id' => '392',
                            'disabled' => true,
                        ),
                    28 =>
                        array (
                            'name' => '随州',
                            'id' => '269',
                            'disabled' => true,
                        ),
                    29 =>
                        array (
                            'name' => '宿迁',
                            'id' => '174',
                            'disabled' => false,
                        ),
                    30 =>
                        array (
                            'name' => '苏州',
                            'id' => '166',
                            'disabled' => false,
                        ),
                    31 =>
                        array (
                            'name' => '宿州',
                            'id' => '197',
                            'disabled' => true,
                        ),
                    32 =>
                        array (
                            'name' => '双鸭山',
                            'id' => '134',
                            'disabled' => true,
                        ),
                ),
            'T' =>
                array (
                    0 =>
                        array (
                            'name' => '塔城地',
                            'id' => '487',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '泰安',
                            'id' => '231',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '太仓',
                            'id' => '2068',
                            'disabled' => true,
                        ),
                    3 =>
                        array (
                            'name' => '台湾',
                            'id' => '32',
                            'disabled' => true,
                        ),
                    4 =>
                        array (
                            'name' => '太原',
                            'id' => '84',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '泰州',
                            'id' => '173',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '台州',
                            'id' => '184',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '唐山',
                            'id' => '74',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '天津',
                            'id' => '2',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '天门',
                            'id' => '273',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '天水',
                            'id' => '452',
                            'disabled' => false,
                        ),
                    11 =>
                        array (
                            'name' => '铁岭',
                            'id' => '118',
                            'disabled' => false,
                        ),
                    12 =>
                        array (
                            'name' => '铜川',
                            'id' => '439',
                            'disabled' => true,
                        ),
                    13 =>
                        array (
                            'name' => '通化',
                            'id' => '125',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '通辽',
                            'id' => '99',
                            'disabled' => true,
                        ),
                    15 =>
                        array (
                            'name' => '铜陵',
                            'id' => '192',
                            'disabled' => false,
                        ),
                    16 =>
                        array (
                            'name' => '铜仁',
                            'id' => '410',
                            'disabled' => true,
                        ),
                    17 =>
                        array (
                            'name' => '吐鲁番地',
                            'id' => '477',
                            'disabled' => false,
                        ),
                ),
            'W' =>
                array (
                    0 =>
                        array (
                            'name' => '万宁',
                            'id' => '330',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '潍坊',
                            'id' => '229',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '威海',
                            'id' => '232',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '渭南',
                            'id' => '442',
                            'disabled' => true,
                        ),
                    4 =>
                        array (
                            'name' => '文昌',
                            'id' => '329',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '文山壮族苗族自治州',
                            'id' => '425',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '温州',
                            'id' => '177',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '乌海',
                            'id' => '97',
                            'disabled' => true,
                        ),
                    8 =>
                        array (
                            'name' => '武汉',
                            'id' => '258',
                            'disabled' => false,
                        ),
                    9 =>
                        array (
                            'name' => '芜湖',
                            'id' => '187',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '乌兰察布',
                            'id' => '103',
                            'disabled' => false,
                        ),
                    11 =>
                        array (
                            'name' => '乌鲁木齐',
                            'id' => '475',
                            'disabled' => true,
                        ),
                    12 =>
                        array (
                            'name' => '武威',
                            'id' => '453',
                            'disabled' => true,
                        ),
                    13 =>
                        array (
                            'name' => '无锡',
                            'id' => '163',
                            'disabled' => false,
                        ),
                    14 =>
                        array (
                            'name' => '吴忠',
                            'id' => '472',
                            'disabled' => true,
                        ),
                    15 =>
                        array (
                            'name' => '梧州',
                            'id' => '313',
                            'disabled' => false,
                        ),
                ),
            'X' =>
                array (
                    0 =>
                        array (
                            'name' => '西安',
                            'id' => '438',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '香港',
                            'id' => '33',
                            'disabled' => true,
                        ),
                    2 =>
                        array (
                            'name' => '湘潭',
                            'id' => '277',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '湘西土家族苗族自治州',
                            'id' => '288',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '襄阳',
                            'id' => '2859',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '咸宁',
                            'id' => '268',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '仙桃',
                            'id' => '271',
                            'disabled' => true,
                        ),
                    7 =>
                        array (
                            'name' => '咸阳',
                            'id' => '441',
                            'disabled' => true,
                        ),
                    8 =>
                        array (
                            'name' => '孝感',
                            'id' => '265',
                            'disabled' => true,
                        ),
                    9 =>
                        array (
                            'name' => '锡林郭勒盟',
                            'id' => '105',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '兴安盟',
                            'id' => '104',
                            'disabled' => true,
                        ),
                    11 =>
                        array (
                            'name' => '邢台',
                            'id' => '77',
                            'disabled' => false,
                        ),
                    12 =>
                        array (
                            'name' => '西宁',
                            'id' => '462',
                            'disabled' => false,
                        ),
                    13 =>
                        array (
                            'name' => '新乡',
                            'id' => '246',
                            'disabled' => true,
                        ),
                    14 =>
                        array (
                            'name' => '信阳',
                            'id' => '254',
                            'disabled' => false,
                        ),
                    15 =>
                        array (
                            'name' => '新余',
                            'id' => '216',
                            'disabled' => true,
                        ),
                    16 =>
                        array (
                            'name' => '忻州',
                            'id' => '92',
                            'disabled' => false,
                        ),
                    17 =>
                        array (
                            'name' => '西双版纳',
                            'id' => '426',
                            'disabled' => true,
                        ),
                    18 =>
                        array (
                            'name' => '宣城',
                            'id' => '202',
                            'disabled' => true,
                        ),
                    19 =>
                        array (
                            'name' => '许昌',
                            'id' => '249',
                            'disabled' => false,
                        ),
                    20 =>
                        array (
                            'name' => '徐州',
                            'id' => '164',
                            'disabled' => false,
                        ),
                    21 =>
                        array (
                            'name' => '厦门',
                            'id' => '204',
                            'disabled' => false,
                        ),
                ),
            'Y' =>
                array (
                    0 =>
                        array (
                            'name' => '雅安',
                            'id' => '400',
                            'disabled' => true,
                        ),
                    1 =>
                        array (
                            'name' => '延安',
                            'id' => '443',
                            'disabled' => true,
                        ),
                    2 =>
                        array (
                            'name' => '延边朝鲜族自治州',
                            'id' => '129',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '盐城',
                            'id' => '170',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '阳江',
                            'id' => '303',
                            'disabled' => false,
                        ),
                    5 =>
                        array (
                            'name' => '阳泉',
                            'id' => '86',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '扬州',
                            'id' => '171',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '烟台',
                            'id' => '228',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '鸭山',
                            'id' => '134',
                            'disabled' => true,
                        ),
                    9 =>
                        array (
                            'name' => '宜宾',
                            'id' => '397',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '宜昌',
                            'id' => '261',
                            'disabled' => false,
                        ),
                    11 =>
                        array (
                            'name' => '宜春',
                            'id' => '220',
                            'disabled' => true,
                        ),
                    12 =>
                        array (
                            'name' => '伊春',
                            'id' => '136',
                            'disabled' => true,
                        ),
                    13 =>
                        array (
                            'name' => '伊犁哈萨克自治州',
                            'id' => '486',
                            'disabled' => true,
                        ),
                    14 =>
                        array (
                            'name' => '银川',
                            'id' => '470',
                            'disabled' => false,
                        ),
                    15 =>
                        array (
                            'name' => '营口',
                            'id' => '114',
                            'disabled' => false,
                        ),
                    16 =>
                        array (
                            'name' => '鹰潭',
                            'id' => '217',
                            'disabled' => false,
                        ),
                    17 =>
                        array (
                            'name' => '义乌',
                            'id' => '2198',
                            'disabled' => true,
                        ),
                    18 =>
                        array (
                            'name' => '宜兴',
                            'id' => '2042',
                            'disabled' => false,
                        ),
                    19 =>
                        array (
                            'name' => '益阳',
                            'id' => '283',
                            'disabled' => false,
                        ),
                    20 =>
                        array (
                            'name' => '永州',
                            'id' => '285',
                            'disabled' => false,
                        ),
                    21 =>
                        array (
                            'name' => '岳阳',
                            'id' => '280',
                            'disabled' => false,
                        ),
                    22 =>
                        array (
                            'name' => '玉林',
                            'id' => '318',
                            'disabled' => true,
                        ),
                    23 =>
                        array (
                            'name' => '榆林',
                            'id' => '445',
                            'disabled' => true,
                        ),
                    24 =>
                        array (
                            'name' => '运城',
                            'id' => '91',
                            'disabled' => false,
                        ),
                    25 =>
                        array (
                            'name' => '云浮',
                            'id' => '309',
                            'disabled' => false,
                        ),
                    26 =>
                        array (
                            'name' => '玉树藏族自治州',
                            'id' => '468',
                            'disabled' => true,
                        ),
                    27 =>
                        array (
                            'name' => '玉溪',
                            'id' => '417',
                            'disabled' => false,
                        ),
                ),
            'Z' =>
                array (
                    0 =>
                        array (
                            'name' => '枣庄',
                            'id' => '226',
                            'disabled' => false,
                        ),
                    1 =>
                        array (
                            'name' => '张家港',
                            'id' => '2071',
                            'disabled' => false,
                        ),
                    2 =>
                        array (
                            'name' => '张家界',
                            'id' => '282',
                            'disabled' => false,
                        ),
                    3 =>
                        array (
                            'name' => '张家口',
                            'id' => '79',
                            'disabled' => false,
                        ),
                    4 =>
                        array (
                            'name' => '张掖',
                            'id' => '454',
                            'disabled' => true,
                        ),
                    5 =>
                        array (
                            'name' => '漳州',
                            'id' => '208',
                            'disabled' => false,
                        ),
                    6 =>
                        array (
                            'name' => '湛江',
                            'id' => '296',
                            'disabled' => false,
                        ),
                    7 =>
                        array (
                            'name' => '肇庆',
                            'id' => '298',
                            'disabled' => false,
                        ),
                    8 =>
                        array (
                            'name' => '昭通',
                            'id' => '419',
                            'disabled' => true,
                        ),
                    9 =>
                        array (
                            'name' => '郑州',
                            'id' => '240',
                            'disabled' => false,
                        ),
                    10 =>
                        array (
                            'name' => '镇江',
                            'id' => '172',
                            'disabled' => false,
                        ),
                    11 =>
                        array (
                            'name' => '中山',
                            'id' => '306',
                            'disabled' => false,
                        ),
                    12 =>
                        array (
                            'name' => '中卫',
                            'id' => '474',
                            'disabled' => true,
                        ),
                    13 =>
                        array (
                            'name' => '周口',
                            'id' => '255',
                            'disabled' => true,
                        ),
                    14 =>
                        array (
                            'name' => '舟山',
                            'id' => '181',
                            'disabled' => false,
                        ),
                    15 =>
                        array (
                            'name' => '珠海',
                            'id' => '292',
                            'disabled' => true,
                        ),
                    16 =>
                        array (
                            'name' => '诸暨',
                            'id' => '2185',
                            'disabled' => false,
                        ),
                    17 =>
                        array (
                            'name' => '驻马店',
                            'id' => '256',
                            'disabled' => true,
                        ),
                    18 =>
                        array (
                            'name' => '株洲',
                            'id' => '276',
                            'disabled' => false,
                        ),
                    19 =>
                        array (
                            'name' => '淄博',
                            'id' => '225',
                            'disabled' => true,
                        ),
                    20 =>
                        array (
                            'name' => '自贡',
                            'id' => '386',
                            'disabled' => false,
                        ),
                    21 =>
                        array (
                            'name' => '资阳',
                            'id' => '402',
                            'disabled' => false,
                        ),
                    22 =>
                        array (
                            'name' => '遵义',
                            'id' => '408',
                            'disabled' => true,
                        ),
                ),
        );
    }

    /**
     * @param $value
     * @param $logo
     * @param int $type 1:url 2:tel
     * @return string|void
     */
    public static function createQrCode($value,$logo,$type=1,$fileName=false){
        $errorCorrectionLevel = 0;//容错级别
        $matrixPointSize = 6;//生成图片大小
        //生成二维码图片
        $QRStr = QRcode::png($value, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);

        if ($logo != FALSE) {
            $QR = imagecreatefromstring($QRStr);
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
            //输出图片
            ob_start();
            imagepng($QR);
            $QRStr = ob_get_contents();
            ob_clean();
        }
        return $QRStr;
    }

    /**
     * 资产列表url链接组合
     * @param array $params_lists 已选择的参数
     * @param $now_param 当前选择的参数
     * @return string
     */
    public static function projectListsUrl($url_param=array(),$url='',$params_lists=array(),$now_param)
    {
        if(empty($now_param))
        {
            $p = implode("_",$params_lists);
            $url.= trim($p,'_');
            return $url;
        }
        $url = rtrim($url,'/').'/';
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
        $url.= trim($p,'_');
        return $url;
    }

    /**
     * 手机格式检查
     * @return bool
     */
    public static function isPhone($phone)
    {
        if (preg_match("/^1(?:3[0-9]|5[012356789]|8[02356789]|7[0678])(?P<separato>-?)\d{4}(?P=separato)\d{4}$/", $phone)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 生成随机密码
     */
    public static function pwd()
    {
        $arr = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','g','k','m','n','p','q','r','s','t','u','v','w','x','y','z');
        $num = count($arr)-1;
        $key = round(1,$num);
        $pwd = $arr[$key];
        for($i=0;$i<7;$i++)
        {
            $key = round(0,$num);
            $pwd .= $arr[$key];
        }
        return $pwd;
    }
    /**
     * APP处理数组
     */
    public static function downlistarray($array,$ios=0){
        $arrays = array();
        foreach ($array as $key=> $item) {
            if($ios==1)
                $v= array('id'=>$key,'name'=>$item);
                //$v= array('id'.$key=>$key,'name'.$key=>$item);
            else
                $v= array('id'=>$key,'name'=>$item);
            array_push($arrays,$v);
        }
        return $arrays;
    }
}

