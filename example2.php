<?php
ini_set('display_errors', 'On');
?>
<?php
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 26.3.15
 * Time: 23:34
 */
include('Visitors.php');
$info=new Visitors();
$info->setSubdomain("http://127.0.0.1");
$info->getVisitorInfo($_SERVER['HTTP_USER_AGENT']);
$info->insertInfo();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Dragan Zlatkovski">
    <style>


        table.pme-main {
            border: 1px solid #004d9c;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }
        table.pme-navigation {
            border: 0 solid #004d9c;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }
        td.pme-navigation-0, td.pme-navigation-1 {
            white-space: nowrap;
        }
        th.pme-header {
            background: none repeat scroll 0 0 #fcff1b;
            border: 1px solid #e6001e;
            padding: 4px;
        }
        td.pme-key-0, td.pme-value-0, td.pme-help-0, td.pme-navigation-0, td.pme-cell-0, td.pme-key-1, td.pme-value-1, td.pme-help-0, td.pme-navigation-1, td.pme-cell-1, td.pme-sortinfo, td.pme-filter {
            border: 1px solid #e6001e;
            padding: 3px;
        }
        td.pme-buttons {
            text-align: left;
        }
        td.pme-message {
            text-align: center;
        }
        td.pme-stats {
            text-align: right;
        }
    </style>
</head>

<body>
<div>
    <?php
    echo '<table>';
    echo '<tr>
            <th class="pme-header" colspan="1">ID</th>
            <th class="pme-header">Domain</th>
            <th class="pme-header">Ip</th>
            <th class="pme-header">ServerDate</th>
            <th class="pme-header">ServerTime</th>
            <th class="pme-header">TimeZone</th>
            <th class="pme-header">UserOS</th>
            <th class="pme-header">UserBrowser</th>
            <th class="pme-header">UserAgent</th>
            <th class="pme-header">Country</th>
            <th class="pme-header">CountryCode</th>
            <th class="pme-header">City</th>
            <th class="pme-header">State</th>
            <th class="pme-header">Lat</th>
            <th class="pme-header">Lon</th>
            <th class="pme-header">Isp</th>
            <th class="pme-header">Org</th>
            <th class="pme-header">Asp</th>
          </tr>';
    $db=new DBConnect();
    $conection = $db->connectDatabase();
    $sql = mysqli_query($conection,"SELECT * FROM visitors");

    while($row=mysqli_fetch_assoc($sql))
    {
        echo '<tr class="pme-sortinfo">';
        echo '<td class="pme-cell-0">'.$row['id'].'</td>';
        echo '<td class="pme-cell-0">'.$row['domain'].'</td>';
        echo '<td class="pme-cell-0">'.$row['ip'].'</td>';
        echo '<td class="pme-cell-0">'.$row['serverDate'].'</td>';
        echo '<td class="pme-cell-0">'.$row['serverTime'].'</td>';
        echo '<td class="pme-cell-0">'.$row['timeZone'].'</td>';
        echo '<td class="pme-cell-0">'.$row['userOS'].'</td>';
        echo '<td class="pme-cell-0">'.$row['userBrowser'].'</td>';
        echo '<td class="pme-cell-0">'.$row['userAgent'].'</td>';
        echo '<td class="pme-cell-0">'.$row['country'].'</td>';
        echo '<td class="pme-cell-0">'.$row['countryCode'].'</td>';
        echo '<td class="pme-cell-0">'.$row['city'].'</td>';
        echo '<td class="pme-cell-0">'.$row['state'].'</td>';
        echo '<td class="pme-cell-0">'.$row['lat'].'</td>';
        echo '<td class="pme-cell-0">'.$row['lon'].'</td>';
        echo '<td class="pme-cell-0">'.$row['isp'].'</td>';
        echo '<td class="pme-cell-0">'.$row['org'].'</td>';
        echo '<td class="pme-cell-0">'.$row['asp'].'</td>';
        echo '</tr>';
    }
    echo '</table>';
    $db->CloseDataBaseConncection();
    ?>
</div>
</body>
</html>
