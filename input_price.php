<?php
	include_once 'util.php';
	
	if (!empty($_COOKIE["drodo_steam_id"])){
		$drodo_steam_id = $_COOKIE["drodo_steam_id"];
	}
	
	if (! empty ( $_GET ["id"] )) {
		$id = $_GET ["id"];
	} else {
		$id = "id";
	}
	if (! empty ( $_GET ["price"] )) {
		$p = $_GET ["price"];
	} else {
		$p = "price";
	}
	
	$price_t = ( array ) json_decode ( file_get_contents ( "get_data/price_water.txt" ), true );
	$price_t[$id] = $p;
	print_r($price_t);
	
	$a=json_encode($price_t);
	file_put_contents("get_data/price_water.txt", $a);
?>

<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
	<link rel="shortcut icon" href="drodo.ico">
	<?php checkBrowser(); ?>
	<title>巨鸟多多!  DOTA2  饰品 直播 奖金 </title>
	

	</script> 
	

</head>


<body >
	
	
	</body>

</html>