<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body><?php
// tmhOAuthを初期化
require "./tmhOAuth.php";
$twitter = new tmhOAuth(array());

// パブリックタイムラインを取得
$twitter->request("GET", $twitter->url("1/statuses/public_timeline"));
$publicTimeline = json_decode($twitter->response["response"]);
// ツイート毎にスクリーン名とツイート本文を表示
print "最新のパブリックタイムライン<br>";
foreach ($publicTimeline as $tweet) {
  $screenName = $tweet->{"user"}->{"screen_name"};
  $profileImageURL = $tweet->{"user"}->{"profile_image_url"};
  print "<img src='${profileImageURL}'> @${screenName} - " . htmlspecialchars($tweet->{"text"}) . "<br>";
}
?>
</body>
</html>
