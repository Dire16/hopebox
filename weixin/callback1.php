<?php

require __DIR__.'/register.php';
$pdo=require __DIR__.'/db.php';
class callback1{
    private $use;

    public function __construct(register $register)
    {
        $this->use=$register;
    }

    public function run(){
         $arr=$this->login();
        $obj = $this->array2object($arr);
        print_r($obj);
    }
    public function array2object($array) {
        if (is_array($array)) {
            $obj = new StdClass();
            foreach ($array as $key => $val)
            {
                $obj->$key = $val;
            }
        }
        else { $obj = $array; }
        return $obj;
    }
    private function _getBodyParams(){
        $raw = file_get_contents('php://input');
        if(empty($raw)){
            throw new Exception("请求参数错误", 400);
        }
        return json_decode($raw,true);
    }

    private function login(){
        $body=$this->_getBodyParams();
        return $this->use->register($body['openid'],$body['nickname'],$body['avatar']);
    }
}
$login =new register($pdo);
$restful=new callback1($login);
$restful->run();
//if($_GET['state']!=$_SESSION["wx_state"]){
//    exit("5001");
//}
//$AppID = 'wx33589087f8e1fb68';
//$AppSecret = 'bfb57e9dad5df9f21283af00009ea5c9';
//$url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$AppID.'&secret='.$AppSecret.'&code='.$_GET['code'].'&grant_type=authorization_code';
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//curl_setopt($ch, CURLOPT_URL, $url);
//$json =  curl_exec($ch);
//curl_close($ch);
//$arr=json_decode($json,1);
////得到 access_token 与 openid
//print_r($arr);
//$url='https://api.weixin.qq.com/sns/userinfo?access_token='.$arr['access_token'].'&openid='.$arr['openid'].'&lang=zh_CN';
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//curl_setopt($ch, CURLOPT_URL, $url);
//$json =  curl_exec($ch);
//curl_close($ch);
//$arr=json_decode($json,1);
//print_r($arr);//openid nickname city province country  headimgurl
