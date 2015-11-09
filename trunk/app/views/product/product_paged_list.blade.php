





<table class="table table-bordered table-hover" id="tb_list">
    <thead>
        <tr>
            <th class="text-center">商品名称</th>
            <th class="text-center">价格</th>
            <th class="text-center">类别</th>
            <th class="text-center">状态</th>
            <th class="text-center">库存数量</th>
            <th class="text-center">缺货提醒数量</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $product)
        <?php $alert = $product->dish_count <= $product->alert_count; ?>
        <tr class="<?php if ($alert) echo 'warning'; ?>">
            <td class="text-center">{{$product->dish_name}}{{$product->is_presell == 0 ? '':'（预订商品）'}}</td>
            <td class="text-center">{{$product->dish_price}}</td>
            <td class="text-center">{{$product->category_name}}</td>
            <td class="text-center" id="cell_<?php echo $product->dish_id;?>">{{$product->dish_status == 1 ? '上架' : '下架'}}</td>
            <td class="text-center">{{$product->dish_count}}</td>
            <td class="text-center">{{$product->alert_count}}</td>
            <td class="text-center">
                <input type="hidden" id="product_img_url_<?php echo $product->dish_id;?>" value="<?php echo $product->pic_url;?>"/>
                <input type="button" class="btn btn-default" value="修改" onclick="edit_product(<?php echo $product->dish_id; ?>)"/>
                <input type="button" class="btn  <?php echo $alert ? 'btn-success' : 'btn-default' ?>" value="补货"  onclick="add_product(<?php echo $product->dish_id; ?>);"/>
                <?php
                echo $product->dish_status == 1 ?
                        '<input type="button" class="btn btn-default" id="btn_'.$product->dish_id .'" onclick="change_product_status('.$product->dish_id.',0);" value="下架"/>':
                    '<input type="button" class="btn btn-default" id="btn_'.$product->dish_id .'" onclick="change_product_status('.$product->dish_id.',1);" value="上架"/>';
                ?>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php echo $list->links(); ?>




