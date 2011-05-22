import twitter4j.Query;
import twitter4j.QueryResult;
import twitter4j.Tweet;
import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;

import java.util.List;

public class Search {
  public static void main(String[] args) {
    if (args.length < 1) {
      System.out.println("使用法: java Search [クエリ]");
      System.exit(-1);
    }
    Twitter twitter = new TwitterFactory().getInstance();
    try {
      QueryResult result = twitter.search(new Query(args[0]));
      System.out.println("検索結果を表示します:");
      List<Tweet> tweets = result.getTweets();
      for (Tweet tweet : tweets) {
        System.out.println("@" + tweet.getFromUser() + " - " + tweet.getText());
      }
      System.exit(0);
    } catch (TwitterException te) {
      te.printStackTrace();
      System.out.println("検索に失敗しました: " + te.getMessage());
      System.exit(-1);
    }
  }
}
