<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
// tmhOAuthを初期化
require "./tmhOAuth.php";
$twitter = new tmhOAuth(array());
$twitter->request("GET", $twitter->url("1/users/show")
        , array("screen_name" => "nonexisting_user"));
if ($twitter->response["code"] != 200) {
  $ratelimit_status = json_decode($twitter->response["response"]);
  $error_message = $ratelimit_status->{"error"};
  $request = $ratelimit_status->{"request"};
  // エラー処理
  print "error_message:" . $error_message . "<br>";
  print "request:" . $request . "<br>";
}
?>
<pre>
</pre>
</body>
</html>
