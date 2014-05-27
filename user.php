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
<link rel="stylesheet" type="text/css" href="css/drodo.css" media="all">
<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
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
		var total_price = 0;
		$("#user_items_loading").show();
		var url="get_user_items.php?steam_id="+id;
		$.get(url, {}, function (data, textStatus){
			var items = $.parseJSON(data);
// 			console.info("【items】"+data);
			if (items.length==0){
				$("#user_items_loading").hide();
				$("#items_hide").fadeIn("slow");
			}
			else{
				
				var i_html = "";
				i_html += "<div >";
				for (var ff in items) {

				var f = items[ff];
				i_html += "<div class='yj_big black60' style='width:105px;height:105px;margin:5px;float:left;border:0px solid #191919;'>";	
				i_html += "<div style='margin-top:40px;'>";
				i_html += "<font class='xxlarge lightgray' >"+f[0].hero+"</font>";
				i_html += "</div></div>";
					for (var cc in f){

						var c = f[cc];
						
						if (!c.id || c.id==0 || c.quality_color=="gray"){
							i_html += "<div class='yj_big' style='width:105px;height:105px;margin:5px;float:left;border:0px solid #191919;'>";
						}
						else{
							i_html += "<div class='yj_big' style='width:105px;height:105px;margin:2px;float:left;border:3px solid "+c.quality_color+";'>";
						}	
						i_html += "<div class='yj' style='width: 105px; height: 105px; float: left;'>";
						if (c.id!=0){
							if (!c.price){
								c.price = "-";
							}
							i_html += "<img class='yj_top clickable' src='"+c.image+"' style='width: 105px; height: 70px;' title='"+c.title+"' ";
							i_html += " onclick=\"open_details('"+c.id+"','"+c.name_cn+"','"+c.name_en+"','"+c.image+"','"+c.desc_cn+"','"+c.price+"','"+c.price_m+"','"+c.price_t+"','"+c.price_s+"','"+c.price_ave+"','"+c.rarity_color+"','"+c.rarity_show+"','"+c.quality_color+"','"+c.quality_cn+"','"+c.new_item+"','"+c.unusual_color+"','"+c.gif+"','"+c.taobao+"');\" ";
							i_html += " >";
							i_html += "<div class='yj_bottom black60' style='width: 105px; height: 35px; text-align: center; opacity: 1; line-height: 17px;'>";
							i_html += "<font style='color:"+c.quality_color+";' class='large' >"+c.quality_cn+"</font>&nbsp;";
							if (c.unusual_color){
								i_html += "<font style='color:"+c.unusual_color+";' class='large' >█</font>&nbsp;";
							}
							i_html += "<font style='color:"+c.rarity_color+";' class='large' >"+c.rarity_cn+"</font>";
							i_html += "<br>";
							if (c.price_ave=='-' || c.price_ave==''){
								i_html += "<font style='color: lightgray;' class='normal'>-</font>";
							}
							else{
								total_price += parseInt(c.price_ave);
								i_html += "<font style='color: lightgray;' class='normal'>￥"+c.price_ave+"</font>";
							}
							
							i_html += "</div>";

						}
						i_html += "</div>";
						i_html += "</div>";
					}
					
				
				}
				i_html += "</div>";
				$("#user_stock").html(i_html);

				//库存总价值
// 				console.info("库存总价值: ￥"+total_price);

				$("#total_price").text("￥"+total_price);
				$("#div_total_price").slideDown("slow");


				//评级
				var user_rarity = '普通';
	 			if (total_price<=500) { user_rarity = '普通'; }
	 			if (total_price<=2000 && total_price>500) { user_rarity = '罕见'; }
	 			if (total_price<=10000 && total_price>2000) { user_rarity = '稀有'; }
	 			if (total_price<=50000 && total_price>10000) { user_rarity = '神话'; }
	 			if (total_price>50000) { user_rarity = '传说'; }

	 			$("#user_rarity_text").text(user_rarity+" 玩家");
		 		$('#user_rarity_text').css('color',rarity_2_color(user_rarity));
		 		$("#user_rarity").slideDown();



				
// 				for (var i=0; i<items.length; i++) {
// 					$("#item_page_"+i).fadeIn("slow");
// 				}
			}
			
		});
	}

	function get_info(id){
		$("#info_loading").show();
		var url="get_user_info.php?steam_id="+id;
		$.get(url, {}, function (data, textStatus){
			var u = $.parseJSON(data); 
			$("#user_info_img").attr("src",u.avatarfull); 
			$("#user_info_name").text(u.personaname);
			if (u.realname){
				$("#user_info_name2").text(u.realname);
			}
			else{
				$("#user_info_name2_div").hide();
			}
			
			$("#info_loading").hide();

			$("#user_info_img_div").slideDown("slow");
			$("#user_info_txt").slideDown("slow");
			$("#user_info_operation").slideDown("slow");
		});
	}

	
	function get_friend(id){
		$("#friends_loading").show();
		var url="get_user_friend_list.php?steam_id="+id;
		$.get(url, {}, function (data, textStatus){
			var f_obj = $.parseJSON(data); 

			var f_html = "";
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
				if (f.communityvisibilitystate ==3){
					f_html += "<div style='width: 60px;height:60px;  float: left; overflow:hidden; ";
					f_html += "margin:3px;' title='"+f.personaname+"'";
					f_html += "	onclick = \"jumppage('user.php?steam_id="+f.steamid+"')\" >";
					f_html += "<img src='"+f.avatarmedium+"' style='width:60px;height:60px;' class='yj clickable'>";
					f_html += "</div>";
				}
			}
			$("#friends_loading").hide();
			$("#friends_list").html(f_html);
			$("#friends_list").fadeIn("slow");
			$("#friends_list_title").fadeIn("slow");

		});
	}
	function get_score(id,time){
		$("#score_loading").show();
		$("#score_no").hide();
		$("#score_yes").hide();
		var u_vh_count,u_h_count,u_n_count;
		var url="get_user_match_count.php?steam_id="+id+"&level=3&time_from="+time;
		$.get(url, {}, function (data, textStatus){
			u_vh_count = parseFloat(data);
			if (u_vh_count==-1){
				var user_rarity = '未知';
				$("#user_rarity_text").text(user_rarity+" 玩家");
	 			$('#user_rarity_text').css('color',rarity_2_color(user_rarity));
	 			$("#user_rarity").slideDown();
				
	 			$("#score_loading").hide();
	 			$("#score_no").slideDown();
	 			$("#score_yes").hide();
	 			return;
			}
				url="get_user_match_count.php?steam_id="+id+"&level=2&time_from="+time;
				$.get(url, {}, function (data, textStatus){
					u_h_count = parseFloat(data);
					url="get_user_match_count.php?steam_id="+id+"&level=1&time_from="+time;
					$.get(url, {}, function (data, textStatus){
						u_n_count = parseFloat(data);
						
						if (u_vh_count==-1 || u_h_count==-1 || u_n_count==-1){
							var user_rarity = '未知';
							$("#user_rarity_text").text(user_rarity+" 玩家");
				 			$('#user_rarity_text').css('color',rarity_2_color(user_rarity));
				 			$("#user_rarity").slideDown();
							
				 			$("#score_loading").hide();
				 			$("#score_no").slideDown();
				 			$("#score_yes").hide();
				 			return;
				 		}
						else if (u_vh_count>=0 && u_h_count>=0 && u_n_count>=0){
				 			var total_count = u_vh_count+u_h_count+u_n_count;
				 			if (total_count==0) { total_count =1; }

				 			var vh_rate = u_vh_count / total_count *100;
				 			var h_rate = u_h_count / total_count *100;
				 			var n_rate = u_n_count / total_count *100;

				 			var score_final = vh_rate+h_rate*0.5;
				 			console.info("score_final:"+score_final);

				 			var user_rarity = '普通';
				 			if (score_final<=30) { user_rarity = '普通'; }
				 			if (score_final<=50 && score_final>30) { user_rarity = '罕见'; }
				 			if (score_final<=70 && score_final>50) { user_rarity = '稀有'; }
				 			if (score_final<=90 && score_final>70) { user_rarity = '神话'; }
				 			if (score_final>90) { user_rarity = '传说'; }

				 			if($("#ti").length>0){
				 				$("#user_rarity_ti").slideDown();
				 			}
				 			else{
				 				$("#user_rarity_text").text(user_rarity+" 玩家");
					 			$('#user_rarity_text').css('color',rarity_2_color(user_rarity));
					 			$("#user_rarity").slideDown();
					 		}

				 			$("#vh_count").text(u_vh_count);
				 			$("#h_count").text(u_h_count);
				 			$("#n_count").text(u_n_count);
							
				 			$("#score_loading").hide();
				 			$("#score_no").hide();
				 			$("#score_yes").slideDown();
				 			return;
				 		}

						
					});
				});
			});
			
	}

	function rarity_2_color(r){
		if (r=="未知") { return "#666666";}
		if (r=="普通") { return "#b0c3d9";}
		if (r=="罕见") { return "#5e98d9";}
		if (r=="稀有") { return "#4b69ff";}
		if (r=="神话") { return "#8847ff";}
		if (r=="传说") { return "#d32ce6";}
		if (r=="远古") { return "#eb4b4b";}
		if (r=="不朽") { return "#e4ae39";}
		if (r=="至宝") { return "#ade55c";}

		return "#666666";
		
	}
	
	function jumppage(url){
		window.location.href=url;
	}
	function go_homepage(){
		window.location.href='index.php';
	}
// 	//固定位置的元素，随着页面的滚动而调整位置
// 	window.onscroll= function (e){
// 		e.preventDefault();
// 		var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
// 		//alert(scrollTop);

// 		//显示、隐藏“回到顶部”按钮
// 		if (scrollTop>200){
// 			showdiv('qd_go_top');
// 		}
// 		else{
// 			hidediv('qd_go_top');
// 		}
// 	}

	//开、关详情页
	function open_details(id,name_cn,name_en,image,desc,price_p,price_m,price_t,price_s,price_ave,rarity_color,rarity,quality_color,quality,isnew,unusual_color,gif,taobao){
// 		alert(title);
// 		alert(image);
		$('#item_details_mask').fadeIn("slow");
		$('#item_details').fadeIn("slow");

		$('#item_details_image').attr("src",image); 
		$('#item_details_image').attr("title",id); 
		$('#item_details_image').show();
		
		$('#item_details_desc').text(desc);
		if (!price_p || price_p=="") price_p="-";
		$('#item_details_price_p').text("￥"+price_p);
		if (!price_m || price_m=="") price_m="-";
		$('#item_details_price_m').text("￥"+price_m);
		if (!price_s || price_s=="") price_s="-";
		$('#item_details_price_s').text("￥"+price_s);
		if (!price_t || price_t=="") price_t="-";
		$('#item_details_price_t').text("￥"+price_t);
		if (price_ave=="") price_ave="-";
		$('#item_details_price_ave').text("￥"+price_ave);

		var rarity_html="<font style='color:"+rarity_color+";' class='xlarge'>"+rarity+"</font>";
		if (isnew){
			rarity_html+="<font id='item_details_new' style='color:red;' class='xlarge' >&nbsp;New!</font>";
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

	function show_editor(){
		var aa=$('#curr_user').text();
		if (aa=='id:76561198034651705'){
				$('#editor').show();
		}
	}
	
	</script>


</head>


<body style='overflow-x: hidden; overflow-y: scroll;'
	onload="page_load('<?php echo $steam_id; ?>',<?php echo $time_3_month_ago; ?>);">
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
			<div class='drodo_title_tab_selected' style="width: 130px;">
				<font class='xxxlarge orange clickable' 
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

	<div
		style='width: 1180px; margin-top: 10px; margin-left: auto; margin-right: auto;'>

		<div id='user_info' class='drodo_left black60' ondblclick='show_editor();'>
				<div id='kuang' >
					<div id='info_loading' 
					style='display: none; width: 170px; float: left; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px;'>
						<div style='display: block; text-align: center;'>
							<!--  <img src='css/loading.gif' style=''>-->
						</div>
					</div>
					
					<div id='user_info_img_div' style='float: left;display:none;'>
					<img id='user_info_img' src='' class = 'yj_top'
						style='width: 200px; height: 200px;'>
					</div>
				
					<div id='user_info_txt' class='yj_bottom black60' 
						style='display:none; width: 180px; float: left; padding: 10px; word-wrap: break-word; word-break: break-all;'>
						<font id='user_info_name' class='xxxlarge lightgray'>???</font>
						<div id='user_info_name2_div'>
							<font id='user_info_name2' class='xxlarge gray'>??</font>
						</div>
						<?php if (!empty($ti)): 
						foreach($ti as $t):
						$ti_color = rarity_2_color($ti_rarity);
						$ti_rarity_cn = rarity_2_cn($ti_rarity);
						?>
						<div>
							<font id='ti' class='xlarge' style='color:<?php echo $ti_color;?>;'><?php echo $t["time"]."&nbsp;".$t["event"]?></font><br> 
						</div>
						
						<?php endforeach;?>
						<div id='user_rarity_ti' style='display: none;'>
							<font id='user_rarity_ti_text' class='large' style='color: <?php echo $ti_color;?>;'><?php echo $ti_rarity_cn;?>
								玩家</font>
						</div>
						<?php 
						endif;
						?>
						<div id='user_rarity' style='display: none;'>
							<font id='user_rarity_text' class='large' style='color: #ffffff;'>普通 玩家</font>
						</div>
						
						
					</div>
				</div>
				
				

				
			<div style='float: left; text-align: center;'>	

				<div id='div_total_price' class='yj black60'
					style='display:none;width: 180px; float: left; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px;'>


					<font class='xxlarge gray' >库存总价值</font><br>
					<font id='total_price' class='xxxxlarge lightgray' >￥0</font>

					
				</div>
				
				

				

				<div id='user_info_operation' style='display:none;margin-bottom:20px;float: left; '>
					<div class='yj black60'
						style='width: 75px; float: left; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; text-align: center;'>
						<font class='xxlarge lightgray hover clickable'
							onclick='jumppage("http://steamcommunity.com/profiles/<?php echo $steam_id; ?>");'>查看资料</font>
					</div>
					<div class='yj black60'
						style='width: 75px; float: left; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-left: 10px; text-align: center;'>
						<font class='xxlarge lightgray hover clickable'
							onclick='jumppage("http://zh.dotabuff.com/players/<?php echo $steam_id; ?>");'>查看战绩</font><br>
	
					</div>
					<div class='yj black60'
						style='width: 75px; float: left; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; text-align: center;'>
						<font class='xxlarge lightgray hover clickable'
							onclick='jumppage("http://dota2lounge.com/profile?id=<?php echo $steam_id; ?>");'>查看交易</font>
					</div>
					<div class='yj black60'
						style='width: 75px; float: left; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-left: 10px; text-align: center;'>
						<font class='xxlarge lightgray hover clickable'
							onclick='jumppage("steam://friends/add/<?php echo $steam_id; ?>");'>加为好友</font>
					</div>
				</div>

				<div id='friends_list_title' style='display:none;text-align: left;margin-bottom:10px;margin-top:20px;'>
					<font class='xlarge gray'>ta的好友</font>
				</div>
				<div id='friends_loading' 
					style='display: none; width: 170px; float: left; padding: 5px; padding-left: 10px; padding-right: 10px; '>
					<div style='display: block; text-align: center;'>
						<!--  <img src='css/loading.gif' style=''>-->
					</div>
				</div>
				<div id='friends_list'></div>

				</div>
				
				<div id='editor' class='drodo_left_banner' style='display:none;text-align:left;'>
				<font class='xlarge lightgray hover clickable' onclick="window.open('editor.php?file=pro_player&src=user');">编辑名人堂</font>
				<div id='curr_user'><font class='xlarge gray '>id:<?php echo $drodo_steam_id;?></font></div>
				</div>

		</div>




	<!-- 库存 -->
	<div id ='user_stock' class='drodo_right black60' >
		<div id='items_hide'
			style='display:none; width: 920px; height:730px;float: left; padding: 15px; padding-right: 10px;'>
			<div style='float: left; display: table-cell;vertical-align: middle; text-lign:center;
						width: 890px; height:490px;padding: 5px; padding-left: 10px; padding-right: 10px; '>
					<div style='width:890px;height:200px;'></div>
					<font class='xxlarge gray' >库存是私密的,不给看:(<br>也可能是库存里真的神马都没有...</font><br> 
			</div>
		</div>
		<div id='user_items_loading'
			style='display:none; width: 920px; height:730px;float: left; padding: 10px; padding-right: 10px;'>
			<div style='display: block; margin-top:150px;text-align: center;'>
						<img src='css/loading.gif' style=''>
			</div>	
		</div>

	</div>

</div>





	<!-- 回到顶部按钮 -->
	<div id='qd_go_top' class='qd_go_top shadow' hidden='true'>
		<div id='icon_qd_go_top' class='icon_qd_go_top clickable' title='回到顶部'
			onclick='javascript:scroll(0,0);'
			onmouseover='change_class("icon_qd_go_top","icon_qd_go_top","icon_qd_go_top_2")'
			onmouseout='change_class("icon_qd_go_top","icon_qd_go_top_2","icon_qd_go_top")'>
		</div>
	</div>

	<!-- 饰品详情遮罩 -->
	<div id="item_details_mask" class="player_mask"
		onclick="close_details();" style="display: none;"></div>

	<!-- 饰品详情 -->
	<div id='item_details' class='yj black60 scroll' style=" box-shadow:0px 3px 10px #000000; width:640px; 
			height:480px; position:fixed;
			top:50%;left:50%;margin-left:-320px;margin-top:-240px; opacity:1; 
			z-index:10020; overflow:hidden;display:none;overflow-y:auto; border:gray solid 3px;">
			
		<div class='yj' style="width:265px;float:left;margin-left:20px;margin-top:20px;margin-botton:20px;text-align:center;">
			<div id='item_details_image_div' style='width: 265px; height: 175px; float: left; '>
				<img id='item_details_image' src='' class='yj'
					style='width: 265px; height: 175px;display:none;' >
			</div>
			<div class='yj'
				style='width: 245px; float: left; background-color: #111111; padding: 5px; padding-left: 10px; padding-right: 10px; margin-top: 20px;'>
				<font class='xxxlarge lightgray'>均价:&nbsp;</font> <font
					id='item_details_price_ave' class='xxxlarge lightgray'>￥100</font><br>
					
				<font class='xxlarge gray'>商城报价:&nbsp;</font> <font
					id='item_details_price_s' class='xxlarge gray'>-</font><br>
				<font class='xxlarge gray'>市场报价:&nbsp;</font> <font
					id='item_details_price_m' class='xxlarge gray'>-</font><br>
				<font class='xxlarge gray'>D2L报价:&nbsp;</font> <font
					id='item_details_price_p' class='xxlarge gray'>-</font><br>
				<font class='xxlarge gray'>水友报价:&nbsp;</font> <font
					id='item_details_price_t' class='xxlarge gray'>-</font><br>
			</div>
			<div
				style='width: 200px; float: left; background-color: #191919; 
				padding: 5px; padding-left: 10px;padding-right: 10px; margin-top: 10px;display:none;'>
				<font class='xxlarge gray'>供求比:&nbsp;</font><font class='xxlarge lightgray'>0 / 0</font>
			</div>
			<div
				style='width: 85px; float: left; background-color: #191919; 
				padding: 5px; padding-left: 10px;padding-right: 10px; margin-top: 10px;text-align:center;display:none;'>
				<font class='xxlarge gray' title='此功能尚未开放，敬请期待'>我想卖!</font>
			</div>
			<div
				style='width: 85px; float: left; background-color: #191919; 
				padding: 5px; padding-left: 10px;padding-right: 10px; margin-top: 10px;margin-left:10px;text-align:center;display:none;'>
				<font class='xxlarge gray' title='此功能尚未开放，敬请期待'>我想买!</font>
			</div>
			<div id="item_details_taobao" style="float: left;margin-top:20px;margin-botton:20px;text-align:left;">
				<font class='xlarge gray '>这里可以买到它</font> <br>
				<div id="item_details_taobao_1" class='yj'
					style='width: 205px; float: left; background-color: #191919; 
					padding: 5px; padding-left: 10px; margin-top: 10px; display:none;text-align:center;'>
					<font class='xxlarge lightgray hover clickable'
						onclick='jumppage("http://drodo.taobao.com");'>巨鸟多多旗舰店</font>
				</div>
				<div id="item_details_taobao_2" class='yj'
					style='width: 205px; float: left; background-color: #191919; 
					padding: 5px; padding-left: 10px; margin-top: 10px; display:none;text-align:center;'>
					<font class='xxlarge lightgray hover clickable'
						onclick='jumppage("http://zoolily.taobao.com");'>大学生兼职小店</font>
				</div>
			</div>
		</div>
		<div style="width:310px;float: left; margin-left:20px;margin-top:20px;margin-right:5px;
			text-align:left;">

			<div id="item_details_content" style="float:left;width:300px;min-height:375px;">
				<div id='item_details_name' >
					<font id='item_details_name_cn' style="color: lightgray;" class="xxxlarge"></font><br>
					<font id='item_details_name_en' style="color: lightgray;" class="xxlarge"></font><br>
				</div>
				<div id='item_details_rarity' style="margin-top:5px;">
					<font style="color: blue;" class="xlarge">稀有度</font>
					<font id='item_details_new' style="color:red;" class="xlarge" >New!</font>
				</div>
				<div style="height:10px;">&nbsp;</div>
				<font id='item_details_desc' style="color: gray;" class="xlarge">
					<!-- JS动态填充 -->
				</font><br>
				<div style='float:left;margin-top:20px;margin-bottom:20px;'>
					<div id="item_details_gif">
						<!-- JS动态填充 -->
					</div>
				</div>
			</div>
			
			
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