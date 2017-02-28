<?php
ini_set('display_errors', 'On');
?>
<?php
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

</head>

<body>

</body>
</html>
