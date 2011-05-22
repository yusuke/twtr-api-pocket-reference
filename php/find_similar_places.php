<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <?php

  if (isset($_POST["lat"])) {
    $lat = htmlspecialchars($_POST["lat"]);
  } else {
    $lat = "35.7886";
  }
  if (isset($_POST["long"])) {
    $long = htmlspecialchars($_POST["long"]);
  } else {
    $long = "139.6857";
  }
  ?>
  <script type="text/javascript">
    function initialize() {
      var latlng = new google.maps.LatLng(<?=$lat?>, <?=$long?>);
      var myOptions = {
        zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
      google.maps.event.addListener(map, 'mouseup', function() {
        // 地図をドラッグしたらフォールの緯度経度欄に反映させる
        document.getElementById("lat").value = map.getCenter().lat();
        document.getElementById("long").value = map.getCenter().lng();
      });
    }

  </script>
</head>
<body onload="initialize()">
  <?php
  // tmhOAuthを初期化
  require "./tmhOAuth.php";
  $twitter = new tmhOAuth(array());

  if (isset($_REQUEST["command"])) {
    if ("similar_places" == $_REQUEST["command"]) {
      // 場所を検索する
      $twitter->request("GET", $twitter->url("1/geo/similar_places")
        , array("lat" => $_POST["lat"]
        , "long" => $_POST["long"]
        , "name" => $_POST["name"]
        ));
      $places = json_decode($twitter->response["response"])->{"result"}->{"places"};

      // ヒットした場所を一覧表示
      print "緯度: $lat 経度: $long 付近 名称: " . htmlspecialchars($_POST["name"]) . " でヒットした場所:<br>";
      foreach ($places as $place) {
        $fullName = $place->{"full_name"};
        print htmlspecialchars($fullName) . "<br>";
      }
    }
    ?><br>
    <?php

  }
  ?>

  <div id="map_canvas" style="width:300px; height:300px"></div>

  <form action="./find_similar_places.php" method="POST">
    <input type="hidden" name="command" value="similar_places"/>
    緯度:<input type="text" name="lat" id="lat"/><br>
    経度:<input type="text" name="long" id="long"/><br>
    名称:<input type="text" name="name"/><br>
    <input type="submit" value="場所を検索"/>
  </form>
</body>
</html>
