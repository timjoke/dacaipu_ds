<?php
$act_order = 'active';
$act_newlist = 'active';
?>

@extends('layouts.master')

@section('sidebar')
@parent
@stop

@section('content')
<link rel="stylesheet" type="text/css" href="//img1.dacaipu.cn/js/fancybox/source/jquery.fancybox.css" />
<script type="text/javascript" src="//img2.dacaipu.cn/js/fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/dictionary.js"></script>
<script type="text/javascript" src="/js/orders_newlist.js"></script>
<script type="text/javascript" src="/js/orders_newlist.js"></script>
<style type="text/css">
    #loading-indicator {
        position: absolute;
        left: 10px;
        top: 10px;
    }
</style>
<table class="table  table-bordered table-hover hidden" id="order_list">
    <thead>
        <tr>
            <th class="text-center">订单编号</th>
            <th class="text-center">订单用户</th>
            <th class="text-center">订单类别</th>
            <th class="text-center">订单总价</th>
            <th class="text-center">订单状态</th>
            <th class="text-center">下单时间</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<h3 id="h3_msg">正在加载新订单……</h3>
<div id="refuse_reason" style="display:none">
    <form role="form">
        <div class="form-group">
            <label for="exampleInputEmail1">拒绝理由</label>

            <input type="text" class="form-control" multiple id="refuse_re" placeholder="拒绝理由" required>
            <span id="reason_msg" class="text-danger"></span>
        </div>
        <button type="button" class="btn btn-default" onclick="submitRefuse();">提交拒绝</button>

    </form>
</div>

@stop