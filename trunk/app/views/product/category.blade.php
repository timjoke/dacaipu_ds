<?php
$act_product = 'active';
$act_product_category = 'active';
?>

@extends('layouts.master')

@section('header')
<link rel="stylesheet" type="text/css" href="//img1.dacaipu.cn/js/fancybox/source/jquery.fancybox.css" />
<script type="text/javascript" src="//img2.dacaipu.cn/js/fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/product_category.js"></script>
@stop

@section('content')

<div class="row">
    <div class="col-xs-6">
        <h3>类别维护</h3>
    </div>
</div>

<hr/>
<div class="row">
    <div class="span-6 text-right" style="padding-right:15px;padding-bottom:20px;">
        <input type="button" class="btn btn-primary" value="新增类别" onclick="modify_cateogry(-1);"/>
    </div>
</div>

<table class="table table-bordered table-hover" id="tb_list">
    <thead>
        <tr>
            <th class="text-center">名称</th>
            <th class="text-center">状态</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>

    @foreach($categories as $category)
    <tr>
        <td class="text-center" id="cell_name_<?php echo $category->category_id;?>">{{$category->category_name}}</td>
        <td class="text-center" id="cell_<?php echo $category->category_id;?>">{{$category->category_status == 1 ? '上线':'下线'}}</td>
        <td class="text-center">
            <input type="button" class="btn btn-default" value="修改" onclick="modify_cateogry(<?php echo $category->category_id; ?>);"/>
            <?php echo $category->category_status == 1 ? 
                '<input type="button" id="btn_'. $category->category_id .'" class="btn btn-default" value="下线" onclick="change_category_status('.$category->category_id.',0);"/>':
                        '<input type="button" id="btn_'. $category->category_id .'" class="btn btn-default" value="上线"  onclick="change_category_status('.$category->category_id.',1);"/>'
            ?>
        </td>
    </tr>
    @endforeach

</table>


<div id="form" style="display:none">
    <form role="form">
        <div class="form-group">
            <input type="hidden" id="hid_cate_id"/>
            <label for="category_name">类别名称</label>

            <input type="text" class="form-control" id="category_name" placeholder="类别名称" required>
            <span id="msg" class="text-danger"></span>
        </div>
        <button type="button" class="btn btn-default" onclick="save_category();">保存</button>
    </form>
</div>



@stop