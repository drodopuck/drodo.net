<?php

if (! empty ( $_GET ["steam_id"] )) {
	$steam_id = $_GET ["steam_id"];
} else {
	$steam_id = "76561198034651705";
}

if (! empty ( $_GET ["time_from"] )) {
	$time_from = $_GET ["time_from"];
} else {
	$time_from = 0;
}

if (! empty ( $_GET ["level"] )) {
	$level = $_GET ["level"];
} else {
	$level = 3;
}

$url = "http://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/v1/?key=45896FD3F02F3672F71B44C3D227FB79"
	."&game_mode=0&skill=$level&account_id=$steam_id&date_min=$time_from&tournament_games_only=0&min_players=8";
$re = file_get_contents ( $url );
$r = json_decode ( $re );
if (! empty ( $r->result->status ) && $r->result->status == "1") {
	$vh_count = $r->result->total_results;
} else {
	$vh_count = "-1";
}

?>

<?php echo $vh_count; ?>