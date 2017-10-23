<?php
/**
 * 连接数据库，返回数据库连接句柄
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/8/18
 * Time: 18:14
 */

$pdo = new PDO('mysql:host=localhost;dbname=video','root','123',array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8",PDO::ATTR_EMULATE_PREPARES=>false));
return $pdo;
