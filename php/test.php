<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
// tmhOAuthを初期化
require "./tmhOAuth.php";
$twitter = new tmhOAuth(array());

$twitter->request("GET", $twitter->url("1/help/test"), array(), false);
print $twitter->response["response"];
if ($twitter->response["code"] == 200) {
  print " 接続に成功しました";
} else {
  print " 接続に失敗しました";
}
?></body>
</html>
