<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
</head>

<?php
include_once '../util.php';
checkBrowser ();

// $data是这样的格式：
// [4934] => Array ( [creation_date] => 2013-04-30 [item_description] => #DOTA_Item_Desc_Penumbral_Cloak
// [item_name] => #DOTA_Item_Penumbral_Cloak [item_rarity] => uncommon [item_type_name] => #DOTA_WearableType_Cloak
// [used_by_heroes] => npc_dota_hero_phantom_assassin )
$data = json_decode ( file_get_contents ( "data.txt" ), true );

// $cn是这样的格式：
// [DOTA_Item_Treasure_Key_of_Crystalline_Chaos] => 晶化混沌的宝箱钥匙
$cn = ( array ) json_decode ( file_get_contents ( "cn.txt" ), true );

// print_r($cn);

// $price是这样的格式：
// [The Garments of the Charred Bloodline Set] => 3-4
$price = ( array ) json_decode ( file_get_contents ( "price.txt" ), true );

$price_m = ( array ) json_decode ( file_get_contents ( "price_steam_market.txt" ), true );
$price_t = ( array ) json_decode ( file_get_contents ( "price_water.txt" ), true );

$re = file_get_contents ( "store_s.txt" );
$schema_obj = json_decode ( $re );

foreach($schema_obj as $i){
	// 	print_r($i->def_index.": ".(($i->prices->base->USD)/100)."<br>");
	$price_s[$i->def_index] = ($i->prices->base->USD)/100;

}

// $hero_2_cn是这样的格式：
// [bloodseeker] => 血魔
// $cn_2_hero是这样的格式：
// [血魔] => bloodseeker
$heros = ( array ) json_decode ( file_get_contents ( "hero.txt" ), true );
$hero_2_cn = Array ();
$cn_2_hero = Array ();
foreach ( $heros as $h ) {
	$hero_array = explode ( "/", $h );
	$hero_cn = "";
	$hero_eng = "";
	if (! empty ( $hero_array [0] ) && ! empty ( $hero_array [1] )) {
		$hero_cn = $hero_array [0];
		$hero_eng = $hero_array [1];
		$hero_2_cn [$hero_eng] = $hero_cn;
		$cn_2_hero [$hero_cn] = $hero_eng;
	}
}
$opts = array(
		'http'=>array(
				'method'=>"GET",
				'timeout'=>60,
		)
);
$context = stream_context_create($opts);
// $items是这样的格式：
// [2432] => stdClass Object ( [name] => Fire-Blessed Mail of the Drake Set
// [defindex] => 20062 [item_class] => bundle [item_type_name] => #DOTA_WearableType_Bundle
// [item_name] => #DOTA_Item_FireBlessed_Mail_of_the_Drake_Set
// [item_description] => #DOTA_Item_Desc_FireBlessed_Mail_of_the_Drake
// [image_url] => http://media.steampowered.com/apps/570/icons/econ/sets/dota_item_fireblessed_mail_of_the_drake_set.0666550aa7a73806932009bd290a4f81e951bc7d.png
// [image_url_large] => http://media.steampowered.com/apps/570/icons/econ/sets/dota_item_fireblessed_mail_of_the_drake_set_large.2e4e37e89dd351f3ca3d21bf2af769173227ee3d.png
$url_get_user_items = "http://api.steampowered.com/IEconItems_570/GetSchema/v0001/?key=668542478BF6150AD44F08DD39047CAA&steamid=76561198034651705";
$re = file_get_contents ( $url_get_user_items );
$schema_obj = json_decode ( $re );
$items = $schema_obj->result->items;

// $schema_obj = json_decode ( file_get_contents ( "s2.txt" ), true );
// $items = $schema_obj["result"]["items"];

print_r($items);

$unusual = ( array ) json_decode ( file_get_contents ( "item_unusual.txt" ), true );



foreach ( $items as $a ) {
	if (! empty ( $a->defindex ) && ! empty ( $a->name ) && ! empty ( $a->image_url ) && ! strstr ( $a->image_url, "testitem_slot_empty" )) {
		$item ["id"] = $a->defindex;
		$item ["name"] = $a->name;
		
		if (strstr($item ["name"],"- ADMIN")){
			continue;
		}
		
		$item ["name_cn"] = "[暂无中文名]";
		$t = str_replace("#","",$a->item_name);
		if (! empty ( $cn [$t] )) {
			$item ["name_cn"] = $cn [$t];
		}
		$item["desc_cn"] = "[暂无描述]";
		$t = str_replace("#","",$a->item_description);
		if (! empty ( $cn [$t] )) {
			$item ["desc_cn"] = $cn [$t];
		}

		$item ["image"] = $a->image_url;
		$item ["class"] = $a->item_class;
		$item ["type"] = $a->item_type_name;
		$item ["type_en"] = str_replace("#DOTA_","",str_replace("#DOTA_WearableType_","",$a->item_type_name));
		$item ["type_cn"] = $item ["type_en"];
		$t = str_replace("#","",$a->item_type_name);
		if (! empty ( $cn [$t] )) {
			$item ["type_cn"] = $cn [$t];
		}
		
		if (! empty ( $data [$item ["id"]] ) && ! empty ( $data [$item ["id"]] ["item_rarity"] )) {
			$item ["rarity"] = $data [$item ["id"]] ["item_rarity"];
		} else {
			$item ["rarity"] = "common";
		}
		
		if (! empty ( $data [$item ["id"]] ) && ! empty ( $data [$item ["id"]] ["used_by_heroes"] )) {
			$item ["hero"] = $data [$item ["id"]] ["used_by_heroes"];
			$item ["hero"] = str_replace ( "npc_dota_hero_", "", $item ["hero"] ); // 去掉前缀npc_dota_hero_
			if (! empty ( $hero_2_cn [$item ["hero"]] )) {
				$item ["hero_cn"] = $hero_2_cn [$item ["hero"]];
			} else {
				$item ["hero_cn"] = "通用";
			}
		} else {
			$item ["hero"] = "anyhero";
			$item ["hero_cn"] = "通用";
		}
		
		if (! empty ( $data [$item ["id"]] ) && ! empty ( $data [$item ["id"]] ["creation_date"] )) {
			$item ["date"] = $data [$item ["id"]] ["creation_date"];
		} else {
			$item ["date"] = "2012-01-01";
		}
		
		if (! empty ( $price [$item ["name"]] )) {
			$item ["price"] = $price [$item ["name"]];
			$item ["price"] = str_replace ( " ", "", $item ["price"] );
			$item ["price_key"] = $item ["price"] . "key";
			
			$price_array = explode ( "-", str_replace ( " ", "", $item ["price"] ) );
			$item ["price_rmb"] = "";
			$item ["price_usd"] = "";
			if (round ( mean ( $price_array ) * $key_2_rmb ) >= 1) {
				$item ["price_rmb"] = number_format ( (mean ( $price_array ) * $key_2_rmb), 2 );
				$item ["price_rmb"] = str_replace ( ",", "",$item ["price_rmb"] );
				$item ["price_usd"] = number_format ( (mean ( $price_array ) * $key_2_rmb) / $usd_2_rmb, 2 );
				$item ["price_usd"] = str_replace ( ",", "",$item ["price_usd"] );
			}
			
		}
		else{
			$item ["price"] = "";
			$item ["price_key"] = "";
			$item ["price_rmb"] = "";
			$item ["price_usd"] = "";
		}
		
		if (! empty ( $price_m [$item ["name"]] )) {
			$item ["price_m"] = $price_m [$item ["name"]];
			$item ["price_m"] = str_replace ( " ", "", $item ["price_m"] );
			$item ["price_m_usd"] = $item ["price_m"] ;
			$item ["price_m_usd"] = str_replace ( ",", "",$item ["price_m_usd"] );
			$item ["price_m_rmb"] = number_format ( floatval($item ["price_m"])* $usd_2_rmb, 2 )  ;
			$item ["price_m_rmb"] = str_replace ( ",", "",$item ["price_m_rmb"] );
			$item ["price_m_key"] = number_format ( floatval($item ["price_m"])* $usd_2_rmb/ $key_2_rmb, 0 ) . "key";
				
		}
		else{
			$item ["price_m"] = "";
			$item ["price_m_key"] = "";
			$item ["price_m_rmb"] = "";
			$item ["price_m_usd"] = "";
		}
		
		$item ["price_t_rmb"] = "";
		if (! empty ( $price_t [ $item ["id"] ])){
			$item ["price_t_rmb"] = number_format (floatval($price_t [ $item ["id"] ]),2);
		}
		
		$item ["price_s_rmb"] = "";
		if (! empty ( $price_s [ $item ["id"] ])){
			$item ["price_s_rmb"]=number_format ( floatval($price_s[$item["id"]])*$usd_2_rmb,2);
		}
		
		$item ["price_rmb"] = str_replace(",","",$item ["price_rmb"]);
		$item ["price_m_rmb"] = str_replace(",","",$item ["price_m_rmb"]);
		$item ["price_t_rmb"] = str_replace(",","",$item ["price_t_rmb"]);
		$item ["price_s_rmb"] = str_replace(",","",$item ["price_s_rmb"]);
		
		
		$ave = "";
		$ave = get_ave_price(str_replace(",","",$item ["price_m_rmb"]),str_replace(",","",$item ["price_rmb"]),str_replace(",","",$item ["price_t_rmb"]),str_replace(",","",$item ["price_s_rmb"]));
// 		if (empty($ave)){
// 			$ave = "";
// 		}
		$item ["price_ave"] = $ave;
		
		
		print_r ( $item );
		//$item已经创建完毕，现在把它按类别存放到指定的库中
		
		
		
		//新品
		$item["new"] = "";
		$zero1=strtotime (date("y-m-d")); //当前时间
		$zero2=strtotime ($item ["date"]);  //发布时间
		$guonian=ceil(($zero1-$zero2)/86400); //60s*60min*24h
		if ($guonian<=15){
			$item["new"] = "new";
			$all_item_type["new"][$item ["id"]] = $item;
		}
		
		if (($item ["type_en"] == "Custom_Courier" || $item ["type_en"] == "Courier" || 
			$item ["type_en"] == "iG_Courier" || $item ["type_en"] == "Baekho_Courier" ||
			$item ["type_en"] == "Brave_Little_Courier" || $item ["type_en"] == "Courier_Itsid_Bitsid_Arachnid" || 
			$item ["type_en"] == "Fish_Courier" || $item ["type_en"] == "Fluffy_Devourer_of_Weeds" || 
			$item ["type_en"] == "Necromantic_SteamTech_Delivery_Machine" || 
			$item ["type_en"] == "Transdimensional_Delivery_Boy" || $item ["type_en"] == "Servant_of_Selemene" || 
			$item ["type_en"] == "Kupu_Courier" || $item ["type_en"] == "Mandrill_Courier" || $item["id"]=="10191"
				|| $item["id"]=="10313"
				|| $item ["id"]=="10174") && $item["id"]!="10096" ){
			
			$item ["hero"] = "courier";
			$item ["hero_cn"] = "信使";
			$all_item_type["courier"][$item ["id"]] = $item;
			
// 			//信使，要遍历一遍"/特效" 来看看都有哪些特效
// 			foreach ($unusual as $un){
// 				$price_search_name = $item ["name"]."/".$un;
// 				print_r($price_search_name."|");
// 				if (! empty ( $price [$price_search_name] )){
// 					$item ["price"] = $price [$price_search_name];
// 					$item ["price"] = str_replace ( " ", "", $item ["price"] );
// 					$item ["price_key"] = $item ["price"] . "key";
						
// 					$price_array = explode ( "-", str_replace ( " ", "", $item ["price"] ) );
// 					$item ["price_rmb"] = "";
// 					$item ["price_usd"] = "";
// 					if (round ( mean ( $price_array ) * $key_2_rmb ) >= 1) {
// 						$item ["price_rmb"] = number_format ( (mean ( $price_array ) * $key_2_rmb), 2 );
// 						$item ["price_rmb"] = str_replace ( ",", "",$item ["price_rmb"] );
// 						$item ["price_usd"] = number_format ( (mean ( $price_array ) * $key_2_rmb) / $usd_2_rmb, 2 );
// 						$item ["price_usd"] = str_replace ( ",", "",$item ["price_usd"] );
// 					}
// 					$item ["unusual"] = $un;
// 					$all_item_type["unusual_courier"][$item ["name"]][$un] = $item;
// 				}
// 			}
// 			//没特效的
// 			$price_search_name = $item ["name"]."/-";
// 			if (! empty ( $price [$price_search_name] )){
// 				$item ["price"] = $price [$price_search_name];
// 				$item ["price"] = str_replace ( " ", "", $item ["price"] );
// 				$item ["price_key"] = $item ["price"] . "key";
			
// 				$price_array = explode ( "-", str_replace ( " ", "", $item ["price"] ) );
// 				$item ["price_rmb"] = "";
// 				$item ["price_usd"] = "";
// 				if (round ( mean ( $price_array ) * $key_2_rmb ) >= 1) {
// 					$item ["price_rmb"] = number_format ( (mean ( $price_array ) * $key_2_rmb), 2 );
// 					$item ["price_rmb"] = str_replace ( ",", "",$item ["price_rmb"] );
// 					$item ["price_usd"] = number_format ( (mean ( $price_array ) * $key_2_rmb) / $usd_2_rmb, 2 );
// 					$item ["price_usd"] = str_replace ( ",", "",$item ["price_usd"] );

// 				}
// 				$all_item_type["courier"][$item ["id"]] = $item;
// 			}
// 			else{
// 				$all_item_type["courier"][$item ["id"]] = $item;
// 			}
			
// 			if ($item["id"]=="10033"){ //联赛狗
// 				$price_search_name = $item ["name"]."/-";
// 				if (! empty ( $price [$price_search_name] )){
// 					$item ["price"] = $price [$price_search_name];
// 					$item ["price"] = str_replace ( " ", "", $item ["price"] );
// 					$item ["price_key"] = $item ["price"] . "key";
						
// 					$price_array = explode ( "-", str_replace ( " ", "", $item ["price"] ) );
// 					$item ["price_rmb"] = "";
// 					$item ["price_usd"] = "";
// 					if (round ( mean ( $price_array ) * $key_2_rmb ) >= 1) {
// 						$item ["price_rmb"] = number_format ( (mean ( $price_array ) * $key_2_rmb), 2 );
// 						$item ["price_rmb"] = str_replace ( ",", "",$item ["price_rmb"] );
// 						$item ["price_usd"] = number_format ( (mean ( $price_array ) * $key_2_rmb) / $usd_2_rmb, 2 );
// 						$item ["price_usd"] = str_replace ( ",", "",$item ["price_usd"] );
// 					}
// 					$item ["unusual"] = "TD";
// 					$all_item_type["unusual_courier"]["Enduring War Dog"]["TD"] = $item;
// 				}
// 			}

			
			
			
		}elseif ($item ["type_en"] == "International_Courier" && $item ["id"]!="10174"){ //邀请赛信使
			$price_search_name = $item ["name"]."/-";
			
			$item ["hero"] = "courier";
			$item ["hero_cn"] = "信使";
			$all_item_type["courier"][$item ["id"]] = $item;
			
// 			if (! empty ( $price [$price_search_name] )){
// 				$item ["price"] = $price [$price_search_name];
// 				$item ["price"] = str_replace ( " ", "", $item ["price"] );
// 				$item ["price_key"] = $item ["price"] . "key";
					
// 				$price_array = explode ( "-", str_replace ( " ", "", $item ["price"] ) );
// 				$item ["price_rmb"] = "";
// 				$item ["price_usd"] = "";
// 				if (round ( mean ( $price_array ) * $key_2_rmb ) >= 1) {
// 					$item ["price_rmb"] = number_format ( (mean ( $price_array ) * $key_2_rmb), 2 );
// 					$item ["price_rmb"] = str_replace ( ",", "",$item ["price_rmb"] );
// 					$item ["price_usd"] = number_format ( (mean ( $price_array ) * $key_2_rmb) / $usd_2_rmb, 2 );
// 					$item ["price_usd"] = str_replace ( ",", "",$item ["price_usd"] );

// 				}
// 				if ($item ["id"]=="10287" || $item ["id"]=="10294" 
// 							|| $item ["id"]=="10300" || $item ["id"]=="10188"){
// 					$item ["unusual"] = "TI3";
// 				}elseif ($item ["id"]=="10005" 
// 							|| $item ["id"]=="10003" || $item ["id"]=="10004"){
// 					$item ["unusual"] = "TI2";
// 				}
// 				$all_item_type["unusual_courier"]["TI"][$item ["id"]] = $item;
// 			}
				
		}elseif ($item["id"]=="10096"){ //金肉山
			
			$item ["hero"] = "courier";
			$item ["hero_cn"] = "信使";
			$all_item_type["courier"][$item ["id"]] = $item;
			
// 			$price_search_name = $item ["name"]."/-";
// 			if (! empty ( $price [$price_search_name] )){
// 				$item ["price"] = $price [$price_search_name];
// 				$item ["price"] = str_replace ( " ", "", $item ["price"] );
// 				$item ["price_key"] = $item ["price"] . "key";
					
// 				$price_array = explode ( "-", str_replace ( " ", "", $item ["price"] ) );
// 				$item ["price_rmb"] = "";
// 				$item ["price_usd"] = "";
// 				if (round ( mean ( $price_array ) * $key_2_rmb ) >= 1) {
// 					$item ["price_rmb"] = number_format ( (mean ( $price_array ) * $key_2_rmb), 2 );
// 					$item ["price_rmb"] = str_replace ( ",", "",$item ["price_rmb"] );
// 					$item ["price_usd"] = number_format ( (mean ( $price_array ) * $key_2_rmb) / $usd_2_rmb, 2 );
// 					$item ["price_usd"] = str_replace ( ",", "",$item ["price_usd"] );

// 				}
// 				$item ["unusual"] = "DT";
// 				$all_item_type["unusual_courier"]["TI"][$item ["id"]] = $item;
// 			}
		}
		
		elseif ($item ["id"]=="5039" || $item ["id"]=="5040" ||$item ["id"]=="5038" || $item ["id"]=="5041") {
			$all_item_type ["sniper"] [$item ["id"]] = $item;
		}elseif ($item["id"]=="15012"){
			$all_item_type ["witch_doctor"] [$item ["id"]] = $item;
		}elseif ($item ["type_en"] == "Ward") {
			$all_item_type ["ward"] [$item ["id"]] = $item;
		}elseif ($item ["type_en"] == "Announcer" || $item ["type_en"] == "Announcer_Bundle") {
			$all_item_type ["announcer"] [$item ["id"]] = $item;
		} elseif ($item ["type_en"] == "HUD_Skin" || $item ["type_en"] == "International_HUD_Skin" ){
			$all_item_type ["skin"] [$item ["id"]] = $item;
		} elseif ($item ["type_en"] == "Treasure_Key"||$item ["id"] =="15057"||$item ["id"] =="15209") {
			$all_item_type ["key"] [$item ["id"]] = $item;
		} elseif ($item ["class"] == "supply_crate" || $item ["type_en"] == "Gift" || 
				$item ["type_en"] == "Priceless_Treasure" || $item ["type_en"] == "Item_Gift") {
			$item ["hero"] = "anyhero";
			$item ["hero_cn"] = "通用";
			
			$all_item_type ["treasure"] [$item ["id"]] = $item;
		} elseif ($item ["type_en"] == "Pennant" || $item ["type_en"] == "Fan_Item" || $item["id"]=="15067"){
			$all_item_type ["pennant"] [$item ["id"]] = $item;
		} else {
			$all_item_type [$item ["hero"]] [$item ["id"]] = $item;
		}
		
		$all_item [$item ["id"]] = $item;
	}
}

$a=json_encode($all_item_type["courier"]);
file_put_contents("../data/item_courier.txt", $a);
// $a=json_encode($all_item_type["unusual_courier"]);
// file_put_contents("../data/item_unusual_courier.txt", $a);
$a=json_encode($all_item_type["ward"]);
file_put_contents("../data/item_ward.txt", $a);
$a=json_encode($all_item_type["key"]);
file_put_contents("../data/item_key.txt", $a);
$a=json_encode($all_item_type["treasure"]);
file_put_contents("../data/item_treasure.txt", $a);
$a=json_encode($all_item_type["announcer"]);
file_put_contents("../data/item_announcer.txt", $a);
$a=json_encode($all_item_type["skin"]);
file_put_contents("../data/item_skin.txt", $a);
$a=json_encode($all_item_type["pennant"]);
file_put_contents("../data/item_pennant.txt", $a);

$a=json_encode($all_item_type["anyhero"]);
file_put_contents("../data/item_anyhero.txt", $a);
$a=json_encode($all_item_type["new"]);
file_put_contents("../data/item_new.txt", $a);

$a=json_encode($all_item);
file_put_contents("../data/item_all.txt", $a);

foreach ($cn_2_hero as $h){
	$a=json_encode($all_item_type[$h]);
	file_put_contents("../data/item_$h.txt", $a);
}
// $a2=json_encode($item_image);
// $a3=json_encode($item_class);
// $a4=json_encode($item_type_name);

// file_put_contents("items_name.txt", $a1);
// file_put_contents("items_image.txt", $a2);
// file_put_contents("item_class.txt", $a3);
// file_put_contents("item_type_name.txt", $a4);

?>

</html>