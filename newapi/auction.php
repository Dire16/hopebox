<?php
/**
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/10/11
 * Time: 10:26
 */
//require __DIR__.'/newapi.php';
//class auction{
//    private $newapi;
//    public function __construct(newapi $newapi)
//    {
//        $this->newapi = $newapi;
//    }
//    public function run(){
//        return $this->_jsontitle($this->_handauction());
//    }
//    private function _jsontitle($array,$code=0)
//    {
//        /*if($array === null && $code === 0){
//            $code = 204;
//        }
//        if($array !== null && $code === 0){
//            $code = 200;
//        }*/
//        if ($code > 0 && $code != 200 && $code != 204) {
//            header("HTTP/1.1 " . $code . "  " . $this->_statusCodes[$code]);
//        }
//        header("Content-Type=application/json;charset=UTF-8 ");
//        echo json_encode($array, JSON_UNESCAPED_UNICODE);
//
//        exit();
//    }
//
//
//    private function _getBodyParams(){
//        $raw = file_get_contents('php://input');
//        if(empty($raw)){
//            throw new Exception("请求参数错误", 400);
//        }
//        return json_decode($raw,true);
//    }
//    private function _handauction(){
//        $body=$this->_getBodyParams();
//        return $this->newapi->getauction($body['price'],$body['num']);
//    }
//}
//$oapi=new newapi();
//$concent=new auction($oapi);
//$concent->run();
echo "{\"memberrate\":\"0.845\", \"nomemberrate\":\"0.65\"}";