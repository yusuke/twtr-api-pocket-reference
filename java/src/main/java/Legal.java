import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;

public class Legal {
  public static void main(String[] args) {
    Twitter twitter = new TwitterFactory().getInstance();

    try {
      System.out.println("利用規約:");
      System.out.println(twitter.getTermsOfService());
      System.out.println("プライバシーポリシー:");
      System.out.println(twitter.getPrivacyPolicy());
    } catch (TwitterException te) {
      te.printStackTrace();
      System.out.println("APIの呼び出しに失敗しました: " + te.getMessage());
      System.exit(-1);
    }
  }
}
