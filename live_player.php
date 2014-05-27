<?php
include_once 'util.php';

$re = file_get_contents ( "live.txt" );
$liver = json_decode ( $re, true );

if (!empty($_GET["liver"])){
	$liver_name = $_GET["liver"];
}

$curr_liver = $liver[$liver_name];
$pic="css/live/".$curr_liver["name"].".png";
if (!empty($curr_liver["pic"])){
	$pic = $curr_liver["pic"];
}
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
		window.location.href='live.php';
	}
	</script> 

</head>

<body style='height:100%;' >



	<!-- 播放器遮罩 -->
	<div id="player_mask " class="player_mask player" hidden="true" ondblclick="close_player();" ></div>
	
	<!-- 播放器窗口 -->
	<div id='player_outside_large' class="player_outside_large black60" style="text-align: left;">
	
		<div style='z-index:10030; position:absolute; width:22px;height:22px;
			 cursor:pointer; opacity:0.75; right:10px;top:10px;'>
			<div id='icon_x' class='icon_x clickable' title='返回巨鸟多多!首页' 
				onclick='go_homepage();'>
			</div>
		</div>
	
		<div id='video_player' class="player_left_large" >
			<?php echo $curr_liver["code"]; ?>
		</div>
		<div id='player_right_large' class="player_right_large" >
			<div style='width:200px;height:150px;'>
				<img src="<?php echo $pic;?>" style='width:200px;height:150px;'/>
			</div>
			<div style='float:left;padding-top:20px;'>
				<font class='orange xxxlarge' ><?php echo $curr_liver["name"]; ?></font><br>
				<font class='lightgray xlarge' ><?php echo $curr_liver["site"]; ?><br><br></font>
				
				<font class='gray xlarge' ><?php echo $curr_liver["description"]; ?><br><br></font>
				
			</div>
		</div>
		
	</div>




</body>

</html>