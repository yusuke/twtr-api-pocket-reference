import twitter4j.Status;
import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;

import java.util.List;

public class ShowPublicTimeline {
  public static void main(String[] args) {
    Twitter twitter = new TwitterFactory().getInstance();
    try {
      // パブリックタイムラインを取得
      List<Status> statuses = twitter.getPublicTimeline();
      System.out.println("パブリックタイムラインを表示します:");
      // ツイート毎にスクリーン名とツイート本文を表示
      for (Status status : statuses) {
        System.out.println("@" + status.getUser().getScreenName() + " - " + status.getText());
      }
      System.exit(0);
    } catch (TwitterException te) {
      te.printStackTrace();
      System.out.println("タイムラインの取得に失敗しました: " + te.getMessage());
      System.exit(-1);
    }
  }
}
