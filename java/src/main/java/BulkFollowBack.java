import twitter4j.IDs;
import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;
import twitter4j.auth.AccessToken;

public class BulkFollowBack {
  public static void main(String[] args) throws TwitterException {
    Twitter twitter = new TwitterFactory().getInstance();
    // 実際に取得したコンシューマキー、アクセストークンを記述
    String consumerKey = "コンシューマキー";
    String consumerSecret = "コンシューマシークレット";
    String accessToken = "アクセストークン";
    String accessTokenSecret = "アクセストークンシークレット";

    // OAuth トークンを設定
    twitter.setOAuthConsumer(consumerKey, consumerSecret);
    twitter.setOAuthAccessToken(new AccessToken(accessToken, accessTokenSecret));

    // フォロワーのリストを取得
    IDs followers = twitter.getFollowersIDs(-1);
    long[] followersIDs = followers.getIDs();

    // フォローしているアカウントのリストを取得
    IDs friends = twitter.getFriendsIDs(-1);
    long[] friendsIDs = friends.getIDs();


    //フォロワーに対して総当たりでフォローしているかどうか確認
    for (long follower : followersIDs) {
      boolean isFollowing = false;
      for (long friend : friendsIDs) {
        if (friend == follower) {
          // 既にフォローしている
          isFollowing = true;
          break;
        }
      }
      //フォローする
      if (isFollowing) {
        System.out.println("id:" + follower + "は既にフォローしています");
      } else {
        // フォロー保留中のアカウントのリストを取得
        IDs pendingFollowRequests = twitter.getOutgoingFriendships(-1);
        long[] pendingFollowRequestIDs = pendingFollowRequests.getIDs();
        boolean followPending = false;
        for (long pendingFollow : pendingFollowRequestIDs) {
          if (pendingFollow == follower) {
            followPending = true;
          }
        }
        if (followPending) {
          System.out.println("id:" + follower + "のフォローは保留されています");
        } else {
          System.out.println("id:" + follower + "をフォローします");
          twitter.createFriendship(follower);
        }
      }
    }
  }
}
