
var modify_category_id = 0;

function modify_cateogry(category_id)
{
    $('#msg').html('');
    $('#category_name').val('');
    
    $.fancybox($('#form'));
    if(category_id != -1)
    {
        modify_category_id = category_id;
        $('#category_name').val($('#cell_name_'+category_id).html());
    }
    $('#form').show();
}

function save_category()
{
    var category_name = $.trim($('#category_name').val());
    if(category_name.length == 0)
    {
        $('#msg').html('必填');
        return;
    }
    
    $.post('/save_category',
    {
        'category_id':modify_category_id,
        'category_name':category_name
    },
    function(obj)
    {
        if(obj.code == 0)
        {
            if(modify_category_id == 0)
            {
                var new_category_id = obj.category_id;
                var str = '<tr><td class="text-center" id="cell_name_' + new_category_id + '">'+ category_name  +'</td>';
                str += '<td class="text-center" id="cell_'+ new_category_id +'">下线</td>';
                str += '<td class="text-center">';
                str += '<input type="button" class="btn btn-default" value="修改" onclick="modify_cateogry('+ new_category_id +');"/> ';
                str += '<input type="button" id="btn_'+new_category_id + '" class="btn btn-default" value="上线"  onclick="change_category_status('+ new_category_id +',1);"/>'
                str += '</td></tr>';
                
                $(str).insertAfter($('#tb_list tr')[0]);
                
                $.fancybox.close();
            }
            else
            {
                $('#cell_name_' + modify_category_id).html($('#category_name').val());
                $.fancybox.close();
            }
        }
        
        modify_category_id = 0;
    },
    'json');
}

function change_category_status(category_id, status_code)
{
    $.post('/change_category_status',
            {
                'category_id': category_id,
                'status_code': status_code
            },
    function(obj) {
        if (obj.code == 0)
        {
                $('#btn_' + category_id).attr('value',status_code == 0 ? '上线':'下线');
                
                $('#btn_' + category_id).removeAttr('onclick');
                $('#btn_' + category_id).attr('onclick','change_category_status('+category_id+','+(status_code == 0 ? 1:0) +');');
                $('#cell_' + category_id).html(status_code == 1 ? '上线':'下线');
        }
    },
            'json');
}