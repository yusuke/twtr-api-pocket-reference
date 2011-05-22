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

$twitter->request("GET", $twitter->url("1/legal/tos"), array(), false);
$tos = htmlspecialchars(json_decode($twitter->response["response"])->{"tos"});
$twitter->request("GET", $twitter->url("1/legal/privacy"), array(), false);
$privacy = htmlspecialchars(json_decode($twitter->response["response"])->{"privacy"});

?><h1>利用規約</h1>
<pre><?=$tos?></pre>
<h1>プライバシーポリシー</h1>
<pre><?=$privacy?></pre>
</body>
</html>
