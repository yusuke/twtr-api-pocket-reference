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

$twitter->request("GET", $twitter->url("1/account/verify_credentials"));
// スクリーン名を取得
$screenName = json_decode($twitter->response["response"])->{"screen_name"};

if(isset($_REQUEST["command"])){
  $list_id = htmlspecialchars($_REQUEST["list_id"]);
  switch($_REQUEST["command"]){
    case "add":
      $screen_name = htmlspecialchars($_REQUEST["screen_name"]);
      // 指定したユーザIDをリストに追加する
      $twitter->request("POST", $twitter->url("1/lists/members/create")
        , array("list_id" => $_REQUEST["list_id"], "screen_name" => $screen_name));
      print "リストID: $list_id に @$screen_name を追加しました<br>";
      break;
    case "delete":
      $screen_name = htmlspecialchars($_REQUEST["screen_name"]);
      // 指定したユーザIDをリストメンバーから外す
      $twitter->request("POST", $twitter->url("1/lists/members/destroy")
        , array("list_id" => $_REQUEST["list_id"], "screen_name" => $screen_name));
      print "リストID: $list_id から @$screen_name を削除しました<br>";
      break;
  }
  // リストメンバーを取得
  $twitter->request("GET", $twitter->url("1/lists/members")
      , array("list_id" => $_REQUEST["list_id"]));
  $users = json_decode($twitter->response["response"])->{"users"};
  print "リストID: $list_id のメンバー一覧:<br>";

  foreach ($users as $user) {
    print "<a href='./manage_list_members.php?command=delete&screen_name=" . $user->{"screen_name"}
      . "&list_id=" . $list_id . "'>メンバーを削除</a> @" . $user->{"screen_name"} . "<br>";
  }
  ?><br>
<form action="./manage_list_members.php" method="POST">
  <input type="hidden" name="command" value="add"/>
  <input type="hidden" name="list_id" value="<?=$list_id?>"/>
  追加するスクリーン名:<input type="text" name="screen_name"/><br>
  <input type="submit" value="リストに追加"/>
</form>
  <?php

} else {
  // リストの一覧を取得
  $twitter->request("GET", $twitter->url("1/lists"));
  $lists = json_decode($twitter->response["response"])->{"lists"};
  print "@" . $screenName . "のリスト一覧:<br>";
  foreach ($lists as $list) {
    print "<a href='./manage_list_members.php?command=show_members&list_id=" . $list->{"id"} . "'>メンバーを表示</a> " .
      htmlspecialchars($list->{"name"} . " - " . $list->{"description"}) . "<br>";
  }
}
?>
</body>
</html>
