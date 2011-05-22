import twitter4j.*;
import twitter4j.auth.AccessToken;

public final class DirectMessages {
  public static void main(String[] args) {
    // 使用法: java DirectMessages [送信先] [メッセージ]

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
      if(args.length == 2){
        String recipientScreenName = args[0];
        String text = args[1];
        twitter.sendDirectMessage(recipientScreenName, text);
        System.out.println("@"+recipientScreenName+"にメッセージを送信しました");
      }
      System.out.println("受信したダイレクトメッセージ:");
      ResponseList<DirectMessage> messages = twitter.getDirectMessages();
      for(DirectMessage message : messages){
        System.out.println("@" + message.getSenderScreenName() + " - " +message.getText());
      }
    } catch (TwitterException te) {
      System.out.println("ダイレクトメッセージの処理に失敗しました: " + te.getMessage());
    }
  }
}
