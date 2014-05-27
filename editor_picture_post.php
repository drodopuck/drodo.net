<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=UTF-8">
</head>


<?php
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 1000000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "源文件: " . $_FILES["file"]["name"] . "<br />";
    echo "类型: " . $_FILES["file"]["type"] . "<br />";
    echo "大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "临时文件: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " 文件已经存在！ ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "上传成功的文件地址: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "文件无效！";
  }
?>

</html>