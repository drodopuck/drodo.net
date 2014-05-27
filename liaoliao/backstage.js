//发送http get请求
var http_ajax = function(httpurl, method, data) {
	if (!method) {
		method = "GET";
	}
	if (!data) {
		data = {};
	}
	
	$.ajax({
		type : method,
		async : false,
		timeout : 5000,
		data : data,
		url : httpurl,
		dataType : "jsonp"
	});

};

// 获取url参数
function get_param(argname)
{
	var url = document.location.href;
	var arrStr = url.substring(url.indexOf("?")+1).split("&");
	//return arrStr;
	for(var i =0;i<arrStr.length;i++)
	{
	   var loc = arrStr[i].indexOf(argname+"=");

	   if(loc!=-1)
	   {
	    return arrStr[i].replace(argname+"=","").replace("?","");
	    break;
	   }
	  
	}
	return "";
}

// date format
if(!Date.prototype.Format) {
	Date.prototype.Format = function(fmt)
    {
        var o = {
            "M+" : this.getMonth()+1,                 //月份
            "d+" : this.getDate(),                    //日
            "h+" : this.getHours(),                   //小时
            "m+" : this.getMinutes(),                 //分
            "s+" : this.getSeconds(),                 //秒
            "q+" : Math.floor((this.getMonth()+3)/3), //季度
            "S"  : this.getMilliseconds()             //毫秒
        };
        if(/(y+)/.test(fmt))
            fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
        for(var k in o)
            if(new RegExp("("+ k +")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
        return fmt;
    };
}


String.prototype.replaceAll = function(reallyDo, replaceWith, ignoreCase) {
    if (!RegExp.prototype.isPrototypeOf(reallyDo)) {
        return this.replace(new RegExp(reallyDo, (ignoreCase ? "gi": "g")), replaceWith);
    } else {
        return this.replace(reallyDo, replaceWith);
    }
}

//JS操作cookies方法!
//写cookies
function setCookie(name,value)
{
	var Days = 7;
	var exp = new Date(); 
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
//读取cookies
function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg)) return unescape(arr[2]);
	else return null;
}
//删除cookies
function delCookie(name)
{
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval=getCookie(name);
	if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

//在光标位置插入内容, 并选中 
(function($) { 
$.fn.extend({ 
insertContent: function(myValue, t) { 
var $t = $(this)[0]; 
if (document.selection) { //ie 
this.focus(); 
var sel = document.selection.createRange(); 
sel.text = myValue; 
this.focus(); 
sel.moveStart('character', -l); 
var wee = sel.text.length; 
if (arguments.length == 2) { 
var l = $t.value.length; 
sel.moveEnd("character", wee + t); 
t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length); 
sel.select(); 
} 
} else if ($t.selectionStart || $t.selectionStart == '0') { 
var startPos = $t.selectionStart; 
var endPos = $t.selectionEnd; 
var scrollTop = $t.scrollTop; 
$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length); 
this.focus(); 
$t.selectionStart = startPos + myValue.length; 
$t.selectionEnd = startPos + myValue.length; 
$t.scrollTop = scrollTop; 
if (arguments.length == 2) { 
$t.setSelectionRange(startPos - t, $t.selectionEnd + t); 
this.focus(); 
} 
} 
else { 
this.value += myValue; 
this.focus(); 
} 
} 
});
})(jQuery);
