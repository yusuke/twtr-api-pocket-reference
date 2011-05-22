import twitter4j.*;
import twitter4j.auth.AccessToken;

public class SearchUsers {
  public static void main(String[] args) {
    if (args.length < 1) {
      System.out.println("使用法: java SearchUsers [クエリ]");
      System.exit(-1);
    }
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
      ResponseList<User> users = twitter.searchUsers(args[0], 1);
      System.out.println("検索結果を表示します:");
      for (User user : users) {
        System.out.println("@" + user.getScreenName() + " - " + user.getName());
      }
      System.exit(0);
    } catch (TwitterException te) {
      te.printStackTrace();
      System.out.println("検索に失敗しました: " + te.getMessage());
      System.exit(-1);
    }
  }
}
