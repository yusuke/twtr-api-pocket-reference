import twitter4j.*;
import twitter4j.auth.AccessToken;

import java.util.ArrayList;
import java.util.Arrays;

public class PrintFilterStream {
  public static void main(String[] args) throws TwitterException {
    if (args.length < 1) {
      System.out.println("使用法: java PrintFilterStream [カンマ区切りのフィルタ句]");
      System.exit(-1);
    }

    TwitterStream twitterStream = new TwitterStreamFactory().getInstance();
    String consumerKey = "コンシューマキー";
    String consumerSecret = "コンシューマシークレット";
    String accessToken = "アクセストークン";
    String accessTokenSecret = "アクセストークンシークレット";

    // OAuth トークンを設定
    twitterStream.setOAuthConsumer(consumerKey, consumerSecret);
    twitterStream.setOAuthAccessToken(new AccessToken(accessToken, accessTokenSecret));

    twitterStream.addListener(new MyStatusAdapter());
    ArrayList<String> track = new ArrayList<String>();
    track.addAll(Arrays.asList(args[0].split(",")));
    String[] trackArray = track.toArray(new String[track.size()]);

    // filter() メソッドは内部的にスレッドを生成し、必要なリスナメソッドを継続的に呼び出します
    twitterStream.filter(new FilterQuery(0, null, trackArray));
  }
}

class MyStatusAdapter extends StatusAdapter {
  public void onStatus(Status status) {
    System.out.println("@" + status.getUser().getScreenName() + " - " + status.getText());
  }
}
