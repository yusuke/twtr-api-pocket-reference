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

if(isset($_REQUEST["command"])) switch($_REQUEST["command"]){
  case "add":
    // 新規リストを作成する
    $twitter->request("POST", $twitter->url("1/lists/create")
      , array("name" => $_POST["name"],
        "description" => $_POST["description"]
      ));
    print "リスト" . htmlspecialchars($_POST["name"]) . "を作成しました<br>";
    break;
  case "delete":
    // 指定したIDのリストを削除する
    $twitter->request("POST", $twitter->url("1/lists/destroy")
      , array("list_id" => $_GET["id"],
      ));
    print "リスト id:" . htmlspecialchars($_GET["id"]) . " を削除しました<br>";
    break;
}
// リストの一覧を取得
$twitter->request("GET", $twitter->url("1/lists"));
$lists = json_decode($twitter->response["response"])->{"lists"};
foreach ($lists as $list) {
  print "<a href='./manage_list.php?command=delete&id=" . $list->{"id"} . "'>削除</a> " .
    htmlspecialchars($list->{"name"} . " - " . $list->{"description"}) . "<br>";
}
?>
<form action="./manage_list.php" method="POST">
  <input type="hidden" name="command" value="add"/>
  リスト名:<input type="text" name="name"/><br>
  説明:<input type="text" name="description"/><br>
  <input type="submit" value="リスト追加"/>
</form>
</body>
</html>
