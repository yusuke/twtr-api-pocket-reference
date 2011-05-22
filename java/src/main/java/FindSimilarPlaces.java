import twitter4j.GeoLocation;
import twitter4j.Place;
import twitter4j.SimilarPlaces;
import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;

public final class FindSimilarPlaces {
  public static void main(String[] args) {
    if (args.length < 3) {
      System.out.println("使用法: java FindSimilarPlaces [緯度] [経度] [名前]");
      System.exit(-1);
    }
    try {
      Twitter twitter = new TwitterFactory().getInstance();

      GeoLocation location = new GeoLocation(Double.parseDouble(args[0]), Double.parseDouble(args[1]));
      String name = args[2];
      SimilarPlaces places = twitter.getSimilarPlaces(location, name, null, null);
      System.out.println("token: " + places.getToken());
      if (places.size() == 0) {
        System.out.println("指定した条件で場所は見つかりませんでした");
      } else {
        for (Place place : places) {
          System.out.println("id: " + place.getId() + " 名前: " + place.getFullName());
        }
      }
      System.exit(0);
    } catch (TwitterException te) {
      te.printStackTrace();
      System.out.println("API呼び出しに失敗しました: " + te.getMessage());
      System.exit(-1);
    }
  }
}
