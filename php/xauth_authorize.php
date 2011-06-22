<?php
//簡単なサンプルとしてPHPのコード例を示しますが、
//携帯用アプリケーションを除き、本来WebインターフェースしかないアプリケーションでxAuthを使うべきではありません。
//代わりにOAuth、またはSign in with Twitterを使うべきです。

//tmhOAuthを初期化
require "./tmhOAuth.php";
$twitter = new tmhOAuth(
  // 実際に取得したコンシューマキーを記述
  array("consumer_key" => "コンシューマキー",
    "consumer_secret" => "コンシューマシークレット"));

$here = $twitter->php_self();
session_start();

if(isset($_REQUEST["command"])) switch($_REQUEST["command"]){
  case "authorize":
    //スクリーン名とパスワードを渡してアクセストークンを取得し、セッションに格納
    $twitter->request("POST", $twitter->url("oauth/access_token", ""),
      array(
        "x_auth_username" => $_POST["screenname"],
        "x_auth_password" => $_POST["password"],
        "x_auth_mode" => "client_auth"
      ));
    $_SESSION["access_token"] = $twitter->extract_params($twitter->response["response"]);
    break;

  case "tweet":
    // ツイートする
    $twitter->config["user_token"] = $_SESSION["access_token"]["oauth_token"];
    $twitter->config["user_secret"] = $_SESSION["access_token"]["oauth_token_secret"];
    $twitter->request("POST", $twitter->url("1/statuses/update"), array("status" => $_POST["tweet"]));
    print "ツイートしました:" . htmlspecialchars($_POST["tweet"]);
    break;

  case "logout":
    //セッションに格納されているアクセストークンを破棄してログアウト
    session_unset();
    break;
}
?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
if (isset($_SESSION["access_token"])) {
  //アクセストークンがセッションに存在するのでOAuth認可済
  ?>
<form action="xauth_authorize.php" method="POST">
  いまどうしてる？ <input type="text" name="tweet" size="50"/><br>
  <input type="hidden" name="command" value="tweet"/>
  <input type="submit" value="ツイート"/>
</form>
<a href="?command=logout">ログアウト</a>
  <?php
} else {
  ?>
<form action="xauth_authorize.php" method="POST">
  ユーザID:<input type="text" name="screenname" size="50"/><br>
  パスワード:<input type="password" name="password" size="50"/><br>
  <input type="hidden" name="command" value="authorize"/>
  <input type="submit" value="xAuth認可"/>
</form>
  <?php
}?>
</body>
</html>
