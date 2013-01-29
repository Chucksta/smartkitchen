<?php
    $reddit = "http://www.reddit.com";

    $db = mysql_connect('localhost', 'root', 'root');
    mysql_select_db('lab3');
    $query = mysql_query("SELECT * FROM subreddits");

    while ($row = mysql_fetch_assoc($query))
    {
        $address = file_get_contents($reddit . $row['urlName'] . '.json');
        $json = json_decode($address);
        //echo "<h1>".$row['name']."</h1>";
        
        
        $subRname = $row['name'];
        $query2 = mysql_query("SELECT id FROM posts WHERE subreddit = '$subRname'");
        $index = 0;
        while($row2 = mysql_fetch_assoc($query2))
        {
            foreach($json->data->children as $postInfo2)
            {
                if($row2['id']==$postInfo2->data->id)
                {
                    $duplicates[$index] = $row2['id'];
                    $index++;
                }
            }
        }
        foreach($json->data->children as $postInfo)
        {
            if(!in_array($postInfo->data->id, $duplicates))
            {
                $info = $postInfo->data;
                mysql_query("INSERT INTO posts (url, subreddit, permalink, author, created_utc, id, ups, downs, title) 
                             VALUES ('$info->url', '$info->subreddit', '$info->permalink', '$info->author',
                                     '$info->created_utc','$info->id', '$info->ups', '$info->downs','$info->title')");
            }
        }

        $today = date("Y-m-d H:i:s");
        //echo "<h2>".$today."<h2>";
        $name = $row['name'];
        mysql_query("UPDATE subreddits SET lastcrawl='$today' WHERE name='$name'");
    }

    mysql_close($db);
    
    //echo "Number of new posts grabbed: <b>".$count."</b>";
    echo "<meta http-equiv='refresh' content='1,index_v2.php'/>";
?>
