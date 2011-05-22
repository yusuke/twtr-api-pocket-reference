<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form action="print_filter_stream.php" method="POST">
  <input type="text" name="track" size="50"/><br>
  <input type="submit" value="フィルタ"/>
</form>
<?php
if (isset($_POST["track"])) {
  print htmlspecialchars($_POST["track"]) . "のフィルタ結果:<br>";

  // tmhOAuthを初期化。
  require './tmhOAuth.php';
  $twitter = new tmhOAuth(
  // 実際に取得したコンシューマキー、アクセストークンを記述
    array("consumer_key" => "コンシューマキー",
         "consumer_secret" => "コンシューマシークレット",
         "user_token" => "アクセストークン",
         "user_secret" => "アクセストークンシークレット"));

  //filterメソッドを呼び出す。tmhOAuthはツイートを受け取るごとにfilter_callback関数を呼び出す
  $twitter->streaming_request(
    "POST", "http://stream.twitter.com/1/statuses/filter.json"
    , array("track" => $_POST["track"]), "filter_callback");

}

//受け取ったツイート数カウント用
$count = 0;

//ツイートを受け取るコールバック関数
function filter_callback($data, $length, $metrics)
{
  global $count;
  $tweet = json_decode($data);
  $screenName = $tweet->{"user"}->{"screen_name"};
  $profileImageURL = $tweet->{"user"}->{"profile_image_url"};
  print "<table><tr><td><img src='$profileImageURL'/></td><td>@$screenName<br>";
  print htmlspecialchars($tweet->{"text"}) . "</td></tr></table>";
  //ツイートを5つ受け取ったらfalseを返して終了する
  return ++$count == 5;
}
?>
</body>
</html>
