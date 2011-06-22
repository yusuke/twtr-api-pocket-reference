<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form action="manage_favorites.php" method="POST">
  <input type="text" name="query" size="50"/><br>
  <input type="submit" value="ツイートを検索"/>
</form>
<?php
// tmhOAuthを初期化
require "./tmhOAuth.php";
$twitter = new tmhOAuth(
  // 実際に取得したコンシューマキー、アクセストークンを記述
  array("consumer_key" => "コンシューマキー",
    "consumer_secret" => "コンシューマシークレット",
    "user_token" => "アクセストークン",
    "user_secret" => "アクセストークンシークレット"));

if (isset($_POST["query"])) {
  print htmlspecialchars($_POST["query"]) . "の検索結果:<br>";
  // 検索用tmhOAuthを初期化。
  // 検索APIではホストがtmhOAuthデフォルトのapi.twitter.comではないので明示的に指定する必要がある
  $search = new tmhOAuth(array("host" => "search.twitter.com",));
  // 検索APIを呼び出す
  $search->request("GET", $search->url("search"), array("q" => $_POST["query"]));
  $tweets = json_decode($search->response["response"])->{"results"};

  // ツイートごとにスクリーン名とツイート本文を表示
  foreach ($tweets as $tweet) {
    $screenName = $tweet->{"from_user"};
    print "<a href='./manage_favorites.php?command=favorite&id=" . $tweet->{"id_str"} . "'>お気に入りに追加</a> <img src='" . $tweet->{"profile_image_url"} . "'> @$screenName " . htmlspecialchars($tweet->{"text"}) . "<br>";
  }
}

if (isset($_REQUEST["command"])) {
  switch($_REQUEST["command"]){
    case "favorite":
      $twitter->request("POST", $twitter->url("1/favorites/create/" . $_REQUEST["id"]));
      print "お気に入りを追加しました。<br>";
      break;
    case "unfavorite":
      $twitter->request("POST", $twitter->url("1/favorites/destroy/" . $_REQUEST["id"]));
      print "お気に入りを解除しました。<br>";
      break;
  }
}

// ユーザ情報を取得
$twitter->request("GET", $twitter->url("1/account/verify_credentials"));
$myself = json_decode($twitter->response["response"]);
$screenName = $myself->{"screen_name"};

print "@" . $screenName . " のお気に入り:<br>";
$twitter->request("GET", $twitter->url("1/favorites"));
$favorites = json_decode($twitter->response["response"]);
foreach ($favorites as $favorite) {
  $screenName = $favorite->{"user"}->{"screen_name"};
  $profileImageURL = $favorite->{"user"}->{"profile_image_url"};
  print "<a href='./manage_favorites.php?command=unfavorite&id=".$favorite->{"id_str"} . "'>お気に入りを解除</a> <img src='${profileImageURL}'/> @$screenName " . htmlspecialchars($favorite->{"text"}) . "<br>";
}
?>
</body>
</html>
