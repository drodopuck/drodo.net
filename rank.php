<?php 
	include_once 'util.php';
?>

<?php

if (! empty ( $_COOKIE ["drodo_steam_id"] )) {
	$drodo_steam_id = $_COOKIE ["drodo_steam_id"];
}

$re = file_get_contents ( "rank.txt" );
$obj = json_decode($re);
$rank = $obj->rank;
$match = $obj->match;
$date = $obj->date;
// print_r($re);

?>
<html>
<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
	<link rel="shortcut icon" href="drodo.ico">
	<?php checkBrowser(); ?>
	
	
	<title>巨鸟多多!2013世界DOTA2奖金排行榜</title>
	<link rel="stylesheet" type="text/css" href="css/drodo.css" media="all">
	<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.masonry.min.js"></script> 
	<script type="text/javascript" src="js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="js/jquery.timeago.js"></script>
	<script type="text/javascript" src="js/qudian_common.js"></script>
	<script type="text/javascript" src="js/qudian_make_html.js"></script>
	<script type="text/javascript" src="js/qudian_playlink_decode.js"></script>
	
	<script type="text/javascript" src="js/phprpc_client.js"></script>  

	<script type="text/javascript">


	//alert(document.documentElement.clientHeight);

	
	function go_homepage(){
		window.location.href='home.php';
	}
	function show_editor(){
		var aa=$('#curr_user').text();
		if (aa=='id:76561198034651705' ){
				$('#editor').show();
		}
	}
	</script> 
	
	<!-- 百度统计 -->
	<script type="text/javascript">
		var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
		document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F2c3f3867a056891335fafead2bf6266b' type='text/javascript'%3E%3C/script%3E"));
	</script>

</head>



<body style='height:100%;' >

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

			<div class='drodo_title_tab'>
				<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("live.php");'>巨鸟直播</font>
			</div>
			
			<div class='drodo_title_tab_selected' style='width: 130px;'>
				<font class='xxxlarge orange'>巨鸟排行榜</font>
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
	<div style='height: 500px; width: 1180px; margin-top: 10px; margin-left: auto; margin-right: auto; text-align: left;'>
		<div id='user_info' class='drodo_left black60' ondblclick='show_editor();'>
		
		<div class='drodo_left_banner' style='margin-top:10px;'>
		<div style='line-height:30px;'>
				<font class='xxxxlarge orange'>巨鸟2013<br>世界DOTA2<br>奖金排行榜</font>
		</div>
		</div>
		
		
		
		<?php foreach($match as $m):?>
		<div class='drodo_left_banner black60 yj'>
			<font class='xlarge lightgray'><?php echo $m->title;?> 冠军:</font><br>
			<img width=20 height=15 style='padding-top:3px;' src='css/rank/flag_<?php echo $m->country;?>.png'/>
			<font class='xxxlarge lightgray'><?php echo $m->team;?></font>
		</div>
		<?php endforeach;?>

		
		<div class='drodo_left_banner'>
			<font class='xlarge gray'>更多赛事新闻</font>
			<a href="http://fight.pcgames.com.cn/dota2/">
			<img src='css/tpy3.png'  border='0' style='border:0px;width:127px;height:18px;padding-top:5px;'>
			</a>
		</div>
		<div class='drodo_left_banner'>
			<font class='xlarge gray'>数据统计<br></font>
			<font class='xlarge lightgray'>萌萌de风行<br></font>
			<font class='xlarge gray'>最后更新时间<br></font>
			<font class='xlarge lightgray'><?php echo $date;?><br></font>
		</div>
		
		<div id='editor' class='drodo_left_banner' style='display:none;'>
				<font class='xlarge lightgray hover clickable' onclick="window.open('editor.php?file=rank&src=rank');">编辑奖金排行</font>
				<div id='curr_user'><font class='xlarge gray '>id:<?php echo $drodo_steam_id;?></font></div>
		</div>
		
		</div>
		
		
		
		
		<div id='user_items' class='drodo_right black60' >
		
		<table style='backgroung-color:#999999;border:0px solid #999999;table-layout:fixed; '>
			<tr style='height:30px;'>
				<td style='text-align:center;width:100px;word-break:break-all;'><font class='xlarge orange'>排名</font></td>
				<td style='text-align:center;width:250px;word-break:break-all;'><font class='xlarge orange'>队名</font></td>
				<td style='text-align:center;width:50px;word-break:break-all;'><font class='xlarge orange'>冠军</font></td>
				<td style='text-align:center;width:50px;word-break:break-all;'><font class='xlarge orange'>亚军</font></td>
				<td style='text-align:center;width:50px;word-break:break-all;'><font class='xlarge orange'>季军</font></td>
				<td style='text-align:center;width:100px;word-break:break-all;'><font class='xlarge orange'>总奖金￥</font></td>
				<td style='text-align:center;width:200px;word-break:break-all;'><font class='xlarge orange'>队员</font></td>
			</tr>
			<?php foreach ( $rank as $item ): ?>
			<tr style='height:60px;'>
				<td style='text-align:center;'><font class='xxxlarge lightgray'>#<?php echo $item->rank;?></font></td>
				<td><div style='float:left;'><img width=48 height=48 class='yj'  src='css/rank/team_<?php echo $item->name;?>.jpeg'/></div>
				<div style='float:left;padding-left:10px;'>
					<img width=20 height=15 style='padding-top:3px;padding-right:3px;' src='css/rank/flag_<?php echo $item->country;?>.png'/>
					<font class='xxxlarge lightgray'><?php echo $item->name;?></font><br>
					<font class='xlarge gray'><?php echo $item->fullname;?></font><br>
				</div>
				</td>
				<td style='text-align:center;' ><font class='xxxlarge lightgray'><?php echo $item->g;?></font></td>
				<td style='text-align:center;' ><font class='xxxlarge lightgray'><?php echo $item->s;?></font></td>
				<td style='text-align:center;' ><font class='xxxlarge lightgray'><?php echo $item->c;?></font></td>
				<td style='text-align:center;' ><font class='xxxlarge lightgray'><?php echo $item->money;?></font></td>
				<td style='text-align:center;' ><font class='xlarge gray'><?php echo $item->p1." / ".$item->p2." / ".$item->p3." / ".$item->p4." / ".$item->p5;?></font></td>

			</tr>
			<?php endforeach;?>
		</table>

		</div>
	</div>
	
</body>

</html>