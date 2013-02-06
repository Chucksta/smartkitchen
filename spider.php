<?php

$connect = mysql_connect('localhost', 'root', 'root') or die(mysql_error());
mysql_select_db('smartkitchen') or die(mysql_error());

$api = "http://www.recipepuppy.com/api/?q=pancake";
$regq = "q=";
$sItem = $_POST["item"];


$contents = file_get_contents("$api . $regq . $sItem");
$json = json_decode($contents);

foreach ($json->results as $result) {

    mysql_query("INSERT INTO recipies (title,href,ingredients, thumbnail) VALUE ('$result->title', '$result->href',
        '$result->ingredients', '$result->thumbnail')");

}

echo "<meta http-equiv='refresh' content='1,searchview.php'/>";
?>

