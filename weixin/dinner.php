<?php

function dinner($user, $input){
	$user_status = json_decode ( file_get_contents ( "user_status.txt" ), true );
	$dinner = json_decode ( file_get_contents ( "dinner.txt" ), true );
	
	$status = $user_status["$user"];
	if (empty($status)){
		$status = "idle";
	}
	
	// 空闲的人说“吃饭”，发起吃饭投票
	if ($status=="idle" && ($input=="吃饭" || $input=="chifan" || $input=="dinner")){
		
		$dinner_list = json_decode ( file_get_contents ( "dinner_list.txt" ), true );
		
		$dinner_number = rand(1000,9999);
		
		while(!empty($dinner["data:$dinner_number"])){
			$dinner_number ++;
		}
		
		$user_status["$user"] = "dinner_host:$dinner_number";
		$dinner["data:$dinner_number"]="[]";
		$dinner["result:$dinner_number"]="vote";
		file_put_contents("user_status.txt", json_encode($user_status));
		file_put_contents("dinner.txt", json_encode($dinner));
		
		$vote_items = "投票选项:  ";
		foreach ($dinner_list as $key => $value){
			$vote_items = $vote_items."$key-$value  ";
		}
		$vote_items = $vote_items."
请输入要选择的编号,反对票请输入负数
您是房主,请在其他人都投完后最后投票~";
		
		$re = "您发起了一个吃饭投票，房间号为$dinner_number
".$vote_items;
		
		return $re;
	} 

	// 饭主说数字，计票，结束并结算投票
	if (strstr($status,"dinner_host:") && isnum($input)){
		$user_status["$user"] = "";
		$dinner_array = explode ( ":", $status );
		$dinner_number= $dinner_array[1];

		// 计票
		$map = (array)json_decode( $dinner["data:$dinner_number"]);
		$map["$user"]=intval($input);
		$dinner["data:$dinner_number"] = json_encode($map);
		
		// 结算
		$vote_result= calculateWinner((array)json_decode($dinner["data:$dinner_number"]));
		$dinner_list = json_decode ( file_get_contents ( "dinner_list.txt" ), true );
		$vote_result_content = $dinner_list["$vote_result"];
		
		if (empty($vote_result_content)){
			$vote_result_content = "什么也不吃!饿死算了...";
		}
		
		$dinner["result:$dinner_number"]="$vote_result_content";
		file_put_contents("user_status.txt", json_encode($user_status));
		file_put_contents("dinner.txt", json_encode($dinner));
		
		$re = "投票结束，投票结果为 $vote_result_content";
		return $re;
	}
	
	// 投票者说数字，计票
	if (strstr($status,"dinner_vote:") && isnum($input)){
		$dinner_array = explode ( ":", $status );
		$dinner_number= $dinner_array[1];
		
		// 计票
		$map = (array)json_decode( $dinner["data:$dinner_number"]);
		$map["$user"]=intval($input);
		$dinner["data:$dinner_number"] = json_encode($map);
		
		$user_status["$user"] = "";
		file_put_contents("user_status.txt", json_encode($user_status));
		file_put_contents("dinner.txt", json_encode($dinner));
	
		$re = "投票成功! 等房主结束投票后再输入一次房间号 $dinner_number 可以查看结果";
		return $re;
	}
	
	// 空闲的人说数字，寻找房间
	if ($status=="idle" && isnum($input)) {
		if ($dinner["result:$input"]=="vote"){
			
			$dinner_list = json_decode ( file_get_contents ( "dinner_list.txt" ), true );
			
			$user_status["$user"] = "dinner_vote:$input";
			file_put_contents("user_status.txt", json_encode($user_status));
			$vote_items = "房间 $input 正在投票吃什么, 投票选项:  
";
			foreach ($dinner_list as $key => $value){
				$vote_items = $vote_items."$key-$value  ";
			}
			$vote_items = $vote_items."
请输入要选择的编号,反对票请输入负数";
			
			$re = $vote_items;
			return $re;
		}
		elseif (empty($dinner["result:$input"])){
			$re = "";
			return $re;
		}
		else{
			$rst = $dinner["result:$input"];
			$re = "投票结果为: $rst";
			return $re;
		}
	}
	
	// 任何时候说“退出”，都进入空闲状态
	if ($input=="退出"){
		$user_status["$user"] = "";
		$re = "退出成功, 您的当前状态为 idle";
		file_put_contents("user_status.txt", json_encode($user_status));
		return $re;
	}
	
	// 清空所有数据
	if ($input=="清空吃饭"){ //需要权限控制
		$user_status["$user"] = "";
		file_put_contents("user_status.txt", "[]");
		file_put_contents("dinner.txt", "[]");
		
		$re = "吃饭数据已清空, 您的当前状态为 idle";
		return $re;
	}
	
	// 任何时候说“?”，查询当前状态
	if ($input=="?" || $input=="？"){
		$re = "您的当前状态为 $status";
		file_put_contents("user_status.txt", json_encode($user_status));
		return $re;
	}

	return "";
}

function calculateWinner($voteData) {
	$arr = array();
	foreach ($voteData as $key => $value) {
		$cid = abs($value);
		if(!array_key_exists($cid, $arr)) {
			$arr[$cid] = 0;
		}
		if($value < 0) {
			$arr[$cid] -= 2;
		} else {
			$arr[$cid] += 1;
		}
	}
	$max = 0;
	$selectedArr = array();
	foreach ($arr as $key => $value) {
		if($value > $max) {
			$max = $value;
			$selectedArr = array();
			array_push($selectedArr, $key);
		} else if($value == $max) {
			array_push($selectedArr, $key);
		}
	}
	$length = count($selectedArr);
	if($length > 1) {
		$index = rand(0, $length - 1);
		return $selectedArr[$index];
	} else if($length == 1) {
		return $selectedArr[0];
	} else {
		return -1;
	}
}

?>
