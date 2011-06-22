import twitter4j.RateLimitStatus;
import twitter4j.ResponseList;
import twitter4j.Status;
import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;

/**
 * @author Yusuke Yamamoto - yusuke at mac.com
 */
public final class GetRateLimitStatus {
    /**
     * Usage: java twitter4j.examples.account.GetRateLimitStatus
     *
     * @param args message
     */
    public static void main(String[] args) {
        try {
            Twitter twitter = new TwitterFactory().getInstance();
            // 明示的にレートリミットステータスを取得する
            RateLimitStatus rateLimitStatus = twitter.getRateLimitStatus();
            printRateLimitStatus(rateLimitStatus);

             ResponseList<Status> statuses = twitter.getPublicTimeline();
            // statusesについて何かする
            
            // レスポンスヘッダに含まれるレートリミットステータスを取得
            rateLimitStatus = statuses.getRateLimitStatus();
            printRateLimitStatus(rateLimitStatus);
        } catch (TwitterException te) {
            if (te.exceededRateLimitation()) {
                // レートリミットオーバーした
                RateLimitStatus rateLimitStatus = te.getRateLimitStatus();
                printRateLimitStatus(rateLimitStatus);
            }
        }
    }
    private static void printRateLimitStatus(RateLimitStatus rls){
        System.out.println("HourlyLimit: " + rls.getHourlyLimit());
        System.out.println("RemainingHits: " + rls.getRemainingHits());
        System.out.println("ResetTime: " + rls.getResetTime());
        System.out.println("ResetTimeInSeconds: " + rls.getResetTimeInSeconds());
        System.out.println("SecondsUntilReset: " + rls.getSecondsUntilReset());
        
    }
}
