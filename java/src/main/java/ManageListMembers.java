import twitter4j.*;
import twitter4j.auth.AccessToken;

public class ManageListMembers {
  public static void main(String[] args) {
    // 使用法: java ManageListMembers [リストID] [コマンド add|delete] [追加または削除するメンバーのユーザID]
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
      if (args.length == 0) {
        // リストの一覧を表示
        System.out.println("@" + twitter.getScreenName() + " のリスト一覧:");
        PagableResponseList<UserList> lists = twitter.getUserLists(twitter.getScreenName(), -1l);
        for (UserList list : lists) {
          System.out.println(list.getName() + " - " + list.getDescription() + "(" + list.getId() + ")");
        }
      } else {
        int listId = Integer.parseInt(args[0]);
        if (args.length == 3) {
          String command = args[1];
          long userId = Long.parseLong(args[2]);
          if ("add".equals(command)) {
            twitter.addUserListMember(listId, userId);
            System.out.println("リスト id:" + listId + " に ユーザID: " + userId + " を追加しました");
          } else if ("delete".equals(command)) {
            twitter.deleteUserListMember(listId, userId);
            System.out.println("リスト id:" + listId + " から ユーザID: " + userId + " を削除しました");
          }
        }
        if (args.length == 2) {
          // 新規にリストを作成
          twitter.createUserList(args[0], true, args[1]);
        }
        // リストメンバーの一覧を表示
        System.out.println("リスト id:" + listId + " のメンバー一覧:");
        PagableResponseList<User> users = twitter.getUserListMembers(twitter.getId(), listId, -1l);
        for (User user : users) {
          System.out.println("@" + user.getScreenName() + "(" + user.getId() + ")");
        }
      }
    } catch (TwitterException te) {
      System.out.println("リストの取得に失敗しました: " + te.getMessage());
    }
  }
}
