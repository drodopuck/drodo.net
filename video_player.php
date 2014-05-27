<?php
include_once 'util.php';

$re = file_get_contents ( "video.txt" );
$v = json_decode ( $re, true );

if (! empty ( $_GET ["id"] )) {
	$show_id = $_GET ["id"];
} else {
	$show_id = "match";
}

$item = $v[$show_id];
?>
<html>
<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
	<link rel="shortcut icon" href="drodo.ico">
	<?php checkBrowser(); ?>
	<title>巨鸟多多!  DOTA2  直播  视频  论坛  饰品  排行 奖金</title>
	
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
	function go_homepage(){
		window.location.href='video.php';
	}
	</script> 

</head>

<body style='height:100%;' >



	<!-- 播放器遮罩 -->
	<div id="player_mask " class="player_mask player" hidden="true" ondblclick="close_player();" ></div>
	
	<!-- 播放器窗口 -->
	<div id='player_outside_large' class="black60" style="text-align: left;">
	
		<div style='z-index:10030; position:absolute; width:22px;height:22px;
			 cursor:pointer; opacity:0.75; right:10px;top:10px;'>
			<div id='icon_x' class='icon_x clickable' title='返回巨鸟多多首页' 
				onclick='go_homepage();'
				onmouseover='change_class("icon_x","icon_x","icon_x_2")' 
				onmouseout='change_class("icon_x","icon_x_2","icon_x")'>
			</div>
		</div>
	
		<div id='video_player' class="player_left_large" >
			<embed src="<?php echo $item["swf"]; ?>" 
			allowFullScreen="true" quality="high" width="910" height="600" 
			align="middle" allowScriptAccess="always" type="application/x-shockwave-flash">
			</embed>
		</div>
		<div id='player_right_large' class="player_right_large" >
			<div style='float:left;'>
			
				<img src="<?php echo $item["pic"];?>" style='width:200px;height:150px;' />
			
				<br><br>
				<font class='orange xxxlarge' ><?php echo $item["name"];?></font><br>

				
				<img width=20 height=15 style='padding-top:3px;' src='css/rank/flag_<?php echo $item["team1_c"];?>.png'/>
				<font class='lightgray xxlarge' ><?php echo $item["team1"];?></font>
				
				<font class='gray large' >vs.</font>
				
				<img width=20 height=15 style='padding-top:3px;' src='css/rank/flag_<?php echo $item["team2_c"];?>.png'/>
				<font class='lightgray xxlarge' ><?php echo $item["team2"];?></font>
				
				<br>
				<font class='gray large' ><?php echo $item["event"];?></font>
				<font class='gray large' ><?php echo $item["upper"];?></font>
				<font class='gray large' ><?php echo $item["time"];?></font>
				<br>
				<br>
				<font class='gray xxlarge' ><?php echo $item["description"];?></font>
				
			</div>
		</div>
		
	</div>




</body>

</html>