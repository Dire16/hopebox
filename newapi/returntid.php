<?php
/**
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/10/13
 * Time: 10:44
 */
require '../post_reply.php';
$pdo=require '../db.php';
class returntid{
    private $_post_reply;
    public function __construct(post_reply $_post_reply)
    {
        $this->_post_reply = $_post_reply;
    }
    public function run(){
        return $this->_jsontitle($this->gettidposition());
    }
    private function _jsontitle($array,$code=0)
    {
        /*if($array === null && $code === 0){
            $code = 204;
        }
        if($array !== null && $code === 0){
            $code = 200;
        }*/
        if ($code > 0 && $code != 200 && $code != 204) {
            header("HTTP/1.1 " . $code . "  " . $this->_statusCodes[$code]);
        }
        header("Content-Type=application/json;charset=UTF-8 ");
        echo json_encode($array, JSON_UNESCAPED_UNICODE);

        exit();
    }


    private function _getBodyParams(){
        $raw = file_get_contents('php://input');
        if(empty($raw)){
            throw new Exception("请求参数错误", 400);
        }
        return json_decode($raw,true);
    }
    private function gettidposition(){
        return $this->_post_reply->returntid();
    }
}
$_post_reply=new post_reply($pdo);
$concent=new returntid($_post_reply);
$concent->run();
