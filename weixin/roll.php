<?php

function roll($user, $input){

	// 说“roll x”
	if (strstr($input,"roll ")){
		$max = intval(substr($input,5));
		$r = rand(0,$max);
		return 	"roll点结果: $r";
	}
}

?>