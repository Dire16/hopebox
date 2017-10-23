<?php
/**
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/8/16
 * Time: 18:14
 */
require_once ('./db.php');
$connect = Db::getInstance()->connect();
$sql = "select * from pre_bnscc8_tshuz_clan";
$result = mysql_query($sql, $connect);
$results = array();
while ($row = mysql_fetch_assoc($result)) {
    $results[] = $row;
}
$good = [
    'code' =>0,
    'msg'=>' ',
    'count'=>1000,
    'data'=>$results
];
echo json_encode($results,JSON_UNESCAPED_UNICODE);
