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

if (isset($_POST["command"]) && $_POST["command"] == "update") {
  // アカウント情報をアップデートする
print $_POST["name"];
  $twitter->request("POST", $twitter->url("1/account/update_profile")
    , array("name" => $_POST["name"]
    , "url" => $_POST["url"]
    , "location" => $_POST["location"]
    , "description" => $_POST["description"]));
    print "アカウント情報をアップデートしました<br>";
}else{
  $twitter->request("GET", $twitter->url("1/account/verify_credentials"));
}
// ユーザ情報を取得
$myself = json_decode($twitter->response["response"]);
$screenName = $myself->{"screen_name"};
$name = $myself->{"name"};
$url = $myself->{"url"};
$location = $myself->{"location"};
$description = $myself->{"description"};
?>
<?=$screenName?>のアカウント情報:<br>

<form action="./manage_account.php" method="POST">
  <input type="hidden" name="command" value="update"/>
  名前: <input type="text" name="name" value="<?=htmlspecialchars($name)?>"/><br>
  URL: <input type="text" name="url" value="<?=htmlspecialchars($url)?>"/><br>
  場所: <input type="text" name="location" value="<?=htmlspecialchars($location)?>"/><br>
  説明: <input type="text" name="description" value="<?=htmlspecialchars($description)?>"/><br>
  <input type="submit" value="アカウント情報を更新"/>
</form>

</body>
</html>
