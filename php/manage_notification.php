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
    case "follow":
      // 指定したユーザーの通知設定をする
      $twitter->request("POST", $twitter->url("1/notifications/follow")
        , array("screen_name" => $screenName));
      print "@${screenName}の通知を設定しました<br>";
      break;
    case "leave":
      // 指定したユーザーの通知を解除する
      $twitter->request("POST", $twitter->url("1/notifications/leave")
        , array("screen_name" => $screenName));
      print "@${screenName}の通知を解除しました<br>";
      break;
  }
  ?><br>
  <?php
}

// スクリーン名を取得
$twitter->request("GET", $twitter->url("1/account/verify_credentials"));
$screenName = json_decode($twitter->response["response"])->{"screen_name"};
print "@" . $screenName . "がフォローしているアカウント一覧:<br>";

// フォローしているアカウント一覧を取得
$twitter->request("GET", $twitter->url("1/statuses/friends"));
$friends = json_decode($twitter->response["response"]);

foreach ($friends as $friend) {
  $screenName = $friend->{"screen_name"};
  $profileImageURL = $friend->{"profile_image_url"};
  $notificationEnabled = $friend->{"notifications"};
  print "<a href='./manage_notification.php?command=" .
    ($notificationEnabled ? "leave" : "follow") .
    "&screen_name=$screenName'>通知". 
    ($notificationEnabled ? "解除" : "設定"). "</a> <img src='$profileImageURL'/> @$screenName<br>";
}
?>
</body>
</html>
