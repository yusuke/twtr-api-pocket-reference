<?php
//tmhOAuthを初期化
require "./tmhOAuth.php";
$twitter = new tmhOAuth(
  // 実際に取得したコンシューマキーを記述
  array("consumer_key" => "コンシューマキー",
       "consumer_secret" => "コンシューマシークレット"));

$here = $twitter->php_self();
session_start();

if(isset($_REQUEST["command"])) switch($_REQUEST["command"]){
  case "signin":
    //OAuth認証、まずリクエストトークンを取得
    $twitter->request("POST", $twitter->url("oauth/request_token", "")
      , array("oauth_callback" => $here . "?command=callback"));
    //リクエストトークンはコールバックを受けてアクセストークンを取得する歳に必要なのでセッションに格納
    $_SESSION["request_token"] = $twitter->extract_params($twitter->response["response"]);
    //Twitterの認可画面へリダイレクト
    header("Location: " . $twitter->url("oauth/authenticate", "") . "?oauth_token={$_SESSION["request_token"]["oauth_token"]}");
    break;

  case "callback":
    // Twitterからコールバックを受けとった
    $twitter->config["user_token"] = $_SESSION["request_token"]["oauth_token"];
    $twitter->config["user_secret"] = $_SESSION["request_token"]["oauth_token_secret"];

    //oauth_verifierを渡し、アクセストークンを取得してセッションに格納
    $twitter->request("POST", $twitter->url("oauth/access_token", "")
      , array("oauth_verifier" => $_REQUEST["oauth_verifier"]));
    $_SESSION["access_token"] = $twitter->extract_params($twitter->response["response"]);
    //リクエストトークンは不要(無効)になったので破棄
    unset($_SESSION["request_token"]);
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
  <form action="sign_in_with_twitter.php" method="POST">
    いまどうしてる？ <input type="text" name="tweet" size="50"/><br>
    <input type="hidden" name="command" value="tweet"/>
    <input type="submit" value="ツイート"/>
  </form>
  <a href="?command=logout">サインアウト</a>
<?php
} else {
?>
  <a href="?command=signin">サインイン</a>
<?php
}?>
</body>
</html>
