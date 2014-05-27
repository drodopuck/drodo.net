<?php
include_once 'util.php';
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
<?php checkBrowser(); ?>
<title>巨鸟多多!  DOTA2  直播  视频  论坛  饰品  排行 奖金</title>
<meta name="baidu-site-verification" content="0aPLpTGExp" />
<link rel="stylesheet" type="text/css" href="css/qstyle.css" media="all">
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="js/jquery.masonry.min.js"></script>
<script type="text/javascript">

//获取url参数
function request(paras)
{ 
    var url = location.href; 
    var paraString = url.substring(url.indexOf("?")+1,url.length).split("&"); 
    var paraObj = {} 
    for (i=0; j=paraString[i]; i++){ 
    paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=")+1,j.length); 
    } 
    var returnValue = paraObj[paras.toLowerCase()]; 
    if(typeof(returnValue)=="undefined"){ 
    return ""; 
    }else{ 
    return returnValue; 
    } 
}
//写cookies
function setCookie(name,value)
{
var Days = 30;
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
///删除cookie
function delCookie (NameOfCookie)
{
 // 该函数检查下cookie是否设置，如果设置了则将过期时间调到过去的时间;
 //剩下就交给操作系统适当时间清理cookie啦
 if (getCookie(NameOfCookie))
 {
  document.cookie = NameOfCookie + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
 }
}



delCookie("drodo_steam_id");
delCookie("drodo_steam_name");
delCookie("drodo_steam_avatar");


var url = "index.php";
window.location.href =url;



</script>
</head>

<body>
</body>
</html>