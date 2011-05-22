import twitter4j.*;

public class ShowLocalTrends {
  public static void main(String[] args) {
    Twitter twitter = new TwitterFactory().getInstance();

    try {
      if(args.length == 0){
        ResponseList<Location> locations = twitter.getAvailableTrends();
        for (Location location : locations) {
          System.out.println(location.getName() + " - WOEID:" + location.getWoeid());
        }
      }else{
        Trends trends = twitter.getLocationTrends(Integer.parseInt(args[0]));
        for (Trend trend : trends.getTrends()) {
          System.out.println(trend.getName() + " - " + trend.getUrl());
        }
      }
      System.exit(0);
    } catch (TwitterException te) {
      te.printStackTrace();
      System.out.println("トレンドトピックの取得に失敗しました: " + te.getMessage());
      System.exit(-1);
    }
  }
}
