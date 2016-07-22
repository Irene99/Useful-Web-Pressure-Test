<?php
/**
*** A script to test you website request.Which could test api bugs in multiple requests situations.
*** @version 2016.07.22
*** @author J.H.Wang 
*** @author GitHub: https://github.com/kianva/
**/
set_time_limit(0);

$times  = 100 ;// request times in a very short timezone
$url    = ''; // the url address you want to test,mostly should be a ajax api file(json transfer)
$cookie = ''; // optional,when you test with logged user,you may need this.
$post_string = array(
	//'gamebox'=>1,
	'action'=>'weixin',
	'time'=>'20160710',
);

// make the array
for($i=0;$i<$times;$i++){
	$query_arr[$i] = $url ; // the url you want to test
}

$result = curl_multi($query_arr,$post_string,$cookie);
var_dump($result);


function curl_multi ($query_arr,$post_string,$cookie) {	
	
	$ch = curl_multi_init();
	$count = count($query_arr);
	$ch_arr = array();
	for ($i = 0; $i < $count; $i++) {
		$query_string = $query_arr[$i];
		$ch_arr[$i] = curl_init($query_string);
		curl_setopt($ch_arr[$i], CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch_arr[$i], CURLOPT_POST, true);      
		curl_setopt($ch_arr[$i],CURLOPT_COOKIE,$cookie);  
		curl_setopt($ch_arr[$i], CURLOPT_POSTFIELDS, $post_string);
		curl_multi_add_handle($ch, $ch_arr[$i]);
	}
	$running = null;
	do {
		curl_multi_exec($ch, $running);
	} while ($running > 0);
	for ($i = 0; $i < $count; $i++) {
		$results[$i] = curl_multi_getcontent($ch_arr[$i]);
		curl_multi_remove_handle($ch, $ch_arr[$i]);
	}
	curl_multi_close($ch);
	return $results;
}
