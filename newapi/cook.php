<?php
/**
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/10/13
 * Time: 10:10
 */
$filename = "cook.json";
$cook_string = file_get_contents($filename);
$filename1="cookstages.json";
$stages_string=file_get_contents($filename1);
$filename2="cloth.json";
$cloth_string=file_get_contents($filename2);
$filename3="rock.json";
$rock_string=file_get_contents($filename3);
$filename4="buff.json";
$buff_string=file_get_contents($filename4);
$str="{\"datas\":".$cook_string.", \"stages\":".$stages_string.", \"cloths\":".$cloth_string.
    ", \"rocks\":".$rock_string.", \"buffs\":".$buff_string.",\"suits\":[{\"name\":\"是\", \"time\":\"-2\", \"num\":\"0\"},{\"name\":\"否\", \"time\":\"0\", \"num\":\"0\"}]}";
echo print_r($str,true);            //打印文件的内容