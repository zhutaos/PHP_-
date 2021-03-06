<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>后台管理中心</title>  
    <link rel="stylesheet" href="/Public/admin/css/pintuer.css">
    <link rel="stylesheet" href="/Public/admin/css/admin.css">
    <script src="/Public/admin/js/jquery.js"></script>
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="/Public/admin/images/y.jpg" class="radius-circle rotate-hover" height="50" alt="" /><?php echo (session('name')); ?></h1>
  </div>
  <div class="head-l"><a class="button button-little bg-green" href="" target="_blank"><span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp <a class="button button-little bg-red" href="login.html"><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
  <h2><span class="icon-user"></span>管理员管理</h2>
  <ul style="display:block">
    <li><a href="<?php echo U('admin/user/pass');?>" target="right"><span class="icon-caret-right"></span>修改密码</a></li>
     
  </ul>   
  <h2><span class="icon-pencil-square-o"></span>电影管理</h2>
  <ul>
    <li><a href="<?php echo U('admin/movie/admin_recommend');?>" target="right"><span class="icon-caret-right"></span>官方推荐</a></li>
    <li><a href="<?php echo U('admin/movie/user_recommend');?>" target="right"><span class="icon-caret-right"></span>用户推荐</a></li>
      <li><a href="<?php echo U('admin/movie/music_recommend');?>" target="right"><span class="icon-caret-right"></span>发表音乐</a></li>
      <li><a href="<?php echo U('admin/movie/movie_automatic');?>" target="right"><span class="icon-caret-right"></span>自动获取</a></li>
  </ul>  
</div>
<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);	
	  $(this).toggleClass("on"); 
  })
  $(".leftnav ul li a").click(function(){
	    $("#a_leader_txt").text($(this).text());
  		$(".leftnav ul li a").removeClass("on");
		$(this).addClass("on");
  })
});
var url = "<?php echo U('admin/user/judgeAdmin');?>";
$.post(url,function (data) {
    data=eval(data);
    if(data==1){
        var l="<?php echo U('admin/user/user');?>";
        var d="<?php echo U('admin/user/add_admin');?>";
        $('.leftnav').children('ul').eq(0).append(
                '<li><a href="'+ l +'" target="right"><span class="icon-caret-right"></span>查看管理员</a></li>'+
                '<li><a href="'+ d +'" target="right"><span class="icon-caret-right"></span>添加管理员</a></li>'
        );
    }
})
</script>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="<?php echo U('admin/movie/admin_recommend');?>" name="right" width="100%" height="100%"></iframe>
</div>
<div style="text-align:center;">

</div>
</body>
</html>