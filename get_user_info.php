<?php
$api_key='668542478BF6150AD44F08DD39047CAA';

if (! empty ( $_GET ["steam_id"] )) {
	$steam_id = $_GET ["steam_id"];
} else {
	$steam_id = "76561198034651705";
}

// 获取用户信息
$url_get_user_info = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$steam_id";
$re = file_get_contents ( $url_get_user_info );
$user_obj = json_decode ( $re );
$curr_user = $user_obj->response->players [0];


?>

<?php echo json_encode($curr_user); ?>