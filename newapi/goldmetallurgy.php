<?php
/**
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/10/13
 * Time: 9:25
 */
$filename = "gold.json";
$gold_string = file_get_contents($filename);
$filename1="stages.json";
$stages_string=file_get_contents($filename1);
$filename2="cloth.json";
$cloth_string=file_get_contents($filename2);
$filename3="rock.json";
$rock_string=file_get_contents($filename3);
$filename4="buff.json";
$buff_string=file_get_contents($filename4);
$str="{\"datas\":".$gold_string.", \"stages\":".$stages_string.", \"cloths\":".$cloth_string.
    ", \"rocks\":".$rock_string.", \"buffs\":".$buff_string.",\"suits\":[]}";
echo print_r($str,true);            //打印文件的内容
