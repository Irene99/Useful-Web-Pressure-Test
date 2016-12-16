// A function to transfer json string into standard json string which PHP could decode into an Array.
function transJson($json){
	$json = preg_replace('/([0-9]{2})\:([0-9]{2})\:([0-9]{2})/','\1：\2：\3',$json);
	return str_replace('：',':',preg_replace('@([\w_0-9]+):@', '"\1":', str_replace('\'', '"', $json)));
}

$json = transJson($json) ;
$arr = json_decode($json,true) ;
