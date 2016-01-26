<?php
require_once('include/CacheHandler.php');

$cacheObj = new CacheHandler();
$results = $cacheObj->getFromCache();

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

<h1>Idea House</h1>

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