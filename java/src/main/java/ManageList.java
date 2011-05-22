import twitter4j.*;
import twitter4j.auth.AccessToken;

public class ManageList {
  public static void main(String[] args) {
    // 使用法: java ManageList [削除するリストID] または [リスト名] [リスト説明] またはパラメータなし(リスト一覧表示のみ)");
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
      if (args.length == 1) {
        // 指定したIDのリストを削除
        twitter.destroyUserList(Integer.parseInt(args[0]));
      } if(args.length == 2) {
        // 新規にリストを作成
        twitter.createUserList(args[0], true, args[1]);
      }
      // リストの一覧を表示
      PagableResponseList<UserList> lists = twitter.getUserLists(twitter.getScreenName(), -1l);
      for (UserList list : lists) {
        System.out.println(list.getName() + " - " + list.getDescription() + "(" + list.getId() + ")");
      }
    } catch (TwitterException te) {
      System.out.println("リストの更新に失敗しました: " + te.getMessage());
    }
  }
}
