<?php

function cutString($string, $size) {

	$res = htmlspecialchars_decode($string);

	$res = substr($res, 0, $size);
	
	if(strlen($string) > $size)
		$res .= "...";
	return $res;
}

function cleanString($string) {
	return htmlspecialchars($string, ENT_QUOTES);
}

?>