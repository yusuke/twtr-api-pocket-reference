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
  switch($_REQUEST["command"]){
    case "block":
      // 指定したユーザーをブロックする
      $twitter->request("POST", $twitter->url("1/blocks/create")
        , array("screen_name" => $_REQUEST["screen_name"]));
      print "@${screenName}をブロックしました<br>";
      break;
    case "unblock":
      // 指定したユーザーをブロック解除する
      $twitter->request("POST", $twitter->url("1/blocks/destroy")
        , array("screen_name" => $_REQUEST["screen_name"]));
      print "@${screenName}をブロック解除しました<br>";
    break;
  }
  ?><br>
  <?php

}

// スクリーン名を取得
$twitter->request("GET", $twitter->url("1/account/verify_credentials"));
$screenName = json_decode($twitter->response["response"])->{"screen_name"};
print "@" . $screenName . "がブロックしているアカウント一覧:<br>";

// ブロックしているユーザー一覧を取得
$twitter->request("GET", $twitter->url("1/blocks/blocking"));
$blocks = json_decode($twitter->response["response"]);

foreach ($blocks as $user) {
  $screenName = $user->{"screen_name"};
  $profileImageURL = $user->{"profile_image_url"};
  print "<a href='./manage_blocks.php?command=unblock&screen_name=$screenName'>ブロック解除</a> <img src='$profileImageURL'/> @$screenName<br>";
}
?>
<form action="./manage_blocks.php" method="POST">
  <input type="hidden" name="command" value="block"/>
  ブロックするユーザ:<input type="text" name="screen_name"/><br>
  <input type="submit" value="ブロック"/>
</form>

</body>
</html>
