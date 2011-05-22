<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form action="search_users.php" method="POST">
  ユーザーを検索: <input type="text" name="query" size="50"/><br>
  <input type="submit" value="検索"/>
</form>
<?php
if (isset($_POST["query"])) {
  // tmhOAuthを初期化
  require "./tmhOAuth.php";
  $twitter = new tmhOAuth(
  // 実際に取得したコンシューマキー、アクセストークンを記述
    array("consumer_key" => "コンシューマキー",
         "consumer_secret" => "コンシューマシークレット",
         "user_token" => "アクセストークン",
         "user_secret" => "アクセストークンシークレット"));

  // 検索する
  $twitter->request("GET", $twitter->url("1/users/search")
    , array("q" => $_POST["query"]));
  $result = json_decode($twitter->response["response"]);
  print htmlspecialchars($_POST["query"]) . "の検索結果<br>";
  foreach ($result as $user) {
    // アイコンとスクリーン名を表示
    print "<img src='" . $user->{"profile_image_url"} . "'> @" . $user->{"screen_name"}
      . " - " . $user->{"name"} .  "<br>";
  }
}
?>
</body>
</html>
