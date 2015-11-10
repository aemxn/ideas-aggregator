<?php
// Include twitteroauth
require_once('twitter/twitteroauth.php');
require_once('twitter/Config.php');

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

// echo '<pre>'.json_encode($results, JSON_PRETTY_PRINT).'</pre>';die();

$title = array(
    'shine on',
    'illuminate',
    'light bulb',
    'ting!',
    'mind=blown',
    'oh my ideas!'
    );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB10lEQVQ4jX1TO2tUQRQelIgiGEt7CwVBhLvzzcZq73xnA4uQbht/QFBLFQnaWIivxcZXE8TCJkSw8REfnWkiRhEiCMEHgkERjGHnjKLCXovcXTfX3D1wiuGc78E3M8bkldVqm6O48bIOHs0fadWZslLighJZaXs8isRs29v9/4Fj6hIl/gwg+Nn2thUFV5R4ueKTnT1wliRDSrwaqF7HpUAEJTqROKmCuWVJhlfVPU4NBBPvlW6q7/xLiRNKzGTN5kajxJfB6vaYEp1CHl9VbCvSXTNB7HgUXFbiYiQmVTCvxO98+a4Sz9cP1Z0zxhgTPK4r8TQSt5VYUY+FSHdT6/asCs4Xw1TBfaV7sJZAbCu/yntKeyt4HFK6Z0pkeXhHYx2VSMwaY0ygPVJwYJeU9oUSn5S4kTX3bFKxE7nqR2OMaY8mu/P5jBIfig4mvtf2bQ/E2yiYXk3ZPenZ9u6N0j5W4rXW7I4g9nAxg0X17ngg3nUHfQ4+Z6N7ty5LMqyCeRUcVMFcjyD6SkM9Forp/iOwSzGtjuXOumEuRl9prHnOgS4NxJ0gOFNw0O2OEg+j4EB22mwo/VRZkgz1EwSiHWmvttPKrlLQukQjI1tiWh371nDbBu39BUbXq0cwWvsKAAAAAElFTkSuQmCC" rel="icon" type="image/x-icon" />    
    <title>Idea House</title>

    <link rel="stylesheet" href="salvattore.css">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="styles.css">    
</head>
<body>

<h1><?php  echo $title[array_rand($keywords, 1)];  ?></h1>

<div id="timeline" data-columns="4">
    <?php foreach($results as $result) { ?>
        <div class="item line-<?php echo $result['metadata']['data_source']; ?>">
            <a target="_blank" href="<?php echo $result['url']; ?>"><p><?php echo $result['title']; ?></p></a>
        </div>
    <?php } ?>
</div>

<script src="salvattore.min.js"></script>  	
</body>
</html>