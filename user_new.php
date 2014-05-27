<?php
include_once 'util.php';
$api_key = '668542478BF6150AD44F08DD39047CAA';

if (! empty ( $_COOKIE ["drodo_steam_id"] )) {
	$drodo_steam_id = $_COOKIE ["drodo_steam_id"];
}

if (! empty ( $_GET ["steam_id"] )) {
	$steam_id = $_GET ["steam_id"];
} else {
	$steam_id = "";
}

$re = file_get_contents ( "pro_player.txt" );
$pro_player = ( array ) json_decode ( $re, true );
foreach($pro_player as $pro){
	if ($pro["id"] == $steam_id){
		$ti = $pro["ti"];
		$ti_rarity = $pro["rarity"];
		$ti_name = $pro["name"];
	}
}

$time_3_month_ago = strtotime ( "today" ) - (90 * 24 * 60 * 60);

?>

<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
<link rel="shortcut icon" href="drodo.ico">
	<?php checkBrowser(); ?>
	<title>巨鸟多多! DOTA2 直播 视频 论坛 饰品 排行 奖金</title>
<meta name="baidu-site-verification" content="0aPLpTGExp" />
<link rel="stylesheet" type="text/css" href="css/qstyle.css" media="all">
<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
<SCRIPT type=text/javascript src="js/jquery.easing.1.2.js"></SCRIPT>
	<!-- 百度统计 -->
	<script type="text/javascript">
		var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
		document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F2c3f3867a056891335fafead2bf6266b' type='text/javascript'%3E%3C/script%3E"));
	</script>

<script type="text/javascript">
	var u_vh_count = -2;
	var u_h_count = -2;
	var u_n_count = -2;

	function page_load(id,time){
		get_info(id);
		//get_score(id,time);
		get_friend(id);
		get_items(id);
	}

	function get_items(id){
		$("#user_items_loading").show();
		var url="get_user_items.php?steam_id="+id;
		$.get(url, {}, function (data, textStatus){
			var items = $.parseJSON(data);
// 			console.info("【items】"+data);
			if (items.length==0){
				$("#user_items_loading").hide();
				$("#items_hide").slideDown();
			}
			else{
				$("#user_items_loading").hide();
				
				var i_html = "";
				for (var i=0; i<items.length; i++) {
					var f = items[i];
				i_html += "<div id='item_page_"+i+"' style='display:none;margin-left: 0px; margin-bottom: 0px; width: 900px; float: left; padding: 0px; ' >";
					for (var ii=1; ii<=30; ii++){
						var c = f[ii];
						if (c.id==0 || c.quality_color=="gray" || !c.image){
							i_html += "<div style='width:140px;height:113px;margin:5px;float:left;border:0px solid #333333;border-radius: 20px;' class='shadow'>";
						}
						else{
							i_html += "<div style='width:140px;height:113px;margin:2px;float:left;border:3px solid "+c.quality_color+";border-radius: 20px;' class='shadow'>";
						}	
						i_html += "<div style='width: 140px; height: 113px; float: left; background-color: #000000;border-radius: 20px;";
						if (!c.image){
							i_html += " opacity:0.3; ";
						}
						i_html += "	'>";
						if (c.id!=0){
							if (!c.price){
								c.price = "-";
							}
							if (c.image){
							i_html += "<img class='clickable' src='"+c.image+"' style='width: 140px; height: 93px;border-top-left-radius: 18px;border-top-right-radius: 18px;' title='"+c.title+"' ";
							i_html += " onclick=\"open_details('"+c.id+"','"+c.name_cn+"','"+c.name+"','"+c.image+"','"+c.desc+"','"+c.price+"','"+c.rarity_color+"','"+c.rarity_show+"','"+c.quality_color+"','"+c.quality_cn+"','"+c.new_item+"','"+c.unusual_color+"','"+c.gif+"','"+c.taobao+"');\" ";
							i_html += " >";
							i_html += "<div style='width: 140px; height: 20px; border-bottom-left-radius: 18px;border-bottom-right-radius: 18px;margin-top: 0px; background-color: #000000; text-align: center; opacity: 1; line-height: 17px;'>";
							i_html += "<font style='color:"+c.quality_color+";' class='large' >"+c.quality_cn+"</font>&nbsp;";
							if (c.unusual_color){
								i_html += "<font style='color:"+c.unusual_color+";' class='large' >█</font>&nbsp;";
							}
							i_html += "<font style='color:"+c.rarity_color+";' class='large' >"+c.rarity_cn+"</font>";
							i_html += "</div>";
							}

						}
						i_html += "</div>";
						i_html += "</div>";
					}
				i_html += "</div>";
				}

				$("#drodo_user_stock").html(i_html);
				total_page = items.length-1;
// 				curr_page = 0;
				
				adjust_page_number();

			}
			
		});
	}

	function get_info(id){
		//$("#info_loading").show();
		var url="get_user_info.php?steam_id="+id;
		$.get(url, {}, function (data, textStatus){
			var u = $.parseJSON(data); 
			
			$("#user_items_loading").hide();
			$("#drodo_right_name").text(u.personaname);
			$("#drodo_right").fadeIn("slow");
			
			
			$("#drodo_user_pic").attr("src",u.avatarfull); 
			$("#drodo_user_name").text(u.personaname);
			$("#drodo_user_details_name").text(u.personaname);
			$("#drodo_user_details").fadeIn("slow");
			
			$("#drodo_page").fadeIn("slow");
			
			curr_page = -1;
			adjust_page_number();
		});
	}

	
	function get_friend(id){
		$("#friends_loading").show();
		$("#drodo_user_friends").hide();
		var url="get_user_friend_list.php?steam_id="+id;
		$.get(url, {}, function (data, textStatus){
			
			var f_obj = $.parseJSON(data); 

			var f_html = "<div style='margin-left:5px;height:30px;text-align:left;'><font style='font-size:18px;color:lightgray;'>ta的好友</font></div>";
			f_obj.sort(
	                function(a, b)
	                {
	                    if(a.personaname < b.personaname) return -1;
	                    if(a.personaname > b.personaname) return 1;
	                    return 0;
	                }
	            );
			
			for (var i=0; i<f_obj.length; i++) {
				var f = f_obj[i];

				f_html += "<div class='shadow' style='float:left;width:64px;overflow:hidden;margin:5px;border-radius: 20px;' ";
				f_html += "	title='"+f.personaname+"' ";
				f_html += "	onclick = \"jumppage('user_new.php?steam_id="+f.steamid+"')\" >";
				f_html += "<img src='"+f.avatarmedium+"' style='width:64px;height:64px;border-radius: 20px;'>";
				f_html += "</div>";

			}
			
			$("#drodo_user_friends").html(f_html);
			$("#drodo_user_friends").slideDown("slow");
// 			$("#friends_list").fadeIn("slow");

		});
	}
	

	function rarity_2_color(r){
		if (r=="未知") { return "#333333";}
		if (r=="普通") { return "#b0c3d9";}
		if (r=="罕见") { return "#5e98d9";}
		if (r=="稀有") { return "#4b69ff";}
		if (r=="神话") { return "#8847ff";}
		if (r=="传说") { return "#d32ce6";}
		if (r=="远古") { return "#eb4b4b";}
		if (r=="不朽") { return "#e4ae39";}
		if (r=="至宝") { return "#ade55c";}

		return "#333333";
		
	}
	
	function jumppage(url){
		window.location.href=url;
	}
	function go_homepage(){
		window.location.href='index.php';
	}

	//开、关详情页
	function open_details(id,name_cn,name_en,image,desc,price,rarity_color,rarity,quality_color,quality,isnew,unusual_color,gif,taobao){
// 		alert(title);
// 		alert(image);
		$('#item_details_mask').fadeIn("slow");
		$('#item_details').fadeIn("slow");

		$('#item_details_image').attr("src",image); 
		$('#item_details_image').show();
		
		$('#item_details_desc').text(desc);
		$('#item_details_price').text(price);

		var rarity_html="<font style='color:"+rarity_color+";' class='xlarge'>"+rarity+"</font>";
		if (isnew){
			rarity_html+="<font id='item_details_new' style='color:red;' class='xlarge' >&nbsp;New!</font>"
		}
		$('#item_details_rarity').html(rarity_html);
		
		if (quality_color && quality){
			//alert(quality_color+" "+quality);
// 			var name_html="<font id='item_details_name_cn' style='color:"+qualily_color+";' class='xxxlarge'>"+name_cn+"</font><br>"+
// 			"<font id='item_details_name_en' style='color:"+qualily_color+";' class='xxlarge'>"+name_en+"</font><br>";
// 			alert(name_html);
// 			$('#item_details_name').html(name_html);
			//alert(qualily_color);
			$('#item_details_name_cn').text(quality+" "+name_cn);
			$('#item_details_name_en').text(name_en);
			$('#item_details_name_cn').css('color',quality_color);
			$('#item_details_name_en').css('color',quality_color);
			$('#item_details').css('border','3px solid '+quality_color);
		}
		else{
			$('#item_details_name_cn').text(name_cn);
			$('#item_details_name_en').text(name_en);
			$('#item_details_name_cn').css('color','lightgray');
			$('#item_details_name_en').css('color','lightgray');
			$('#item_details').css('border','3px solid gray');
		}

		if (unusual_color){
			$('#item_details_unusual_color').show();
			$('#item_details_unusual_color_block').css('color',unusual_color);
			$('#item_details_unusual_color_text').text('颜色: '+unusual_color);
			$('#item_details_unusual_color_text').css('color',unusual_color);
		}else{
			$('#item_details_unusual_color').hide();
		}
		
		//gif
		if (gif){
			$('#item_details_gif').show();
			var gif_html = "<img src='"+gif+"'>";
			$('#item_details_gif').html(gif_html);
		}
		else{
			$('#item_details_gif').hide();
		}
		
		//taobao
		if (taobao){
			$('#item_details_taobao').show();
			$('#item_details_taobao_1').hide();
			$('#item_details_taobao_2').hide();
			if (taobao=="1"){
				$('#item_details_taobao_1').show();
			}
			if (taobao=="2"){
				$('#item_details_taobao_2').show();
			}
			if (taobao=="3"){
				$('#item_details_taobao_1').show();
				$('#item_details_taobao_2').show();
			}
		}
		else{
			$('#item_details_taobao').hide();
		}

		
	}
	function close_details(){
		$('#item_details_mask').fadeOut("slow");
		$('#item_details').fadeOut("slow");
	}

	var total_page = 0;
	var curr_page = 0; 
	
	function pageup(){
		if (curr_page>=0){
			curr_page--;
			$("#item_page_"+(curr_page+1)).hide();
			$("#item_page_"+(curr_page)).show();

			adjust_page_number();
		}
	}
	function pagedown(){
		if (curr_page<total_page){
			curr_page++;
			$("#item_page_"+(curr_page-1)).hide();
			$("#item_page_"+(curr_page)).show();

			adjust_page_number();
		}
	}

	function adjust_page_number(){

		if (curr_page!=-1){
			$("#drodo_user_stock").show();
			$("#drodo_user_details").hide();
		}
		else{
			$("#drodo_user_stock").hide();
			$("#drodo_user_details").show();
		}

		$("#drodo_page_curr").text(curr_page+1);
		$("#drodo_page_total").text(total_page+1);
		
		if (curr_page!=-1){
			$("#drodo_go_left").fadeIn("slow");
			$("#qd_go_left").fadeIn("slow");
		}
		else{
			$("#drodo_go_left").fadeOut("slow");
			$("#qd_go_left").fadeOut("slow");
		}
		if (curr_page!=total_page){
			$("#drodo_go_right").fadeIn("slow");
			$("#qd_go_right").fadeIn("slow");
		}
		else{
			$("#drodo_go_right").fadeOut("slow");
			$("#qd_go_right").fadeOut("slow");
		}
	}

	function go_user_details(){
		curr_page=-1;
		
		adjust_page_number();
	}
	
	function go_user_stock(){
		$("#item_page_"+(curr_page)).hide();
		$("#item_page_0").fadeIn("slow");

		curr_page=0;
		
		adjust_page_number();

	}

	
	</script>


</head>


<body style='overflow-x: hidden; overflow-y: hidden;'
	onload="page_load('<?php echo $steam_id; ?>',<?php echo $time_3_month_ago; ?>);"
	>
	

	<!-- 库存 -->
	<div id ='drodo_user_stock' style='display:none;width: 900px; height:620px;
	position:fixed;top:50%;left:50%;margin-top:-310px;margin-left:-450px;'>
		<div id='items_hide'
			style='display:none; margin-left: 0px; margin-bottom: 10px; width: 900px; height:500px;background-color: #191919; float: left; padding: 15px; padding-right: 10px;'
			class='shadow'>
			<div style='float: left; background-color: #222222; display: table-cell;vertical-align: middle; text-lign:center;
						width: 890px; height:490px;padding: 5px; padding-left: 10px; padding-right: 10px; '>
					<div style='width:890px;height:225px;'></div>
					<font class='xxlarge gray' >库存是私密的,不给看:(</font><br> 
			</div>
		</div>
	</div>


	<!-- 个人资料 -->
	<div id= 'drodo_user_details' style='display:none;width:900px;height:620px;
						position:fixed;top:50%;left:50%;margin-top:-310px;margin-left:-450px;'>
		<div style='width:560px;height:620px;float:left;'>
			<!-- 1 -->
			<div class='shadow' style='width:560px;height:184px;background-color:#000000;
				border-radius: 20px;padding:0px;opacity:1;float:left;'>
				<div style='float:left;opacity:1;position:relative; '>
					<img id='drodo_user_pic' src='' style='width:184px;height:184px;
						border-top-left-radius:20px;border-bottom-left-radius:20px;' class='shadow'>
				</div>
				<div style='float:left;padding:20px;opacity:1;position:relative; '>
					<font id='drodo_user_details_name' style='color:white;font-size:22px;'>zoolily</font>
				</div>
			</div>
			<!-- 2 -->
			<div class='shadow' style='float:left;width:560px;margin-top:10px;height:20px;background-color:#000000;'>
			</div>
			<!-- 3 -->
			<div class='shadow' style='float:left;width:560px;margin-top:10px;height:64px;background-color:#000000;'>
			</div>
			<div class='shadow' style='float:left;width:560px;margin-top:10px;height:64px;background-color:#000000;'>
			</div>
			<div class='shadow' style='float:left;width:560px;margin-top:10px;height:64px;background-color:#000000;'>
			</div>
			<div class='shadow' style='float:left;width:560px;margin-top:10px;height:64px;background-color:#000000;'>
			</div>
			<div class='shadow' style='float:left;width:560px;margin-top:10px;height:64px;background-color:#000000;'>
			</div>
		
		</div>
		
		<!-- 好友 -->
		<div id ='drodo_user_friends' style='width: 325px; height:620px;float:right;padding-left:15px; overflow-y:auto;'>
		</div>
	</div>
	
	
	
	
	<!-- Loading -->
	<div id='user_items_loading'
		style='z-index:5; position:fixed; width:100px;height:100px; left:50%; top:50%;
					margin-top:-64px;margin-left:-64px;'>
		<div style='display: block; text-align: center;'>
					<img src='css/loading.gif' style='width:128px;heght:128px;'>
		</div>	
	</div>



	<!-- 上一页 下一页 -->
	<div id='qd_go_right' class='qd_go_top shadow' onclick="pagedown();" style='opacity:0;display:none;'></div>
	<div id='qd_go_left' class='qd_go_top2 shadow' onclick="pageup();" style='opacity:0;display:none;'></div>
	<div id='drodo_go_right' style='z-index:-1;display:none;position:fixed;right:20px;top:50%;margin-top:-50px;opacity:0.6;'>
		<font style='font-size:72px;color:white;'>〉</font>
	</div>
	<div id='drodo_go_left' style='z-index:-1;display:none;position:fixed;left:20px;top:50%;margin-top:-50px;opacity:0.6;'>
		<font style='font-size:72px;color:white;'>〈</font>
	</div>
	
	
	<!-- 页码 -->
	<div id='drodo_page' style='z:index:-1;display:none;width:200px;height:60px;position:fixed;right:20px;bottom:30px;text-align:right;opacity:0.6;'>
		<font id='drodo_page_curr' class='white' style='font-size:60px;'>00</font>
		<font id='drodo_page_split' class='white' style='font-size:36px;'>/</font>
		<font id='drodo_page_total' class='white' style='font-size:36px;'>00</font>
	</div>
	
	<!-- 右侧栏 -->
	<div id = 'drodo_right' style='z-index:100;display:none;'>
		<div id='drodo_name' style='width:180px;height:24px;position:fixed;right:20px;top:25px;text-align:right;opacity:0.6;'>
			<font id='drodo_right_name' style='color:yellow;font-size:22px;' onclick='go_user_details();'></font><br>
			
			<div style='margin-top:10px;'>
				<font id='drodo_right_weapon' style='color:white;font-size:18px;' onclick='go_user_stock();'>兵器库</font><br>
				<font id='drodo_right_dotabuff' style='color:white;font-size:18px;'>战绩</font><br>
				<font id='drodo_right_trade' style='color:white;font-size:18px;'>交易</font><br>
			</div>
		</div>
	</div>
	
	<!-- 左侧栏 -->
	<div id = 'drodo_left' style='z-index:100;'>
		<div id='drodo_name' style='width:150px;height:24px;position:fixed;left:20px;top:25px;text-align:left;opacity:0.6;'>
			<font id='drodo_right_name' style='color:white;font-size:22px;' onclick='alert(1);'>〈 返回 </font><br>
		</div>
	</div>
	
	
	

	<!-- 饰品详情遮罩 -->
	<div id="item_details_mask" class="player_mask"
		onclick="close_details();" style="display: none;"></div>

	<!-- 饰品详情 -->
	<div id='item_details' class='shadow'
		style="box-shadow: 0px 3px 10px #000000; border-radius: 30px; width: 640px; height: 480px; background-color:#222222; position: fixed; top: 50%; left: 50%; margin-left: -320px; margin-top: -240px; opacity: 1; z-index: 10020; overflow: hidden; display: none; overflow-y: auto; border: gray solid 3px;">

		<div
			style="width: 220px; float: left; margin-left: 20px; margin-top: 20px; margin-botton: 20px; text-align: center;">
			<div id='item_details_image_div' class='shadow'
				style='width: 220px; height: 150px; float: left; background-color: #191919;border-radius: 20px;'>
				<img id='item_details_image' src='' class='shadow'
					style='width: 220px; height: 150px; display: none; border-radius: 20px;'>
			</div>
			<div
				style='width: 200px; float: left; background-color: #191919; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 20px;border-radius: 20px;'>
				<font class='xxlarge gray'>市场估价:&nbsp;</font> <font
					id='item_details_price' class='xxlarge lightgray'>-</font>
			</div>
			<div
				style='width: 200px; float: left; background-color: #191919; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; display: none;'>
				<font class='xxlarge gray'>供求比:&nbsp;</font><font
					class='xxlarge lightgray'>0 / 0</font>
			</div>
			<div
				style='width: 85px; float: left; background-color: #191919; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; text-align: center; display: none;'>
				<font class='xxlarge gray' title='此功能尚未开放，敬请期待'>我想卖!</font>
			</div>
			<div
				style='width: 85px; float: left; background-color: #191919; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-left: 10px; text-align: center; display: none;'>
				<font class='xxlarge gray' title='此功能尚未开放，敬请期待'>我想买!</font>
			</div>
			<div id="item_details_taobao"
				style="float: left; margin-top: 20px; margin-botton: 20px; text-align: left;">
				<font class='xlarge gray '>这里可以买到它</font> <br>
				<div id="item_details_taobao_1"
					style='width: 205px; float: left; background-color: #191919; padding: 5px; padding-left: 10px; margin-top: 10px; display: none; text-align: center;'>
					<font class='xxlarge lightgray hover clickable'
						onclick='jumppage("http://drodo.taobao.com");'>巨鸟多多旗舰店</font>
				</div>
				<div id="item_details_taobao_2"
					style='width: 205px; float: left; background-color: #191919; padding: 5px; padding-left: 10px; margin-top: 10px; display: none; text-align: center;'>
					<font class='xxlarge lightgray hover clickable'
						onclick='jumppage("http://zoolily.taobao.com");'>大学生兼职小店</font>
				</div>
			</div>
		</div>
		<div
			style="width: 355px; float: left; margin-left: 20px; margin-top: 20px; margin-right: 5px; text-align: left;">

			<div id="item_details_content"
				style="float: left; width: 355px; min-height: 375px;">
				<div id='item_details_name'>
					<font id='item_details_name_cn' style="color: lightgray;"
						class="xxxlarge"></font><br> <font id='item_details_name_en'
						style="color: lightgray;" class="xxlarge"></font><br>
				</div>
				<div id='item_details_rarity' style="margin-top: 5px;">
					<font style="color: blue;" class="xlarge">稀有度</font> <font
						id='item_details_new' style="color: red;" class="xlarge">New!</font>
				</div>
				<div id='item_details_unusual_color' style="">
					<font id='item_details_unusual_color_block' style="color: gray;"
						class="large">█</font> <font id='item_details_unusual_color_text'
						style="color: gray;" class="xlarge">&nbsp;</font>
				</div>
				<div style="height: 10px;">&nbsp;</div>
				<font id='item_details_desc' style="color: gray;" class="xlarge"> <!-- JS动态填充 -->
				</font><br>
				<div style='float: right; margin-top: 20px; margin-bottom: 20px;'>
					<div id="item_details_gif">
						<!-- JS动态填充 -->
					</div>
				</div>
			</div>

			<!-- <div id="item_details_comment"
				style="margin-bottom: 20px; float: right; text-align: right;">
				<font class='xlarge gray '>大家对它的评价</font> <br>
				<div
					style='float: left; background-color: #191919; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-left: 10px;'>
					<font class='xxlarge lightgray hover clickable'>评价功能</font>
				</div>
				<div
					style='float: left; background-color: #191919; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-left: 10px;'>
					<font class='xxlarge lightgray hover clickable'>尚未开放</font>
				</div>
				<div
					style='float: left; background-color: #191919; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-left: 10px;'>
					<font class='xxlarge lightgray hover clickable'>敬请期待</font>
				</div>
				<div
					style='float: left; background-color: #191919; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-left: 10px;'>
					<font class='xxlarge lightgray hover clickable'>谢谢</font>
				</div>
			</div>
			 -->

		</div>
		<!--  <div id='video_player' class="player_left_large" ></div>
		<div id='video_details' class="player_right_large_2 webstore-pb-Gb-Hb-Yd webstore-Qf-Rf-Hb"></div>
		<div id='player_x' class="player_x">
			<div id='icon_x' class='icon_x clickable' title='关闭' 
				onclick='close_player();'
				onmouseover='change_class("icon_x","icon_x","icon_x_2")' 
				onmouseout='change_class("icon_x","icon_x_2","icon_x")'>
			</div>
		</div>
		-->
	</div>

</body>

</html>