<?php
$api_key='668542478BF6150AD44F08DD39047CAA';

if (! empty ( $_GET ["steam_id"] )) {
	$steam_id = $_GET ["steam_id"];
} else {
	$steam_id = "76561198034651705";
}

//获取好友列表
$url_get_user_friend = "http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=$api_key&steamid=$steam_id&relationship=friend";
$re=file_get_contents($url_get_user_friend);
$friend_obj=json_decode($re);

$friends_list = $friend_obj->friendslist->friends;
$friend = "";
foreach($friends_list as $a){
	$friend = $friend.$a->steamid.",";
}

//获取朋友信息
$url_get_user_info = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$friend";
$re=file_get_contents($url_get_user_info);
$user_obj=json_decode($re);
$friends = $user_obj->response->players;


?>

<?php echo json_encode($friends); ?>