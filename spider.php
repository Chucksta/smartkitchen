<?php

$connect = mysql_connect('localhost', 'root', 'root') or die(mysql_error());
mysql_select_db('smartkitchen') or die(mysql_error());

$api = "http://www.recipepuppy.com/api/?";
$regQ = "q=";
$reqI = "i=";
$sItem = $_POST["item"];
$url = $api . $regQ . $sItem ;

$contents = file_get_contents("$url");
$json = json_decode($contents);

$truncateR = mysql_query('TRUNCATE TABLE `recipies`');

foreach ($json->results as $result) {

    mysql_query("INSERT INTO recipies (title,href,ingredients, thumbnail) VALUE ('$result->title', '$result->href',
        '$result->ingredients', '$result->thumbnail')");

}
mysql_close($connect);
echo "seached for: " . $url;
echo "<meta http-equiv='refresh' content='1,searchview.php'/>";
?>