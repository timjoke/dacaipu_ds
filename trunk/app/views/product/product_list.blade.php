<?php
$act_product = 'active';
$act_product_list = 'active';
?>

@extends('layouts.master')

@section('header')
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<link rel="stylesheet" type="text/css" href="//img1.dacaipu.cn/js/fancybox/source/jquery.fancybox.css" />
<script type="text/javascript" src="//img2.dacaipu.cn/js/fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/messages_zh.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/product_list.js"></script>
<link rel="stylesheet" type="text/css" href="/js/uploadify/uploadify.css"/>
<script type="text/javascript" src="/js/uploadify/jquery.uploadify.js"></script>
@stop

@section('content')

<div class="row">
    <div class="col-xs-6">
        <h3>商品维护</h3>
    </div>
</div>

<hr/>
<div class="row">
    <div class="col-md-2 form-group" >
        <input type="text" id="product_name" placeholder="商品名称" class="form-control" onkeyup="get_Content();"/>
    </div>
    <div class="col-md-2 form-group">
        {{Form::select('category_id', $categories,null,array('class' => 'form-control','onchange' => 'get_Content();','id' => 'category_id'))}}
    </div>
    <div class="col-md-8 text-right" style="padding-bottom:20px;">
        <input type="button" class="btn btn-primary" value="新增商品" onclick="edit_product(-1);"/>
    </div>

</div>

<div id="contents"></div>

<h3 id="h3_msg">正在加载库存商品……</h3>

<div id="product_form_layer" style="display:none;;width:500px;">
    <form role="form" method="post" action="/save_product">
        <input type="hidden" name="product_id" id="product_id" value="0"/>
        <div class="form-group">
            <label for="product_name">商品名称</label>
            <input type="text" class="form-control" id="edit_product_name" name="edit_product_name" placeholder="商品名称" required >
        </div>
        <div class="form-group">
            <label for="edit_category_id">类别</label>
            
            {{Form::select('edit_category_id', $categories,null,array('class' => 'form-control','id' => 'edit_category_id'))}}
            <span class="text-danger" id="edit_category_msg"></span>

        </div>
        <div class="form-group">
            <label for="product_price">价格</label>
            <input type="number" maxlength="8"  class="form-control" id="product_price" name="product_price" placeholder="价格" required>
        </div>
        <div class="form-group">
            <label for="product_price">是否预订</label>
            <select class="form-control" id="product_presell" name="product_presell">
                <option value="0">否</option>
                <option value="1">是</option>
            </select>
        </div>
        <div class="form-group">
            <label for="product_count">库存数量</label>
            <input type="number" class="form-control" maxlength="8" id="product_count" name="product_count" placeholder="库存数量" required>
        </div>
        <div class="form-group">
            <label for="alert_count">预警数量</label>
            <input type="number" class="form-control" maxlength="8" id="alert_count" name="alert_count" placeholder="预警数量" required>
        </div>
        
        <div class="form-group">
            <label for="product_status">状态</label>
            <select id="product_status" name="product_status" class="form-control">
                <option value="1">上线</option>
                <option value="0">下线</option>
            </select>
        </div>
        <div class="form-group">
            <label for="product_status">图片</label>
            <div id="queue"></div>
            <input type="file" id="product_img" name="product_img"/>
            <input type="hidden" id="product_img_url" name="product_img_url" value="60_60/mobile/img/dish_default.png"/>
        </div>
        <div class="form-group">
            <label for="product_memo">简介</label>
            
            <textarea id="product_memo" name="product_memo" class="form-control" rows="3" maxlength="200"></textarea>
        </div>
        <input type="submit" id="form_sub"  class="btn btn-default"  value="保存"/>
    </form>
</div>



<div id="product_add_form_layer" style="display:none;;width:500px;">
    <form role="form" method="post" action="/add_product_count">
        <input type="hidden" name="add_product_id" id="add_product_id" value="0"/>
        <div class="form-group">
            <label for="add_product_name">商品名称：</label>
            <span id="add_product_name"></span>
        </div>
        <div class="form-group">
            <label for="add_product_count">现有数量：</label>
            <span id="add_product_count"></span>
        </div>
        <div class="form-group">
            <label for="add_count">新增数量：</label>
            <input type="number" id="add_count" name="add_count" placeholder="新增数量" required/>
        </div>
        
        <input type="submit" id="add_form_sub"  class="btn btn-default" value="提交"/>
    </form>
</div>

@stop