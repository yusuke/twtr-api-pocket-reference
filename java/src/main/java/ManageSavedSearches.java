import twitter4j.*;
import twitter4j.auth.AccessToken;

import java.util.List;

public class ManageSavedSearches {
  public static void main(String[] args) {
    // 使用法: java ManageSavedSearches [コマンド create / delete] [新規作成するクエリ / 削除するid]
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
        if ("create".equals(command)) {
          String query = args[1];
          twitter.createSavedSearch(query);
          System.out.println("新しい保存した検索 " + query + " を作成しました");
        } else if ("delete".equals(command)) {
          int id = Integer.parseInt(args[1]);
          twitter.destroySavedSearch(id);
          System.out.println("保存した検索を削除しました");
        }
      }
      System.out.println("@" + twitter.getScreenName() + "の保存した検索一覧:");
      List<SavedSearch> savedSearches = twitter.getSavedSearches();
      for (SavedSearch savedSearch : savedSearches) {
        System.out.println(savedSearch.getQuery() + " (id:" + savedSearch.getId() + ")");
      }
    } catch (TwitterException te) {
      System.out.println("API呼び出しに失敗しました: " + te.getMessage());
    }
  }
}
