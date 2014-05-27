<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
</head>

<?php
// 搜酷
// $ii=["AKB48","dota2","节奏大师","周杰伦","跑跑卡丁车","罗辑思维"];
// foreach ($ii as $i){
// 	for ($j=1;$j<=10;$j++){
// 		echo("http://www.soku.com/search_video/q_".$i."_orderby_1_page_$j;\n");
// 	}
// }

// 音悦台列表页
// foreach ($ii as $i){
	for ($j=1;$j<=100;$j++){
		echo("http://mv.yinyuetai.com/include/mv-list-play?sort=weekViews&page=$j&pageType=page;\n");
	}
// }

// $item ["price_m"] = "0.08";
// $item ["price_m"] = str_replace ( " ", "", $item ["price_m"] );
// $item ["price_m_usd"] = "$" . $item ["price_m"] ;
// $item ["price_m_rmb"] = "rmb" . number_format ( 1.0*floatval($item ["price_m"])* 6.1, 2 )  ;
// $item ["price_m_key"] = number_format ( 1.0*floatval($item ["price_m"])* 6.1/ 12.5, 1 ) . "key";

// if ($item ["price_m_usd"]=="$0"){
// 	$item ["price_m_usd"] = "";
// }

// print_r($item ["price_m_usd"]."<br>");
// print_r($item ["price_m_rmb"]."<br>");
// print_r($item ["price_m_key"]."<br>");

// $useragent = $_SERVER ['HTTP_USER_AGENT'];
// echo $useragent;

?>
</html>
