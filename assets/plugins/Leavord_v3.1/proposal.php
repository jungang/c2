


								<div class="row-fluid" id="proposal">
								<div class="bd main">
									<div class="left bd1">
									<div class="bd11"></div>
									<a href="#" class="login right">设定昵称</a>
									<textarea class="bd111 row-fluid" placeholder="留下我的建议"  ></textarea>	
									<button class="btn green big btn-block bd121" style="display:block">提交我的建议<i class="m-icon-big-swapright m-icon-white"></i></button>
									
									<ul class="chats">
											
									</ul>
									
									
									<div class="list">
										
									</div>	
									</div>	

									</div>

								</div>

<script>
var nickname="";
var lastid=<?php
//获取vords数量
$arr = scandir("assets/plugins/Leavord_v3.1/vords"); $all = count($arr)-2;echo $all;
 ?>;
var firstid=lastid-9;
$(function(){	


//获取旧的信息
if(firstid>0){
//$(".list").after("<a href='#' id='listold' class='listold'>获取旧点留言</a>");	

$(".chats").after('<button type="button" id="listold" class="btn blue">显示更多</button>');



$("#listold").click(function(){
$.post("assets/plugins/Leavord_v3.1/post",{gn:"listold",firstid:firstid},function(json){
if(json[0]==1){
$(".chats").append(json[1][1]);
if(json[1][0]==0){
$("#listold").remove();	
}else{
firstid=json[1][0];	
}
$("body").animate({scrollTop:$("body").height()}, 'slow');
}else{
rs(json[1]);
$("#listold").remove();	
}
},"json");
return false;
});
}

listnew(firstid);
setInterval("listnew(lastid);",1000);
});
//消息滚动

//查找最新留言
function listnew(str){
$.post("assets/plugins/Leavord_v3.1/post",{gn:"listnew",lastid:str},function(json){
if(json[0]==1){
lastid=json[1][0];
$(".chats").prepend(json[1][1]);	
}
},"json");	
$(".msg1:first").fadeOut(3000,function(){$(this).remove();});
}
</script>

<script>
function rs(str){
$(".bd11").append('<div class="rsbox">'+str+'</div>');	
$(".rsbox").fadeOut(3000,function(){$(this).remove();});
}	
$(function(){

//设定昵称界面
$(".login").click(function(){
$(".userbox").remove();
rs("请先设定昵称");
$(".bd11").append('<div class="userbox"><input placeholder="请先输入昵称" class="nickname m-wrap large" type="text"><button type="button" class="btn blue qrnn1">确认</button><button type="button" class="btn qrnn2">取消</button></form></div>');
return false;
});
//关闭设定昵称界面
$(document).on("click",".qrnn2",function(){
$(".userbox").animate({top:"-=20px"},200).fadeOut(100,function(){$(this).remove();});	
return false;
});
//确认昵称设置
$(document).on("click",".qrnn1",function(){
	if($(".nickname").val()==""){
	$(".userbox").animate({left:"-=30"}).animate({left:"+=30"}).animate({left:"-=15"}).animate({left:"+=15"});
	$(".nickname").focus();
	return false;	
	}
	$.post("assets/plugins/Leavord_v3.1/post",{gn:"setnn",nickname:$(".nickname").val()},function(json){
	if(json[0]==1){
	$(".userbox").animate({top:"-=20px"},200).fadeOut(200,function(){$(this).remove();});	
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
$.post("assets/plugins/Leavord_v3.1/post",{gn:"pb",vord:$(".bd111").val()},function(json){
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
onbeforeunload=$.post("assets/plugins/Leavord_v3.1/post",{gn:"quit"});
});
 

</script>
