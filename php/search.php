<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form action="search.php" method="POST">
  <input type="text" name="query" size="50"/><br>
  <input type="submit" value="検索"/>
</form>
<?php
if (isset($_POST["query"])) {
  print htmlspecialchars($_POST["query"]) . "の検索結果:<br>";
  // tmhOAuthを初期化
  // 検索APIではホストがtmhOAuthデフォルトのapi.twitter.comではないので明示的に指定する必要がある
  require "./tmhOAuth.php";
  $twitter = new tmhOAuth(array("host" => "search.twitter.com",));
  // 検索APIを呼び出す
  $twitter->request("GET", $twitter->url("search"), array("q" => $_POST["query"]));
  $tweets = json_decode($twitter->response["response"])->{"results"};

  // ツイートごとにスクリーン名とツイート本文を表示
  foreach ($tweets as $tweet) {
    $screenName = $tweet->{"from_user"};
    print "<img src='" . $tweet->{"profile_image_url"} . "'> @$screenName " . htmlspecialchars($tweet->{"text"}) . "<br>";
  }
}
?>
</body>
</html>
