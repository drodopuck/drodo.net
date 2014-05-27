<?php
include_once 'util.php';
$api_key='668542478BF6150AD44F08DD39047CAA';

if (! empty ( $_GET ["steam_id"] )) {
	$steam_id = $_GET ["steam_id"];
} else {
	$steam_id = "76561198034651705";
}
$show_price = "rmb";

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

$re = file_get_contents ( "gif.txt" );
$item_gif = ( array ) json_decode ( $re, true );
$re = file_get_contents ( "taobao.txt" );
$item_taobao = ( array ) json_decode ( $re, true );


$curr_items_sort = array ();
$curr_items_quality = array ();
$curr_items_texiao = array ();

$show = json_decode ( file_get_contents ( "data/item_all.txt" ), true );

// 获取用户库存
$url_get_user_items = "http://api.steampowered.com/IEconItems_570/GetPlayerItems/v0001/?key=$api_key&steamid=$steam_id";
$re = file_get_contents ( $url_get_user_items );
$items_obj = json_decode ( $re );
if (!empty($items_obj->result)){
	$result = $items_obj->result;
}

// print_r($result);
$stock_hide = "yes";
if (!empty($items_obj->result) && $result->status == 1) {
		
	$stock_hide = "no";
	$curr_items = $result->items; // 当前库存
	$curr_backpack_slots = $result->num_backpack_slots;

// 	print_r($curr_items);
		
	foreach ( $curr_items as $a ) {
		
		$index = $a->defindex;
		if (empty( $show [$index])){
			continue;
		}
		$hero = $show [$index] ["hero_cn"];
		
		// id
		$final_items[$hero][$a->inventory]["id"] = $index; 
		
		// 名字
		$final_items[$hero][$a->inventory]["name_en"] = str_replace ( "'", "",$show [$index] ["name"]);
		if (! empty ( $a->custom_name ) && $a->defindex != "10070" && $a->defindex != "10066") {
			$final_items[$hero][$a->inventory]["name_cn"] = str_replace ( "'", "",$a->custom_name);
		}
		else{
			$final_items[$hero][$a->inventory]["name_cn"] = str_replace ( "'", "",$show [$index] ["name_cn"]);
		}
		
		// 描述
		if (! empty ( $a->custom_desc )) {
			$final_items[$hero][$a->inventory]["desc_cn"] = str_replace ( "\"", "", str_replace ( "'", "",$a->custom_desc));
		}
		else{
			$final_items[$hero][$a->inventory]["desc_cn"] = str_replace ( "\"", "", str_replace ( "'", "",$show [$index] ["desc_cn"]));
		}
		
		// 英雄
		$final_items[$hero][$a->inventory]["hero"] = $show [$index] ["hero_cn"];

		// 稀有度
		$curr_rarity = $show [$index] ["rarity"];
		$curr_rarity_cn = rarity_2_cn($curr_rarity);
		$curr_rarity_color = rarity_2_color($curr_rarity);
		$rarity_show = $curr_rarity_cn . " " . $show [$index] ["hero_cn"] . " " . $show [$index] ["type_cn"];
		$final_items[$hero][$a->inventory]["rarity"] = $curr_rarity;
		$final_items[$hero][$a->inventory]["rarity_show"] = $rarity_show;
		$final_items[$hero][$a->inventory]["rarity_cn"] = rarity_2_cn($curr_rarity);
		$final_items[$hero][$a->inventory]["rarity_color"] = rarity_2_color($curr_rarity);

		//特效
		if (! empty ( $a->attributes )) {
			$greevil_cicle = 0;
			$greevil_red = 0;
			$greevil_blue = 0;
			$greevil_yellow = 0;
			$greevil_black = 0;
				
			foreach ( $a->attributes as $tx ) {
				if ($tx->defindex == 134) {
					$curr_items_texiao [$a->inventory] = $tx->float_value;
				}
				if ($tx->defindex == 142) { // 颜色
					$curr_items_color [$a->inventory] = dechex ( $tx->float_value );
				}
				if ($tx->defindex == 379) { // 怪异
					$curr_items_strange [$a->inventory] = "I";
				}
				if ($tx->defindex == 381) { // 怪异
					$curr_items_strange [$a->inventory] = "II";
				}
				if ($tx->defindex == 383) { // 怪异
					$curr_items_strange [$a->inventory] = "III";
				}
				if ($tx->defindex == 385) { // 怪异
					$curr_items_strange [$a->inventory] = "IIII";
				}
				// 贪魔
				if ($a->defindex == "10070" || $a->defindex == "10066") {
					if ($tx->defindex == 154) { // 黑
						$greevil_black = $tx->value;
					}
						
					if ($tx->defindex == 155) { // 特效圈数0-3
						$greevil_cicle = $tx->value;
						if ($greevil_cicle == 0) {
							$greevil_cicle = "";
						}
						if ($greevil_cicle == 1) {
							$greevil_cicle = "I";
						}
						if ($greevil_cicle == 2) {
							$greevil_cicle = "II";
						}
						if ($greevil_cicle == 3) {
							$greevil_cicle = "III";
						}
					}
					if ($tx->defindex == 156) { // 红0-3
						$greevil_red = $tx->value;
					}
					if ($tx->defindex == 157) { // 蓝0-3
						$greevil_blue = $tx->value;
					}
					if ($tx->defindex == 158) { // 黄0-3
						$greevil_yellow = $tx->value;
					}
				}
			}
				
			// 贪魔
			if ($a->defindex == "10070" || $a->defindex == "10066") {
				if ($greevil_red > $greevil_blue && $greevil_red > $greevil_yellow) {
					$greevil_color = "ff0000";
				}
				if ($greevil_blue > $greevil_red && $greevil_blue > $greevil_yellow) {
					$greevil_color = "0000ff";
				}
				if ($greevil_yellow > $greevil_red && $greevil_yellow > $greevil_blue) {
					$greevil_color = "ffff00";
				}
				if ($greevil_red == $greevil_blue && $greevil_red == $greevil_yellow) {
					$greevil_color = "ffffff";
				}
				if ($greevil_red == $greevil_blue && $greevil_blue > $greevil_yellow) {
					$greevil_color = "cc00ff";
				}
				if ($greevil_yellow == $greevil_red && $greevil_yellow > $greevil_blue) {
					$greevil_color = "ff6600";
				}
				if ($greevil_yellow == $greevil_blue && $greevil_blue > $greevil_red) {
					$greevil_color = "00ff00";
				}
				if ($greevil_yellow == 0 && $greevil_blue == 0 && $greevil_red == 0) {
					$greevil_color = "666666";
				}
				if ($greevil_yellow == 1 && $greevil_blue == 1 && $greevil_red == 1) {
					$greevil_color = "666666";
				}
				if ($greevil_yellow == 2 && $greevil_blue == 2 && $greevil_red == 2) {
					$greevil_color = "666666";
				}
				if ($greevil_black == 1) {
					$greevil_color = "111111";
				}

				$curr_items_strange [$a->inventory] = $greevil_cicle;
				$curr_items_color [$a->inventory] = $greevil_color;
			}
		}
		
		// 特效
		$texiao_cn = "";
		if (!empty( $curr_items_texiao [$a->inventory])){
			$texiao = $curr_items_texiao [$a->inventory];
			$texiao_cn = "";
			if ($texiao != 0) {
				$texiao_cn = unusual_id_2_cn($texiao);
			}
			$final_items[$hero][$a->inventory]["unusual"] = $texiao;
			$final_items[$hero][$a->inventory]["unusual_cn"] = $texiao_cn;
		}

		// 特效颜色
		if (! empty ( $curr_items_color [$a->inventory] )) {
			$color16 = $curr_items_color [$a->inventory];
			if (strlen ( $color16 ) == 1) {
				$color16 = "00000" . $color16;
			}
			if (strlen ( $color16 ) == 2) {
				$color16 = "0000" . $color16;
			}
			if (strlen ( $color16 ) == 3) {
				$color16 = "000" . $color16;
			}
			if (strlen ( $color16 ) == 4) {
				$color16 = "00" . $color16;
			}
			if (strlen ( $color16 ) == 5) {
				$color16 = "0" . $color16;
			}

			$color16 = "#" . $color16;
		} else {
			$color = "";
			$color16 = "";
		}
		$final_items[$hero][$a->inventory]["unusual_color"] = $color16;
		
		// 品质
		$curr_quality = "";
		if (! empty ( $a->quality)) {
			$quality = $a->quality;
		} else {
			$quality = 0;
		}
		$s="";
		if (!empty($curr_items_strange[$a->inventory])){
			$s = $curr_items_strange[$a->inventory];
		}
		$curr_quality = quality_2_cn($quality,$s);
		$curr_quality_color = quality_2_color($quality,$s);
		$quality_show = $curr_quality . $texiao_cn;
		if (! empty ( $curr_quality_color )) {
			$quality_color_show = $curr_quality_color;
		} else {
			$quality_color_show = "gray";
		}
		$final_items[$hero][$a->inventory]["quality"] = $quality;
		$final_items[$hero][$a->inventory]["quality_cn"] = $quality_show;
		$final_items[$hero][$a->inventory]["quality_color"] = $quality_color_show;
		
		// 显示的内容
		$title = $index . " - " . $final_items[$hero][$a->inventory]["name_cn"] . " / " . $final_items[$hero][$a->inventory]["name_en"] . "&#10" . $final_items[$hero][$a->inventory]["rarity_show"];
		if (! empty ( $color16 )) {
			$title = $title . "&#10" . $texiao_cn . " " . $color16;
		}
		$final_items[$hero][$a->inventory]["title"] = $title;

		// 价格
// 		$price_show = "";
// 		if (! empty ( $show [$index] ["price_rmb"] ) && empty ( $texiao_cn )) {
// 			$price_show = $show [$index] ["price_rmb"];
// 		}
// 		$final_items[$hero][$a->inventory]["price"] = $price_show;
		
// 		// 市场价格_m
// 		$price_m_show = "";
// 		if (! empty ( $show [$index] ["price_m_$show_price"] ) && empty ( $texiao_cn )) {
// 			$price_m_show = $show [$index] ["price_m_$show_price"];
// 		}
// 		$final_items[$hero][$a->inventory]["price_m"] = str_replace(",","",$price_m_show);
		
// 		$final_items[$hero][$a->inventory]["price_ave"] = $show [$index] ["price_ave"];
// 		
        // 估价
//      if ($quality==12 || $quality==9 || $quality==3)
// 		{
// 			$final_items[$hero][$a->inventory]["price"] = "";
// 			$final_items[$hero][$a->inventory]["price_m"] = "";
// 			$final_items[$hero][$a->inventory]["price_t"] = "";
// 			$final_items[$hero][$a->inventory]["price_s"] = "";
// 			$final_items[$hero][$a->inventory]["price_ave"] = "";
// 		}
// 		else{
		$final_items[$hero][$a->inventory]["price"] = "";
		if (! empty ( $show [$index] ["price_rmb"] )) {
			$final_items[$hero][$a->inventory]["price"] = $show [$index] ["price_rmb"];
		}
		
		$final_items[$hero][$a->inventory]["price_m"] = "";
		if (! empty ( $show [$index] ["price_m_rmb"] )) {
			$final_items[$hero][$a->inventory]["price_m"] = $show [$index] ["price_m_rmb"];
		}
		
		$final_items[$hero][$a->inventory]["price_t"] = ""; 
		if (! empty ( $show [$index] ["price_t_rmb"] )) {
			$final_items[$hero][$a->inventory]["price_t"] = $show [$index] ["price_t_rmb"];
		}
		
		$final_items[$hero][$a->inventory]["price_s"] = "";
		if (! empty ( $show [$index] ["price_s_rmb"] )) {
			$final_items[$hero][$a->inventory]["price_s"] = $show [$index] ["price_s_rmb"];
		}
		
		
		$final_items[$hero][$a->inventory]["price_ave"] = ""; 
		// 				if (! empty ( $curr_item ["price_ave"] )) {
		$final_items[$hero][$a->inventory]["price_ave"] = $show [$index] ["price_ave"];
		// 				}
		
		
		if ( $quality==9 ) // 奇异
		{
			$final_items[$hero][$a->inventory]["price_ave"] = (get_ave_price($final_items[$hero][$a->inventory]["price"],
				$final_items[$hero][$a->inventory]["price_m"],$final_items[$hero][$a->inventory]["price_t"]
				,$final_items[$hero][$a->inventory]["price_s"]) +1.0)* $qiyi_price;
		}
		else if ( $quality ==12){ // 锦标赛
			$final_items[$hero][$a->inventory]["price_ave"] = (get_ave_price($final_items[$hero][$a->inventory]["price"],
				$final_items[$hero][$a->inventory]["price_m"],$final_items[$hero][$a->inventory]["price_t"]
				,$final_items[$hero][$a->inventory]["price_s"]) +1.0)* $jinbiaosai_price;
		}	
		else if ( $quality ==3 ){ // 独特
			
		}
		

		// 新品
		if (! empty ( $show [$index] ["new"] ) && $show [$index] ["new"] == "new") {
			$new_show = "new";
		} else {
			$new_show = "";
		}
		$final_items[$hero][$a->inventory]["new_item"] = $new_show;

		// gif
		$gif = "";
		if (! empty ( $item_gif [$show [$index] ["id"]] )) {
			$gif = $item_gif [$show [$index] ["id"]];
		}
		$final_items[$hero][$a->inventory]["gif"] = $gif;

		// taobao
		$taobao = "";
		if (! empty ( $item_taobao [$show [$index] ["id"]] )) {
			$taobao = $item_taobao [$show [$index] ["id"]];
		}
		$final_items[$hero][$a->inventory]["taobao"] = $taobao;
		$final_items[$hero][$a->inventory]["image"] = $show [$index]["image"];
		
		
	}
	
}//
?>

<?php 
if ($stock_hide == "yes" || empty($final_items)){
	echo "[]";
}
else{
	//排序

// 	foreach ($final_items as $i){
// 		$demo = $i;
// 		usort($demo,'sortByRarity');
// // 		print_r($demo);
// // 		return;
// 	}

	while($key = key($final_items)) {
		$demo = $final_items[$key];
		usort($demo,'sortByRarity');
// 		print_r($demo);
		$demo[0]["score"] = getHeroScore($demo);
		$final_items[$key] = $demo;
		next($final_items);
		
	}
	
	usort($final_items,'sortByScore');

// 	print_r(json_encode($final_items));

















	echo json_encode($final_items); 
}
?>