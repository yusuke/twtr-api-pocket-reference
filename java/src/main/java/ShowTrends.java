import twitter4j.*;

public class ShowTrends {
  public static void main(String[] args) {
    Twitter twitter = new TwitterFactory().getInstance();

    try {
      Trends trends = twitter.getTrends();
      for (Trend trend : trends.getTrends()) {
        System.out.println(trend.getName() + " - " + trend.getUrl());
      }
      System.exit(0);
    } catch (TwitterException te) {
      te.printStackTrace();
      System.out.println("トレンドトピックの取得に失敗しました: " + te.getMessage());
      System.exit(-1);
    }
  }
}
