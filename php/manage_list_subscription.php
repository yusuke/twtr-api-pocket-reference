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

if (isset($_REQUEST["screen_name"])) {
  $screenName = htmlspecialchars($_REQUEST["screen_name"]);

  switch($_REQUEST["command"]){
    case "subscribe":
      $list_id = htmlspecialchars($_REQUEST["list_id"]);
      // 指定したリストを購読する
      $twitter->request("POST", $twitter->url("1/lists/subscribers/create")
        , array("list_id" => $list_id));
      print "リストID:  $list_id を購読開始しました<br>";
      break;
    case "unsubscribe":
      $list_id = htmlspecialchars($_REQUEST["list_id"]);
      // 指定したリストの購読を解除する
      $twitter->request("POST", $twitter->url("1/lists/subscribers/destroy")
        , array("list_id" => $list_id));
      print "リストID: $list_id を購読解除しました<br>";
      break;
  }
  // リストの一覧を取得
  $twitter->request("GET", $twitter->url("1/lists")
      , array("screen_name" => $screenName));
  $lists = json_decode($twitter->response["response"])->{"lists"};
  print "@${screenName}のリスト一覧:<br>";

  $twitter->request("GET", $twitter->url("1/account/verify_credentials"));
  $myUserId = json_decode($twitter->response["response"])->{"id"};

  foreach ($lists as $list) {
    // 購読状況を確認
    $twitter->request("GET", $twitter->url("1/lists/subscribers/show")
      , array("list_id" => $list->{"id"}, "user_id" => $myUserId));

    // 購読している場合は200、していない場合は404が返る
    $subscribing = 200 == $twitter->response["code"];
    if($subscribing){
      print "<a href='./manage_list_subscription.php?command=unsubscribe&list_id=" . $list->{"id"}
        . "&screen_name=${screenName}'>購読解除</a> ";
    }else{
      print "<a href='./manage_list_subscription.php?command=subscribe&list_id=" . $list->{"id"}
        . "&screen_name=${screenName}'>購読</a> ";
    }
    print htmlspecialchars($list->{"name"} . " - " . $list->{"description"}) . "<br>";
  }
}
?><br>

<form action="./manage_list_subscription.php" method="GET">
  <input type="hidden" name="command" value="show"/>
  リスト一覧を取得するスクリーン名:@<input type="text" name="screen_name"/><br>
  <input type="submit" value="リスト一覧を表示"/>
</form>
</body>
</html>
