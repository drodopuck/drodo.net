

<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
</head>
<?php
set_time_limit(0);

for ($i=0;$i<24;$i++){

	$j=$i*100;
	
$re = file_get_contents ( "http://steamcommunity.com/market/search/render/?query=appid%3A570&start=$j&count=100" );
$schema_obj = json_decode ( $re );
$a = str_replace("<","",$schema_obj->results_html);
$c = explode("market_listing_num_listings_qty",$a);
// print_r($a);
foreach ($c as $a){

	if (sizeof(explode("&#36;",$a))<=1){
		continue;
	}

$b = explode("&#36;",$a)[1];
$price = explode(" USD",$b)[0];

$b = explode("market_listing_item_name\" style=\"color: ",$a)[1];
$name = explode("/span>",$b)[0];
$name = explode(">",$name)[1];

	if (sizeof(explode("Egg",$name))>1){
		continue;
	}
	if (sizeof(explode("Greevil",$name))>1){
		continue;
	}


// 	if (sizeof(explode("Tournament",$name))>1){
// 		continue;
// 	}

// 	if (sizeof(explode("Unusual",$name))>1){
// 		continue;
// 	}
	
	$name = str_replace("Genuine ","",$name);

print_r("\"$name\" : \"$price\",<br>");

}
}
?>
<body>


</body>
</html>