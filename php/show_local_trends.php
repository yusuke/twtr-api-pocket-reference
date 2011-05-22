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

if (!isset($_GET["woeid"])) {
  // woeidが指定されていないのでトレンドトピックのある地域一覧を取得する
  // ローカルトレンドAPIを呼び出す
  $twitter->request("GET", $twitter->url("1/trends/available"));
  //$twitter->pr($twitter->response["response"]);
  $locations = json_decode($twitter->response["response"]);
  print "トレンドトピックのある地域一覧:<br>";
  // 場所をリンクとして表示
  foreach ($locations as $location) {
    print "<a href='./show_local_trends.php?woeid=" . $location->{"woeid"} . "'>"
      . htmlspecialchars($location->{"name"}) . "</a><br>";
  }
} else {
  // ローカルトレンドAPIを呼び出す
  $twitter->request("GET", $twitter->url("1/trends/" . $_GET["woeid"]));
  //$twitter->pr($twitter->response["response"]);
  $trends = json_decode($twitter->response["response"]);

  // トレンドをリンクとして表示
  print "トレンドトピック:<br>";
  foreach ($trends[0]->{"trends"} as $trend) {
    print "<a href='" . $trend->{"url"} . "'>" . htmlspecialchars($trend->{"name"}) . "</a><br>";
  }
}
?>
</body>
</html>
