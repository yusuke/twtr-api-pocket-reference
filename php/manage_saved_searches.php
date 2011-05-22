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
  switch($_REQUEST["command"]){
    case "create":
      // 保存した検索を作成する
      $query = $_REQUEST["query"];
      $twitter->request("POST", $twitter->url("1/saved_searches/create")
        , array("query" => $query));
      print "新しい保存した検索: " . htmlspecialchars($query) . " を作成しました<br>";
      break;
    case "delete":
      // 指定した保存した検索を削除する
      $twitter->request("DELETE", $twitter->url("1/saved_searches/destroy/" . $_REQUEST["id"]));
      print "保存した検索を削除しました<br>";
      break;
  }
  ?><br>
  <?php
}

// スクリーン名を取得
$twitter->request("GET", $twitter->url("1/account/verify_credentials"));
$screenName = json_decode($twitter->response["response"])->{"screen_name"};
print "@" . $screenName . "の保存した検索一覧:<br>";

// 保存した検索一覧を取得
$twitter->request("GET", $twitter->url("1/saved_searches"));
$savedSearches = json_decode($twitter->response["response"]);
foreach ($savedSearches as $savedSearch) {
  print "<a href='./manage_saved_searches.php?command=delete&id=" . $savedSearch->{"id_str"} . "'>削除</a> "
    . htmlspecialchars($savedSearch->{"query"}) . "<br>";
}
?>
<form action="./manage_saved_searches.php" method="POST">
  <input type="hidden" name="command" value="create"/>
  保存する検索:<input type="text" name="query"/><br>
  <input type="submit" value="保存した検索を作成"/>
</form>

</body>
</html>
