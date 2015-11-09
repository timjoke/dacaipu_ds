<?php
$act_order = 'active';
$act_historylist = 'active';
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
<script type="text/javascript" src="/js/orders_historylist.js"></script>
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
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<h3 id="h3_msg">正在加载订单……</h3>

<ul class="pagination">

</ul>
@stop