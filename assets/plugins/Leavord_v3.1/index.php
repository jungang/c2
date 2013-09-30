<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<style> 
*,body{margin:0px auto;}
*:focus{outline: none;}
*{resize:none;}
.main{margin:0px auto 10px auto;width:90%;min-width:1000px;}
img{border:0px;}
body,a,div,*{font-size:12px;color:#444444;font-family:Arial,Helvetica,sans-serif;}
a{color:#056bcb;text-decoration:none;}
a:hover{color:#ffffff;background-color:#056bcb;}
.left{float:left;}
.right{float:right;}
.red{color:red;}
.green{color:green;}
.none{display:none;} 
.clear{clear: both;}
div,a{overflow:hidden;} 
.rsbox,.userbox{z-index:999;border-radius:2px;position:fixed;_position:absolute;*position:absolute;min-height:24px;min-width:24px;max-width:30%;line-height:24px;padding:3px;text-indent:26px;background:url(imgs/bg2.gif) no-repeat 2px 2px #f7f7f7;top:70px;left:35%;border:1px solid #d4d4d4;}
 
.hd{height:40px;background-color:#056bcb;}
.hd *{font-size:14px;font-weight:bold;}
.hd1,.hd2{height:40px;}
.hd1{max-width:300px;}
.hd1 a{line-height:40px;height:40px;display:inline-block;padding-left:8px;padding-right:8px;float:left;color:#ffffff;}
.hd1 a:hover{background-color:#1d79cf;}
.hd2{text-align:right;line-height:40px;min-width:150px;}
.hd2 a{margin-right:10px;color:#f1f1f1;}
.hd2 a:hover{color:#ffffff;} 
.bd3{width:2%;min-width:20px;height:1px;}
.bd1{width:68%;min-width:680px;}	
.bd11{height:58px;}
.bd111{border-radius:2px;height:48px;line-height:24px;width:99%;min-width:674px;padding:2px;border:1px solid #dedede;overflow:auto;}
.bd12{height:26px;line-height:26px;margin-top:3px;}
.bd121{float:right;display:inline-block;margin-left:1%;margin-left:6px;height:24px;line-height:24px;width:8.8%;min-width:60px;text-align:center;border-radius:2px;border:1px solid #528641;background-color:#3fa156;color:#ffffff;}
.bd121:hover{border:1px solid #6aad54;background-color:#4fca6c;}

.msg,.msg1{height:25px;}
.msg1{line-height:25px;text-align:center;}
 
.listold{display:inline-block;width:100%;text-align:center;line-height:25px;margin-top:10px;border-top:1px solid #dedede;}
.listold:hover{background-color:#000;} 

.list h2{line-height:28px;color:#056bcb;border-bottom:1px solid #dedede;} 
.list p{margin-top:3px;text-indent:2em;line-height:25px;margin-bottom:10px;font-size:14px;} 
 
.bd2{width:30%;min-width:300px;} 
.bd21{background:url("imgs/bg.gif") repeat-y  8px 0px;}
.bd211{background:url("imgs/yd.gif") no-repeat  6px 9px;padding-left:16px;line-height:23px;color:#333;} 
.bd22{margin-top:15px;text-indent:2em;line-height:24px;font-size:14px;border:1px solid #dedede;padding:8px;}

.ptqq{height:26px;line-height: 26px;text-indent: 40px;background: url("imgs/qqun.gif") no-repeat 18px 3px;}

.ft{margin-top:10px;padding-top:5px;border-top:1px solid #056bcb;height:22px;font-family:Arial;color:#999;}
.ft .left{height:22px;line-height:22px;width:50%;}
.ft2{text-align:right;}

.nickname{float:left;margin-left:30px;background: url("imgs/nn.gif") no-repeat 0px 0px;border-radius:2px;height:22px;line-height:22px;padding:1px;border:1px solid red;padding-left:20px;min-width:150px;}
.qrnn{cursor:pointer;margin-left:1px;float:left;border-radius:2px;height:26px;line-height:26px;padding:1px;border:1px solid #6aad54;background-color:#4fca6c;color:#ffffff;width:50px;text-align:center;}
</style>
<title>Leavord 3.1-学新公园出品</title>
</head>
<body>
 

<script>
var nickname="";
var lastid=<?php 
//获取vords数量
$arr = scandir("vords"); $all = count($arr)-2;echo $all;
 ?>;
var firstid=lastid-9;
$(function(){	

//编辑框效果
$(".bd111").focus();
$(".bd111").focus(function(){
$(this).css("border-color","#999999");	
});
$(".bd111").blur(function(){
$(this).css("border-color","#f1f1f1");	
});
//获取旧的信息
if(firstid>0){
$(".list").after("<a href='#' id='listold' class='listold'>获取旧点留言</a>");	
$(".listold").click(function(){
$.post("post.php",{gn:"listold",firstid:firstid},function(json){
if(json[0]==1){
$(".list").append(json[1][1]);
if(json[1][0]==0){
$(".listold").remove();	
}else{
firstid=json[1][0];	
}
$("body").animate({scrollTop:$("body").height()}, 'slow');
}else{
rs(json[1]);
$(".listold").remove();	
}
},"json");
return false;
});
}

listnew(firstid);
//消息滚动
msg1();
setInterval("listnew(lastid);",1500);
});
//消息滚动
function msg1(){
$(".msg1:first").fadeOut(3000,function(){$(this).remove();if($(".msg1:first").length>0){msg1();}else{ if(lastid==0){$(".msg").html('<div class="msg1">还没有人留言。</div>');} }});
}
//查找最新留言
function listnew(str){
$.post("post.php",{gn:"listnew",lastid:str},function(json){
if(json[0]==1){
lastid=json[1][0];
$(".msg").append('<div class="msg1">发现新留言。</div>');
$(".list").prepend(json[1][1]);	
}else{
$(".msg").append('<div class="msg1">正在为你发现新留言....</div>'); 
}
},"json");	
$(".msg1:first").fadeOut(3000,function(){$(this).remove();});
}
</script>

<div class="bd main">
<div class="left bd1">
<div class="bd11">
<textarea class="bd111"></textarea>	
</div>
<div class="bd12" style="color:#999999;">
<a href="#" class="bd121">Leave</a><a href="#" class="login right">设定昵称</a>Leavord:用文字留下你的声音。
</div>
<div class="msg">
<div class="msg1">Leavord从未离开。</div>
<div class="msg1">它一直在等待</div>	
<div class="msg1">这一天的到来。</div>	
<div class="msg1">请耐心等待。</div>	
<div class="msg1">正在为你加载来自网友的留言。</div>	
</div>
<div class="list">
	
</div>	

	
	
</div>	
<div class="left bd3"></div>

</div>



<script>
function rs(str){
$("body").append('<div class="rsbox">'+str+'</div>');	
$(".rsbox").animate({top:"-=20px"},1000).fadeOut(2000,function(){$(this).remove();});
}	
$(function(){

//设定昵称界面
$(".login").click(function(){
$(".userbox").remove();
rs("请先设定昵称");
$("body").append('<div class="userbox"><form><input class="nickname"/><input type="submit" class="qrnn qrnn1" value="确认"/><input type="submit" class="qrnn qrnn2" value="取消"/></form></div>');
return false;
});
//关闭设定昵称界面
$(document).on("click",".qrnn2",function(){
$(".userbox").animate({top:"-=20px"},1000).fadeOut(2000,function(){$(this).remove();});	
return false;
});
//确认昵称设置
$(document).on("click",".qrnn1",function(){
if($(".nickname").val()==""){
$(".userbox").animate({left:"-=30"}).animate({left:"+=30"}).animate({left:"-=15"}).animate({left:"+=15"});
$(".nickname").focus();
return false;	
}
$.post("post.php",{gn:"setnn",nickname:$(".nickname").val()},function(json){
if(json[0]==1){
$(".userbox").animate({top:"-=20px"},1000).fadeOut(2000,function(){$(this).remove();});	
$(".login").after("<span class='right'>"+json[1]+"</span>").remove();	
nickname=json[1];
}else{
rs(json[1]);	
}
},"json");
return false;
});	


//leavord
$(document).on("click",".bd121",function(){
if(nickname==""){
$(".login").click();	
}else if($(".bd111").val()=="" || $(".bd111").val().replace(/\s+/g,"")==""){
rs("请留点什么吧。");	
$(".bd111").focus();
}else{
$.post("post.php",{gn:"pb",vord:$(".bd111").val()},function(json){
rs(json[1]);
if(json[0]==3){
$(".login").click();
}else if(json[0]==1){
$(".bd111").val("");	
}
},"json");	
}
return false;
});

//离开网站
onbeforeunload=$.post("post.php",{gn:"quit"});

	
});
 


</script>

</body>
</html>