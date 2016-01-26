<?php 
    require_once('../twitter/twitteroauth.php');
    require_once('../twitter/Config.php');
    require_once('../include/DbHandler.php');

    $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

    $keywords = array(
            '"an app for"',
            '"an app that"',
            '"need an app"',
            'random idea:'
    );
    $rand_key = array_rand($keywords, 1);
    $twitter_search = $twitter->get('search/tweets', array('q' => $keywords[$rand_key]));

    $jsonObj = new stdClass();

    foreach($twitter_search->statuses as $tweet) {
        $twArr = array(
            'title'=>$tweet->text,
            'id'=>$tweet->id_str,
            'author'=>$tweet->user->screen_name,
            'url'=>'https://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id_str,
            'metadata'=>array(
                'data_source'=>'twitter'
                )
            );
        $jsonObj->twitter[] = $twArr;
    }

    $reddit_limit = 10;
    $subreddit = 'somebodymakethis';
    $reddit = file_get_contents("http://www.reddit.com/r/".$subreddit."/new.json?sort=new&limit=".$reddit_limit."");
    $reddit = json_decode($reddit);
    $reddit_arr = $reddit->data->children;


    foreach ($reddit_arr as $key) {
        $redditArr = array(
            'title'=>$key->data->title,
            'id'=>$key->data->id,
            'author'=>$key->data->author,
            'url'=>$key->data->url,
            'metadata'=>array(
                'data_source'=>'reddit',
                'subreddit'=>$key->data->subreddit
                )
            );
        $jsonObj->reddit[] = $redditArr;
    }

    $results = array_merge($jsonObj->twitter, $jsonObj->reddit);

    $dbObj = new DbHandler();
    $cronResponse = $dbObj->insertDataSourceToDb($results);
    echo json_encode($cronResponse);

    file_put_contents('../cache/cache_ideas.json', json_encode($results));
?>