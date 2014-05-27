<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
</head>

<?php
if (! empty ( $_POST ["file"] )) {
	$file = $_POST ["file"];
} else {
	die ( "提交的文件名不能为空！" );
}

if (! empty ( $_POST ["src"] )) {
	$src = $_POST ["src"];
} else {
	die ( "提交来源网页不能为空！" );
}

if (! empty ( $_POST ["content"] )) {
	$content = $_POST ["content"];
} else {
	die ( "提交的文件内容不能为空！" );
}

$content = stripslashes($content);

file_put_contents($file.".txt", $content);
// echo $content;
echo "<script>location.href='$src.php';</script>"

?>

<body>
</body>
</html>