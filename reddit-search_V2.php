<?php
echo '<p><input type="button" name="Back" value="Back" onclick="window.location =\'index_V2.php\'" /></p>';

$connect = mysql_connect('localhost', 'root', 'root') or die(mysql_error());
mysql_select_db('lab3') or die(mysql_error());

$search = $_POST["svalue"];

echo "Searched for '$search'. <hr> <br>";

if (strstr($search, '/') !== false) {
    date_default_timezone_set('America/New_York');

    $date = new DateTime($search);
    $fullutc = $date->format('U');
    $term4 = substr("$fullutc", 0, -5);
} else {
    $term4 = $search;
}
if (strstr($search, ',') !== false) {

    $terms = explode(",", $search);
    $term1 = $terms[0];
    $term2 = $terms[1];
    $term3 = $terms[2];
}
else
    $term1 = $search;
$term2 = $search;
$term3 = $search;


$sqlsearch = "SELECT * FROM posts WHERE
    ((title LIKE '%$term1%') OR (title LIKE '%$term2%') OR (title LIKE '%$term3%')
    OR
    (author LIKE '%$term1%') OR (author LIKE '%$term2%') OR (author LIKE '%$term3%')
    OR
    (created_utc LIKE '%$term1%') OR (created_utc LIKE '%$term2%') OR (created_utc LIKE '%$term3%') OR (created_utc LIKE '%$term4%'))";

$searchresult = mysql_query($sqlsearch);

if (!$searchresult) {
    echo "couldn't run query ($search): " . mysql_error();
    exit;
}

if (mysql_num_rows($searchresult) == 0) {
    echo "No posts containing '$search'";
    exit;
}

if (!$searchresult) {
    echo "couln't run query ($search):" . mysql_error();
    exit;
}

$reddit = "http://www.reddit.com/r/";


while ($rowP = mysql_fetch_assoc($searchresult)) {
    
    echo '<a href="' .$reddit.$rowP['subreddit'] . '">' . $rowP['subreddit'] . '</a> - ';
    echo '<a href="' . $rowP['url'] . '">' . $rowP['title'] . '</a> </br>';
    echo '<a href="' . $reddit . $rowP['permalink'] . '"> Comments</a> | Ups: <b><font color="orange">' .
    $rowP['ups'] . '</font color> </b> | Downs: <b><font color="blue">' . $rowP ['downs'] .
    '</font color></b> <hr></br>';
    echo '</center>';
}
?>

</body>
</html>
