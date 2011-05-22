import twitter4j.*;
import twitter4j.auth.AccessToken;

public class ManageListSubscription {
  public static void main(String[] args) {
    if (args.length == 0) {
      System.out.println("使用法: java ManageListSubscription [スクリーン名] [コマンド subscribe|unsubscribe] [購読するリストのID]");
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

    String screenName = args[0];

    try {
      if (args.length == 3) {
        String command = args[1];
        int listId = Integer.parseInt(args[2]);
        if ("subscribe".equals(command)) {
          twitter.subscribeUserList(screenName, listId);
          System.out.println("リスト id:" + listId + " を購読しました");
        } else if ("unsubscribe".equals(command)) {
          twitter.unsubscribeUserList(screenName, listId);
          System.out.println("リスト id:" + listId + " を購読解除しました");
        }
      }
      // リストの一覧を表示
      System.out.println("@" + screenName + " のリスト一覧:");
      PagableResponseList<UserList> lists = twitter.getUserLists(screenName, -1l);
      for (UserList list : lists) {
        // 購読中かどうか判定
        boolean subscribing = false;
        try {
          twitter.checkUserListSubscription(screenName, list.getId(), twitter.getId());
          subscribing = true;
        } catch (TwitterException ignore) {
          //購読していなければ例外が発生
        }
        System.out.print(subscribing ? "購読中 " : "未購読 ");
        System.out.println(list.getName() + " - " + list.getDescription() + "(" + list.getId() + ")");
      }
    } catch (TwitterException te) {
      System.out.println("リストの取得に失敗しました: " + te.getMessage());
    }
  }
}
