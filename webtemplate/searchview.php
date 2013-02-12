
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <input type="button" value="Return to Homepage" onClick="location.href='index.php'">
        <?php
        $connect = mysql_connect('localhost', 'root', '') or die(mysql_error());
        mysql_select_db('smartkitchen') or die(mysql_error());

        $sqlS = "SELECT * FROM recipies";
        $resultS = mysql_query($sqlS);

        while ($rowS = mysql_fetch_assoc($resultS)) {
            echo '<center>';
            echo '<hr>';
            $resultS = mysql_query("SELECT * FROM recipies ORDER BY title DESC");
            while ($rowS = mysql_fetch_assoc($resultS)) {
                echo "<a href='" . $rowS['href'] . "'>" . $rowS['title'] . "</a></br>";
                echo $rowS['ingredients'] . "</br>";
                echo "<a href='" . $rowS['href'] . "'><img src='" . $rowS['thumbnail'] . "'></a></br>";
                echo "<hr>";
            }
            echo '</center>';
        }
        ?>
    </body>
</html>
