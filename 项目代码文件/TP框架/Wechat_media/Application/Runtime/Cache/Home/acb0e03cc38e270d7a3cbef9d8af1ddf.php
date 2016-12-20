<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>评论页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/Wechat_media/Public/home/lib/weui.min.css" type="text/css"/>
    <link rel="stylesheet" href="/Wechat_media/Public/home/css/jquery-weui.min.css" type="text/css"/>
    <link rel="stylesheet" href="/Wechat_media/Public/home/css/demos.css" type="text/css"/>
    <style>
        h1{
            text-align: center;
            font-size: inherit;
        }
        .username{
            width: auto;
            height: auto;
            float: left;
            font-size: 12px;
            color: #5a5a5a;
        }
        .time{
            width: auto;
            height: auto;
            float: left;
            font-size: 12px;
            color: #cccccc;
            position:relative;left:5%;
        }
        .zan{
            position: absolute;
            right: 5%;
            top: 15px;
        }
        .comment_content{
            padding: 10px 15px 10px 30px;
        }
        .weui_search_bar{
            width: 100%;
        }
        .head{
            float: left;
            width: 35px;
            height: 35px;
        }
        .head img{
            width: 100%;
            height: 100%;
        }
        .background{
            display: none;
            position: absolute;
            top: 0%;
            width: 100%;
            height: 100%;
            background: #111;
            opacity: 0.6;
        }
        .comment{
            display: none;
            position: absolute;
            top: 0%;
            width: 100%;
            height: auto;
        }
        .praise{
            background: #3CC51F;
        }
    </style>
</head>
<body>
<div class="weui_tab">
    <div class="weui_tab_bd">
        <div class="weui-pull-to-refresh-layer">
            <div class='pull-to-refresh-arrow'></div>
            <div class='pull-to-refresh-preloader'></div>
            <div class="down">下拉刷新</div>
            <div class="up">释放刷新</div>
            <div class="refresh">正在刷新</div>
        </div>
        <div class="weui_cells">
            <?php if(is_array($comments)): $i = 0; $__LIST__ = $comments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$comment): $mod = ($i % 2 );++$i;?><div class="weui_cell">
                    <div class="head">
                        <img src="<?php echo ($comment["userimg"]); ?>">
                    </div>
                    <div class="username">
                        <p><?php echo ($comment["username"]); ?></p>
                    </div>
                    <div class="time">
                        <p><?php echo (date("Y-m-d H:i",$comment["time"])); ?></p>
                    </div>
                    <div class="zan">
                        <div class="weui_btn weui_btn_mini weui_btn_default"><p>赞<?php echo ($comment["parisecount"]); ?></p><input class="id" hidden value="<?php echo ($comment["c_id"]); ?>"></div>
                    </div>
                </div>
                <div class="comment_content">
                    <p><?php echo ($comment["content"]); ?></p>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="weui-infinite-scroll">
            <div class="infinite-preloader"></div>
            正在加载
        </div>
    </div>
    <div class="background"></div>
    <div class="comment">
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <textarea class="weui_textarea" placeholder="请输入评论" rows="4"></textarea>
                    <div class="weui_textarea_counter"><span class="OK">0</span>/200</div>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="weui_btn weui_btn_primary">发表</a>
    </div>
    <div class="weui_tabbar">
        <div class="weui_search_bar" id="search_bar">
            <form class="weui_search_outer">
                <div class="weui_search_inner">
                    <input type="text" class="weui_search_input" placeholder="我来说两句" required="" value="">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="/Wechat_media/Public/home/lib/jquery-2.1.4.js"></script>
<script src="/Wechat_media/Public/home/lib/fastclick.js"></script>
<script src="/Wechat_media/Public/home/js/jquery-weui.js"></script>
<script>
    var MAX_LENGTH=200; //最大输入字数
//    检查是否点过赞
    function praisecheck() {
        $.post("<?php echo U('home/adminrcmd/getsession');?>",function (data) {
            var session = jQuery.parseJSON(data)
            $.each(session,function (n,value) {
                $(".id").each(function () {
                    var id = $(this).val();
                    if (id == value){
                        $(this).parent().addClass("praise");
                    }
                });
            })
        });
    }
    $(document).ready(function(){
        praisecheck();
    });
    $(".weui_tab_bd").pullToRefresh().on("pull-to-refresh", function() {
        var url = "<?php echo U('home/adminrcmd/newcomment');?>";
        var ar_id = "<?php echo ($ar_id); ?>";
        $.post(url,{'ar_id':ar_id},function (data) {
            var comments = jQuery.parseJSON(data);
            $(".weui_tab_bd .weui_cells").html(
            '<div class="weui_cell">'+
                '<div class="head">'+
                    '<img src="'+comments[0].userimg+'">'+
                '</div>'+
                '<div class="username">'+
                    '<p>'+comments[0].username+'</p>'+
                '</div>'+
                '<div class="time">'+
                    '<p>'+comments[0].time+'</p>'+
                '</div>'+
                '<div class="zan">'+
                    '<div class="weui_btn weui_btn_mini weui_btn_default"><p>赞'+comments[0].parisecount+'</p><input class="id" hidden value="'+comments[0].c_id+'"></div>'+
                '</div>'+
                '</div>'+
                '<div class="comment_content">'+
                    '<p>'+comments[0].content+'</p>'+
                '</div>'
            )
            for (var i=1;i<comments.length;i++){
                $(".weui_tab_bd .weui_cells").append(
                    '<div class="weui_cell">'+
                        '<div class="head">'+
                            '<img src="'+comments[i].userimg+'">'+
                        '</div>'+
                        '<div class="username">'+
                            '<p>'+comments[i].username+'</p>'+
                        '</div>'+
                        '<div class="time">'+
                            '<p>'+comments[i].time+'</p>'+
                        '</div>'+
                        '<div class="zan">'+
                            '<div class="weui_btn weui_btn_mini weui_btn_default"><p>赞'+comments[i].parisecount+'</p><input class="id" hidden value="'+comments[i].c_id+'"></div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="comment_content">'+
                        '<p>'+comments[i].content+'</p>'+
                    '</div>'
                )
            }
            $(".weui_tab_bd").pullToRefreshDone();
            praise();
            praisecheck();
        });
    });
//点赞功能函数
    function praise(classname) {
        $(".weui_tab_bd .weui_cells .weui_btn_mini").unbind('click').on('click',function(){
            var classname = $.trim($(this).attr('class')).substr(-6);
            var id = $(this).children(".id").val();
            var num = parseInt($.trim($(this).text()).substr(1));
            if (classname=='praise'){
                var url="<?php echo U('home/adminrcmd/praise_c');?>";
                $.post(url,{"c_id":id});
                num = num-1;
                $(this).removeClass("praise");
            }else{
                var url="<?php echo U('home/adminrcmd/praise');?>";
                $.post(url,{"c_id":id});
                num = num+1;
                $(this).addClass("praise");
            }
            $(this).children('p').text('赞'+num);
        });
    }
praise();
$(".weui_tabbar").click(function () {
    $(".comment").show();
    $(".background").show();
    $(".weui_tabbar").hide();
});
$(".background").click(function () {
    $(".weui_search_input").val($(".weui_textarea").val());
    $(".comment").hide();
    $(".background").hide();
    $(".weui_tabbar").show();
});
    //发表评论
    $(".weui_btn_primary").click(function () {
        var content=$(".weui_textarea").val();
        if(content==''){
            $.toast("请输入评论内容",'text');
        }else {
            var url="<?php echo U('home/adminrcmd/comment_publish');?>";
            var mediaid="<?php echo ($content["ar_id"]); ?>";
            $.post(url, {'content':content,'mediaid':mediaid},function (data) {
                if (data=='1'){
                    $(".comment").hide();
                    $(".background").hide();
                    $(".weui_tabbar").show();
                    $.toast('发表成功');
                    $(".weui_textarea").val('');
                    $(".weui_search_input").val('');
                }
            });
        }
    });
    $(".weui_textarea").keyup(function () {
        var len = $(".weui_textarea").val().length;
        if (len>MAX_LENGTH){
            $.toast("您的字数达到最大限制了",'text');
            $(this).val($(this).val().substring(0,MAX_LENGTH));
        }
        var length = $(".weui_textarea").val().length;
        $(".OK").text(length );
    });
    $(".weui_tab_bd").infinite();
    var loading = false;
    var p=1;
    $(".weui_tab_bd").infinite().on("infinite", function() {
        if(loading) return;
        loading = true;
        var url = "<?php echo U('home/adminrcmd/commentpage');?>";
        var ar_id = "<?php echo ($ar_id); ?>";
        $.post(url,{'ar_id':ar_id,'p':p},function (data) {
            if (data=='0'){
                $.toast('没有更多评论了!','text');
            }else{
                for (var i=0;i<comments.length;i++){
                    $(".weui_tab_bd .weui_cells").append(
                            '<div class="weui_cell">'+
                            '<div class="head">'+
                            '<img src="'+comments[i].userimg+'">'+
                            '</div>'+
                            '<div class="username">'+
                            '<p>'+comments[i].username+'</p>'+
                            '</div>'+
                            '<div class="time">'+
                            '<p>'+comments[i].time+'</p>'+
                            '</div>'+
                            '<div class="zan">'+
                            '<div class="weui_btn weui_btn_mini weui_btn_default"><p>赞'+comments[i].parisecount+'</p><input class="id" hidden value="'+comments[i].c_id+'"></div>'+
                            '</div>'+
                            '</div>'+
                            '<div class="comment_content">'+
                            '<p>'+comments[i].content+'</p>'+
                            '</div>'
                    )
                }
                p++;
                praise();
                praisecheck();
                loading = false;
            }
        });
    });
</script>
</html>