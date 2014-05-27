<?php
	include_once 'util.php';
	
	if (!empty($_COOKIE["drodo_steam_id"])){
		$drodo_steam_id = $_COOKIE["drodo_steam_id"];
	}
	
	if (! empty ( $_GET ["file"] )) {
		$file = $_GET ["file"];
	} else {
		$file = "live";
	}
	if (! empty ( $_GET ["src"] )) {
		$src = $_GET ["src"];
	} else {
		$src = "live";
	}
	
	$re = file_get_contents ( "$file.txt" );
	$liver = json_decode ( $re, true );
	
?>

<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
	<link rel="shortcut icon" href="drodo.ico">
	<?php checkBrowser(); ?>
	<title>巨鸟多多!  DOTA2  饰品 直播 奖金 </title>
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

	// 提交表单
	function submit_editor(){
		$("#editor_form").submit();
	}

	</script> 
	

</head>


<body style='overflow-x:hidden;overflow-y:scroll;'>
	
	
	<!-- drodo_body -->
	<div
		style='height: 500px; width: 1180px; margin-top: 10px; margin-left: auto; margin-right: auto; text-align: left;'>
		<div id='user_info' class='drodo_left black60'>
			
			<div class='drodo_left_banner'>
				<font class='xlarge gray '>编辑<?php echo ' '.$file;?>.txt</font>
			</div>
			
			<div class='drodo_left_banner black60 yj'>
				<font class='xxxlarge lightgray hover clickable' onclick="submit_editor();">保存修改 / Save</font>
			</div>
			
			<div class='drodo_left_banner black60 yj'>
				<font class='xxxlarge lightgray' >上传图片 / Picture</font>
				<form action="editor_picture_post.php" method="post" target="_blank" style="margin-bottom:5px;"
				enctype="multipart/form-data">
					<div class="yj clickable" style="background-color:gray;margin-top:5px;padding-left:10px;height:32px;line-height:40px;">
   						<input type="file" name="file" class="file" id="file" size="28" value="浏览" style="margin-top:5px;font-family:微软雅黑;font-size:12px;width:150px;"/>
 					</div>
 					
 					<input type="submit" name="submit" class="btn yj clickable"  value="上传" style="font-family:微软雅黑;font-size:14px;background-color:lightgray;margin-top:10px; border:0px solid #CDCDCD;height:24px; width:170px;"/>
				</form>
			
			</div>
			
			
			<div class='drodo_left_banner black60 yj'>
				<font class='xxxlarge lightgray hover clickable' onclick="window.open('http://s981.photobucket.com/')">外链图片 / Outlink</font>
			</div>
			
			
			
			<div class='drodo_left_banner black60 yj'>
				<font class='xxxlarge lightgray hover clickable' onclick="jumppage('<?php echo $src;?>.php')">退出 / Exit</font>
			</div>
			
		</div>
		
		
	<div id='user_items' class='drodo_right black60' style='height:620px;'>
		<form id="editor_form" action="editor_post.php" method="post">
			<input type=hidden value="<?php echo $file;?>" name="file">
			<input type=hidden value="<?php echo $src;?>" name="src">
	        <textarea id="content" name="content"
	        	style='font-family:Consolas;width:920px;height:620px;background-color:#191919;color:lightgray;'>
	        	<?php echo $re;?>
	        </textarea>
		</form>
	</div>	

	</div>
	
	</body>

</html>