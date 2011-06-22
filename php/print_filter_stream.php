<?php
if (isset($argv[1])) {
  // tmhOAuthを初期化
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
    , array("track" => $argv[1]), "filter_callback");
  $twitter->pr($twitter);
}
//ツイートを受け取るコールバック関数
function filter_callback($data, $length, $metrics) {
  $tweet = json_decode($data);
  $screenName = $tweet->{"user"}->{"screen_name"};
  $text = $tweet->{"text"};
  print "@$screenName - $text \n";
}
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
このサンプルプログラムはコマンドラインから起動します。<br>
使用法: php print_filter_stream.php フィルタ句1,フィルタ句2,...
</body>
</html>
