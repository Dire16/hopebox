<?php
/**
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/8/19
 * Time: 19:44
 */
require __DIR__.'/../lib/User.php';
//require __DIR__ . '/../lib/Boss.php';
$pdo=require __DIR__.'/../lib/db.php';
class restful{
    private $_user;
    private $_requestMethod;
    private $_resourceName;
    /**
     * 请求的资源ID
     * @var string
     */
    private $_id;
    /**
     * 允许请求的资源列表
     * @var array
     */
    private $_allowResources=array('users','select','bossselect','bossdesc','bosslasttime','returntid','handtid');
    /**
     * 允许请求的http方法
     * @var array
     */
    private $_allowResquestMethods=array('GET','POST','PUT','DELETE','OPTIONS');
    private $_statusCodes = array(
        200 => 'OK',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Server Internet Error'
    );

    /**
     * restful constructor.
     * @param User $_user
     */
    public function __construct(User $_user)
    {
        $this->_user = $_user;
    }
    public function  run(){
        try{
            $this->_setupRequestMethod();
            $this->_setupResource();
            if($this->_resourceName == 'users'){

                return $this->_json($this->_handleUser());
            }
            if($this->_resourceName == 'select'){

                return $this->_json($this->_handledeadtimeView());
            }
            if($this->_resourceName == 'bossselect')
            {
                return $this->_jsontitle($this->_handledeadtimeView1());
            }
            if($this->_resourceName =='bossdesc')
            {
                return $this->_jsontitle($this->_showdescbossName());
            }
            if($this->_resourceName =='bosslasttime')
            {
                return $this->_jsontitle($this->_bosslasttime());
            }
            if($this->_resourceName =='returntid'){
                return $this->_jsontitle($this->_returntid());
            }
            if($this->_resourceName=='handtid'){
                return $this->_jsontitle($this->_handtid());
            }
        }catch (Exception $e)
        {
            $this->_jsontitle(array('error'=> $e->getMessage()),$e->getCode());
        }
    }
    /**
     * 初始化请求方法
     */
    private function _setupRequestMethod()
    {
        $this->_requestMethod=$_SERVER['REQUEST_METHOD'];
        if(!in_array($this->_requestMethod,$this->_allowResquestMethods)){
            throw new Exception('请求方法不被允许',405);
        }

    }
    /**
     * 初始化请求资源
     */
    private function _setupResource()
    {
        $path =$_SERVER['PATH_INFO'];
        $params =explode('/',$path);
        $this->_resourceName =$params[1];
        if(!in_array($this->_resourceName,$this->_allowResources))
        {
            throw new Exception('请求资源不被允许',400);
        }
		
        if(!empty($params[2])){
            $this->_id =$params[2];
        }
    }


    private function _json($array,$code=0){
        /*if($array === null && $code === 0){
            $code = 204;
        }
        if($array !== null && $code === 0){
            $code = 200;
        }*/
        if($code>0 && $code != 200 && $code != 204){
            header("HTTP/1.1 ".$code."  ".$this->_statusCodes[$code]);
        }
        header("Content-Type=application/json;charset=UTF-8 ");
        $key='BGoIaCn_sCfCmo8sCe';
        echo  $this->encrypt(json_encode($array,JSON_UNESCAPED_UNICODE),$key);

        exit();
    }
    private function _jsontitle($array,$code=0){
        /*if($array === null && $code === 0){
            $code = 204;
        }
        if($array !== null && $code === 0){
            $code = 200;
        }*/
        if($code>0 && $code != 200 && $code != 204){
            header("HTTP/1.1 ".$code."  ".$this->_statusCodes[$code]);
        }
        header("Content-Type=application/json;charset=UTF-8 ");

        echo json_encode($array,JSON_UNESCAPED_UNICODE);

        exit();
    }

    /**
     * 请求用户资源
     */
    private function _handleUser(){
        if($this->_requestMethod != 'POST'){
            throw new Exception("请求方法不被允许", 405);
        }
        $date =date("Y/m/d") ;
        $body = $this->_getBodyParams();
        if(empty($body['player'])){
            throw new Exception("玩家名不能为空", 400);
        }
        if(empty($body['time'])){
            throw new Exception("time不能为空", 400);
        }
        if(empty($body['bossType'])){
            throw new Exception("bossType不能为空", 400);
        }
        if(empty($body['bossName'])){
            throw new Exception("bossName不能为空", 400);
        }
        $this->_user->report_boss($body['bossName'],$body['time'],$body['bossType']);
        return $this->_user->report($body['player'], $body['time'], $body['bossType'],$body['bossName'],$date);
    }

    private function _getBodyParams(){
        $key='BGoIaCn_sCfCmo8sCe';
        $raw = $this->decrypt(file_get_contents('php://input'),$key);
        if(empty($raw)){
            throw new Exception("请求参数错误", 400);
        }
        return json_decode($raw,true);
    }
    private function _getBodyParams1(){
        $raw = file_get_contents('php://input');
        if(empty($raw)){
            throw new Exception("请求参数错误", 400);
        }
        return json_decode($raw,true);
    }
    private function _bosslasttime(){

        return $this->_user->bosslasttime();
    }
    private function _returntid(){
        return $this->_user->returntid();
    }
    private function _handtid(){
        $body = $this->_getBodyParams1();
        if(empty($body['tid'])){
            throw new Exception("tid不能为空", 400);
        }
        if(empty($body['position'])){
            throw new Exception("position不能为空", 400);
        }
        return $this->_user->updatetid($body['tid'],$body['position']);

    }
    private function _handledeadtimeView(){
        $body = $this->_getBodyParams();
        if(empty($body['bossName'])){
            throw new Exception("boss名不能为空", 400);
        }
        return $this->_user->boss_select($body['bossName']);
    }
    private function _handledeadtimeView1(){
        $body = $this->_getBodyParams1();
        if(empty($body['bossName'])){
            throw new Exception("boss名不能为空", 400);
        }
        return $this->_user->boss_select($body['bossName']);
    }
    private function _showdescbossName()
    {
        return $this->_user->boss_desc();
    }
    private function decode($str)
    {
        return base64_decode($str);
    }

    private function encode($str)
    {
        return base64_encode($str);
    }

    private function getBytes($string) {
        $bytes = array();
        for($i = 0; $i < strlen($string); $i++){
            $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }

    private function getString($bytes) {
        $str = '';
        foreach($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }

    private function xor_enc($str, $key){
        $slen = count($str);
        $klen = strlen($key);
        $cipher = '';
        for ($i=0;$i<$slen;$i++) {
            $cipher .= chr($str[$i] ^ ord($key[$i % $klen]));
        }
        return $cipher;
    }

//加密
    private function encrypt($str, $key)
    {
        try {
            $bts = $this->getBytes($str);
            $crypt = $this->xor_enc($bts, $key);
            return $this->encode($crypt);
        }catch (Exception $e){

        }
        return '';
    }

//解密
    private function decrypt($str, $key)
    {
        try {
            if (base64_encode(base64_decode($str)) == $str)
            {
                $base64 = $this->decode($str);
                $bts = $this->getBytes($base64);
                $crypt = $this->xor_enc($bts, $key);
                return $crypt;
            }
        }catch (Exception $e){

        }
        return '';
    }
}
$user =new User($pdo);
$restful=new Restful($user);
$restful->run();
