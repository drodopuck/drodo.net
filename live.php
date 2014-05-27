<?php
	include_once 'util.php';
	
	if (!empty($_COOKIE["drodo_steam_id"])){
		$drodo_steam_id = $_COOKIE["drodo_steam_id"];
	}
	
	if (! empty ( $_GET ["type"] )) {
		$show_type = $_GET ["type"];
	} else {
		$show_type = "dota2";
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

	$re = file_get_contents ( "live.txt" );
	$liver = json_decode ( $re, true );
	
	//print_r($liver);
?>

<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
	<link rel="shortcut icon" href="drodo.ico">
	<?php checkBrowser(); ?>
	<title>巨鸟多多!  DOTA2  直播  视频  论坛  饰品  排行 奖金</title>
	<meta name="baidu-site-verification" content="0aPLpTGExp" />
	<link rel="stylesheet" type="text/css" href="css/drodo.css" media="all">
	<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.masonry.min.js"></script> 
	<script type="text/javascript">
	function jumppage(url){
		window.location.href=url;
	}
	function go_homepage(){
		window.location.href='index.php';
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

	function show_editor(){
		var aa=$('#curr_user').text();
		if (aa=='id:76561198034651705' || aa=='id:76561198070997936'){
				$('#editor').show();
		}
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
				<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("items.php");'>巨鸟饰品</font>
			</div>

			<div class='drodo_title_tab_selected'>
				<font class='xxxlarge orange'>巨鸟直播</font>
			</div>
			
			<div class='drodo_title_tab' style='width: 130px;'>
				<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("rank.php");'>巨鸟排行榜</font>
			</div>

			<?php if (empty($drodo_steam_id)): ?>
			<div class='drodo_title_tab' style="width: 460px;"></div>
			<div class='drodo_title_tab' style="width: 130px;">
				<a style='text-decoration: none;'
					href="https://steamcommunity.com/openid/login?openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&amp;openid.mode=checkid_setup&amp;openid.return_to=http%3A%2F%2Fdrodo.net%2Fsteam_login.php%3Fdo%3Dlogin%26from%3Dhttp%3A%2F%2Fdrodo.net%2Findex.php&amp;openid.realm=http%3A%2F%2Fdrodo.net&amp;openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&amp;openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select">
					<font class='xxxlarge lightgray hover clickable'>Steam登录</font>
				</a>
			</div>
			<?php else: ?>
			<div class='drodo_title_tab' style="width: 390px;"></div>
			<div class='drodo_title_tab' style="width: 130px;">
				<font class='xxxlarge lightgray clickable hover clickable'
					onclick='jumppage("user.php?steam_id=<?php echo $drodo_steam_id;?>")'>我的兵器库</font>
			</div>
			<div class='drodo_title_tab' style="width: 70px;">
				<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("steam_logout.php")'>退出</font>
			</div>		
			<?php endif; ?>
		</div>
	</div>
	<!-- 巨鸟多多标题栏 end -->
	
	<!-- drodo_body -->
	<div
		style='height: 500px; width: 1180px; margin-top: 10px; margin-left: auto; margin-right: auto; text-align: left;'>
		<div id='user_info' class='drodo_left black60' ondblclick='show_editor();'>
			
			<div class='drodo_left_banner'>
				<font class='xlarge gray '>直播频道分类</font>
			</div>
			
			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="dota2"):?>
				<font class='xxxlarge orange hover'>明星主播 / dota2</font>
				<?php else:?>
				<font class='xxxlarge lightgray clickable hover'
				onclick='jumppage("live.php?type=dota2");'>明星主播 / dota2</font>
				<?php endif;?>
			</div>
			
			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="game"):?>
				<font class='xxxlarge orange hover'>游戏频道 / game</font>
				<?php else:?>
				<font class='xxxlarge lightgray clickable hover'
				onclick='jumppage("live.php?type=game");'>游戏频道 / game</font>
				<?php endif;?>
			</div>
			
			
			
			
			
			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="sports"):?>
				<font class='xxxlarge orange hover'>体育频道 / sports</font>
				<?php else:?>
				<font class='xxxlarge lightgray clickable hover'
				onclick='jumppage("live.php?type=sport");'>体育频道 / sports</font>
				<?php endif;?>
			</div>
			
			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="variety"):?>
				<font class='xxxlarge orange hover'>综艺频道 / variety</font>
				<?php else:?>
				<font class='xxxlarge lightgray clickable hover'
				onclick='jumppage("live.php?type=variety");'>综艺频道 / variety</font>
				<?php endif;?>
			</div>
			
			<div id='editor' class='drodo_left_banner' style='display:none;'>
				<font class='xlarge lightgray hover clickable' onclick="window.open('editor.php?file=live&src=live');">编辑直播频道</font>
				<div id='curr_user'><font class='xlarge gray '>id:<?php echo $drodo_steam_id;?></font></div>
			</div>
			
		</div>
		
		
	<div id='user_items' class='drodo_right black60' >
		<?php foreach ( $liver as $item ): ?>
		
			<?php if (!empty($item["type"]) && $item["type"]==$show_type):
				$pic="css/live/".$item["name"].".png";
				if (!empty($item["pic"])){
					$pic = $item["pic"];
				}
			?>
			
			<div class='clickable yj' onclick='jumppage("live_player.php?liver=<?php echo $item["name"];?>")'
				style='width: 220px; height: 200px; margin: 5px; float: left; '>
				<div
					style='width: 220px; height: 150px; float: left; '>
					<img class='yj_top' src="<?php echo $pic;?>" style='width:220px;height:150px;'/>
						<div class='yj_bottom black60'
							style='width: 200px; height: 50px; padding-left:10px;padding-right:10px;position: absolute; text-align: center; opacity: 1; line-height: 20px;display: table-cell;vertical-align: middle;'>
						<div style="width:200px;height:50px;display: table-cell;vertical-align: middle;line-height:20px;">
							<font class='orange xxxlarge' ><?php echo $item["name"];?></font><br>
							<font class='lightgray xlarge' ><?php echo $item["site"];?></font>
						</div>
					</div>

				</div>

			</div>
			
			
			
			<?php endif;?>
		
		<?php endforeach;?>
	</div>	

	</div>
	
	</body>

</html>