<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form action="./direct_messages.php" method="POST">
  メッセージの宛先: <input type="text" name="to_user"/><br>
  メッセージ: <input type="text" name="text" size="50"/><br>
  <input type="submit" value="ダイレクトメッセージ送信"/>
</form>
<?php
// tmhOAuthを初期化
require "./tmhOAuth.php";
$twitter = new tmhOAuth(
  // 実際に取得したコンシューマキー、アクセストークンを記述
  array("consumer_key" => "コンシューマキー",
    "consumer_secret" => "コンシューマシークレット",
    "user_token" => "アクセストークン",
    "user_secret" => "アクセストークンシークレット"));

if (isset($_POST["text"])) {
  $toUser = htmlspecialchars($_POST["to_user"]);
  // ダイレクトメッセージを送信する
  $twitter->request("POST", $twitter->url("1/direct_messages/new")
    , array("screen_name" => $toUser, "text" => $_POST["text"]));
  print "@${toUser}へメッセージを送信しました:" . htmlspecialchars($_POST["text"]) . "<br>";
}

// ダイレクトメッセージの一覧を取得
$twitter->request("GET", $twitter->url("1/direct_messages"));
$response = json_decode($twitter->response["response"]);
print "受信したダイレクトメッセージ:<br>";
foreach ($response as $directMessage) {
  $sender = $directMessage->{"sender_screen_name"};
  $senderProfileImageURL = $directMessage->{"sender"}->{"profile_image_url"};
  $text = $directMessage->{"text"};
  print "<img src='$senderProfileImageURL'/> @$sender $text<br>";
}
?>

</body>
</html>
