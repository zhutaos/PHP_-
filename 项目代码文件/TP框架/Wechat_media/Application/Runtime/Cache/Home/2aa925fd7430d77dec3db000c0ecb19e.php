<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/Public/home/lib/weui.min.css" type="text/css"/>
    <link rel="stylesheet" href="/Public/home/css/jquery-weui.min.css" type="text/css"/>
    <link rel="stylesheet" href="/Public/home/css/demos.css" type="text/css"/>
    <title>时间查询</title>
    <style>
        .media_hd{
            width: 25%;
            float: left;
            height: auto;
            position:
        }
        .media_hd img{
            width: 100%;
        }
        .conment_hd{
            width: 73%;
            float: right;
        }
        .tuijianren{
            font-size: 12px;
        }
        .weui_panel_hd{
            float: right;
        }
        .media_desc{
            font-family: 'STXinwei';
            font-size: 14px;
            color:#999;
            line-height:1.2;
            overflow:hidden;
            text-overflow:ellipsis;
            display:-webkit-box;
            -webkit-box-orient:vertical;
            -webkit-line-clamp:4;
        }
        .color{
            background: #ee8a87;
        }
    </style>
</head>
<body>
<div class="weui_tab">
    <div class="weui_tab_bd">
            <!--页面主体-->
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label for="date" class="weui_label">起始日期</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" id="date" type="text">
                </div>
            </div>
        </div>
        <div class="content"></div>
        <!--结束页面主体-->
        <div id="inline-calendar"></div>
    </div>
    <div class="weui_tabbar">
        <a href="user_recommend_index.html" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/Public/home/images/shouye2.png" alt="">
            </div>
            <p class="weui_tabbar_label">主页</p>
        </a>
        <a href=" user_recommend_search.html" class="weui_tabbar_item weui_bar_item_on">
            <div class="weui_tabbar_icon">
                <img src="/Public/home/images/sousuo.png" alt="">
            </div>
            <p class="weui_tabbar_label">搜索</p>
        </a>
        <a href="user_recommend.html" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/Public/home/images/woyaotuijian.png" alt="">
            </div>
            <p class="weui_tabbar_label">我要推荐</p>
        </a>
        <a href="<?php echo U('home/usershome/my_home');?>" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/Public/home/images/gerenzhongxin.png" alt="">
            </div>
            <p class="weui_tabbar_label">个人中心</p>
        </a>
    </div>
</div>
<script src="/Public/home/lib/jquery-2.1.4.js"></script>
<script src="/Public/home/lib/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<script src="/Public/home/js/jquery-weui.js"></script>
<script>
    //            判定用户是否收藏
    function collectioncheck() {
        $.post("<?php echo U('home/usersrcmd/getcollection');?>",function (data) {
            var collection = jQuery.parseJSON(data)
            $.each(collection,function (n,value) {
                $(".collection .id").each(function () {
                    var id = $(this).val();
                    if (id == value.mediaid){
                        $(this).parent().addClass("color");
                        $(this).parent().children("p").text('已收藏');
                    }
                });
            })
        });
    }
    //            判断用户是否点赞
    function praisecheck() {
        $.post("<?php echo U('home/usersrcmd/getsession');?>",function (data) {
            var session = jQuery.parseJSON(data)
            $.each(session,function (n,value) {
                $(".praise .id").each(function () {
                    var id = $(this).val();
                    if (id == value){
                        $(this).parent().addClass("color");
                    }
                });
            })
        });
    }
//    收藏功能函数
    function collection() {
        $(".collection").unbind('').click(function(){
            var classname = $.trim($(this).attr('class')).substr(-5);
            var id = $(this).children(".id").val();
            if (classname=='color'){

            }else{
                var url="<?php echo U('home/usersrcmd/collection');?>";
                $.post(url,{"mediaid":id});
                $(this).addClass("color");
                $(this).children("p").text('已收藏');
            }
        });
    }
//    点赞功能函数
    function praise() {
        $(".praise").unbind('click').on('click',function(){
            var classname = $.trim($(this).attr('class')).substr(-5);
            var id = $(this).children(".id").val();
            var num = parseInt($.trim($(this).text()).substr(2));
            if (classname=='color'){
                var url="<?php echo U('home/usersrcmd/praise_c');?>";
                $.post(url,{"ur_id":id});
                num = num-1;
                $(this).removeClass("color");
            }else{
                var url="<?php echo U('home/usersrcmd/praise');?>";
                $.post(url,{"ur_id":id});
                num = num+1;
                $(this).addClass("color");
            }
            $(this).children('p').text('喜欢'+num);
        });
    }
    $("#date").calendar({
        maxDate:"<?php echo ($maxDate); ?>",
        minDate:"<?php echo ($minDate); ?>",
        onClose: function (p) {
            var url = "<?php echo U('home/usersrcmd/search');?>";
            var time = $("#date").val();
            $.post(url,{'time':time},function (data) {
                $(".content").html('');
                if (data=='0'){
                    $.toast('没有推荐了!','text');
                }else {
                    var recommends = jQuery.parseJSON(data);
                    for (var i=0;i<recommends.length;i++){
                        var urli = "<?php echo U('home/usersrcmd/media_content/UR_Id');?>/"+recommends[i].ur_id;
                        $(".content").append(
                                '<div class="weui_panel weui_panel_access">' +
                                '<div class="weui_panel_bd">' +
                                '<div class="media_hd">' +
                                '<img class="weui_media_appmsg_thumb" src=" ' + recommends[i].thumb + '" alt="无图">' +
                                '</div>' +
                                '<div  class="conment_hd">' +
                                '<h3 class="title"> &nbsp;&nbsp;&nbsp;&nbsp;' + recommends[i].title + '</h3>' +
                                '<p class="tuijianren">推荐人：' + recommends[i].name + '</p>' +
                                '<p class="media_desc">' +
                                '推荐理由：' + recommends[i].reason +
                                '</p>' +
                                '</div>' +
                                '<div class="weui_panel_hd">' +
                                '<div href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default collection"><p>收藏</p><input hidden class="id" value="'+recommends[i].ur_id+'"></div>' +
                                '&nbsp;&nbsp;' +
                                '<div href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default praise"><p>喜欢' + recommends[i].parisecount + '</p><input hidden class="id" value="'+recommends[i].ur_id+'" /></div>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                        );
                    }
                }
                collectioncheck();
                praisecheck();
                collection();
                praise();
            });
        }
    });
</script>
</body>
</html>