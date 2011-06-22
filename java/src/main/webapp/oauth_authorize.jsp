<%@ page import="twitter4j.*,twitter4j.auth.*" contentType="text/html; charset=UTF-8" session="true"%><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body><%
//Twitter4Jを初期化
Twitter twitter = new TwitterFactory().getInstance();
twitter.setOAuthConsumer("コンシューマキー", "コンシューマシークレット");

String command = request.getParameter("command");
if ("authorize".equals(command)) {
  //OAuth認可、まずリクエストトークンを取得
  RequestToken requestToken = twitter.getOAuthRequestToken(request.getRequestURL() + "?command=callback");
  session.setAttribute("requestToken", requestToken);
  response.sendRedirect(requestToken.getAuthorizationURL());
} else if ("callback".equals(command)) {
  // Twitterからコールバックを受け取った
  //アクセストークンを取得してセッションに格納
  AccessToken accessToken = twitter.getOAuthAccessToken((RequestToken)session.getAttribute("requestToken"));
  session.setAttribute("accessToken", accessToken);

  //リクエストトークンは不要（無効）になったので破棄
  session.removeAttribute("requestToken");

} else if ("tweet".equals(command)) {
    // ツイートする
    twitter.setOAuthAccessToken((AccessToken)session.getAttribute("accessToken"));
    request.setCharacterEncoding("UTF-8");
    twitter.updateStatus(request.getParameter("tweet"));
    out.print("ツイートしました");

} else if ("logout".equals(command)) {
  //セッションに格納されているアクセストークンを破棄してログアウト
  session.removeAttribute("accessToken");
}
%>
<%
if (null != session.getAttribute("accessToken")) {
  //アクセストークンがセッションに存在するのでOAuth認可済
%>
  <form action="oauth_authorize.jsp" method="POST">
    いまどうしてる？ <input type="text" name="tweet" size="50"/><br>
    <input type="hidden" name="command" value="tweet"/>
    <input type="submit" value="ツイート"/>
  </form>
  <a href="?command=logout">ログアウト</a>
<%
} else {
%>
  <a href="?command=authorize">OAuth認可する</a>
<%
}%>
</body>
</html>