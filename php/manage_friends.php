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
      // 指定したユーザーをフォローする
      $twitter->request("POST", $twitter->url("1/friendships/create")
        , array("screen_name" => $screenName));
      print "@${screenName}をフォローしました<br>";
      break;
    case "unfollow":
      // 指定したユーザーをフォロー解除する
      $twitter->request("POST", $twitter->url("1/friendships/destroy")
        , array("screen_name" => $screenName));
      print "@${screenName}をフォロー解除しました<br>";
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
  print "<a href='./manage_friends.php?command=unfollow&screen_name=$screenName'>フォロー解除</a> <img src='$profileImageURL'/> @$screenName<br>";
}
?>
<form action="./manage_friends.php" method="POST">
  <input type="hidden" name="command" value="follow"/>
  フォローするユーザー:<input type="text" name="screen_name"/><br>
  <input type="submit" value="フォロー"/>
</form>

</body>
</html>
