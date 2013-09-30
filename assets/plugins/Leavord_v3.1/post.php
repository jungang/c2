<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
ini_set('date.timezone','Asia/Shanghai');


function get_user_ip() {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']!='unknown') {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']!='unknown') {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }



if(isset($_SERVER['HTTP_REFERER'])){
$urlar=parse_url($_SERVER['HTTP_REFERER']); 
if($urlar["host"]==$_SERVER["HTTP_HOST"]){}else{rs("故障2");}
}else{rs("故障2");}	
rp("gn");
$gn=$_POST["gn"];
//留言
if($gn=="pb"){
rp("vord");	
if(!isset($_SESSION["nickname"])){
rs("请先设定昵称",3);	
} 
$vord=str_replace("\n","<br/>",htmlspecialchars($_POST["vord"],ENT_QUOTES));

$scan=count(scandir("vords"))-1; 

for($n=1;$n<14;$n++){
$vord=str_replace("<br/><br/>","<br/>",$vord);	
}
$strlen = (strlen($vord)+mb_strlen($vord,"UTF8"))/2;
if($strlen>300){
rs('这是留言板哇！内容最好别超过300字。。');		
}
$nn=$_SESSION["nickname"];
$time=date("Y年m月d日 H:i:s");
$data='<li class="in"><img class="avatar" alt="" src="assets/img/avatar.png"><div class="message"><span class="arrow"></span><a href="#" class="name" ip="'.get_user_ip().'">'.$nn.' </a><span class="datetime">'.$time.'</span><span class="body">'.$vord.'</span></div></li>';
$file="vords/".$scan;
if(file_put_contents($file,$data)){
rs("留言成功。",1);	
}
rs("我也不知道为什么发布失败。");
}else


//判断是否已经设定昵称
if($gn=="online"){
if(!isset($_SESSION["nickname"])){
rs("请设定昵称。");	
}
rs($_SESSION["nickname"],1);	
}else



//设定昵称
if($gn=="setnn"){
if(isset($_SESSION["nickname"])){
//rs("你已经设定了昵称");	
}
rp("nickname");
$nickname=$_POST["nickname"];
//检查昵称的合法性
$strlen = (strlen($nickname)+mb_strlen($nickname,"UTF8"))/2;
if($strlen>14){
rs('昵称太长拉。');		
}
$reg = '/^[\x{4e00}-\x{9fa5}a-zA-Z]+$/u';     
if (!preg_match($reg, $nickname)) {
rs('你是电话号码么。');	
}
//检查用户文件
$userfile="users/".md5($nickname);
if(file_exists($userfile)){
$filemtime=filemtime($userfile);	
if($filemtime+3600>time()){
rs("该昵称正在保护期。请更换一个。");	
}else{
$file=fopen($userfile,"r");
fclose($file);
}
}else{
$file=fopen($userfile,"w");
fclose($file);
}
$_SESSION["nickname"]=$nickname;
rs($_SESSION["nickname"],1);	
}else


//离开leavord
if($gn=="quit"){
$userfile="users/".md5($_SESSION["nickname"]);
if(file_exists($userfile)){
unlink($userfile);	
}
session_destroy();
}else


//获取老留言
if($gn=="listold"){
rp("firstid");
$id=$_POST["firstid"];
if(!is_numeric($id)){
rs("你做了一次危险的提交");	
}
if($id<=0){
rs("已经没有更多旧留言。");	
}
$more="";
for($n=1;$n<=10;$n++){
if($id==0){
break;	
}
$file="vords/".$id;
if(file_exists($file)){
$more=$more.file_get_contents($file); 
}	
$id=$id-1;
} 
$arr=array($id,$more);
rs($arr,1);
}else


//获取新留言
if($gn=="listnew"){
rp("lastid");
$scan=count(scandir("vords"))-2;
$id=$_POST["lastid"];
if(!is_numeric($id) or $id<=0){
rs("你做了一次危险的提交");	
}
$more="";
for($n=1;$n<=10;$n++){
if($id>$scan){
break;	
}
$file="vords/".$id;
if(file_exists($file)){
$more=file_get_contents($file).$more; 
}	
$id=$id+1;
} 
if($id==$_POST["lastid"]){
rs("错误提示");	
}
$arr=array($id,$more);
rs($arr,1);
}



rs('post丢失');




//排除空post
function rp($arr){
if(!is_array($arr)){
$arr=array($arr);
} 	
foreach ($arr as $value) {
if(!isset($_POST[$value]) or (empty($_POST[$value]) and $_POST[$value]!=0) or str_replace(" ","",$_POST[$value])==""){
rs("请完成表单，再提交".$value);
} 
}
}

//返回错误信息
function rs($rs1="系统故障",$rs0="0"){
$rs=array();
$rs[0]=$rs0;
$rs[1]=$rs1;
echo json_encode($rs);	
exit();	
}
?>