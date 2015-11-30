<?php
class CacheHandler {

    function __construct() {}

    public function getFromCache() {
    	$cache_data = file_get_contents('cache/cache_ideas.json');

    	return json_decode($cache_data, true);
    }
}
?>