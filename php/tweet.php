<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form action="tweet.php" method="POST">
  いまどうしてる？ <input type="text" name="tweet" size="50"/><br>
  <input type="submit" value="ツイート"/>
</form>
<?php
if (isset($_POST["tweet"])) {
  // tmhOAuthを初期化
  require "./tmhOAuth.php";
  $twitter = new tmhOAuth(
  // 実際に取得したコンシューマキー、アクセストークンを記述
  array("consumer_key" => "コンシューマキー",
    "consumer_secret" => "コンシューマシークレット",
    "user_token" => "アクセストークン",
    "user_secret" => "アクセストークンシークレット"));

  // ツイートする
  $twitter->request("POST", $twitter->url("1/statuses/update")
    , array("status" => $_POST["tweet"]));
  print "ツイートしました:" . htmlspecialchars($_POST["tweet"]);
}
?>
</body>
</html>
