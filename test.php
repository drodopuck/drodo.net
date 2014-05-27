<?php
$api_key='668542478BF6150AD44F08DD39047CAA';

if (!empty($_GET["steam_id"])){
	$steam_id = $_GET["steam_id"];
}
else{
	$steam_id = "76561198034651705";
}

$item_class = array();
$item_type_name = array();
$heros = array();

//获取规则
$url_get_user_items = "http://api.steampowered.com/IEconDOTA2_570/GetHeroes/v1?key=668542478BF6150AD44F08DD39047CAA&steamid=76561198034651705&itemizedonly=1";
$re=file_get_contents($url_get_user_items);
$schema_obj=json_decode($re);
$curr_items_schema = $schema_obj->result->heroes;

print_r($curr_items_schema);

foreach($curr_items_schema as $a){
	$heros[$a->id] = $a->name;
}




$a1=json_encode($heros);

// print_r($a2);

file_put_contents("item_hero.txt", $a1);
// file_put_contents("item_type_name.txt", $a2);
// $re=file_get_contents("items_rarity.txt");
// print_r($re);

// $obj=json_decode($re, true);
// print_r($obj[0]["name"]);

// $re=file_get_contents("items_name.txt");
// print_r($re);

// $obj=json_decode($re, true);
// print_r($obj);

//$items_name = array(50000);
// $items_name=(array)json_decode($re);

// foreach($re as $a){
// 	print_r($a);
// }
?>