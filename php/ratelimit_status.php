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
$twitter->request("GET", $twitter->url("1/account/rate_limit_status"));
$ratelimit_status = json_decode($twitter->response["response"]);
$reset_time_in_seconds = $ratelimit_status->{"reset_time_in_seconds"};
$reset_time = $ratelimit_status->{"reset_time"};
$remaining_hits = $ratelimit_status->{"remaining_hits"};
$hourly_limit = $ratelimit_status->{"hourly_limit"};
?>
<pre>
reset_time_in_seconds:<?=$reset_time_in_seconds?>

reset_time:<?=$reset_time?>

remaining_hits:<?=$remaining_hits?>

hourly_limit:<?=$hourly_limit?>
</pre>
</body>
</html>
