<?php
require __DIR__.'/ErrorCode.php';
class User{
    /**
     * 数据库连接句柄
     * @var
     */
       private  $_db;
    /**
     * 构造方法
     * User constructor.
     * @param $_db
     */
       public function __construct($_db)
       {
           $this->_db=$_db;

       }
       public function report($player,$time,$bossType,$bossName,$date)
       {
           if(empty($player)){
               throw new Exception('玩家名不能为空',ErrorCode::PLAYER_CANNOT_EMPTY);
           }
           if(empty($time)){
               throw new Exception('没有传入time值',ErrorCode::TIME_CANNOT_EMPTY);
           }
           if(empty($bossType)){
               throw new Exception('没有bossType值',ErrorCode::BOSSTYPE_CANNOT_EMPTY);
           }
           if(empty($bossName)){
               throw new Exception('boss名不能为空',ErrorCode::BOSS_CANNOT_EMPTY);
           }
            /*if(!$this->_isPlayerExists($date,$player,$boss))
            {
                throw new Exception('重复报告',ErrorCode::REPEAT_REPORT);
            }*/

            if($this->_isPlayerExists($player,$date,$bossName))
            {
                $judge=1;
            }else{
                $judge=0;
            }
           if($judge)
           {
               throw new Exception('重复报告',ErrorCode::REPEAT_REPORT);
           }
//           $boss_rename=array(
//               "LUA_DESERTDRAGON_SQAWN"	=> "科扎卡",
//               "LUA_DESERTDRAGON_SQAWN" => "怒贝尔",
//               "LUA_KARANDA_SQAWN"=>"卡兰达",
//               "LUA_ANCIENTWORM_SQAWN"=>"库图姆",
//               "LUA_IMPBOSS_SPAWN"=>"红鼻子",
//               "LUA_ALTERIMPBOSS_SPAWN"=>"小恶魔",
//               "LUA_MUDMAN_SPAWN"=>"泥人",
//               "LUA_TREEDUMMER_SPAWN"=>"树精",
//               "LUA_TRUKING_SPAWN"=>"塔罗卡尔",
//               "LUA_TREEDUMMER_SPAWN"=>"奥加",
//               "LUA_OGREBOSS_SPAWN"=>"穆拉卡",
//               "LUA_OCEAN_BOSS_BELL_SPAWN"=>"贝尔"
//           );
//           if(in_array($bossName,$boss_rename))
//           {
//               $bossName=$boss_rename[$bossName];
//           }
           if($bossName=="LUA_CZAKA_SQAWN")
           {$bossName="科扎卡";}
           if($bossName=="LUA_DESERTDRAGON_SQAWN")
           {$bossName="怒贝尔";}
           if($bossName=="LUA_KARANDA_SQAWN")
           {$bossName="卡兰达";}
           if($bossName=="LUA_ANCIENTWORM_SQAWN")
           {$bossName="库图姆";}
           if($bossName=="LUA_IMPBOSS_SPAWN")
           {$bossName="红鼻子";}
           if($bossName=="LUA_ALTERIMPBOSS_SPAWN")
           {$bossName="小恶魔";}
           if($bossName=="LUA_MUDMAN_SPAWN")
           {$bossName="泥人";}
           if($bossName=="LUA_TREEDUMMER_SPAWN")
           {$bossName="树精";}
           if($bossName=="LUA_TRUKING_SPAWN")
           {$bossName="塔罗卡尔";}
           if($bossName=="LUA_TROLLBOSS_SPAWN")
           {$bossName="奥加";}
           if($bossName=="LUA_OGREBOSS_SPAWN")
           {$bossName="穆拉卡";}
           if($bossName=="LUA_OCEAN_BOSS_BELL_SPAWN")
           {$bossName="贝尔";}
           $sql = "INSERT INTO player_report (`player`, `time`, `bossType`,`bossName`,`date`) VALUES (:player,:time,:bossType,:bossName,:date)";
           $stmt=$this->_db->prepare($sql);
           $stmt->bindParam(':player',$player);
           $stmt->bindParam(':time',$time);
           $stmt->bindParam(':bossType',$bossType);
           $stmt->bindParam(':bossName',$bossName);
           $stmt->bindParam(':date',$date);

           if(!$stmt->execute()){
               throw new Exception('插入数据包失败',ErrorCode::INSERT_FAIL);
           }
           return array(
               'player'	=> $player,
               'time' => $time,
               'bossType' =>$bossType,
               'bossName' => $bossName
           );
       }
       public function boss_select($bossName){
           if($bossName=="LUA_CZAKA_SQAWN")
           {$bossName="科扎卡";}
           if($bossName=="LUA_DESERTDRAGON_SQAWN")
           {$bossName="怒贝尔";}
           if($bossName=="LUA_KARANDA_SQAWN")
           {$bossName="卡兰达";}
           if($bossName=="LUA_ANCIENTWORM_SQAWN")
           {$bossName="库图姆";}
           if($bossName=="LUA_IMPBOSS_SPAWN")
           {$bossName="红鼻子";}
           if($bossName=="LUA_ALTERIMPBOSS_SPAWN")
           {$bossName="小恶魔";}
           if($bossName=="LUA_MUDMAN_SPAWN")
           {$bossName="泥人";}
           if($bossName=="LUA_TREEDUMMER_SPAWN")
           {$bossName="树精";}
           if($bossName=="LUA_TRUKING_SPAWN")
           {$bossName="塔罗卡尔";}
           if($bossName=="LUA_TROLLBOSS_SPAWN")
           {$bossName="奥加";}
           if($bossName=="LUA_OGREBOSS_SPAWN")
           {$bossName="穆拉卡";}
           if($bossName=="LUA_OCEAN_BOSS_BELL_SPAWN")
           {$bossName="贝尔";}
           $sql = "select * from boss where `bossName`=:bossName";
           $stmt=$this->_db->prepare($sql);
           $stmt->bindParam(':bossName',$bossName);
           if(!$stmt->execute()){
               throw new Exception('获取数据失败失败',ErrorCode::INSERT_FAIL);
           }
           $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $data;
       }
       public function boss_desc(){
           $sql="select * from boss ORDER BY time DESC ";
           $stmt=$this->_db->prepare($sql);
           if(!$stmt->execute()){
               throw new Exception('获取数据失败失败',ErrorCode::INSERT_FAIL);
           }
           $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $data;
       }
    /**
     * 检测玩家是否在今天上传过此boss
     * @param $player
     * @return bool
     */
    private  function  _isPlayerExists($player,$date,$bossName){
        $exists=false;
        $sql = "select player,bossName from player_report where `date`=:date AND `player`=:player AND `bossName`=:bossName";
        $stmt=$this->_db->prepare($sql);
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':player',$player);
        $stmt->bindParam(':bossName',$bossName);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($result);
    }
    public function report_boss($bossName,$time,$bossType){
        if($this->_isBossExists($bossName))
        {
            $judge1=1;
        }else{
            $judge1=0;
        }
        if($bossName=="LUA_CZAKA_SQAWN")
        {$bossName="科扎卡";}
        if($bossName=="LUA_DESERTDRAGON_SQAWN")
        {$bossName="怒贝尔";}
        if($bossName=="LUA_KARANDA_SQAWN")
        {$bossName="卡兰达";}
        if($bossName=="LUA_ANCIENTWORM_SQAWN")
        {$bossName="库图姆";}
        if($bossName=="LUA_IMPBOSS_SPAWN")
        {$bossName="红鼻子";}
        if($bossName=="LUA_ALTERIMPBOSS_SPAWN")
        {$bossName="小恶魔";}
        if($bossName=="LUA_MUDMAN_SPAWN")
        {$bossName="泥人";}
        if($bossName=="LUA_TREEDUMMER_SPAWN")
        {$bossName="树精";}
        if($bossName=="LUA_TRUKING_SPAWN")
        {$bossName="塔罗卡尔";}
        if($bossName=="LUA_TROLLBOSS_SPAWN")
        {$bossName="奥加";}
        if($bossName=="LUA_OGREBOSS_SPAWN")
        {$bossName="穆拉卡";}
        if($bossName=="LUA_OCEAN_BOSS_BELL_SPAWN")
        {$bossName="贝尔";}
        if($judge1){
            $sql='UPDATE boss SET `time`=:time ,`bossType`=:bossType WHERE bossName=:bossName';
            $stmt=$this->_db->prepare($sql);
            $stmt->bindParam(':time',$time);
            $stmt->bindParam(':bossName',$bossName);
            $stmt->bindParam(':bossType',$bossType);
            if(!$stmt->execute()){
                throw new Exception('更新数据库失败',ErrorCode::UPDATE_FAIL);
            }
        }else{
            $sql='INSERT INTO boss (`bossName`, `time`,`bossType`) VALUES (:bossName,:time,:bossType)';
            $stmt=$this->_db->prepare($sql);
            $stmt->bindParam(':bossName',$bossName);
            $stmt->bindParam(':time',$time);
            $stmt->bindParam(':bossType',$bossType);
            if(!$stmt->execute()){
                throw new Exception('插入数据库失败',ErrorCode::UPDATE_FAIL);
            }
        }
    }

    private  function  _isBossExists($bossName){
        $sql = 'select bossName from boss where `bossName`=:bossName';
        $stmt=$this->_db->prepare($sql);
        $stmt->bindParam(':bossName',$bossName);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($result);
    }

    public function bosslasttime(){
        $sql ='select bossName,time,bossId from boss';
        $stmt=$this->_db->prepare($sql);
        if(!$stmt->execute()){
            throw new Exception('获取数据失败失败',ErrorCode::INSERT_FAIL);
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $addtime=array(
            [8, 12], [8, 12], [11, 17], [7.83, 7.83], [7.83, 7.83], [7.83, 7.83], [7.83, 7.83]
        );
        $timearray=array();

        for($i =0;$i<count($addtime);$i++){
            $catime=strtotime($data[$i]['time']);
            $time1=$catime+$addtime[$i][0] * 60 * 60;
            $time2=$catime+$addtime[$i][1] * 60 * 60;
            $nowtime1=date("m-d H:i",$time1*1);
            $nowtime2=date("m-d H:i",$time2*1);
            if($addtime[$i][0]==$addtime[$i][1])
            {
                $time3=$nowtime1;
            }else{
                $time3=$nowtime1."~".$nowtime2;
            }
            $timearray[$i]=$time3;
        }
        $imglist=array(
            "/images/bossimg/LUA_CZAKA_SQAWN.png",
            "/images/bossimg/LUA_ANCIENTWORM_SQAWN.png",
            "/images/bossimg/LUA_DESERTDRAGON_SQAWN.png",
            "/images/bossimg/LUA_IMPBOSS_SPAWN.png",
            "/images/bossimg/LUA_MUDMAN_SPAWN.png",
            "/images/bossimg/LUA_TREEDUMMER_SPAWN.png",
            "/images/bossimg/LUA_ALTERIMPBOSS_SPAWN.png",

        );
//        $catime=strtotime($data[0]['time']);
//        $time1=$catime+$addtime[0][0] * 60 * 60;
//        $time2=$catime+$addtime[0][1] * 60 * 60;
//        $nowtime1=date("Y-m-d H:i:s",$time1*1);
//        $nowtime2=date("Y-m-d H:i:s",$time2);
        $returnarray=array();
        for($j=0;$j<count($addtime);$j++){
            $returnarray[$j]['code']=$data[$j]['bossId'];
            $returnarray[$j]['name']=$data[$j]['bossName'];
            $returnarray[$j]['LastTime']=$data[$j]['time'];
            $returnarray[$j]['CurrentTime']=$timearray[$j];
            $returnarray[$j]['icon']=$imglist[$j];
        }
        return $returnarray;
    }

    public function returntid(){
        $sql='select tid from recommendtid ORDER BY position ASC';
        $stmt=$this->_db->prepare($sql);
        if(!$stmt->execute()){
            throw new Exception('插入数据包失败',ErrorCode::INSERT_FAIL);
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function updatetid($tid,$position){
        $sql='UPDATE recommendtid SET `tid`=:tid WHERE position=:position ';
        $stmt=$this->_db->prepare($sql);
        $stmt->bindParam(':tid',$tid);
        $stmt->bindParam(':position',$position);
        if(!$stmt->execute()){
            throw new Exception('插入数据包失败',ErrorCode::INSERT_FAIL);
        }
        return array(
            'tid'=>$tid,
            'position'=>$position
        );
    }
}
