

<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
</head>
	<script type="text/javascript" src="../../js/jquery-1.10.1.min.js"></script>
<?php
include_once('simple_html_dom.php');

$html = file_get_html('http://www.gosugamers.net/dota2');

$ret = $html->find('#gb-matches',0)->find('tr',0);


//echo $html;
print_r($ret);
?>
</head>
<body></body>
</html>