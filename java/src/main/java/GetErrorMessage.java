import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;
import twitter4j.User;

/**
 * @author Yusuke Yamamoto - yusuke at mac.com
 */
public class GetErrorMessage {
    public static void main(String[] args) {
        Twitter twitter = new TwitterFactory().getInstance();
        try {
            User user = twitter.showUser("nonexisting_user");
            // userについて何かする
        } catch (TwitterException te) {
            if(te.isErrorMessageAvailable()){
                System.out.println("エラーメッセージ:"+te.getErrorMessage());
                System.out.println("リクエストパス:"+te.getRequestPath());
            }
        }
    }
}
