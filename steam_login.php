<?php include_once 'util.php';?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
<?php checkBrowser(); ?>
<title>巨鸟多多!  DOTA2  直播  视频  论坛  饰品  排行 奖金</title>

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


var claimed_id = request("openid.claimed_id");
var re = '.*openid%2Fid%2F(.*)';
var h = claimed_id.match(re);
var steam_id=h[1];




setCookie("drodo_steam_id",steam_id);

var url = "user.php?steam_id="+steam_id;
window.location.href =url;



</script>
</head>

<body>
</body>
</html>