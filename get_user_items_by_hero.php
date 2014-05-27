<?php
include_once 'util.php';
$api_key='668542478BF6150AD44F08DD39047CAA';

if (! empty ( $_GET ["steam_id"] )) {
	$steam_id = $_GET ["steam_id"];
} else {
	$steam_id = "76561198034651705";
}

if (! empty ( $_GET ["price"] )) {
	$show_price = $_GET ["price"];
	setCookie ( "drodo_price", $show_price );
} else {
	if (! empty ( $_COOKIE ["drodo_price"] )) {
		$show_price = $_COOKIE ["drodo_price"];
	} else {
		$show_price = "rmb";
		setCookie ( "drodo_price", $show_price );
	}
}

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
	if (empty ( $curr_backpack_slots )) {
		$curr_backpack_slots = 720;
	}
	for($i = 1; $i <= $curr_backpack_slots; $i ++) {
		$curr_items_sort [$i] = 0;
		$curr_items_quality [$i] = 0;
		$curr_items_texiao [$i] = 0;
	}
	// print_r($curr_items);
		
	foreach ( $curr_items as $a ) {
		if ($a->inventory > 2147483000) {
			$a->inventory = $a->inventory - 2147483600 - 48;
		}
		$curr_items_sort [$a->inventory] = $a->defindex;
		$curr_items_quality [$a->inventory] = $a->quality;

		// 自定义名字
		if (! empty ( $a->custom_name )) {
			if ($a->defindex != "10070" && $a->defindex != "10066") {
				// print_r($a->inventory." -> ".$a->custom_name."\n");
				$curr_items_custom_name [$a->inventory] = $a->custom_name;
			}
		}
		if (! empty ( $a->custom_desc )) {
			$curr_items_custom_desc [$a->inventory] = $a->custom_desc;
		}

		// "custom_name": "马甲姐之戟",
		// "custom_desc": "马甲姐总是用和马甲哥一样的farm能力，带领菜鸡们走向胜利",

		// 特效
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
	}
		
	// print_r($curr_items_texiao);
	
	$show = json_decode ( file_get_contents ( "data/item_all.txt" ), true );
		
	if (empty ( $curr_backpack_slots )) {
		$curr_backpack_slots = 720;
	}
	$backpack_page = $curr_backpack_slots / 30;
	
	
	//遍历每一页库存，计算数据
	for($i = 0; $i < $backpack_page; $i ++){
		//遍历一页中的30个格子
		for($j = 1; $j <= 30; $j ++){
			if (! empty ( $curr_items_sort [$i * 30 + $j] )) {
				$index = $curr_items_sort [$i * 30 + $j];
			} else {
				$index = 0;
			}
			//$index是当前这一格的物品id
			$final_items[$i][$j]["id"] = $index;
			
			if ($index != 0 && !empty($show [$index])){ //如果这一格不为空
				
				$curr_item = $show [$index];
				
				// 英雄
				$used_by_heroes = $show [$index] ["hero_cn"];
				$final_items[$i][$j]["hero"] = $used_by_heroes;
				
				// 稀有度
				$curr_rarity = $show [$index] ["rarity"];
				$curr_rarity_cn = rarity_2_cn($curr_rarity);
				$curr_rarity_color = rarity_2_color($curr_rarity);
				$rarity_show = $curr_rarity_cn . " " . $curr_item ["hero_cn"] . " " . $curr_item ["type_cn"];
				
				$final_items[$i][$j]["rarity"] = $curr_rarity;
				$final_items[$i][$j]["rarity_show"] = $rarity_show;
				$final_items[$i][$j]["rarity_cn"] = rarity_2_cn($curr_rarity);
				$final_items[$i][$j]["rarity_color"] = rarity_2_color($curr_rarity);

				// 特效
				$texiao = $curr_items_texiao [$i * 30 + $j];
				$texiao_cn = "";
				if ($texiao != 0) {
					$texiao_cn = unusual_id_2_cn($texiao);
				}
				$final_items[$i][$j]["unusual"] = $texiao;
				$final_items[$i][$j]["unusual_cn"] = $texiao_cn;
				
				// 特效颜色
				if (! empty ( $curr_items_color [$i * 30 + $j] )) {
					$color16 = $curr_items_color [$i * 30 + $j];
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
				$final_items[$i][$j]["unusual_color"] = $color16;
				
				// 品质
				$curr_quality = "";
				if (! empty ( $curr_items_quality [$i * 30 + $j] )) {
					$quality = $curr_items_quality [$i * 30 + $j];
				} else {
					$quality = 0;
				}
				$s="";
				if (!empty($curr_items_strange[$i * 30 + $j])){
					$s = $curr_items_strange[$i * 30 + $j];
				}
				$curr_quality = quality_2_cn($quality,$s);
				$curr_quality_color = quality_2_color($quality,$s);
				$quality_show = $curr_quality . $texiao_cn;
				if (! empty ( $curr_quality_color )) {
					$quality_color_show = $curr_quality_color;
				} else {
					$quality_color_show = "gray";
				}
				$final_items[$i][$j]["quality"] = $quality;
				$final_items[$i][$j]["quality_cn"] = $quality_show;
				$final_items[$i][$j]["quality_color"] = $quality_color_show;
				
				// 名字和描述
				$show_name = $curr_item ["name_cn"];
				if (! empty ( $curr_items_custom_name [$i * 30 + $j] )) {
					$show_name = $curr_items_custom_name [$i * 30 + $j];
				}
				$show_desc = str_replace ( "'", "", ($curr_item ["desc_cn"]) );
				if (! empty ( $curr_items_custom_desc [$i * 30 + $j] )) {
					$show_desc = $curr_items_custom_desc [$i * 30 + $j];
				}
				$name_cn_show = str_replace ( "'", "", $show_name );
				$name_en_show = str_replace ( "'", "", $curr_item ["name"] );
				$desc_show = str_replace ( "\"", "", $show_desc );
				$final_items[$i][$j]["name_cn"] = $name_cn_show;
				$final_items[$i][$j]["name"] = $name_en_show;
				$final_items[$i][$j]["desc"] = $desc_show;
				
				// 显示的内容
				$title = $curr_item ["id"] . " - " . str_replace ( "'", "", $show_name ) . " / " . str_replace ( "'", "", $curr_item ["name"] ) . "&#10" . $curr_rarity_cn . " " . $used_by_heroes . " " . $curr_item ["type_cn"];
				if (! empty ( $color16 )) {
					$title = $title . "&#10" . $texiao_cn . " " . $color16;
				}
				$final_items[$i][$j]["title"] = $title;
				
				// 价格
				$price_show = "";
				if (! empty ( $curr_item ["price_$show_price"] ) && empty ( $texiao_cn )) {
					$price_show = $curr_item ["price_$show_price"];
				}
				$final_items[$i][$j]["price"] = $price_show;

				// 新品
				if (! empty ( $curr_item ["new"] ) && $curr_item ["new"] == "new") {
					$new_show = "new";
				} else {
					$new_show = "";
				}
				$final_items[$i][$j]["new_item"] = $new_show;

				// gif
				$gif = "";
				if (! empty ( $item_gif [$curr_item ["id"]] )) {
					$gif = $item_gif [$curr_item ["id"]];
				}
				$final_items[$i][$j]["gif"] = $gif;
				
				// taobao
				$taobao = "";
				if (! empty ( $item_taobao [$curr_item ["id"]] )) {
					$taobao = $item_taobao [$curr_item ["id"]];
				}
				$final_items[$i][$j]["taobao"] = $taobao;
				$final_items[$i][$j]["image"] = $curr_item["image"];

			}
		
		}
	}
}//
?>

<?php 
if ($stock_hide == "yes"){
	echo "[]";
}
else{
	echo json_encode($final_items); 
}
?>