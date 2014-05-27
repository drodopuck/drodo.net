<?php
include_once 'util.php';
$api_key = '668542478BF6150AD44F08DD39047CAA';
$is_hero = false;
if (! empty ( $_COOKIE ["drodo_steam_id"] )) {
	$drodo_steam_id = $_COOKIE ["drodo_steam_id"];
}
else{
	$drodo_steam_id = 0;
}
// if (! empty ( $_COOKIE ["drodo_steam_name"] )) {
// 	$drodo_steam_name = $_COOKIE ["drodo_steam_name"];
// }
// if (! empty ( $_COOKIE ["drodo_steam_avatar"] )) {
// 	$drodo_steam_avatar = $_COOKIE ["drodo_steam_avatar"];
// }

// // $drodo_steam_id = "76561198034651705";
// // 如果有$drodo_steam_id，说明已登录，可以查用户信息
// if (! empty ( $drodo_steam_id ) && empty ( $drodo_steam_name )) {
	
// 	$url_get_user_info = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$drodo_steam_id";
// 	$re = file_get_contents ( $url_get_user_info );
	
// 	$user_obj = json_decode ( $re );
// 	$curr_user = $user_obj->response->players [0];
// 	// print_r($curr_user);
// 	// echo($curr_user->personaname);
// 	// echo($curr_user->avatar);
// 	$drodo_steam_name = $curr_user->personaname;
// 	$drodo_steam_avatar = $curr_user->avatar;
// 	setCookie ( "drodo_steam_name", $drodo_steam_name );
// 	setCookie ( "drodo_steam_avatar", $drodo_steam_avatar );
// }

if (! empty ( $_GET ["steam_id"] )) {
	$steam_id = $_GET ["steam_id"];
} else {
	$steam_id = "";
}

if (! empty ( $_GET ["type"] )) {
	$show_type = $_GET ["type"];
} else {
	$show_type = "new";
}

// $show_price = "rmb";

// print_r($show_price);


// $steam_id = "76561197998794603";
$show_items = true;

$re = file_get_contents ( "item_hero.txt" );
$items_heros = ( array ) json_decode ( $re, true );
$items_hero_2_cn = Array ();
$items_cn_2_hero = Array ();
foreach ( $items_heros as $h ) {
	$hero_array = explode ( "/", $h );
	$hero_cn = "";
	$hero_eng = "";
	if (! empty ( $hero_array [0] ) && ! empty ( $hero_array [1] )) {
		$hero_cn = $hero_array [0];
		$hero_eng = $hero_array [1];
		$items_hero_2_cn [$hero_eng] = $hero_cn;
		$items_cn_2_hero [$hero_cn] = $hero_eng;
	}
}
sort ( $items_cn_2_hero );

$re = file_get_contents("gif.txt");
$item_gif = ( array ) json_decode ( $re, true );
$re = file_get_contents("taobao.txt");
$item_taobao = ( array ) json_decode ( $re, true );


?>

<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
<link rel="shortcut icon" href="drodo.ico">
<?php checkBrowser(); ?>
<title>巨鸟多多! DOTA2 直播 视频 论坛 饰品 排行 奖金</title>
<meta name="baidu-site-verification" content="0aPLpTGExp" />
<link rel="stylesheet" type="text/css" href="css/drodo.css" media="all">
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="js/jquery.masonry.min.js"></script>

	<!-- 百度统计 -->
	<script type="text/javascript">
		var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
		document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F2c3f3867a056891335fafead2bf6266b' type='text/javascript'%3E%3C/script%3E"));
	</script>
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

	function select_hero(){
		var aa = $("#select_hero").val();
		jumppage("items.php?type="+aa);
	}
	function select_price(){
		var bb = $("#select_price").val();
		jumppage("items.php?type=<?php echo $show_type;?>&price="+bb);
	}
	function select_courier(){
		var aa = $("#select_courier").val();
		jumppage("items.php?type="+aa);
	}

	//开、关详情页
	function open_details(id,name_cn,name_en,image,desc,price_p,price_m,price_t,price_s,price_ave,rarity_color,rarity,quality_color,quality,isnew,gif,taobao){
		//alert(gif);
		
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
		}
		
// 		if (id=='4365'){
// 			$('#item_details_gif').attr("src","http://i981.photobucket.com/albums/ae298/puckwang/548654EE5F13_zpsb46972dc.gif");
// 			$('#item_details_gif').show();
// 			$('#item_details_taobao').show();
// 		}else{
// 			$('#item_details_gif').hide();
// 			$('#item_details_taobao').hide();
// 		}

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
		if (aa=='id:76561198034651705' || aa=='id:76561198071969619' || aa=='id:76561198070997936'){
				$('#editor').show();
		}
	}
	function show_editor2(){
		var aa=$('#curr_user').text();
		if (aa=='id:76561198034651705' || aa=='id:76561198071969619' || aa=='id:76561198070997936'){
				$('#editor2').show();
		}
	}

	function input_price(){
		var input_id = $('#item_details_image').attr("title"); 
		var input_price = $('#input_price').val();
		window.open("input_price.php?id="+input_id+"&price="+input_price);
		$('#input_price').val('');
		$('#editor2').hide();
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

<body class='bd' style='overflow-x: hidden; overflow-y: scroll;'>
	<!--巨鸟多多标题栏-->
	<div id='drodo_title' class='drodo_title'>
		<div class='drodo_logo clickable' onclick='go_homepage();'>
			<img src='css/drodo_logo.png' class='drodo_logo' />
		</div>
		<div id='drodo_title_text' class='drodo_title_text'>
			<div class='drodo_title_tab_selected'>
				<font class='xxxlarge orange' >巨鸟饰品</font>
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
		
			<div class='drodo_left_banner'>
				<font class='xlarge gray '>饰品分类</font>
			</div>

			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="new"):?>
					<font class='xxxlarge orange hover'>新品 / new</font>
				<?php else:?>
					<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("items.php?type=new");'>新品 / new</font>
				<?php endif;?>
			</div>
			
			<div class='drodo_left_banner black60 yj'>
			<?php
				
if ($show_type != "courier" && $show_type != "other" && $show_type != "ward" && $show_type != "key" && $show_type != "treasure" && $show_type != "pennant" && $show_type != "announcer" && $show_type != "skin" && $show_type != "ticket" && $show_type != "modifier" && $show_type != "new" && $show_type !="unusual_courier") :
					$is_hero = true;
					?>
					<font class='xxxlarge orange'>英雄 / hero</font><br>
				<?php else:?>
					<font class='xxxlarge lightgray'>英雄 / hero</font><br>
				<?php endif;?>
				<select id='select_hero' class='drodo_left_select' onchange="select_hero();">
					<option value="">-</option>
				<?php
				foreach ( $items_cn_2_hero as $h ) :
					$hero_cn = $items_hero_2_cn [$h];
					?>
				<option value="<?php echo $h;?>"
						onclick='jumppage("items.php?type=<?php echo $h;?>");'
						<?php if ($h==$show_type): ?> selected="selected" <?php endif;?>><?php echo $hero_cn." / ".$h;?></option>
				<?php
				endforeach
				;
				?>
			</select>
			</div>
			
			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="courier" ):?>
					<font class='xxxlarge orange'>信使 / courier</font>
				<?php else:?>
					<font class='xxxlarge lightgray hover clickable''
						onclick='jumppage("items.php?type=<?php echo "courier";?>");' >信使 / courier</font>
				<?php endif;?>
				</select>
			</div>
			
			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="ward"):?>
					<font class='xxxlarge orange'>侦查守卫 / ward</font>
				<?php else:?>
					<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("items.php?type=ward");'>侦查守卫 / ward</font>
				<?php endif;?>
					
			</div>

			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="key"):?>
					<font class='xxxlarge orange'>钥匙 / key</font>
				<?php else:?>
					<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("items.php?type=key");'>钥匙 / key</font>
				<?php endif;?>
					
			</div>

			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="treasure"):?>
					<font class='xxxlarge orange'>宝箱 / treasure</font>
				<?php else:?>
					<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("items.php?type=treasure");'>宝箱 / treasure</font>
				<?php endif;?>
					
			</div>

			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="pennant"):?>
					<font class='xxxlarge orange'>队旗 / pennant</font>
				<?php else:?>
					<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("items.php?type=pennant");'>队旗 / pennant</font>
				<?php endif;?>
					
			</div>

			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="announcer"):?>
					<font class='xxxlarge orange'>语音 / announcer</font>
				<?php else:?>
					<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("items.php?type=announcer");'>语音 / announcer</font>
				<?php endif;?>
					
			</div>


			<div class='drodo_left_banner black60 yj'>
				<?php if ($show_type=="skin"):?>
					<font class='xxxlarge orange'>界面皮肤 / skin</font>
				<?php else:?>
					<font class='xxxlarge lightgray hover clickable'
					onclick='jumppage("items.php?type=skin");'>界面皮肤 / skin</font>
				<?php endif;?>
					
			</div>




			<div class='drodo_left_banner '>
				<font class='xlarge gray'>本站的价格数据来源均为国外交易网站实时统计，不含任何主观成分，仅供交易参考~</font><br>




				</select>
				&nbsp;<br>
				<font class='xlarge gray'>最后更新时间</font><br>
				<font class='xlarge lightgray'><?php echo $last_update_time;?></font><br>
			</div>
			
			<div id='editor' class='drodo_left_banner' style='display:none;'>
				<font class='xlarge lightgray hover clickable' onclick="window.open('editor.php?file=gif&src=items');">编辑饰品图片</font>
				<div id='curr_user'><font class='xlarge gray '>id:<?php echo $drodo_steam_id;?></font></div>
			</div>
		
		</div>

		<?php if ($show_type!="unusual_courier"):?>
		
		<!-- 正常展示（特效信使除外） -->
		
		<div id='user_items' class='drodo_right black60'>
			<?php
			if (file_exists( "data/item_$show_type.txt" )){
			$show = json_decode ( file_get_contents ( "data/item_$show_type.txt" ), true );
			
			usort ( $show, 'sortByLen' );
			}
			// print_r($show);
			// array_multisort($type_name, $rarity, $show);
			if (empty($show)){
				return;
			}
			foreach ( $show as $curr_item ) : // $i是序号
				
// 				$curr_item["desc_cn"] = str_replace("<fontcolor=","",$curr_item["desc_cn"]);
// 				$curr_item["desc_cn"] = str_replace("#9da1a9","",$curr_item["desc_cn"]);
// 				$curr_item["desc_cn"] = str_replace("</font>","",$curr_item["desc_cn"]);
			
				$curr_rarity = $curr_item ["rarity"];
				
				if ($curr_rarity == "common") :
					$curr_rarity_cn = "普通";
					$curr_color = "#b0c3d9";
				 elseif ($curr_rarity == "uncommon") :
					$curr_rarity_cn = "罕见";
					$curr_color = "#5e98d9";
				 elseif ($curr_rarity == "rare") :
					$curr_rarity_cn = "稀有";
					$curr_color = "#4b69ff";
				 elseif ($curr_rarity == "mythical") :
					$curr_rarity_cn = "神话";
					$curr_color = "#8847ff";
				 elseif ($curr_rarity == "legendary") :
					$curr_rarity_cn = "传说";
					$curr_color = "#d32ce6";
				 elseif ($curr_rarity == "ancient") :
					$curr_rarity_cn = "远古";
					$curr_color = "#eb4b4b";
				 elseif ($curr_rarity == "immortal") :
					$curr_rarity_cn = "不朽";
					$curr_color = "#e4ae39";
				 elseif ($curr_rarity == "arcana") :
					$curr_rarity_cn = "至宝";
					$curr_color = "#ade55c";
				endif;
				
				$price = "";
				if (! empty ( $curr_item ["price_rmb"] )) {
					$price = $curr_item ["price_rmb"];
				}
				
				$price_m = "";
				if (! empty ( $curr_item ["price_m_rmb"] )) {
					$price_m = $curr_item ["price_m_rmb"];
				}
				
				$price_t = "";
				if (! empty ( $curr_item ["price_t_rmb"] )) {
					$price_t = $curr_item ["price_t_rmb"];
				}
				
				$price_s = "";
				if (! empty ( $curr_item ["price_s_rmb"] )) {
					$price_s = $curr_item ["price_s_rmb"];
				}
				
				$price_ave = "";
// 				if (! empty ( $curr_item ["price_ave"] )) {
					$price_ave = $curr_item ["price_ave"];
// 				}
				
				?>
			
			<?php
// 				if (! empty ( $hero_2_cn [$curr_item ["hero"]] )) {
// 					$hero_cn_name = $hero_2_cn [$curr_item ["hero"]];
// 				} else {
// 					$hero_cn_name = "通用";
// 				}
				
				$title = $curr_item ["id"]. " - ".str_replace ( "'", "", $curr_item ["name_cn"] ) . " / " . str_replace ( "'", "", $curr_item ["name"] ) . "&#10" . $curr_rarity_cn . " " . $curr_item["hero_cn"] . " " . $curr_item ["type_cn"];
				$name_cn_show = str_replace("'","",$curr_item ["name_cn"]);
				$name_en_show = str_replace("'","",$curr_item ["name"]);
				$desc_show = str_replace("'","",($curr_item["desc_cn"]));
				$rarity_show = $curr_rarity_cn . " " . $curr_item["hero_cn"] . " " . $curr_item ["type_cn"];
				$rarity_color_show = $curr_color;
				$quality_color_show = "";
				$quality_show = "";
				if (!empty($curr_item["new"]) && $curr_item["new"]=="new"){
					$new_show = "new";
				}else{
					$new_show = "";
				}
				
				$gif = "";
				if (!empty($item_gif[$curr_item ["id"]])){
					$gif = $item_gif[$curr_item ["id"]];
				}
				$taobao = "";
				if (!empty($item_taobao[$curr_item ["id"]])){
					$taobao = $item_taobao[$curr_item ["id"]];
				}
				
				if (! isBundle ( $curr_item ) ) :
					
					?>
			<div class="clickable" onclick="open_details('<?php echo $curr_item ["id"];?>','<?php echo $name_cn_show;?>','<?php echo $name_en_show;?>','<?php echo $curr_item["image"]; ?>','<?php echo $desc_show; ?>','<?php echo $price; ?>','<?php echo $price_m; ?>','<?php echo $price_t; ?>','<?php echo $price_s; ?>','<?php echo $price_ave; ?>','<?php echo $rarity_color_show; ?>','<?php echo $rarity_show; ?>','<?php echo $quality_color_show; ?>','<?php echo $quality_show; ?>','<?php echo $new_show;?>','<?php echo $gif;?>','<?php echo $taobao;?>');"
					style='width: 105px; height: 105px; margin: 5px; float: left; '>
				<div 
					style='width: 105px; height: 70px; float: left; '>
					<img class='yj_top' src='<?php echo $curr_item["image"]; ?>'
						style='width: 105px; height: 70px;' title='<?php echo $title; ?>'>
					<div class='yj_bottom black60'
						style='width: 105px; height: 35px; margin-top: 0px;text-align: center; opacity: 1; line-height: 16px;'>
						<font style="color:<?php echo $curr_color;?>;" class="large" >&nbsp;<?php echo $curr_rarity_cn;?></font>
						<?php if ($curr_item["new"]=="new"):?>
						<font style="color:red;" class="large" >New!</font>
						<?php endif;?><br>
						
						<?php if ($price_ave=="-"): ?>
						<font style="color: lightgray;" class="normal">-</font>
						<?php else: ?>
						<font style="color: lightgray;" class="normal">￥<?php echo $price_ave; ?></font>
						<?php endif; ?>
					</div>

				</div>

			</div>
			<?php else:?>
			<div class="clickable" onclick="open_details('<?php echo $curr_item ["id"];?>','<?php echo $name_cn_show;?>','<?php echo $name_en_show;?>','<?php echo $curr_item["image"]; ?>','<?php echo $desc_show; ?>','<?php echo $price; ?>','<?php echo $price_m; ?>','<?php echo $price_t; ?>','<?php echo $price_s; ?>','<?php echo $price_ave; ?>','<?php echo $rarity_color_show; ?>','<?php echo $rarity_show; ?>','<?php echo $quality_color_show; ?>','<?php echo $quality_show; ?>','<?php echo $new_show;?>','<?php echo $gif;?>','<?php echo $taobao;?>');"
					style='width: 220px; height: 220px; margin: 5px; float: left; '>
				<div
					style='width: 220px; height: 220px; float: left; '>
					<img class='yj_top' src='<?php echo $curr_item["image"]; ?>'
						style='width: 220px; height: 150px;' title='<?php echo $title; ?>'>
						<div class='yj_bottom black60'
							style='width: 200px; height: 70px; padding-left:10px;padding-right:10px;text-align: center; opacity: 1; line-height: 16px;display: table-cell;vertical-align: middle;'>
						<div style="width:200px;height:35px;display: table-cell;vertical-align: middle;">
						<?php if ($curr_item["name_cn"]=="[暂无中文名]"): ?>
						<font style="color: lightgray;" class="xxlarge"><?php echo $curr_item["name"]; ?></font><br>
						<?php else:?>
						<font style="color: lightgray;" class="xxlarge"><?php echo $curr_item["name_cn"]; ?></font><br>
						<?php endif;?>
						</div>
						<font style="color:<?php echo $curr_color;?>;" class="large" >&nbsp;<?php echo $curr_rarity_cn;?></font>
						<?php if ($curr_item["new"]=="new"):?>
						<font style="color:red;" class="large" > New!</font>
						<?php endif;?><br>
						
						<?php if ($price_ave=="-"): ?>
						<font style="color: lightgray;" class="normal">-</font>
						<?php else: ?>
						<font style="color: lightgray;" class="normal">￥<?php echo $price_ave; ?></font>
						<?php endif; ?>
					</div>

				</div>

			</div>
			<?php endif;?>
			<?php endforeach;?>
			</div>
	</div>

	<?php else:?>
	<!-- 特效信使 -->	
	<div id='user_items' class='drodo_right black60'>
	<?php $show_base = json_decode ( file_get_contents ( "data/item_$show_type.txt" ), true );
	foreach ($show_base as $show):
		usort ( $show, 'sortByLen' );
	?>

			
	<?php foreach ( $show as $curr_item ) : // $i是序号
				
				$curr_rarity = $curr_item ["rarity"];
				$curr_rarity_cn =rarity_2_cn($curr_rarity); 
				$curr_color =rarity_2_color($curr_rarity);
				
				
				$price_show = "";
				if (! empty ( $curr_item ["price_$show_price"] )) {
					$price_show = $curr_item ["price_$show_price"];
				}
				
				$title = $curr_item ["id"] . " - ".str_replace ( "'", "", $curr_item ["name_cn"] ) . " / " . str_replace ( "'", "", $curr_item ["name"] ) . "&#10" . $curr_rarity_cn . " " . $curr_item["hero_cn"] . " " . $curr_item ["type_cn"];
				$name_cn_show = str_replace("'","",$curr_item ["name_cn"]);
				$name_en_show = str_replace("'","",$curr_item ["name"]);
				$desc_show = str_replace("'","",($curr_item["desc_cn"]));
				$rarity_show = $curr_rarity_cn . " " . $curr_item["hero_cn"] . " " . $curr_item ["type_cn"];
				$rarity_color_show = $curr_color;
				$quality_show = "独特".unusual2cn($curr_item["unusual"]);
				$quality_color_show = "#8650AC";
				if (!empty($curr_item["new"]) && $curr_item["new"]=="new"){
					$new_show = "new";
				}else{
					$new_show = "";
				}
				
				$gif = "";
				if (!empty($item_gif[$curr_item ["id"]])){
					$gif = $item_gif[$curr_item ["id"]];
				}
				$taobao = "";
				if (!empty($item_taobao[$curr_item ["id"]])){
					$taobao = $item_taobao[$curr_item ["id"]];
				}
				
				
				
				?>
				<?php if ($curr_item["unusual"]!="TI2" && $curr_item["unusual"]!="TI3" && $curr_item["unusual"]!="DT"):?>
				<div class="clickable yj_big" onclick="open_details('<?php echo $curr_item ["id"];?>','<?php echo $name_cn_show;?>','<?php echo $name_en_show;?>','<?php echo $curr_item["image"]; ?>','<?php echo $desc_show; ?>','<?php if (!empty($price_show)){echo $price_show;}else{echo "-";}?>','<?php echo $rarity_color_show; ?>','<?php echo $rarity_show; ?>','<?php echo $quality_color_show; ?>','<?php echo $quality_show; ?>','<?php echo $new_show;?>','<?php echo $gif;?>','<?php echo $taobao;?>');"
					style='width:105px;height:105px;margin:2px;float:left;border:3px solid #8650AC;'>
					<div
						style='width: 105px; height: 70px; float: left;'>
						<img class='yj_top' src='<?php echo $curr_item["image"]; ?>'
							style='width: 105px; height: 70px;' title='<?php echo $title; ?>'>
						<div class='yj_bottom black60'
							style='width: 105px; height: 35px; text-align: center; opacity: 1; line-height: 16px;'>
							<font style="color:#8650AC;" class="large" >&nbsp;独特<?php echo unusual2cn($curr_item["unusual"]);?></font>
							<font style="color:<?php echo $curr_color;?>;" class="large" ><?php echo $curr_rarity_cn;?></font>
							<?php if ($curr_item["new"]=="new"):?>
							<font style="color:red;" class="large" > New!</font>
							<?php endif;?><br>
							<font style="color: lightgray;" class="normal">
							<?php if (!empty($price_show)){echo $price_show;}else{echo "-";}?>
							</font>
						</div>
					</div>
				</div>
				<?php else: ?>
				<div class="clickable yj_big" onclick="open_details('<?php echo $curr_item ["id"];?>','<?php echo $name_cn_show;?>','<?php echo $name_en_show;?>','<?php echo $curr_item["image"]; ?>','<?php echo $desc_show; ?>','<?php if (!empty($price_show)){echo $price_show;}else{echo "-";}?>','<?php echo $rarity_color_show; ?>','<?php echo $rarity_show; ?>','<?php echo $quality_color_show; ?>','<?php echo $quality_show; ?>','<?php echo $new_show;?>','<?php echo $gif;?>','<?php echo $taobao;?>');"
					style='width:220px;height:220px;margin:2px;float:left;border:3px solid #8650AC;'>
					<div
						style='width: 220px; height: 150px; float: left; '>
						<img class='yj_top ' src='<?php echo $curr_item["image"]; ?>'
							style='width: 220px; height: 150px;' title='<?php echo $title; ?>'>
						<div class='yj_bottom black60'
							style='width: 200px; height: 70px; padding-left:10px;padding-right:10px;text-align: center; opacity: 1; line-height: 16px;'>
							
							<div style="width:200px;height:35px;display: table-cell;vertical-align: middle;">
							<?php if ($curr_item["name_cn"]=="[暂无中文名]"): ?>
							<font style="color: lightgray;" class="xxlarge"><?php echo $curr_item["name"]; ?></font><br>
							<?php else:?>
							<font style="color: lightgray;" class="xxlarge"><?php echo $curr_item["name_cn"]; ?></font><br>
							<?php endif;?>	
							</div>
													
							<font style="color:#8650AC;" class="large" >&nbsp;独特<?php echo unusual2cn($curr_item["unusual"]);?></font>
							<font style="color:<?php echo $curr_color;?>;" class="large" ><?php echo $curr_rarity_cn;?></font>
							<?php if ($curr_item["new"]=="new"):?>
							<font style="color:red;" class="large" > New!</font>
							<?php endif;?><br>
							<font style="color: lightgray;" class="normal">
							<?php if (!empty($price_show)){echo $price_show;}else{echo "-";}?>
							</font>
						</div>
					</div>
				</div>
				<?php endif;?>
			
			<?php endforeach;?>		
	
			<!-- <div style="width:1000px;height:10px;float:left;"></div>  -->
	
	<?php endforeach;?>
	
	</div>
	
	
	
	
	
	
	
	
	
	<?php endif;?>
	
	
	<!-- end drodo_body -->

	<!-- 回到顶部按钮 -->
	<div id='qd_go_top' class='qd_go_top shadow' hidden='true'>
		<div id='icon_qd_go_top' class='icon_qd_go_top clickable' title='回到顶部'
			onclick='javascript:scroll(0,0);'
			onmouseover='change_class("icon_qd_go_top","icon_qd_go_top","icon_qd_go_top_2")'
			onmouseout='change_class("icon_qd_go_top","icon_qd_go_top_2","icon_qd_go_top")'>
		</div>
	</div>

	<!-- 饰品详情遮罩 -->
	<div id="item_details_mask" class="player_mask" onclick="close_details();" 
	style="display:none;"></div>
	
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
			<div class='yj' ondblclick='show_editor2();'
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
			
			
			<div id='editor2' class='drodo_left_banner' style='display:none;width: 245px;padding:0px;margin-top:10px;margin-bottom:5px;'>
				<input id='input_id' type='hidden'></input>
				<input id='input_price' type='text' class='yj_left' 
					style='float:left;width:130px;padding:5px; background-color:lightgray;padding-left:15px;padding-right:15px;margin-bottom:10px;font-size:13px;font-family:微软雅黑;'>
				 
				
				<div class='drodo_left_banner black60 yj_right' style='width:80px;margin-bottom:5px;float:left;'>
					<font class='xxxlarge lightgray hover clickable' onclick="input_price();">报价</font>
				</div>
				
				<div class='drodo_left_banner black60 yj' style='width:210px;margin-bottom:5px;'>
					<font class='xxxlarge lightgray hover clickable' onclick="window.open('get_data/get.php')">刷新服务器全部数据</font>
				</div>
			</div>
			
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