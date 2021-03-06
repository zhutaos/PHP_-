<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>用户推荐</title>
    <link rel="stylesheet" href="/Public/home/lib/weui.min.css">
    <link rel="stylesheet" href="/Public/home/css/jquery-weui.css">
    <link rel="stylesheet" href="/Public/home/css/demos.css">
    <style>
        .Preview{
            width: 28%;
            height: auto;
            float: right;
            margin: 0 20px 0 0;
        }
        .PreviewImg{
            width: 100%;
        }
    </style>
</head>
<body>
<div class="weui_tab">
    <div class="weui_tab_bd">
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">电影名称</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="tel" placeholder="请输入电影名称">
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <textarea class="weui_textarea" placeholder="请输入您推荐此电影的理由" rows="3"></textarea>
                    <div class="weui_textarea_counter"><span class="OK">0</span>/300</div>
                </div>
            </div>
            <div class="weui_cell weui_vcode">
                <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" placeholder="请输入验证码">
                </div>
                <div class="weui_cell_ft">
                    <img src="<?php echo U('home/usersrcmd/verify');?>">
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <div class="weui_uploader">
                        <div class="weui_uploader_hd weui_cell">
                            <div class="weui_cell_bd weui_cell_primary">封面图片上传</div>
                            <div class="weui_cell_ft PreviewCount">0/1</div>
                        </div>
                        <div class="weui_uploader_bd">
                            <div class="Preview"><img class="PreviewImg"></div>
                            <div class="weui_uploader_input_wrp">
                                <input class="weui_uploader_input" name="file" id="file" type="file" accept="image/*" multiple="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="javascript:;" class="weui_btn weui_btn_primary">发表</a>
        </div>
    </div>


    <div class="weui_tabbar">
        <a href="user_recommend_index.html" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/Public/home/images/shouye2.png" alt="">
            </div>
            <p class="weui_tabbar_label">主页</p>
        </a>
        <a href=" user_recommend_search.html" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/Public/home/images/sousuo.png" alt="">
            </div>
            <p class="weui_tabbar_label">搜索</p>
        </a>
        <a href="user_recommend.html" class="weui_tabbar_item weui_bar_item_on">
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
</body>
<script src="/Public/home/lib/jquery-2.1.4.js"></script>
<script src="/Public/home/lib/fastclick.js"></script>
<script src="/Public/home/js/jquery-weui.js"></script>
<script src="/Public/home/js/ajaxfileupload.js"></script>
<script>
    var MAX_LENGTH=300; //最大输入字数
    var verifycheck=false;
//    文本域输入动态变化
    $(".weui_textarea").keyup(function () {
        var len = $(".weui_textarea").val().length;
        if (len>MAX_LENGTH){
            $.toast("您的字数达到最大限制了",'text');
            $(this).val($(this).val().substring(0,MAX_LENGTH));
        }
        var length = $(".weui_textarea").val().length;
        $(".OK").text(length );
    });
    //刷新验证码
    $(".weui_vcode .weui_cell_ft").children("img").unbind().click(function () {
        $(this).attr('src',"<?php echo U('home/usersrcmd/verify');?>");
        $(".weui_vcode .weui_input").val('');
        verifycheck==false;
    });
//点击提交时
    $(".weui_btn_primary").unbind().click(function () {
        if (verifycheck==false){
            $.toptip('验证码错误')
        }else {
            var title = $(".weui_cell .weui_input").val();
            var reason = $(".weui_textarea").val();
            var url = "<?php echo U('home/usersrcmd/publish');?>";
            $.ajaxFileUpload
            (
                    {
                        url: url, //用于文件上传的服务器端请求地址
                        secureuri: false,           //一般设置为false
                        data:{'title':title,'reason':reason},
                        fileElementId: $(".weui_uploader_input").attr("id"), //文件上传控件的id属性  <input type="file" id="file" name="file" /> 注意，这里一定要有name值
                        //$("form").serialize(),表单序列化。指把所有元素的ID，NAME 等全部发过去
                        dataType: 'json',//返回值类型 一般设置为json
                        success: function (data, status)  //服务器成功响应处理函数
                        {
                            if (data=='1'){
                                $.toast('发表成功');
                                location.href = "<?php echo U('home/usersrcmd/user_recommend_index');?>";
                            }else{
                                $.toast('发表失败','text');
                                // window.location.reload();
                            }
                        },
                        error: function (data, status, e)//服务器响应失败处理函数
                        {
                            $.toast('网络不给力哦');
                        }
                    }
            )
        }
    });
    //获取预览图url
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
    //图片上传-预览
    $(".weui_uploader_input").change(function () {
        var url = getObjectURL(this.files[0]);
        $(".Preview").css('float','left');
        $(".Preview").children('img').attr("src",url);
        $(".PreviewCount").html("1/1")
    });
    //输入验证码
    $(".weui_vcode .weui_input").change(function () {
        var verify = $(".weui_vcode .weui_input").val();
        var url="<?php echo U('home/usersrcmd/check_verify');?>";
        $.post(url,{'verify':verify},function (data) {
            if (data == '1'){
                verifycheck=true;
            }else if (data == '0'){
                $(".weui_vcode .weui_cell_ft").children('img').attr('src',"<?php echo U('home/usersrcmd/verify');?>");
                $(".weui_vcode .weui_input").val('');
                $.toptip('验证码错误');
                verifycheck=false;
            }
        });
    });
    $(".weui_input").click(function(){
        $(".weui_tabbar").hide();
    });
    $(".weui_textarea").click(function(){
        $(".weui_tabbar").hide();
    });
    $(".weui_input").blur(function(){
        $(".weui_tabbar").show();
    });
    $(".weui_textarea").blur(function(){
        $(".weui_tabbar").show();
    });
</script>
</html>