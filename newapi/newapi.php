<?php
/**
 * Created by PhpStorm.
 * User: zz
 * Date: 2017/10/11
 * Time: 10:35
 */
class newapi{
    public function getauction($Price,$num){
        $memberrate=$Price*$num*0.845;
        $nomemberrate=$Price*$num*0.65;
         return array(
            'memberrate'=>$memberrate,
            'nomemberrate'=>$nomemberrate,
        );
    }
}