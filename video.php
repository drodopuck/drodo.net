<?php
	include_once 'util.php';
	
	if (!empty($_COOKIE["drodo_steam_id"])){
		$drodo_steam_id = $_COOKIE["drodo_steam_id"];
	}
	
	if (! empty ( $_GET ["type"] )) {
		$show_type = $_GET ["type"];
	} else {
		$show_type = "match";
	}
	
	$re = file_get_contents ( "video.txt" );
	$v = json_decode ( $re, true );
	
	//print_r($liver);
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
	
	<!-- drodo_body -->
	<div
		style='height: 500px; width: 1180px; margin-top: 10px; margin-left: auto; margin-right: auto; text-align: left;'>
		<div id='user_info'
			style='padding: 15px; width: 190px; min-height: 500px; overflow: hidden; background-color: #191919; float: left;'
			class='shadow'>
			
			<font class='xlarge gray '>视频分类</font> <br>
			
			<div
				style='width: 175px; height: 26px; float: left; background-color: #222222; padding: 5px; padding-left: 10px; margin-top: 10px;'>
					<?php if ($show_type=="match"):?>
					<font class='xxxlarge orange hover'>刀塔赛事 / match</font>
					<?php else:?>
					<font class='xxxlarge lightgray clickable hover'
					onclick='jumppage("video.php?type=match");'>刀塔赛事 / match</font>
					<?php endif;?>
			</div>
			
			<div
				style='width: 175px; height: 26px; float: left; background-color: #222222; padding: 5px; padding-left: 10px; margin-top: 10px;'>
					<?php if ($show_type=="study"):?>
					<font class='xxxlarge orange hover'>刀塔教学 / study</font>
					<?php else:?>
					<font class='xxxlarge lightgray clickable hover'
					onclick='jumppage("video.php?type=study");'>刀塔教学 / study</font>
					<?php endif;?>
			</div>
			
			<div
				style='width: 175px; height: 26px; float: left; background-color: #222222; padding: 5px; padding-left: 10px; margin-top: 10px;'>
					<?php if ($show_type=="cartoon"):?>
					<font class='xxxlarge orange hover'>动漫 / cartoon</font>
					<?php else:?>
					<font class='xxxlarge lightgray clickable hover'
					onclick='jumppage("video.php?type=cartoon");'>动漫 / cartoon</font>
					<?php endif;?>
			</div>
			
			<div 
				style='width: 175px; height: 26px; float: left; background-color: #222222; padding: 5px; padding-left: 10px; margin-top: 10px;'>
					<?php if ($show_type=="music"):?>
					<font class='xxxlarge orange hover'>音乐 / music</font>
					<?php else:?>
					<font class='xxxlarge lightgray clickable hover'
					onclick='jumppage("video.php?type=music");'>音乐 / music</font>
					<?php endif;?>
			</div>
			
		</div>
		
		
	<div id='user_items'
			style='margin-left: 10px; margin-bottom: 10px; width: 920px; background-color: #191919; float: left; padding: 10px; padding-right: 10px; min-height: 730px;'
			class='shadow'>
		<?php foreach ( $v as $item ): ?>
		
			<?php if (!empty($item["type"]) && $item["type"]==$show_type):?>
			
			<div 
				style='width: 220px; height: 200px; margin: 2px; float: left; border: 3px solid #191919;'>
				<div
					style='width: 220px; height: 150px; float: left; background-color: #222222;'>
					<img src="<?php echo $item["pic"];?>" style='width:220px;height:150px;' 
					class='clickable' onclick='jumppage("video_player.php?id=<?php echo $item["id"];?>")'/>
						<div
							style='width: 200px; height: 80px; padding-left:10px;padding-right:10px;position: absolute; margin-top: 0px; background-color: #000000; text-align: center; opacity: 1; line-height: 20px;display: table-cell;vertical-align: middle;'>
						
						<div style="width:200px;height:33px;display: table-cell;vertical-align: middle;line-height:25px;">
							<font class='orange xxxlarge' ><?php echo $item["name"];?></font><br>
						</div>	
						
						<img width=20 height=15 style='padding-top:3px;' src='css/rank/flag_<?php echo $item["team1_c"];?>.png'/>
						<font class='lightgray xxlarge' ><?php echo $item["team1"];?></font>
						
						<font class='gray large' >vs.</font>
						
						<img width=20 height=15 style='padding-top:3px;' src='css/rank/flag_<?php echo $item["team2_c"];?>.png'/>
						<font class='lightgray xxlarge' ><?php echo $item["team2"];?></font>
						
						<br>
						<font class='gray large' ><?php echo $item["event"];?></font>
						<font class='gray large' ><?php echo $item["upper"];?></font>
						<font class='gray large' ><?php echo $item["time"];?></font>

					</div>

				</div>

			</div>
			
			
			
			<?php endif;?>
		
		<?php endforeach;?>
	</div>	

	</div>
	
	</body>

</html>