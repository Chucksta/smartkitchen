<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <input type="button" value="Admin" onClick="location.href='admin.html'">
        <input type="button" value="Refresh" onClick="location.href='spider_v2.php'">
        <hr>
        <h4>
            Enter 1 or 3 of the following; Title, Author, UTC or date in mm/dd/yyyy in CSV format.
        </h4>
        <form name="search" action="search_V2.php" method="post">
            Search:<input type="text" name="svalue" value="Title,Author,UTC">
            <input type="submit" value="submit">
        </form>
        <?php
        $connect = mysql_connect('localhost', 'root', 'root') or die(mysql_error());
        mysql_select_db('lab3') or die(mysql_error());

        $sqlS = "SELECT * FROM subreddits";
        //$sqlP = "SELECT * FROM posts";

        $resultS = mysql_query($sqlS);
        //$resultP = mysql_query($sqlP);

        if (!$resultS) {
            echo "couln't run query ($sqlS):" . mysql_error();
            exit;
        }
        if (mysql_num_rows($resultS) == 0) {
            echo "no rows found in subreddits";
            exit;
        }

        /*if (!$resultP) {
            echo "couldn't run query ($sqlP):" . mysql_error();
            exit;
        }

        if (mysql_num_rows($resultP) == 0) {
            echo "no rows found in comments";
            exit;
        }*/
            
          mysql_data_seek($resultS,0);
          //mysql_data_seek($resultP,0);
          $reddit = "http://www.reddit.com";
        while ($rowS = mysql_fetch_assoc($resultS)) {
            echo '<center>';
            echo '<hr>';
            echo '<a href="' .$reddit.$rowS['urlName'] . '">' . $rowS['name'] . '</a> </br>';
            echo '<hr>';
            $name = $rowS['name'];
            $resultP = mysql_query("SELECT * FROM posts WHERE subreddit='$name' ORDER BY created_utc DESC");
            while ($rowP = mysql_fetch_assoc($resultP)) {
                //if (strcasecmp($rowP['subreddit'], $rowS['name'])==0) {
                    echo '<a href="'.$rowP['url'] . '">' . $rowP['title'] . '</a> </br>';
                    echo '<a href="'.$reddit.$rowP['permalink'] . '"> Comments</a> | Ups: <b><font color="orange">' .
                    $rowP['ups'] . '</font color> </b> | Downs: <b><font color="blue">' . $rowP ['downs'] .
                    '</font color></b></br>';
                    
                //}
            }
            mysql_data_seek($resultP,0);
            echo '</center>';
        }
        ?>

    </body>
</html>
