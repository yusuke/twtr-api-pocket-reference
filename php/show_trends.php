<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
// tmhOAuthを初期化。
require "./tmhOAuth.php";
$twitter = new tmhOAuth(array());
// トレンドAPIを呼び出す
$twitter->request("GET", $twitter->url("1/trends"));
$trends = json_decode($twitter->response["response"])->{"trends"};

// トレンドをリンクとして表示
print "現在のトレンドトピック:<br>";
foreach ($trends as $trend) {
  print "<a href='". $trend->{"url"} . "'>" . htmlspecialchars($trend->{"name"}) . "</a><br>";
}
?>
</body>
</html>
