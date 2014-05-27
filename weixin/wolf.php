<?php

function wolf($user, $input){
	$c = 0;
	// 说“狼人杀”
	if (strstr($input,"狼人杀 ")){
		$c = intval(substr($input,10));
		if ($c>=6 && $c<=16){
			$wolf_list = json_decode ( file_get_contents ( "wolf_list.txt" ), true );
			$roles_config = $wolf_list["config"]["$c"];
			$roles = $wolf_list["roles"];
			
// 			$re = [];
			$count = 1;
			foreach ($roles_config as $key => $value){
				if ($key!="random"){
					for ($i=0;$i<$value;$i++){
						$re["$count"]=$key;
						$count ++;
					}
				}
				else{
					for ($i=0;$i<$value["count"];$i++){
						$tt = count($value["roles"]);
						$nn = rand(0,$tt-1);
						$re["$count"]=$value["roles"][$nn];
						$value["roles"][$nn] = "villager";
						$count ++;
					}
				}
			}
			
			$wolf_number = rand(1000,9999);
			
			
			
			shuffle($re);
			//print_r($re);
			
			$wolf = json_decode ( file_get_contents ( "wolf.txt" ), true );
			

			while(!empty($wolf["data:$wolf_number"])){
				$wolf_number ++;
			}
			
			$wolf["data:$wolf_number"]=json_encode($re);
			$wolf["count:$wolf_number"]=$c;
			$wolf["curr_count:$wolf_number"]=0;
			$wolf["join:$wolf_number"]="[]";
			
			file_put_contents("wolf.txt", json_encode($wolf));
			
			$return = "您创建了一个狼人杀游戏，房间号为$wolf_number
";
			foreach ($re as $key => $value){
				$cn_name = $wolf_list["roles"]["$value"]["name"];
				$return = $return."$key-$cn_name
";
			}
			return 	$return;
		}
		else{
			return 	"您正在试图创建狼人杀游戏，请输入合法的游戏人数（6-16）!";
		}
	}
	
	if ($input=="狼人新月"){
		$wolf_list = json_decode ( file_get_contents ( "wolf_list.txt" ), true );
		$e = $wolf_list["event"];
		$c = count($e);
		$n = rand(0,$c);
		
		return 	$e["$n"]["name"]."
".	$e["$n"]["desc"];
	}
	
	// 空闲的人说数字，寻找房间
	if (isnum($input)) {
		$wolf = json_decode ( file_get_contents ( "wolf.txt" ), true );
		$wolf_list = json_decode ( file_get_contents ( "wolf_list.txt" ), true );
		
		if (!empty($wolf["data:$input"])){
			$curr = $wolf["curr_count:$input"];
			$count = $wolf["count:$input"];
			$join = (array)json_decode($wolf["join:$input"]);
			
			if (!empty($join["$user"])){
				$re = "请不要重复加入游戏!";
				return $re;
			}
			
			if ($curr>=$count){
				$re = "对不起, ".$input."房间已满员!";
				return $re;
			}
			
			$data = (array)json_decode($wolf["data:$input"]);
			$r = $data[$curr];
			
			$r_details = $wolf_list["roles"]["$r"];
			$join["$user"] = $curr +1;
			$wolf["join:$input"] = json_encode($join);
			
			$re = "您已加入".$input."房间狼人杀游戏，您的角色为
";
			$re = $re.	$r_details["name"]."
".$r_details["desc"];	
			
			$curr = $curr +1;
			$wolf["curr_count:$input"] = $curr;
			file_put_contents("wolf.txt", json_encode($wolf));
			
			return $re;
		}
	}
	
	// 清空所有数据
	if ($input=="清空狼人杀"){ //需要权限控制
		file_put_contents("wolf.txt", "[]");
	
		$re = "狼人杀数据已清空, 您的当前状态为 idle";
		return $re;
	}
	
	return "";
}

//echo wolf("hehe","狼人杀 10");

?>