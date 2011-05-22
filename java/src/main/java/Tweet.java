import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;
import twitter4j.auth.AccessToken;

public final class Tweet {
  public static void main(String[] args) {
    if (args.length < 1) {
      System.out.println("使用法: java Tweet [テキスト]");
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
      twitter.updateStatus(args[0]);
      System.out.println("ツイートしました: " + args[0]);
    } catch (TwitterException te) {
      System.out.println("ツイートに失敗しました: " + te.getMessage());
    }
  }
}
