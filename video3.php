<?php 
include_once 'util.php';
 //include_once 'crypt.php';
 //global $result;
 //$encode_param = "2636288343&http%3A%2F%2Ftp4.sinaimg.cn%2F2636288343%2F50%2F40024599190%2F1&%E8%90%8C%E5%B0%8F%E8%99%BE%E4%B8%8D%E6%98%AF%E5%91%86%E5%B0%8F%E7%B1%B3%E9%82%A3%E6%A0%B7%E7%9A%84%E5%90%83%E8%B4%A7";
 //$enParam['des3key'] = "29028A7698EF4C6D3D252F02F4F79D5815389DF18525D326";
 //$enParam['des3key_hexiv'] = "70706C6976656F6B";


 // $result = pplive_3des_encrypt($encode_param, $enParam['des3key'],$enParam['des3key_hexiv']);

 //echo $result;
$api_key='668542478BF6150AD44F08DD39047CAA';

if (!empty($_COOKIE["drodo_steam_id"])){
	$drodo_steam_id = $_COOKIE["drodo_steam_id"];
}
// if (!empty($_COOKIE["drodo_steam_name"])){
// 	$drodo_steam_name = $_COOKIE["drodo_steam_name"];
// }
// if (!empty($_COOKIE["drodo_steam_avatar"])){
// 	$drodo_steam_avatar = $_COOKIE["drodo_steam_avatar"];
// }
// //如果有$drodo_steam_id，说明已登录，可以查用户信息
// if (!empty($drodo_steam_id) && empty($drodo_steam_name)){

// 	$url_get_user_info = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$drodo_steam_id";
// 	$re=file_get_contents($url_get_user_info);

// 	$user_obj=json_decode($re);
// 	$curr_user = $user_obj->response->players[0];
// 	// 		print_r($curr_user);
// 	//echo($curr_user->personaname);
// 	//echo($curr_user->avatar);
// 	$drodo_steam_name = $curr_user->personaname;
// 	$drodo_steam_avatar = $curr_user->avatar;
// 	setCookie("drodo_steam_name",$drodo_steam_name);
// 	setCookie("drodo_steam_avatar",$drodo_steam_avatar);
// }

// if (!empty($_GET["steam_id"])){
// 	$steam_id = $_GET["steam_id"];
// }
// else{
// 	$steam_id = "";
// }
?>
<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
	<?php checkBrowser(); ?>
	<title>巨鸟多多!  DOTA2  直播  视频  论坛  饰品  排行 奖金</title>
	
	<link rel="stylesheet" type="text/css" href="css/qstyle.css" media="all">
	<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.masonry.min.js"></script> 
	<script type="text/javascript" src="js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="js/jquery.timeago.js"></script>
	<script type="text/javascript" src="js/qudian_common.js"></script>
	<script type="text/javascript" src="js/qudian_make_html.js"></script>
	<script type="text/javascript" src="js/qudian_playlink_decode.js"></script>
	
	<script type="text/javascript" src="js/phprpc_client.js"></script>  

	<script type="text/javascript">
	function go_homepage(){
		window.location.href='index.php';
	}
	</script> 
	
</head>

<body onload="page_load();" style='overflow-x:hidden;overflow-y:scroll;'>

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
			<div class='drodo_title_tab_selected'>	
				<font class='xxxlarge orange clickable' onclick='jumppage("video.php");'>巨鸟视频</font>
			</div>
			<div class='drodo_title_tab'>	
				<font class='xxxlarge gray hover clickable' onclick='jumppage("items.php");'>巨鸟饰品</font>
			</div>
			<div class='drodo_title_tab'>	
				<font class='xxxlarge gray hover clickable' onclick='jumppage("forum.php");'>巨鸟论坛</font>
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
	
	
	<div style='width:1180px;margin-top:10px;margin-left:auto;margin-right:auto;'>	
				<!-- 瀑布流 -->
				<div id="waterfall_today" class="body_left_waterfall" style='padding-top:10px;'></div>
					<!-- <div class="body_left_loading_more" onclick="page_add();"></div>
					<div class="body_left_no_more" hidden='true'></div> -->
				</div>

	</div><!-- wholepage结束 -->
	
	<!-- 播放器遮罩 -->
	<div id="player_mask " class="player_mask player" style="display:none;" hidden="true" ondblclick="close_player();" ></div>
	
	<!-- 播放器窗口 -->
	<div id='video_player_outside' class="player_outside_large" style="display:none;text-align:left;">
		<div id='video_player' class="player_left_large" ></div>
		<div id='video_details' class="player_right_large_2 webstore-pb-Gb-Hb-Yd webstore-Qf-Rf-Hb"></div>
		<div id='player_x' class="player_x">
			<div id='icon_x' class='icon_x clickable' title='关闭' 
				onclick='close_player();'
				onmouseover='change_class("icon_x","icon_x","icon_x_2")' 
				onmouseout='change_class("icon_x","icon_x_2","icon_x")'>
			</div>
		</div>
	</div>
 	<!-- 向左、向右箭头 
	<div id='player_arrow_left' class="player_arrow_left player" hidden='true'>
		<div id='icon_arrow_left' class='icon_arrow_left clickable' title='上一个视频' 
			onclick=''
			onmouseover='change_class("icon_arrow_left","icon_arrow_left","icon_arrow_left_2")' 
			onmouseout='change_class("icon_arrow_left","icon_arrow_left_2","icon_arrow_left")'>
		</div>
	</div>
	<div id='player_arrow_right' class="player_arrow_right player" hidden='true'>
		<div id='icon_arrow_right' class='icon_arrow_right clickable' title='上一个视频' 
			onclick=''
			onmouseover='change_class("icon_arrow_right","icon_arrow_right","icon_arrow_right_2");' 
			onmouseout='change_class("icon_arrow_right","icon_arrow_right_2","icon_arrow_right");'>
		</div>
	</div>-->
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