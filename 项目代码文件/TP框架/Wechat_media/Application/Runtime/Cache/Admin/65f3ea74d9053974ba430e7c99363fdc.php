<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title></title>
    <link rel="stylesheet" href="/Public/admin/css/pintuer.css">
    <link rel="stylesheet" href="/Public/admin/css/admin.css">
    <script src="/Public/admin/js/jquery.js"></script>
    <script src="/Public/admin/js/pintuer.js"></script>
</head>
<style>

    .t1{
        width: 15%;
        margin-left: 20px;
        font-size : 15px;
    }
    td{
        font-size : 14px;
    }
    tr{
        height: 80px;
    }
</style>
<body>
<div class="panel ">
    <div class="panel-head"><strong class="icon-reorder" >电影歌曲</strong></div>
    <table style="TABLE-LAYOUT: fixed" class="table table-hover">
        <tr>
            <td class="t1">ID:</td>
            <td><?php echo ($results["music_id"]); ?></td>
        <tr>
            <td class="t1">歌曲名称:</td>
            <td><?php echo ($results["musicname"]); ?></td>
        </tr>
        <tr>
            <td class="t1">歌手:</td>
            <td><?php echo ($results["singer"]); ?></td>
        </tr>
        <tr>
            <td class="t1">来自电影:</td>
            <td><?php echo ($results["frommedia"]); ?></td>
        </tr>
        <tr>
            <td class="t1">歌曲链接:</td>
            <td style="WORD-WRAP: break-word"><?php echo ($results["musicaddress"]); ?></td>
        </tr>
    </table>
</div>
</body>
</html>