import twitter4j.PagableResponseList;
import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;
import twitter4j.User;
import twitter4j.auth.AccessToken;

public class ManageNotification {
  public static void main(String[] args) {
    // 使用法: java ManageNotification [コマンド follow / leave] [スクリーン名]
    Twitter twitter = new TwitterFactory().getInstance();
    // 実際に取得したコンシューマキー、アクセストークンを記述
    String consumerKey = "コンシューマキー";
    String consumerSecret = "コンシューマシークレット";
    String accessToken = "アクセストークン";
    String accessTokenSecret = "アクセストークンシークレット";

    // OAuth トークンを設定
    twitter.setOAuthConsumer(consumerKey, consumerSecret);
    twitter.setOAuthAccessToken(new AccessToken(accessToken, accessTokenSecret));
    try {
      if (args.length == 2) {
        String command = args[0];
        String screenName = args[1];
        if ("follow".equals(command)) {
          twitter.enableNotification(screenName);
          System.out.println("@" + screenName + "の通知を設定しました");
        } else if ("leave".equals(command)) {
          twitter.disableNotification(screenName);
          System.out.println("@" + screenName + "の通知を解除しました");
        }
      }
      System.out.println("@" + twitter.getScreenName() + "がフォローしているユーザー一覧:");
      PagableResponseList<User> users = twitter.getFriendsStatuses(-1);
      for (User user : users) {
        System.out.println("@" + user.getScreenName());
      }
    } catch (TwitterException te) {
      System.out.println("API呼び出しに失敗しました: " + te.getMessage());
    }
  }
}
