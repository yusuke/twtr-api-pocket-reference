import twitter4j.*;
import twitter4j.auth.AccessToken;

public class ManageFavorites {
  public static void main(String[] args) {
    // 使用法: java ManageFavorites [コマンド add / delete] [id]
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
        long id = Long.parseLong(args[1]);
        if ("add".equals(command)) {
          twitter.createFavorite(id);
          System.out.println(id + " をお気に入り登録しました");
        } else if ("delete".equals(command)) {
          twitter.destroyFavorite(id);
          System.out.println(id + " をお気に入り解除しました");
        }
      }
      System.out.println("@" + twitter.getScreenName() + "のお気に入り一覧:");
      ResponseList<Status> favorites = twitter.getFavorites();
      for (Status status : favorites) {
        System.out.println("@" + status.getUser().getScreenName() + " - " + status.getText() + "(id:" + status.getId() + ")");
      }
    } catch (TwitterException te) {
      System.out.println("API呼び出しに失敗しました: " + te.getMessage());
    }
  }
}
