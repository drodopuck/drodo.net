<?php
	include_once 'util.php';
	$api_key='668542478BF6150AD44F08DD39047CAA';
	
	if (!empty($_COOKIE["drodo_steam_id"])){
		$drodo_steam_id = $_COOKIE["drodo_steam_id"];
	}
// 	if (!empty($_COOKIE["drodo_steam_name"])){
// 		$drodo_steam_name = $_COOKIE["drodo_steam_name"];
// 	}
// 	if (!empty($_COOKIE["drodo_steam_avatar"])){
// 		$drodo_steam_avatar = $_COOKIE["drodo_steam_avatar"];
// 	}
// 	//如果有$drodo_steam_id，说明已登录，可以查用户信息
// 	if (!empty($drodo_steam_id) && empty($drodo_steam_name)){

// 		$url_get_user_info = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$drodo_steam_id";
// 		$re=file_get_contents($url_get_user_info);
		
// 		$user_obj=json_decode($re);
// 		$curr_user = $user_obj->response->players[0];
// // 		print_r($curr_user);
// 		//echo($curr_user->personaname);
// 		//echo($curr_user->avatar);
// 		$drodo_steam_name = $curr_user->personaname;
// 		$drodo_steam_avatar = $curr_user->avatar;
// 		setCookie("drodo_steam_name",$drodo_steam_name);
// 		setCookie("drodo_steam_avatar",$drodo_steam_avatar);
// 	}

?>

<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
	<link rel="shortcut icon" href="drodo.ico">
	<?php checkBrowser(); ?>
	<title>巨鸟多多!  DOTA2  直播  视频  论坛  饰品  排行 奖金</title>
	<meta name="baidu-site-verification" content="0aPLpTGExp" />
	<link rel="stylesheet" type="text/css" href="css/qstyle.css" media="all">
	<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.masonry.min.js"></script> 
	<script type="text/javascript" src="js/qudian_common.js"></script>
	<script type="text/javascript" src="js/qudian_make_html.js"></script>
	<script type="text/javascript" src="js/qudian_playlink_decode.js"></script>
	
	<script type="text/javascript">
	function jumppage(url){
		window.location.href=url;
	}
	function go_homepage(){
		window.location.href='index.php';
	}

	//鼠标移到图片上的放大效果
	function enlarge_video(id,x,y) {
		$('#img_div_video_'+id).removeClass('normal');
		$('#img_video_'+id).width(x);
		$('#img_video_'+id).height(y);
		$('#btn_play_'+id).show();
		$('#btn_time_'+id).show();
	}
	function ennormal_video(id,x,y) {
		$('#img_div_video_'+id).addClass('normal');
		$('#img_video_'+id).width(x);
		$('#img_video_'+id).height(y);
		$('#btn_play_'+id).hide();
		$('#btn_time_'+id).hide();
	}

	function change_class(id,a,b){
		$('#'+id).removeClass(a);
		$('#'+id).addClass(b);
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

	</script> 
	

</head>
<script type="text/javascript">
//var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
//document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F2c3f3867a056891335fafead2bf6266b' type='text/javascript'%3E%3C/script%3E"));
</script>
<!--  <div style='z-index:-5; position:absolute; left:0px;top:60px;width:100%'>
	<marquee behavior="scroll" scrollamount="1" scrollDelay="10"  direction="left" width=100% >
        <font class='xxxlarge lightgray'><i>人生三大错觉：IG无敌，DK会虎起，LGD能夺冠！</i></font>
	</marquee>
</div>-->

<body style='overflow-x:hidden;overflow-y:scroll;'>
	<!--巨鸟多多标题栏-->
	<div id='drodo_title' class='drodo_title'>
		<div class='drodo_logo clickable' onclick='go_homepage();'>
			<img src='css/drodo_logo.png' class='drodo_logo' />
		</div>
		<div id='drodo_title_text' class='drodo_title_text'>
			
			<div class='drodo_title_tab'>
				<font class='xxxlarge gray hover clickable' onclick='jumppage("home.php");'>巨鸟导航</font>
			</div>
			<div class='drodo_title_tab'>	
				<font class='xxxlarge gray hover clickable' onclick='jumppage("live.php");'>巨鸟直播</font>
			</div>
			<div class='drodo_title_tab'>	
				<font class='xxxlarge gray hover clickable' onclick='jumppage("video.php");'>巨鸟视频</font>
			</div>
			<div class='drodo_title_tab'>	
				<font class='xxxlarge gray hover clickable' onclick='jumppage("items.php");'>巨鸟饰品</font>
			</div>
			<div class='drodo_title_tab_selected'>	
				<font class='xxxlarge orange clickable' onclick='jumppage("forum.php");'>巨鸟论坛</font>
			</div>
			<div class='drodo_title_tab'>	
				<font class='xxxlarge gray hover clickable' onclick='jumppage("rank.php");'>巨鸟奖金</font>
			</div>

			<?php if (empty($drodo_steam_id)): ?>
			<div class='drodo_title_tab' style="width:120px;">
			</div>
			<div class='drodo_title_tab' style="width:130px;">
				<a style='text-decoration:none;'
					href="https://steamcommunity.com/openid/login?openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&amp;openid.mode=checkid_setup&amp;openid.return_to=http%3A%2F%2Fdrodo.net%2Fsteam_login.php%3Fdo%3Dlogin%26from%3Dhttp%3A%2F%2Fdrodo.net%2Findex.php&amp;openid.realm=http%3A%2F%2Fdrodo.net&amp;openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&amp;openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select">
					<font class='xxxlarge gray hover clickable'>Steam登录</font>
				</a>
			</div>
			<?php else: ?>
			<div class='drodo_title_tab' style="width:70px;">
			</div>
			<div class='drodo_title_tab' >
				<font class='xxxlarge gray hover clickable' onclick='jumppage("user.php?steam_id=<?php echo $drodo_steam_id;?>")'>我的库存</font>
			</div>
			<div class='drodo_title_tab' style="width:70px;">
				<font class='xxxlarge gray hover clickable' onclick='jumppage("steam_logout.php")'>退出</font>
			</div>
							
			<?php endif; ?>
		</div>
	</div>
	<!-- 巨鸟多多标题栏 end -->
	
	<!-- drodo_body -->
	<div style='height:500px;
			width:1180px;margin-top:10px;margin-left:auto;margin-right:auto;text-align:left;' >
		<div id='user_info' style='padding:20px;width:180px;height:700px;background-color:#191919;float:left;' class='shadow'>
			<font class='xxxlarge gray hover clickable'>建设中...</font>
		
		</div>
		
		<div style="width:940px;height:6320px;float:left;padding-left:5px;">
			<div id='user_items' style='margin-left:5px;margin-bottom:10px;width:910px;height:700px;background-color:#191919;float:left;padding:20px;' class='shadow'>
			
			</div>
		</div>
		
	</div><!-- end drodo_body -->

	<!-- 回到顶部按钮 -->
	<div id='qd_go_top' class='qd_go_top shadow' hidden='true'>
		<div id='icon_qd_go_top' class='icon_qd_go_top clickable' title='回到顶部' 
			onclick='javascript:scroll(0,0);'
			onmouseover='change_class("icon_qd_go_top","icon_qd_go_top","icon_qd_go_top_2")' 
			onmouseout='change_class("icon_qd_go_top","icon_qd_go_top_2","icon_qd_go_top")'>
		</div>
	</div>

	
	
	</body>

</html>