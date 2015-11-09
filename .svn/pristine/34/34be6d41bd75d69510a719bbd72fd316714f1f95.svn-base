
var page = 1;
var http_static_url = 'http://img2.dacaipu.cn/';

$(document).ready(function()
{
    get_Content();

    $('#category_id').on('change', function() {
        page=1;
        get_Content();
    });

    $('#name').on('pressup', function(){ 
        page=1;
        get_Content();
    });

    $('#product_img').uploadify({
        'formData': {
            'timestamp': new Date().getMilliseconds()
        },
        'swf': '/js/uploadify/uploadify.swf',
        'buttonText': '选择图片',
        'buttonImage': http_static_url + '60_60/mobile/img/dish_default.png',
        'height': 60,
        'width': 60,
        'uploader': '/product_img',
        'onUploadSuccess': function(file, data, response)
        {
            var obj = JSON.parse(data);
            //$('#dish_img').attr('src', obj.file_path);
            $('#product_img_url').attr('value', obj.new_path);
            $('#product_img-button').css('backgroundImage', 'url(' + obj.file_path + ') 100% 100%');
        },
        'onUploadError': function(file, errorCode, errorMsg, errorString) {
            alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
        }
    });

    $('#product_form_layer form').validate({
        errorClass: 'text-danger',
        submitHandler: function(form)
        {
            if ($('#edit_category_id').val() == '0')
            {
                $('#edit_category_msg').html('请选择所属类别');
                return false;
            }

            if ($(form).valid())
            {
                var args = $(form).serialize();
                $.post('/save_product', args, function(obj)
                {
                    get_Content();
                    $.fancybox.close();
                }, 'json');
            }
        }
    });


    $('#product_add_form_layer form').validate({
        errorClass: 'text-danger',
        submitHandler: function(form)
        {
            if ($(form).valid())
            {
                var args = $(form).serialize();
                $.post('/add_product', args, function(obj) {
                    get_Content();
                    $.fancybox.close();
                }, 'json');
            }
        }
    });
});




function edit_product(product_id)
{
    clear_form();
    $('#product_id').attr('value', product_id);
    if (product_id != -1)
    {
        $.post('/product_item.json', {"product_id": product_id}, function(obj) {

            $('#edit_product_name').val(obj.dish_name);
            $('#edit_category_id').val(obj.category_id);
            $('#product_price').val(obj.dish_price);
            $('#product_count').val(obj.dish_count);
            $('#alert_count').val(obj.alert_count);
            $('#product_status').val(obj.dish_status);
            $('#product_img_url').val(obj.pic_url);
            $('#product_memo').val(obj.dish_introduction);
            $('#product_presell').val(obj.is_presell);
            
            $('#product_img-button').css('background-image', 'url(' + http_static_url + obj.pic_url + ')');
            $.fancybox($('#product_form_layer'));
        }, 'JSON');
    }
    else
    {
        $.fancybox($('#product_form_layer'));
    }


}


function clear_form()
{
    $('#product_id').attr('value', '0');
    $('#edit_product_name').val('');
    $('#edit_category_id').val('0');
    $('#product_price').val('');
    $('#product_count').val('');
    $('#alert_count').val('');
    $('#product_memo').val('');
}


function go(to_page)
{
    page = to_page;
    get_Content();
}

function get_Content()
{
    $.post('/product_paged_list?page=' + page,
            {
                'category_id': $('#category_id').val(),
                'product_name': $.trim($('#product_name').val())
            },
    function(data) {
        $('#h3_msg').hide();
        $('#contents').html(data);

        $('.pagination li a').each(function(idx, a) {
            var url = $(this).attr('href');

            var datas = url.split('?')[1].split('&');
            var page = 1;
            for (var i = 0; i < datas.length; i++)
            {
                var d = datas[i].split('=');
                page = d[1];
            }

            $(this).attr('onclick', 'go(' + page + ');');
            $(this).attr('href', 'javascript:void(0);');
        });


    });
}



function add_product(product_id)
{

    $('#add_product_id').attr('value', product_id);

    $.post('/product_item.json', {"product_id": product_id}, function(obj) {

        $('#add_product_name').html(obj.dish_name);
        $('#add_product_count').html(obj.dish_count);
        $('#add_count').val('');

        $.fancybox($('#product_add_form_layer'));
    }, 'JSON');

}


function change_product_status(product_id, status_code)
{
    $('#btn_'+product_id).addClass('disabled');
    $.post('/change_product_status',
            {
                'product_id': product_id,
                'status_code': status_code
            },
    function(obj) 
    {
        if (obj.code == 0)
        {
            $('#btn_' + product_id).attr('value', status_code == 0 ? '上架' : '下架');
            $('#btn_' + product_id).removeAttr('onclick');
            $('#btn_' + product_id).attr('onclick', 'change_product_status(' + product_id + ',' + (status_code == 0 ? 1 : 0) + ');');
            $('#cell_' + product_id).html(status_code == 1 ? '上架' : '下架');
            
            $('#btn_'+product_id).removeClass('disabled');
        }
    },'json');
}