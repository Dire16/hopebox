<?php
/**
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/10/13
 * Time: 10:44
 */
require '../post_reply.php';
$pdo=require '../db.php';
class tidcontent{
    private $_post_reply;
    public function __construct(post_reply $_post_reply)
    {
        $this->_post_reply = $_post_reply;
    }
    public function run(){
        echo $this->gettidposition();
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
        $body=$this->_getBodyParams();
        return $this->_post_reply->replies($body['tid']);
    }
}
$_post_reply=new post_reply($pdo);
$concent=new tidcontent($_post_reply);
$concent->run();
