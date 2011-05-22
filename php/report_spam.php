<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
// tmhOAuthを初期化
require "./tmhOAuth.php";
$twitter = new tmhOAuth(
  // 実際に取得したコンシューマキー、アクセストークンを記述
  array("consumer_key" => "コンシューマキー",
    "consumer_secret" => "コンシューマシークレット",
    "user_token" => "アクセストークン",
    "user_secret" => "アクセストークンシークレット"));

if (isset($_REQUEST["command"])) {
  $screenName = htmlspecialchars($_REQUEST["screen_name"]);
  // 指定したユーザーをスパム報告する
  $twitter->request("POST", $twitter->url("1/report_spam")
    , array("screen_name" => $screenName));
  print "@${screenName}をスパム報告しました<br>";
}
  ?><br>

<form action="./report_spam.php" method="POST">
  <input type="hidden" name="command" value="report_spam"/>
  スパム報告するユーザー:<input type="text" name="screen_name"/><br>
  <input type="submit" value="スパム報告"/>
</form>

</body>
</html>
