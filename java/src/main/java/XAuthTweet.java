import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;
import twitter4j.auth.AccessToken;

public final class XAuthTweet {
  public static void main(String[] args) {
    if (args.length < 3) {
      System.out.println("使用法: java XAuthTweet [スクリーン名] [パスワード] [テキスト]");
      System.exit(-1);
    }
    Twitter twitter = new TwitterFactory().getInstance();
    String consumerKey = "コンシューマキー";
    String consumerSecret = "コンシューマシークレット";

    // OAuth トークンを設定
    twitter.setOAuthConsumer(consumerKey, consumerSecret);
    try {
    // xAuth でアクセストークンを取得
      AccessToken accessToken = twitter.getOAuthAccessToken(args[0], args[1]);
      System.out.println("アクセストークン: " + accessToken.getToken());
      System.out.println("アクセストークンシークレット: " + accessToken.getTokenSecret());
      twitter.updateStatus(args[2]);
      System.out.println("ツイートしました: " + args[2]);
    } catch (TwitterException te) {
      System.out.println("ツイートに失敗しました: " + te.getMessage());
    }
  }
}
