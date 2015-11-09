/**
 * HtmlParams v1.0
 *
 * Copyright 2013 Docee
 * Released under the MIT license
 */
function ParamsObject(){this.valueSize=0,this.value=[]}function HtmlParams(){this.params=[],this.init()}HtmlParams.prototype.init=function(){var e=location.search,t=e.substring(e.indexOf("?")+1,e.length).split("&"),n=this.params,r=this;t.forEach(function(e){var t=e.toString().split("=")[0],i=unescape(e.toString().split("=")[1]);if(!r.isExistedParams(t)){var s=new ParamsObject;s.value.push(String(i)),s.valueSize++,n[t]=s}else n[t].valueSize++,n[t].value.push(String(i))})},HtmlParams.prototype.isExistedParams=function(e){var t=this.params;return t[e]},HtmlParams.prototype.getNormalParams=function(e){return this.isExistedParams(e)?this.getParamsObj(e).getValue(0):undefined},HtmlParams.prototype.getParamsObj=function(e){var t=this.params;return this.isExistedParams(e)?t[e]:undefined},ParamsObject.prototype.toValueArray=function(){return this.value},ParamsObject.prototype.getValue=function(e){var t=Number(e);if(!isNaN(t))return this.value[t]?this.value[t]:undefined;console.error("参数值位置必须是数字类型!")}

$.money = function($cell) {
    var reg = /[\$,%]/g;
    var key = parseFloat(String($cell).replace(reg, '')).toFixed(2); // toFixed小数点后两位  
    return isNaN(key) ? 0.00 : key;
};

$(function($) {
    $("#ajax_loader").ajaxStop(function() {
        $(this).hide();
    });
    $("#ajax_loader").ajaxStart(function() {
        $(this).show();
    });
}); 

function printOrder(orderid) {
    host = window.location.host;
    var printUrl = 'http://ct.dacaipu.cn/orders/printOrdersDS/order_id/' + orderid;
    //var url = 'http://localhost:55555/?url=' + base64encode('http://'+host+'/orders/printOrders/order_id/'+orderid+'?callback=?');
    var url = 'http://localhost:55555/?url=http://ct.dacaipu.cn/orders/printOrders/order_id/' + orderid + '&callback=?';
    $.ajaxSetup({
        timeout: 3000,
        dataType: 'json',
        //请求成功后触发
        success: function(data) {
            if (data.code == 1) {
                return;
            } else if (data.code == -1) {
                //window.location.href = printUrl;
            }
        },
        //请求失败遇到异常触发
        error: function(xhr, status, e) {
            window.location.href = printUrl;
        },
                //发送请求前触发
                beforeSend: function(xhr) {
                    //可以设置自定义标头
                    xhr.setRequestHeader('Content-Type', 'application/xml;charset=utf-8');
                },
    });
    $.getJSON(url);
}