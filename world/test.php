
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
</head>
<?php

if (! empty ( $_GET ["poi"] )) {
	$poi = $_GET ["poi"];
} else {
	$poi = "2013105";
}
if (! empty ( $_GET ["server"] )) {
	$ip = $_GET ["server"];
} else {
	$ip = "172.16.2.30";
}
if (! empty ( $_GET ["name"] )) {
	$name = $_GET ["name"];
} else {
	$name = "木有名字";
}

$re = file_get_contents ( "http://172.16.2.30:8888/getpoidelivers.json?id=$poi&n=100" );
$schema_obj = json_decode ( $re );


// print_r($schema_obj);
$no_video = 0;


// print_r($videos[0]);
if (empty($schema_obj->data->videos) || empty($schema_obj->data->count)){
	$no_video = 1;
}
else{
	$no_video = 0;
	$count = $schema_obj->data->count;
	$videos = $schema_obj->data->videos;
}


?>
<body style="background-color:black;background-image: url('drodo_bg3.png');	background-repeat:no-repeat;background-attachment:fixed;">

<div style="position: relative;">
	<div style="font-size:36px;margin:10px;">
	<font style="color:gray;font-size:20px;">
	兴趣点:
	</font>
	<font style="color:#ffffff;">
	<?php echo $name;?>
	</font>
	</div>
</div>

<div style='width:100%;'>



<?php 

if ($no_video==1):
?>
	<font style="color:gray;">
	木有推荐视频
	</font>
<?php 
else:




for ($i =0;$i<$count;$i++):
	
	$v = json_decode($videos[$i]);

	$url = "";
	$s = "";
	$u = "";
	foreach ($v->urlList as $url){
// 		print_r($url);
		if (!strstr($s,$url->source)){
			$s = $s.$url->source." | ";
			$u = $url->url;
		}
		
	}
// 	if (!empty($v->urlList) &&!empty($v->urlList[0]) && !empty($v->urlList[0]->url)){
	echo "<div style='background-color:gray;width:240px;height:160px;margin:10px;float:left;cursor:pointer;' onclick='window.open(\"".$u."\")' title='".$v->title."'>";
// 	echo "<div style='background-color:gray;width:240px;height:155px;margin:10px;float:left;cursor:pointer;overflow:hidden;' onclick='' title='".$v->title."'>";
	echo "<img src='".$v->Image."' style='width:240px;height:135px;'>";
	echo "<div style='position:absolute;background-color:black;margin-top:0px;height:25px;width:230px;line-height:25px;padding-left:5px;padding-right:5px;overflow:hidden;word-break:break-all;'>";
	echo "<span style='color:gray;font-size:12px;font-family:微软雅黑;margin-top:5px;'>".$s."</span>";
	echo "<span style='color:white;font-size:14px;font-family:微软雅黑;margin-top:5px;'>".$v->title."</span>";
	echo "</div>";
	echo "</div>";
// 	}
?>

<?php endfor; endif;?>
	</div>

</body>
</html>