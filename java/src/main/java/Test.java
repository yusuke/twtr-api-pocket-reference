import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;

public class Test {
  public static void main(String[] args) {
    Twitter twitter = new TwitterFactory().getInstance();
    try {
      boolean ok = twitter.test();
      System.out.println(ok ? "APIの呼び出しに成功しました" : "APIの呼び出しに失敗しました");
    } catch (TwitterException te) {
      te.printStackTrace();
      System.out.println("APIの呼び出しに失敗しました: " + te.getMessage());
      System.exit(-1);
    }
  }
}
