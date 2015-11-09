
cur_page = 1;
max_page = 0;
$(document).ready(function() {
    $(document).on('click', '.row_order', function() {
        $('.row_detail').addClass('hidden');
        $('.row_order').removeClass('bg-info');
        $(this).addClass('bg-info');
        var id = $(this).attr('id').replace('row_order_', '');
        $('#row_detail_' + id).removeClass('hidden');
    });

    getOrders();
});

function pre()
{
    if (cur_page > 1)
    {
        cur_page--;
        getOrders();
    }
}

function next()
{
    if (cur_page != max_page)
    {
        cur_page++;
        getOrders();
    }
}

function go(page)
{
    cur_page = page;
    getOrders();
}

function getOrders()
{
    $.getJSON('/history_orders.json?ts=' + new Date().getMilliseconds(),
            {'page': cur_page},
    function(data) {
        $('.pagination').empty();
        $('.pagination').append('<li onclick="pre();"><a href="javascript:void(0);">&laquo;</a></li>');
        var total_page = Math.ceil(data.total_count / 10);

        max_page = total_page;
        for (var i = 1; i <= total_page; i++)
        {
            $('.pagination').append('<li class="' + (i == cur_page ? "active" : "") + '"><a href="javascript:void(0);" onclick="go(' + i + ');">' + i + '</a></li>');
        }
        $('.pagination').append('<li onclick="next();"><a href="javascript:void(0);">&raquo;</a></li>');

        var list = $('#order_list');


        $(list).empty();
        var title = '<tr><th class="text-center">订单编号</th><th class="text-center">订单用户</th><th class="text-center">订单类别</th><th class="text-center">订单总价</th><th class="text-center">订单状态</th><th class="text-center">下单时间</th></tr>';
        $(list).append(title);
        if (data.length == 0)
        {
            $('#h3_msg').html('还没有订单。');
        }
        else
        {
            $('#h3_msg').hide();
            $(list).removeClass('hidden');
        }


        $(data.list).each(function(index, obj) {
            var str = '<tr id="row_order_' + obj.order_id + '" class="row_order">';
            str += '<td class="text-center">';
            str += obj.order_id;
            str += '<input type="hidden" value="' + obj.order_id + '"/>';
            str += '</td><td class="text-left">';
            str += obj.contact_name + '<br/>';
            str += obj.contact_tel + '<br/>';
            str += obj.contact_addr + '<br/>';
            str += '</td><td class="text-center">';
            str += obj.order_type == 1 ? '送货上门' : '到店自取';
            str += '</td><td class="text-center">';
            str += '￥' + obj.order_paid;
            str += '</td><td class="text-center">';
            str += obj.status == 8 ? '已完成' : '已结束';
            str += '</td><td class="text-center">';
            str += obj.order_createtime;
            str += '</td></tr>';

            str += '<tr id="row_detail_' + obj.order_id + '" class="row_detail hidden">';
            str += '<td colspan="3">';

            str += '订  单  号:	' + obj.order_id;
            str += '&nbsp;&nbsp;<a href="#" onclick="return printOrder(' + obj.order_id + ');">';
            str += '<img src="//img1.dacaipu.cn/pc/images/icon_printer-alt.png" width="16px" height="16px" border="0" alt="打印" title="打印">';
            str += '</a>';
            str += '<br/>';
            if (obj.order_type == 1)
            {
                str += '收货时间：' + obj.order_dinnertime;
            }
            else
            {
                str += '取货时间：' + obj.order_dinnertime;
            }

            str += '<br/>用户备注:' + obj.memo;
            str += '<br/>';
            str += '</td>';
            str += '<td colspan="3">';
            str += '<table class="table table-bordered"><tr><td colspan="3"><strong>订单详情</strong></td></tr><tr><td>商品</td><td>数量</td><td>单价</td></tr>';
            //
            $(obj.products).each(function(idx, product) {
                str += '<tr><td>';
                str += product.dish_name;
                str += '</td><td>' + product.order_count;
                str += '</td><td>';
                str += $.money((parseFloat(product.dish_price) + parseFloat(product.dish_package_fee))) + '</td>';
                str += '</tr>';
            });

            $(obj.discount).each(function(idx, discount) {

                str += '<tr><td>' + discount.discount_name + '</td><td></td><td>-' + discount.discount_money_value + '</td></tr>';
            });

            if (obj.coupon)
            {
                str += '<tr><td>优惠券(' + obj.coupon.coupon_code + ')</td><td></td><td>-' + obj.coupon.coupon_value + '</td></tr>';
            }

            if (obj.order_type == 1)
            {
                str += '<tr><td>配送费</td><td>1</td><td>' + obj.express_fee + '</td></tr>';
            }
            str += '<tr><td colspan="2">总计</td><td>' + obj.order_paid + ' 元</td></tr>';


            str += '</td></tr>';

            $(list).append(str);
        });

    });

}