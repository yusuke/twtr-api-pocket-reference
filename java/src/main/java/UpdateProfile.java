import twitter4j.*;
import twitter4j.auth.AccessToken;

public class UpdateProfile {
  public static void main(String[] args) {
    if(args.length < 4){
     System.out.println("使用法: java UpdateProfile [名前] [url] [場所] [説明]");
     System.exit(0);
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
      twitter.updateProfile(args[0], args[1], args[2], args[3]);
      System.out.println("プロファイルをアップデートしました");
    } catch (TwitterException te) {
      System.out.println("API呼び出しに失敗しました: " + te.getMessage());
    }
  }
}
