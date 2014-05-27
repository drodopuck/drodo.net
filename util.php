<?php
$api_key = '668542478BF6150AD44F08DD39047CAA';
$key_2_rmb = 13;
$usd_2_rmb = 6.08;
$last_update_time = "2014-2-22";
$qiyi_price = 3.0;
$jinbiaosai_price = 5.0;
$dute_price = 10.0;



function checkBrowser() {
	$useragent = $_SERVER ['HTTP_USER_AGENT'];
	$pass = false;
	if (strstr ( $useragent, "360SE" )) {
		die ( "对不起，本站不支持360流氓浏览器！" );
	}
	if (strstr ( $useragent, "MSIE 5.0" ) || strstr ( $useragent, "MSIE 6.0" ) ) {
		die ( "您的IE浏览器版本过旧，请更换IE7以上的浏览器访问~" );
	}
	if (strstr ( $useragent, "Chrome" ) || strstr ( $useragent, "Firefox" ) || strstr ( $useragent, "rv:11.0" ) || strstr ( $useragent, "MSIE 10.0" ) || strstr ( $useragent, "MSIE 9.0" ) || strstr ( $useragent, "MSIE 8.0" ) || strstr ( $useragent, "MSIE 7.0" ) || strstr ( $useragent, "Safari" )) {
		$pass = true;
	}
	if (! $pass) {
		die ( "不支持的浏览器，请使用主流浏览器(Chrome,FireFox,IE9-11等)访问~" );
	}
}

// 判断是否是套装
function isBundle($curr_item) {
	if ($curr_item ["id"] == "20230") {
		return false;
	}
	if ($curr_item ["id"] == "20055") {
		return false;
	}
	if ($curr_item ["id"] == "20083") {
		return false;
	}
	if ($curr_item ["id"] == "20049") {
		return false;
	}
	if ($curr_item ["id"] == "20050") {
		return false;
	}
	if ($curr_item ["id"] == "20215") {
		return true;
	}
	if ($curr_item ["id"] == "20209") {
		return true;
	}
	if ($curr_item ["id"] == "20241") {
		return true;
	}
	if ($curr_item ["id"] == "20240") {
		return true;
	}
	if ($curr_item ["id"] == "20233") {
		return true;
	}
	if ($curr_item ["id"] == "20235") {
		return true;
	}
	if ($curr_item ["id"] == "20272") {
		return true;
	}
	if ($curr_item ["id"] == "20289") {
		return true;
	}
	if ($curr_item ["id"] == "20309") {
		return true;
	}
	if ($curr_item ["id"] == "20302") {
		return true;
	}
	if ($curr_item ["id"] == "20301") {
		return true;
	}
	if ($curr_item ["id"] == "20307") {
		return true;
	}
	if ($curr_item ["id"] == "20308") {
		return true;
	}
	if ($curr_item ["id"] == "20306") {
		return true;
	}
	if ($curr_item ["id"] == "20310") {
		return true;
	}
	if ($curr_item ["id"] == "20311") {
		return true;
	}
	if ($curr_item ["id"] == "20305") {
		return true;
	}
	if (!empty($curr_item ["type_en"]) && $curr_item ["type_en"] == "Bundle") {
		return true;
	}
	
	return false;
}

// 计算数组的平均值
function mean($array) {
	$sum = 0;
	foreach ( $array as $value ) {
		$sum += $value;
	}
	$lenght = count ( $array );
	$mean = $sum / $lenght;
	return $mean;
}
function rarity_2_cn($curr_rarity) {
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
	return $curr_rarity_cn;
}
function rarity_2_color($curr_rarity) {
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
	return $curr_color;
}

// function utf8_array_asort(&$array) {
// if(!isset($array) || !is_array($array)) {
// return false;
// }
// foreach($array as $k=>$v) {
// $array[$k] = iconv('UTF-8', 'GBK//IGNORE',$v);
// }
// asort($array);
// foreach($array as $k=>$v) {
// $array[$k] = iconv('GBK', 'UTF-8//IGNORE', $v);
// }
// return true;
// }
function sortByLen($a, $b) {
	if (empty($a ["price_ave"])){
		$a ["priceprice_ave_usd"] =0;
	}
	if (empty($b ["price_ave"])){
		$b ["price_ave"] =0;
	}
	
	if (isBundle ( $a ) && isBundle ( $b )) {
		if (rarity2Int ( $a ["rarity"] ) > rarity2Int ( $b ["rarity"] )) {
			return 1;
		} elseif (rarity2Int ( $a ["rarity"] ) < rarity2Int ( $b ["rarity"] )) {
			return - 1;
		} else {
			$aaa = str_replace ( ",", "", str_replace ( "$", "", $a ["price_ave"] ) );
			$bbb = str_replace ( ",", "", str_replace ( "$", "", $b ["price_ave"] ) );
			if ($aaa > $bbb) {
				return 1;
			} else {
				
				return - 1;
			}
		}
	}
	
	if (isBundle ( $a )) {
		return - 1;
	}
	if (isBundle ( $b )) {
		return 1;
	}
	
	if (rarity2Int ( $a ["rarity"] ) > rarity2Int ( $b ["rarity"] )) {
		return 1;
	} elseif (rarity2Int ( $a ["rarity"] ) < rarity2Int ( $b ["rarity"] )) {
		return - 1;
	} else {
		$aaa = str_replace ( ",", "", str_replace ( "$", "", $a ["price_ave"] ) );
		$bbb = str_replace ( ",", "", str_replace ( "$", "", $b ["price_ave"] ) );
		if ($aaa > $bbb) {
			return 1;
		} else {
			
			return - 1;
		}
	}
}
function rarity2Int($r) {
	if ($r == "common") {
		return 1;
	}
	if ($r == "uncommon") {
		return 2;
	}
	if ($r == "rare") {
		return 3;
	}
	if ($r == "mythical") {
		return 4;
	}
	if ($r == "legendary") {
		return 5;
	}
	if ($r == "ancient") {
		return 6;
	}
	if ($r == "immortal") {
		return 7;
	}
	if ($r == "arcana") {
		return 8;
	}
	return 0;
}


function sortByRarity($a, $b) {
// 	print_r(rarity2Int ( $a ["rarity"] ));
	if (rarity2Int ( $a ["rarity"] ) > rarity2Int ( $b ["rarity"] )) {
		return -1;
	} elseif (rarity2Int ( $a ["rarity"] ) < rarity2Int ( $b ["rarity"] )){
		return 1;
	} else{
		if ($a ["quality"] > $b["quality"]){
			return 1;
		}
		elseif ($a ["quality"] < $b["quality"]){
			return -1;
		}else{
			if ($a ["id"] > $b["id"]){
				return -1;
			}
			else{
				return 1;
			}
		}
	}
}

function sortByScore($a, $b) {
	if ($a[0]["score"]>$b[0]["score"]){
		return -1;
	}
	else{
		return 1;
	}
}

function getHeroScore($a){
	$score = 0;
	
	foreach($a as $aa){
		if ($aa ["hero"] == "通用"){
			return 0;
		}
		$xishu = 1;
		if ($aa["quality"]!=4){
			$xishu=5;
		}
		
		
		$score += $xishu * pow ( 3,  (rarity2Int ( $aa ["rarity"] )) )  ;
		
	}
	return $score;
}



function unusual2cn($un) {
	if ($un == "DT") {
		return "万圣节";
	}
	if ($un == "TD") {
		return "TD联赛";
	}
	if ($un == "TI3") {
		return "TI3";
	}
	if ($un == "TI2") {
		return "TI2";
	}
	if ($un == "Piercing Beams") {
		return "光束";
	}
	if ($un == "Luminous Gaze") {
		return "凝视";
	}
	if ($un == "Searing Essence") {
		return "灼热";
	}
	if ($un == "Resonant Energy") {
		return "共鸣";
	}
	if ($un == "Burning Animus") {
		return "战意";
	}
	if ($un == "Felicity's Blessing") {
		return "长草";
	}
	if ($un == "Ethereal Flames") {
		return "虚无";
	}
	if ($un == "Affliction of Vermin") {
		return "毒虫";
	}
	if ($un == "Sunfire") {
		return "阳炎";
	}
	if ($un == "Diretide Corruption") {
		return "暗潮";
	}
	if ($un == "Frostivus Frost") {
		return "冰霜";
	}
	if ($un == "Trail of the Lotus Blossom") {
		return "莲花";
	}
	if ($un == "Crystal Rift") {
		return "裂痕";
	}
	if ($un == "Cursed Essence") {
		return "诅咒";
	}
	if ($un == "Divine Essence") {
		return "圣洁";
	}
	if ($un == "Trail of the Amanita") {
		return "毒蕈";
	}
	if ($un == "Lava") {
		return "熔岩";
	}
}
function unusual_id_2_cn($texiao) {
	$texiao_cn = $texiao;
	if ($texiao == 4) {
		$texiao_cn = "";
	}
	if ($texiao == 109) {
		$texiao_cn = "TI3";
	}
	if ($texiao == 57) {
		$texiao_cn = "冰霜";
	}
	if ($texiao == 73) {
		$texiao_cn = "诅咒";
	}
	if ($texiao == 61) {
		$texiao_cn = "莲花";
	}
	if ($texiao == 20) {
		$texiao_cn = "光束";
	}
	if ($texiao == 15) {
		$texiao_cn = "虚无";
	}
	if ($texiao == 22) {
		$texiao_cn = "毒虫";
	}
	if ($texiao == 96) {
		$texiao_cn = "熔岩";
	}
	if ($texiao == 46) {
		$texiao_cn = "暗潮";
	}
	if ($texiao == 32) {
		$texiao_cn = "阳炎";
	}
	if ($texiao == 19) {
		$texiao_cn = "战意";
	}
	if ($texiao == 68) {
		$texiao_cn = "裂痕";
	}
	if ($texiao == 17) {
		$texiao_cn = "凝视";
	}
	if ($texiao == 76) {
		$texiao_cn = "毒蕈";
	}
	if ($texiao == 16) {
		$texiao_cn = "共鸣";
	}
	if ($texiao == 21) {
		$texiao_cn = "长草";
	}
	if ($texiao == 74) {
		$texiao_cn = "圣洁";
	}
	if ($texiao == 18) {
		$texiao_cn = "灼热";
	}
	if ($texiao == 129) {
		$texiao_cn = "红晶";
	}
	if ($texiao == 138) {
		$texiao_cn = "翡翠";
	}
	return $texiao_cn;
}

function quality_2_cn($quality,$curr_items_strange) {
	$curr_quality = $quality;
	$curr_quality_color = "gray";
	if ($quality == 12) : // 比赛
		$curr_quality = "比赛";
		$curr_quality_color = "#8650AC";
	 elseif ($quality == 9) : // 怪异
		if (! empty ( $curr_items_strange )) {
			$curr_quality = "怪异" . $curr_items_strange;
		} else {
			$curr_quality = "怪异";
		}
		$curr_quality_color = "#cf6a32";
	 elseif ($quality == 3) : // 独特
		if (! empty ( $curr_items_strange )) {
			$curr_quality = "独特" . $curr_items_strange ;
		} else {
			$curr_quality = "独特";
		}
		$curr_quality_color = "#8650AC";
	 elseif ($quality == 2) : // 传承
		$curr_quality = "传承";
		$curr_quality_color = "#476291";
	 elseif ($quality == 1) : // 纯正
		$curr_quality = "纯正";
		$curr_quality_color = "#4D7455";
	 elseif ($quality == 7) : // 自制
		$curr_quality = "自制";
		$curr_quality_color = "#70B04A";
	 elseif ($quality == 13) : // 青睐
		$curr_quality = "青睐";
		$curr_quality_color = "#FFFF00";
	 

	else : // 普通
		$curr_quality = "";
	endif;
	return $curr_quality;
}

function quality_2_color($quality,$curr_items_strange) {
	$curr_quality = $quality;
	$curr_quality_color = "gray";
	if ($quality == 12) : // 比赛
	$curr_quality = "比赛";
	$curr_quality_color = "#8650AC";
	elseif ($quality == 9) : // 奇异
	if (! empty ( $curr_items_strange )) {
		$curr_quality = "奇异" . $curr_items_strange;
	} else {
		$curr_quality = "奇异";
	}
	$curr_quality_color = "#cf6a32";
	elseif ($quality == 3) : // 独特
	if (! empty ( $curr_items_strange )) {
		$curr_quality = "独特" . $curr_items_strange;
	} else {
		$curr_quality = "独特";
	}
	$curr_quality_color = "#8650AC";
	elseif ($quality == 2) : // 传承
	$curr_quality = "传承";
	$curr_quality_color = "#476291";
	elseif ($quality == 1) : // 纯正
	$curr_quality = "纯正";
	$curr_quality_color = "#4D7455";
	elseif ($quality == 7) : // 自制
	$curr_quality = "自制";
	$curr_quality_color = "#70B04A";
	elseif ($quality == 13) : // 青睐
	$curr_quality = "青睐";
	$curr_quality_color = "#FFFF00";


	else : // 普通
	$curr_quality = "";
	endif;
	return $curr_quality_color;
}

function id64_2_id32($id64){
	$id32= $id64-76561197960265728;
	if ($id32%2==0) { $id32 = $id32/2; }
	return $id32;
}

function get_ave_price($p1,$p2,$p3,$p4){
	$total = 0.0;
	$count = 0;
	
	if ((!empty($p1)&&$p1!="-")){
		$total = $total+floatval($p1);
		$count ++;
	}
	if ((!empty($p2)&&$p2!="-")){
		$total = $total+floatval($p2);
		$count ++;
	}
	if ((!empty($p3)&&$p3!="-")){
		$total = $total+floatval($p3);
		$count ++;
	}
	if ((!empty($p4)&&$p4!="-")){
		$total = $total+floatval($p4);
		$count ++;
	}
	
	if ($count ==0){
		return "-";
	}
	else{
		$c =  floatval($total) / floatval($count);
		return str_replace(",", "", number_format ($c,0));
	}
	

}

?>