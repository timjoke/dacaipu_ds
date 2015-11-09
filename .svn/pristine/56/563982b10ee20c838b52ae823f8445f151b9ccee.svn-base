var order_list = new Dictionary();
var op_order_id = 0;
var op_order_type = 0;



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


function showRefuse(order_id, order_type)
{
    op_order_id = order_id;
    op_order_type = order_type;
    $('#refuse_re').val('');
    $('#reason_msg').html('');
    $.fancybox($('#refuse_reason'));
    $('#refuse_reason').show();
}

function submitRefuse()
{
    var reason = $.trim($('#refuse_re').val());
    if (reason.length == 0)
    {
        $('#reason_msg').html('请输入拒绝理由');
        return;
    }


    OrderStatusCallBack(op_order_id, 2, 4, 1, reason, function() {
        $.fancybox.close();
    });
}

function OrderStatus(order_id, status_code, new_status_code, order_type)
{
    OrderStatusCallBack(order_id, status_code, new_status_code, order_type, null, null);
}

function OrderStatusCallBack(order_id, status_code, new_status_code, order_type, reason, fn)
{
    $.post('/change_order_status',
            {
                "order_id": order_id,
                "order_status": status_code,
                "new_status": new_status_code,
                "reason": reason
            },
    function(data) {
        var place = $('#cell_btn_' + order_id);
        if (data.code == 0)
        {
            $(place).empty();

            if (new_status_code == 3)
            {
                if (order_type == 1)
                {
                    $(place).append('<input type="button" class="btn btn-default btn-block" value="备货完毕" onclick="OrderStatus(' + order_id + ',3,7,' + order_type + ');"/>');
                }
                else if (order_type == 2)
                {
                    $(place).append('<input type="button" class="btn btn-default btn-block" value="备货完毕" onclick="OrderStatus(' + order_id + ',3,6,' + order_type + ');"/>');
                }
            }

            else if (new_status_code == 5)
            {
                $(place).append('<input type="button" class="btn btn-default btn-block" value="开始配送" onclick="OrderStatus(' + order_id + ',3,7,' + order_type + ');"/>');
            }
            else if (new_status_code == 6)
            {
                $(place).append('<input type="button" class="btn btn-default btn-block" value="完成自取" onclick="OrderStatus(' + order_id + ',6,8,' + order_type + ');"/>');
            }
            else if (new_status_code == 7)
            {
                $(place).append('<input type="button" class="btn btn-default btn-block" value="完成配送" onclick="OrderStatus(' + order_id + ',7,8,' + order_type + ');"/>');
            }
            else if (new_status_code == 8 || new_status_code == 4)
            {
                $('#row_order_' + order_id).remove();
                $('#row_detail_' + order_id).remove();
            }

            if (fn != null)
            {
                fn();
            }

            op_order_id = 0;
            op_order_type = 0;

            return false;
        }
        else
        {
            alert(data.msg);
        }
    }, 'json');
}


function getOrders()
{
    $.getJSON('/new_orders.json?ts=' + new Date().getMilliseconds(), function(data) {
        var list = $('#order_list');

        if (data.length == 0)
        {
            $('#h3_msg').html('暂时没有新订单。');
        }
        else
        {
            $('#h3_msg').hide();
            $(list).removeClass('hidden');
        }

        $(order_list.key_list).each(function(idx, k)
        {
//            var exist_old = false;
//            $(data).each(function(idx2, obj2) {
//                if (k === obj2.order_id)
//                {
//                    exist_old = true;
//                    return false;
//                }
//            });
//            if (!exist_old)
//            {
                order_list.remove(k);
                $('#row_order_' + k).remove();
                $('#row_detail_' + k).remove();
            //}
        });

        $(data).each(function(index, obj) {
            if (!order_list.contains(obj.order_id))
            {
                order_list.add(obj.order_id, obj);

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
                switch (obj.order_status)
                {
                    case 3:
                        str += '已接受，备货中';
                        break;
                    case 4:
                        str += '已拒绝';
                        break;
                    case 5:
                        str += '已备货，准备配送';
                        break;
                    case 6:
                        str += '已备货，等待取货';
                        break;
                    case 7:
                        str += '已备货，配送在途';
                        break;
                    default:
                        break;
                }

                str += '</td><td class="text-center">';
                str += obj.order_createtime;
                str += '</td><td class="text-center" id="cell_btn_' + obj.order_id + '">';
                //待处理
                if (obj.order_status == 2)
                {
                    str += '<input type="button" class="btn btn-default btn-block" value="接受订单" onclick="OrderStatus(' + obj.order_id + ',2,3,' + obj.order_type + ');"/>';
                    str += '<input type="button" class="btn btn-default btn-block" value="拒绝订单"  onclick="showRefuse(' + obj.order_id + ',' + obj.order_type + ');"/>';
                }
                //处理中
                else if (obj.order_status == 3)
                {
                    if (obj.order_type == 1) {
                        str += '<input type="button" class="btn btn-default btn-block" value="备货完毕" onclick="OrderStatus(' + obj.order_id + ',3,7,' + obj.order_type + ');"/>';
                    }
                    else if (obj.order_type == 2)
                    {
                        str += '<input type="button" class="btn btn-default btn-block" value="备货完毕" onclick="OrderStatus(' + obj.order_id + ',3,6,' + obj.order_type + ');"/>';
                    }

                }
                //待派送
                else if (obj.order_status == 5)
                {
                    str += '<input type="button" class="btn btn-default btn-block" value="完成订单" onclick="OrderStatus(' + obj.order_id + ',5,7,' + obj.order_type + ');"/>';
                }
                //待自取
                else if (obj.order_status == 6)
                {
                    str += '<input type="button" class="btn btn-default btn-block" value="完成自取" onclick="OrderStatus(' + obj.order_id + ',6,8,' + obj.order_type + ');"/>';
                }
                //派送中
                else if (obj.order_status == 7)
                {
                    str += '<input type="button" class="btn btn-default btn-block" value="完成配送" onclick="OrderStatus(' + obj.order_id + ',7,8,' + obj.order_type + ');"/>';
                }

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
                str += '<td colspan="4">';
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

                if (obj.order_type == 1)
                {
                    str += '<tr><td>配送费</td><td>1</td><td>' + obj.express_fee + '</td></tr>';
                }
                str += '<tr><td colspan="2">总计</td><td>' + obj.order_paid + ' 元</td></tr>';


                str += '</td></tr>';

                $(list).append(str);
            }
        });

    });

    setTimeout('getOrders();', 7000);
}