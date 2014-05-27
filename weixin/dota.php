<?php

function dota($user, $input){

	// 说“刀塔比赛”
	if ($input=="刀塔比赛"){
		
		$match_list = json_decode ( file_get_contents ( "../match.txt" ), true );
		return 	$match_list;
	}
}

?>