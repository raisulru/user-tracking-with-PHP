<?php
ini_set('display_errors', 'On');
?>
<?php
session_start();
ob_start();

include ('VisitorsCon.php');
$db=new DBConnect();
$conection = $db->connectDatabase();
$points = array();
$interval=(isset($_GET['period']))?(int)$_GET['period']:30;

$getpoints = mysqli_query($conection, "SELECT ip, lat, lon, country, city, serverTime, serverDate, isp  FROM visitors WHERE serverDate BETWEEN DATE_SUB(NOW(), INTERVAL $interval DAY) AND NOW()");
if(!$getpoints){die('There was an error running the query [' . $con->error . ']');
} else {
    while ($row = mysqli_fetch_array($getpoints)) {
        $points[] = array('lat' => $row['lat'], 'lng' => $row['lon'], 'name' => '<b>IP</b>: '.$row['ip'].' </br><b>Country</b>: '.$row['country'] .' </br><b>City</b>: '.$row['city'] .' </br><b>Time</b>: '.$row['serverTime'].' </br><b>Date</b>: '.$row['serverDate'].' </br><b>ISP</b>: '.$row['isp']);
        //echo 'var myLatlng1 = new google.maps.LatLng('.$row['lat'].', '.$row['lon'].');
        //var marker1 = new google.maps.Marker({ position: myLatlng1, map: map, title:"'.$row['ip'].'"});';

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google Map Ip Locator</title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   

    <style type="text/css">
        #map {
            width:  100%;
            height: 600px;
        }

        #map {
            height: 100%;
            width: 100%;
            position:absolute;
            top: 0;
            left: 0;
            z-index: 0; /* Set z-index to 0 as it will be on a layer below the contact form */
        }

        #forma {
            position: relative;
            z-index: 1; /* The z-index should be higher than Google Maps */
            width: 500px;
            margin: 10px auto 0;
            padding: 10px;
            background: black;
            height: auto;
            opacity: .45; /* Set the opacity for a slightly transparent Google Form */
            color: blue;
        }
    </style>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
    <script type="text/javascript">
        var points = <?php echo json_encode($points); ?>;
        $(document).ready(function(){
            google.maps.event.addDomListener(window, 'load', init);

            function init() {
                var mapOptions = {
                    zoom: 3,
                    center: new google.maps.LatLng(45.605,15.0358),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    //styles: [  {featureType:"administrative",elementType:"all",stylers:[{visibility:"on"},{saturation:-100},{lightness:20}]},  {featureType:"road",elementType:"all",stylers:[{visibility:"on"},{saturation:-100},{lightness:40}]},    {featureType:"water",elementType:"all",stylers:[{visibility:"on"},{saturation:-10},{lightness:30}]},    {featureType:"landscape.man_made",elementType:"all",stylers:[{visibility:"simplified"},{saturation:-60},{lightness:10}]},   {featureType:"landscape.natural",elementType:"all",stylers:[{visibility:"simplified"},{saturation:-60},{lightness:60}]},    {featureType:"poi",elementType:"all",stylers:[{visibility:"off"},{saturation:-100},{lightness:60}]},
                    //   {featureType:"transit",elementType:"all",stylers:[{visibility:"off"},{saturation:-100},{lightness:60}]}]
                };
                var mapElement = document.getElementById('map');
                var map = new google.maps.Map(mapElement, mapOptions);
                //var latlngbounds = new google.maps.LatLngBounds();
                for (var i=0,l=points.length;i<l;i++) {
                    var latLng = new google.maps.LatLng(points[i].lat, points[i].lng);
                    var marker1 = new google.maps.Marker({ position: latLng, map: map, title:points[i].name});
                   // var infowindow = new google.maps.InfoWindow({content:points[i].name });
                    //var content = "Loan Number: Address: " + latLng;
                    var content = "<span style='color: #0044cc; font-style: oblique;'>Info:</span></br> " + points[i].name +  '</br>' + "<span style='color: #a91b0c; font-style: oblique;'>Geo:</span></br>" + latLng
                    var infowindow = new google.maps.InfoWindow();

                    google.maps.event.addListener(marker1,'click', (function(marker1,content,infowindow){
                        return function() {
                            infowindow.setContent(content);
                            infowindow.open(map,marker1);
                        };
                    })(marker1,content,infowindow));
                }
            }

        });


    </script>

    <script type="text/javascript">
        function handleSelect(elm)
        {
            window.location = "GoogleMap.php?period="+elm.value+".php";
        }
    </script>
</head>

<body>

<div class="container-fluid">
    <div id="map"></div>

    <div id="forma">
    <div>
        <a href="../dbms.php"><h3>Google Map Mark IP DBMS </h3></a>
    </div>
    <div style="margin-left: 30px; margin-bottom: 10px;">
        <form action="" method="get">
            <select name="period" onchange="javascript:handleSelect(this)">
                <option value="30">Select Period</option>
                <option value="1">Today</option>
                <option value="2">Last Two Day</option>
                <option value="3">Last Three Day</option>
                <option value="7">Last Seven Days</option>
                <option value="30">Last 30 Days</option>
                <option value="60">Last Two Months</option>
                <option value="90">Last Three Months</option>
                <option value="183">Half Year</option>
                <option value="365">One Year</option>
            </select>
        </form>

    </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</body>
</html>
<?php
$db->CloseDataBaseConncection();
?>