<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body><?php
require "./tmhOAuth.php";

// OAuth トークンを設定
$twitter = new tmhOAuth(
  // 実際に取得したコンシューマキー、アクセストークンを記述
  array("consumer_key" => "コンシューマキー",
       "consumer_secret" => "コンシューマシークレット",
       "user_token" => "アクセストークン",
       "user_secret" => "アクセストークンシークレット"));

// フォロワーのリストを取得
$twitter->request("GET", $twitter->url("1/followers/ids"));
$followersIDs = json_decode($twitter->response["response"]);

// フォローしているアカウントのリストを取得
$twitter->request("GET", $twitter->url("1/friends/ids"));
$friendsIDs = json_decode($twitter->response["response"]);

//フォロワーに対して総当たりでフォローしているかどうか確認
foreach ($followersIDs as $follower) {
  $isFollowing = false;
  foreach ($friendsIDs as $friend) {
    if ($follower == $friend) {
      $isFollowing = true;
      break;
    }
  }
  //フォローしていないアカウントなのでフォローする
  if ($isFollowing) {
    print "id:${follower}は既にフォローしています<br>";
  } else {
    // フォロー保留中のアカウントのリストを取得
    $twitter->request("GET", $twitter->url("1/friendships/outgoing"));
    $pendingFriendIDs = json_decode($twitter->response["response"])->{"ids"};
    $followPending = false;
    foreach ($pendingFriendIDs as $pendingFriend) {
      if ($follower == $pendingFriend) {
        $followPending = true;
        break;
      }
    }
    if ($followPending) {
      print "id:${follower}のフォローは保留されています<br>";
    } else {
      print "id:${follower}をフォローします<br>";
      $twitter->request("POST", $twitter->url("1/friendships/create")
        , array("user_id" => $follower));
    }
  }
}
?>Ok
</body>
</html>
